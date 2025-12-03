#!/bin/bash

# Exit on error
set -e

# Load environment variables from .env file
if [ -f .env ]; then
    echo "📄 Loading configuration from .env file..."
    export $(grep -v '^#' .env | xargs)
else
    echo "⚠️  .env file not found! Using default values or environment variables."
fi

# Configuration
PROJECT_ID="${GCS_PROJECT_ID:-tracker-expenses-478512}"
REGION="asia-southeast1" # Singapore
SERVICE_NAME="AbiyaMakruf-landingPage"
REPO_NAME="AbiyaMakruf-landingPage"
IMAGE_NAME="AbiyaMakruf-landingPage"

if [ -z "$PROJECT_ID" ]; then
    echo "Error: PROJECT_ID is not set."
    echo "Usage: Ensure GCS_PROJECT_ID is set in .env or export PROJECT_ID=..."
    exit 1
fi

IMAGE_TAG="$REGION-docker.pkg.dev/$PROJECT_ID/$REPO_NAME/$IMAGE_NAME"

echo "🚀 Starting deployment process..."
echo "Project: $PROJECT_ID"
echo "Region: $REGION"
echo "Service: $SERVICE_NAME"
echo "Image: $IMAGE_TAG"

# 1. Build and Push Image
echo "📦 Building and pushing image to Artifact Registry..."
# Ensure the service account file exists if referenced
if [[ "$GCS_KEY_FILE_PATH" == *".json" ]]; then
    JSON_FILE=$(basename "$GCS_KEY_FILE_PATH")
    if [ ! -f "$JSON_FILE" ]; then
        echo "⚠️  Warning: Service account file '$JSON_FILE' not found in current directory."
        echo "   Make sure to place 'landingPage-478512-cbeffd8a247e.json' in the root if you want it copied to the image."
    fi
fi

gcloud builds submit --tag "$IMAGE_TAG" .

# 2. Deploy to Cloud Run
echo "🚀 Deploying to Cloud Run..."

# Construct environment variables string from .env values
# We explicitly pick the ones we want to pass to avoid passing sensitive local vars
ENV_VARS="APP_ENV=production"
ENV_VARS+=",APP_DEBUG=false"
ENV_VARS+=",LOG_CHANNEL=stderr"
ENV_VARS+=",DB_CONNECTION=pgsql"
ENV_VARS+=",DB_HOST=$DB_HOST"
ENV_VARS+=",DB_PORT=$DB_PORT"
ENV_VARS+=",DB_DATABASE=$DB_DATABASE"
ENV_VARS+=",DB_USERNAME=$DB_USERNAME"
ENV_VARS+=",DB_PASSWORD=$DB_PASSWORD"
ENV_VARS+=",DB_SSLMODE=$DB_SSLMODE"
ENV_VARS+=",FILESYSTEM_DISK=gcs"
ENV_VARS+=",GCS_PROJECT_ID=$GCS_PROJECT_ID"
ENV_VARS+=",GCS_BUCKET=$GCS_BUCKET"
ENV_VARS+=",GCS_KEY_FILE_PATH=$GCS_KEY_FILE_PATH"
ENV_VARS+=",APP_KEY=$APP_KEY"

gcloud run deploy "$SERVICE_NAME" \
  --image="$IMAGE_TAG" \
  --platform=managed \
  --region="$REGION" \
  --allow-unauthenticated \
  --port=8080 \
  --set-env-vars="$ENV_VARS"

echo "✅ Deployment complete!"
echo "⚠️  Note: Ensure your Artifact Registry repository '$REPO_NAME' exists in '$REGION'."

