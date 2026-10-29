Bahan materi kelas XII
Langkah-langkah yang harus dilakukan:

Silakan kalian fork untuk memasukan ke dalam repositori kalian masing-masing
Setelah di fork silahkan kalian lakukan clone dari repo hasil fork
git clone nama-repo-masing-masing
cd dataweb
Membuat file .env
cp .env.example .env
nano .env
Atur koneksi database (pastikan databasenya sudah di buat terlebih dahulu)
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_name
DB_USERNAME=db_user
DB_PASSWORD=db_pass
Instal dependensi
composer install
Hasilkan Kunci APP
php artisan key:generate
Migrasi & Penabur Benih
php artisan migrate -s
salin folder gambar yang ada pada folder publik ke dalam folder penyimpanan/aplikasi
Buat symlink untuk penyimpanan
php artisan storage:link
```

Poster film disediakan di `public/template/images` dan dipakai langsung oleh halaman film; tidak perlu menyalin gambar ke storage atau membuat symlink.
