SIPERDIN - Layout horizontal overflow fix

Cara memasang:
1. Ekstrak ZIP ini pada folder root project SIPERDIN (folder yang berisi artisan).
2. Izinkan file resources/views/layouts/app.blade.php ditimpa.
3. Jalankan: php artisan view:clear
4. Refresh browser dengan Ctrl + F5.

Perubahan:
- Menambahkan min-w-0 pada area utama layout agar konten tidak memaksa lebar flex melebihi viewport.
- Membatasi main ke lebar area yang tersedia; tabel tetap dapat di-scroll secara horizontal di dalam kontainernya.

Tidak ada perubahan database atau migration.
