# Sistem Informasi Manajemen Panti

Sistem informasi untuk pengelolaan panti lansia dengan portal Admin/Karyawan/Keluarga, manajemen data lansia, kegiatan, kesehatan, dan chat realtime keluarga–petugas (Laravel Reverb + Echo).

## Fitur Utama
- Manajemen lansia, kegiatan, kesehatan, inventaris, dan user
- Portal keluarga untuk melihat informasi lansia
- Chat realtime keluarga–petugas + toast notifikasi di luar halaman chat

## Prasyarat
- PHP 8.2+
- Composer
- Node.js 18+ dan npm
- MySQL/MariaDB
- Git

## Instalasi Lokal
1) Clone repo
```bash
git clone <repo-url>
cd sistem-informati-manajemen-panti
```

2) Siapkan environment
```bash
copy .env.example .env
```
Isi koneksi database di `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=panti
DB_USERNAME=root
DB_PASSWORD=
```

3) Install dependencies
```bash
composer install
npm install
```

4) Generate key dan migrasi
```bash
php artisan key:generate
php artisan migrate
```

5) Seed data (opsional)
```bash
php artisan db:seed
```
Cek akun default di `database/seeders/UserSeeder.php`.

6) Build asset
- Development (HMR):
```bash
npm run dev
```
- Production build:
```bash
npm run build
```
Jika memakai build produksi, pastikan file `public/hot` **tidak ada**.

7) Jalankan aplikasi
```bash
php artisan serve
```

## Setup Realtime Chat (Laravel Reverb)
Chat realtime menggunakan Reverb. Pastikan `.env` terisi dan konsisten antara backend dan frontend.

1) Isi konfigurasi `.env`
```env
BROADCAST_CONNECTION=reverb

REVERB_APP_ID=local
REVERB_APP_KEY=your_app_key
REVERB_APP_SECRET=your_app_secret
REVERB_HOST=127.0.0.1
REVERB_PORT=8081
REVERB_SCHEME=http

REVERB_SERVER_HOST=0.0.0.0
REVERB_SERVER_PORT=8081

VITE_BROADCAST_DRIVER=reverb
VITE_REVERB_APP_KEY="${REVERB_APP_KEY}"
VITE_REVERB_HOST="${REVERB_HOST}"
VITE_REVERB_PORT="${REVERB_PORT}"
VITE_REVERB_SCHEME="${REVERB_SCHEME}"
```

Untuk membuat key/secret cepat (PowerShell):
```bash
php -r "echo bin2hex(random_bytes(16));"
```
Gunakan hasilnya untuk `REVERB_APP_KEY` dan `REVERB_APP_SECRET`.

2) Clear config dan rebuild asset
```bash
php artisan config:clear
npm run build
```

3) Jalankan Reverb
```bash
php artisan reverb:start
```
Jika port sudah dipakai, ubah `REVERB_SERVER_PORT` dan `REVERB_PORT` ke port lain, lalu restart Reverb.

4) Verifikasi realtime di browser
```js
window.Echo?.connector?.pusher?.connection?.state
```
Status harus `connecting`/`connected`.

## Catatan Vite (HMR vs Build)
- Jika `public/hot` ada, maka **wajib** jalankan `npm run dev`.
- Jika menggunakan `npm run build`, hapus `public/hot` agar asset dari `public/build` dipakai.

## Troubleshooting
- `Vite manifest not found`:
  - Jalankan `npm run build` dan pastikan `public/hot` tidak ada.
- Reverb gagal listen:
  - Pastikan port `REVERB_SERVER_PORT` tidak dipakai proses lain.
- Realtime tidak jalan:
  - Pastikan `BROADCAST_CONNECTION=reverb`.
  - Cek `POST /broadcasting/auth` (Network tab) harus `200`.
  - Pastikan layout memuat `@vite(['resources/css/app.css','resources/js/app.js'])`.

## License
MIT
