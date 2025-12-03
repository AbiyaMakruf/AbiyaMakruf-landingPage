<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;

class TestGcsUpload extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:gcs-upload';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test uploading a file to Google Cloud Storage';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Fix for local Laragon SSL issue
        $cacert = 'C:\laragon\etc\ssl\cacert.pem';
        if (file_exists($cacert)) {
            ini_set('curl.cainfo', $cacert);
            ini_set('openssl.cafile', $cacert);
            $this->info("Configured SSL CA file: {$cacert}");
        }

        $this->info('Testing GCS Upload...');

        try {
            // Enable exceptions for the gcs disk to see why it fails
            Config::set('filesystems.disks.gcs.throw', true);
            
            $disk = Storage::disk('gcs');
            $filename = 'test-upload-' . time() . '.txt';
            $content = 'This is a test file uploaded from Laravel at ' . now();

            $this->info("Attempting to upload {$filename} via Storage facade...");

            // Try to get the underlying adapter to see configuration
            $adapter = $disk->getAdapter();
            $this->info('Adapter class: ' . get_class($adapter));

            // Attempt upload
            try {
                $disk->put($filename, $content);
                $this->info('✅ Upload successful via Storage facade!');
                $url = $disk->url($filename);
                $this->info("File URL: {$url}");
            } catch (\Exception $e) {
                $this->error('❌ Upload failed via Storage facade.');
                $this->error('Error: ' . $e->getMessage());
                
                if (str_contains($e->getMessage(), 'AccessControl')) {
                    $this->warn('This might be due to "Uniform bucket-level access" being enabled on the bucket.');
                    $this->warn('Try setting "visibility" to "private" or removing it in config/filesystems.php');
                }
            }

            // Try using the Google Cloud Storage client directly for verification
            $this->info('------------------------------------------------');
            $this->info('Attempting direct Google Cloud Storage client upload for debugging...');
            
            $config = config('filesystems.disks.gcs');
            
            $storage = new \Google\Cloud\Storage\StorageClient([
                'projectId' => $config['project_id'],
                'keyFile' => $config['key_file'],
            ]);
            
            $bucket = $storage->bucket($config['bucket']);
            $object = $bucket->upload($content, [
                'name' => 'direct-' . $filename
            ]);
            
            $this->info('✅ Direct upload successful!');
            $this->info('Object info: ' . $object->name());

        } catch (\Exception $e) {
            $this->error('❌ Exception occurred:');
            $this->error($e->getMessage());
            $this->line($e->getTraceAsString());
        }
    }
}
