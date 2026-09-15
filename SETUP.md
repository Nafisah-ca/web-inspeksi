# Setup Cepat InspeksiKu

## Langkah 1 — Buat Database

Buka phpMyAdmin (http://localhost/phpmyadmin) atau HeidiSQL di Laragon, lalu jalankan:

```sql
CREATE DATABASE inspeksi CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

## Langkah 2 — Konfigurasi .env

File `.env` sudah ada. Pastikan bagian DB sesuai:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=inspeksi
DB_USERNAME=root
DB_PASSWORD=
```

## Langkah 3 — Install via Terminal

Buka terminal di folder `D:\laragon\www\inspeksi` lalu jalankan satu per satu:

```bash
composer install
php artisan key:generate
php artisan migrate
php artisan db:seed
npm install
npm run build
php artisan storage:link
```

## Langkah 4 — Tambahkan Virtual Host (Laragon)

Laragon otomatis membuat virtual host untuk folder di `www/`.
Buka: **http://inspeksi.test**

Jika tidak otomatis, tambah manual di Laragon → Menu → Hosts.

## Langkah 5 — Test Login

| URL | Email | Password |
|---|---|---|
| http://inspeksi.test/login | andi@example.com | password |
| http://inspeksi.test/admin/login | admin@inspeksi.test | password |
| http://inspeksi.test/admin/login | budi@inspeksi.test | password |

---

## Troubleshooting

**Error: `Class not found`**
```bash
composer dump-autoload
```

**Error: `SQLSTATE[HY000]`**
- Pastikan MySQL Laragon sudah running (indikator hijau di tray)
- Cek DB_DATABASE, DB_USERNAME, DB_PASSWORD di .env

**Asset CSS tidak muncul**
```bash
npm run build
```
Atau untuk development dengan hot reload:
```bash
npm run dev
```
Kemudian refresh halaman.

**APP_KEY masih kosong**
```bash
php artisan key:generate
```
