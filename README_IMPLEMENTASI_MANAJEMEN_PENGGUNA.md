# Patch Manajemen Pengguna SIPERDIN

Patch ini mengisi halaman Manajemen Pengguna yang sebelumnya kosong dan melengkapi proses pengelolaan akun sesuai matriks RBAC SIPERDIN.

## File yang diperbarui

- `app/Http/Controllers/UserController.php`
- `routes/web.php`
- `resources/views/user/index.blade.php`
- `resources/views/user/create.blade.php`
- `resources/views/user/edit.blade.php`
- `tests/Feature/UserManagementTest.php` (pengujian fitur tambahan)

Tidak ada migration baru dan tidak ada perubahan struktur tabel.

## Cara menerapkan patch

1. Buat salinan/backup folder project SIPERDIN terlebih dahulu.
2. Ekstrak isi ZIP patch ke folder root project Laravel, misalnya `C:\laragon\www\siperdin`.
3. Pilih **Replace/Timpa** jika Windows meminta konfirmasi file.
4. Buka terminal VS Code pada folder project, lalu jalankan:

   ```bash
   php artisan optimize:clear
   php artisan route:list --path=user
   ```

5. Pastikan route berikut muncul: `user.index`, `user.create`, `user.store`, `user.edit`, `user.update`, `user.role`, `user.status`, dan `user.reset-password`.
6. Jalankan aplikasi melalui Laragon atau `php artisan serve`, kemudian buka `http://127.0.0.1:8000/user`.

Jika Vite belum berjalan, buka terminal kedua pada folder project dan jalankan `npm run dev`. Terminal tersebut harus tetap terbuka selama pengembangan. Untuk penggunaan tanpa Vite dev server, jalankan `npm run build` setelah dependency Node.js terpasang. Jika `npm run dev` gagal dan halaman tidak memuat CSS/JavaScript, periksa file `public/hot`: hapus file tersebut hanya ketika Vite dev server memang tidak sedang berjalan. File `public/hot` yang tertinggal membuat Laravel tetap mencoba mengambil aset dari `http://[::1]:5173`, meskipun server Vite sudah berhenti. Folder `public/build` dan `public/build/manifest.json` tetap dipertahankan untuk memakai aset hasil build.

## Fungsi yang tersedia

- Daftar akun pengguna dengan pencarian username, nama pegawai, NIP, dan satuan kerja.
- Filter daftar berdasarkan role dan status akun.
- Ringkasan jumlah akun, akun aktif, dan akun nonaktif.
- Pembuatan akun dengan username dan password awal.
- Penghubungan akun ke data pegawai.
- Penetapan satu role internal per akun sesuai matriks RBAC.
- Perubahan username dan penautan pegawai.
- Aktivasi dan deaktivasi akun tanpa menghapus riwayat.
- Reset password oleh Superadmin tanpa email.
- Pencatatan aktivitas pembuatan akun, perubahan akun, perubahan role, perubahan status, dan reset password.

## Aturan penting

- Identitas login tetap menggunakan **username dan password**; tidak ada field atau proses email.
- Guest tetap merupakan pengunjung publik tanpa role Spatie.
- Role yang tersedia hanya Superadmin, Operator Data, Operator Satker, dan Admin Keuangan.
- Setiap akun diberi satu role melalui antarmuka agar pemisahan kewenangan operasional tetap terjaga.
- Operator Satker dan Admin Keuangan wajib terhubung dengan data pegawai karena pembatasan akses keduanya mengikuti satuan kerja.
- Superadmin dan Operator Data boleh menggunakan akun tanpa penautan pegawai.
- Halaman ini tidak menyediakan pengubahan konfigurasi role/permission dan tidak menyediakan penghapusan akun.
- Akun yang sedang digunakan tidak dapat dinonaktifkan atau diturunkan dari role Superadmin melalui halaman ini. Sistem juga menjaga agar selalu tersedia setidaknya satu Superadmin aktif.
- Password awal dan password hasil reset minimal mengikuti kebijakan aplikasi (12 karakter) serta disimpan dalam bentuk hash.

## Pengujian

Pengujian tambahan tersedia pada `tests/Feature/UserManagementTest.php`. Jalankan di lingkungan Laragon:

```bash
php artisan test
```

Jika ada kegagalan karena cache lama, jalankan `php artisan optimize:clear`, kemudian ulangi pengujian.
