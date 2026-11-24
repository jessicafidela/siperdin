<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use RuntimeException;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $username = trim((string) config('siperdin.bootstrap_admin.username'));
        $password = (string) config('siperdin.bootstrap_admin.password');

        if ($username === '' && $password === '') {
            $this->command?->warn(
                'Superadmin tidak dibuat. Isi SIPERDIN_SUPERADMIN_USERNAME dan SIPERDIN_SUPERADMIN_PASSWORD di .env, lalu jalankan seeder kembali.'
            );

            return;
        }

        if ($username === '' || $password === '') {
            throw new RuntimeException(
                'Username dan password bootstrap Superadmin harus diisi bersama-sama di .env.'
            );
        }

        if (strlen($password) < 12) {
            throw new RuntimeException('Password bootstrap Superadmin minimal 12 karakter.');
        }

        $user = User::firstOrCreate(
            ['username' => $username],
            [
                'id_pegawai' => null,
                'password' => $password,
                'status' => 'aktif',
            ]
        );

        $user->syncRoles(['Superadmin']);

        $this->command?->info('Akun bootstrap Superadmin tersedia: '.$username);
    }
}
