# 🚗 InspeksiKu — Sistem Inspeksi Kendaraan

Aplikasi web sistem inspeksi kendaraan berbasis **Laravel 11 + MySQL + Blade + TailwindCSS + Alpine.js**.

---

## 📋 Fitur Utama

| Modul | Fitur |
|---|---|
| **Landing Page** | Hero, daftar paket inspeksi, cara kerja, CTA |
| **Booking** | Form booking multi-step, slot waktu dinamis (AJAX), manajemen kendaraan |
| **Customer Dashboard** | Progress tracker visual, riwayat, hasil inspeksi lengkap |
| **Admin Panel** | Dashboard grafik, kelola semua booking, CRUD paket, checklist, inspektor |
| **Inspektor** | Daftar tugas, form checklist, upload foto, submit laporan |

---

## 👤 Role & Akun Demo

| Role | Email | Password | Login URL |
|---|---|---|---|
| **Admin** | admin@inspeksi.test | password | `/admin/login` |
| **Inspektor 1** | budi@inspeksi.test | password | `/admin/login` |
| **Inspektor 2** | agus@inspeksi.test | password | `/admin/login` |
| **Customer 1** | andi@example.com | password | `/login` |
| **Customer 2** | siti@example.com | password | `/login` |
| **Customer 3** | reza@example.com | password | `/login` |

---

## 🚀 Instalasi

### Prasyarat
- PHP 8.2+
- Composer
- Node.js 18+ & NPM
- MySQL 8.0+
- Laragon (sudah terinstall di mesin ini)

### Langkah Instalasi

**1. Buat database MySQL**
```sql
CREATE DATABASE inspeksi CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

**2. Konfigurasi .env**
```bash
cp .env.example .env
```
Edit `.env`:
```
DB_DATABASE=inspeksi
DB_USERNAME=root
DB_PASSWORD=          # kosong jika Laragon default
APP_URL=http://inspeksi.test
```

**3. Install dependencies**
```bash
composer install
php artisan key:generate
```

**4. Migrasi & Seeder**
```bash
php artisan migrate
php artisan db:seed
```

**5. Build assets**
```bash
npm install
npm run build
```

**6. Storage symlink**
```bash
php artisan storage:link
```

**7. Atau jalankan semua sekaligus:**
```bash
install.bat
```

---

## 🗂️ Struktur Project

```
inspeksi/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Auth/          # Login, Register, AdminLogin
│   │   │   ├── Admin/         # Dashboard, Booking, Package, Checklist, Inspector
│   │   │   ├── User/          # Dashboard, BookingHistory, Profile
│   │   │   ├── Inspector/     # TaskController
│   │   │   ├── HomeController.php
│   │   │   └── BookingController.php
│   │   └── Middleware/
│   │       ├── CheckRole.php
│   │       ├── AdminMiddleware.php
│   │       └── InspectorMiddleware.php
│   └── Models/
│       ├── User.php
│       ├── Vehicle.php
│       ├── InspectionPackage.php
│       ├── InspectionChecklistItem.php
│       ├── Booking.php
│       └── InspectionResult.php
├── database/
│   ├── migrations/            # 8 migration files
│   └── seeders/               # 5 seeder files
├── resources/views/
│   ├── layouts/               # app, admin, user layouts
│   ├── auth/                  # login, register, admin-login
│   ├── admin/                 # dashboard, bookings, packages, checklist, inspectors
│   ├── user/                  # dashboard, history, booking-detail, profile
│   ├── inspector/             # dashboard, task-detail
│   ├── booking/               # create, success
│   ├── home.blade.php
│   └── packages.blade.php
└── routes/
    └── web.php
```

---

## 🔄 Alur Bisnis

```
Customer booking
    → Status: PENDING
    
Admin konfirmasi + assign inspektor
    → Status: CONFIRMED
    
Inspektor mulai pengerjaan
    → Status: ON_PROGRESS
    
Inspektor submit hasil inspeksi
    → Status: COMPLETED
    → Customer bisa lihat laporan lengkap
```

---

## 📦 Data Seeder

- **3 Paket inspeksi**: Dasar (Rp 150rb), Standar (Rp 300rb), Komprehensif (Rp 550rb)
- **32 item checklist** terdistribusi ke 3 paket
- **2 inspektor**: Budi Santoso, Agus Prasetyo
- **3 customer**: Andi, Siti, Reza
- **5 booking contoh**: pending, confirmed, on_progress, completed (dengan hasil), cancelled

---

## 🛠️ Tech Stack

| Layer | Teknologi |
|---|---|
| Backend | Laravel 11 |
| Database | MySQL 8 |
| Frontend | Blade + TailwindCSS 3 + Alpine.js 3 |
| Auth | Native Laravel Auth (session-based) |
| Build | Vite |

---

## 📱 Responsif

Semua halaman mobile-first. Customer dashboard dilengkapi floating action button untuk booking dari HP.

---

## 🔐 Keamanan

- CSRF protection di semua form
- Role-based middleware (`CheckRole`, `AdminMiddleware`, `InspectorMiddleware`)
- Password di-hash dengan Bcrypt
- Ownership check di semua resource user (booking, vehicle)
- Slot validation mencegah double-booking
