# Laravel Kelas XII

## Menyiapkan aplikasi

Pastikan MySQL aktif, lalu buat database dari direktori proyek:

```bash
mysql -u root -p < database/create_database.sql
```

Salin `.env.example` menjadi `.env`, lalu sesuaikan `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, dan `DB_PASSWORD` dengan MySQL lokal. Nilai database bawaan adalah `laravel_kelas_xii`.

Jalankan perintah berikut untuk memasang dependensi, membuat app key, membuat tabel, dan mengisi data awal beserta data film:

```bash
composer install
php artisan key:generate
php artisan migrate --seed
php artisan serve
```

Poster film disediakan di `public/template/images` dan dipakai langsung oleh halaman film; tidak perlu menyalin gambar ke storage atau membuat symlink.
