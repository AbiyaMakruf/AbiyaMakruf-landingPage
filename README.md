# 🚀 Subdomain Directory

Project simpel buat manage subdomain directory. Bikinnya pake Laravel, styling pake Tailwind, database di Neon Tech, storage gambar di Google Cloud Storage, dan deploy-nya ke Google Cloud Run.

## 🛠️ Tech Stack
- **Backend:** Laravel 12 🐘
- **Frontend:** Blade + Tailwind CSS + Alpine.js 🎨
- **Database:** PostgreSQL (Neon Tech) 🗄️
- **Storage:** Google Cloud Storage ☁️
- **Infrastructure:** Docker & Google Cloud Run 🐳

## ✨ Fitur
- 📱 Mobile Friendly (Responsive banget!)
- 🔐 Admin Dashboard (Login/Logout)
- 📝 CRUD Subdomain (Create, Read, Update, Delete)
- 🖼️ Upload Screenshot ke GCS
- 🔍 Search & Filter Kategori

## 🏃‍♂️ Cara Jalanin di Local
Buat yang mau coba di laptop sendiri:

1. **Clone Repo**
   ```bash
   git clone https://github.com/AbiyaMakruf/landingPage.git
   cd landingPage
   ```

2. **Setup Environment**
   Copy `.env.example` jadi `.env` terus isi database & GCS credentials.
   ```bash
   cp .env.example .env
   ```

3. **Install Dependencies**
   ```bash
   composer install
   npm install && npm run build
   ```

4. **Migrate Database**
   ```bash
   php artisan migrate --seed
   ```

5. **Jalanin Server**
   ```bash
   php artisan serve
   ```
   Buka `http://localhost:8000` deh! 🎉

## ☁️ Cara Deploy ke Cloud Run
Kita udah siapin script `deploy.sh` biar gampang.

1. **Pastikan `gcloud` CLI udah login**
   ```bash
   gcloud auth login
   ```

2. **Siapin File Config**
   Pastikan file `cloudrun.env` udah diisi dengan config production (Database Neon, GCS Bucket, dll).

3. **Jalanin Script Deploy**
   ```bash
   ./deploy.sh
   ```
   Tunggu bentar, nanti bakal muncul URL aplikasinya. 🚀

## 📋 Yang Harus Disiapin (GCP)
Sebelum deploy, pastiin punya ini di Google Cloud Platform:

- **Project ID**: ID project GCP kamu (cek di `deploy.sh`).
- **Artifact Registry**: Buat repo docker (misal: `abiya-makruf-landing-page`).
- **Cloud Storage Bucket**: Buat nyimpen gambar (misal: `tracker-expenses-bucket`).
- **Service Account**: Pastikan punya permission buat Cloud Run & Storage Admin.
- **Neon Database**: Connection string buat PostgreSQL.

---
*Dibuat dengan ❤️ dan sedikit kopi ☕*
