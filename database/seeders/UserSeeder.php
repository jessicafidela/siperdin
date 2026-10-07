<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name' => 'Superadmin SIPERDIN',
                'email' => 'superadmin@siperdin.test',
                'password' => 'password123',
                'role' => 'Superadmin',
            ],
            [
                'name' => 'Operator Data SIPERDIN',
                'email' => 'operator.data@siperdin.test',
                'password' => 'password123',
                'role' => 'Operator Data',
            ],
            [
                'name' => 'Operator Satker SIPERDIN',
                'email' => 'operator.satker@siperdin.test',
                'password' => 'password123',
                'role' => 'Operator Satker',
            ],
            [
                'name' => 'Admin Keuangan SIPERDIN',
                'email' => 'admin.keuangan@siperdin.test',
                'password' => 'password123',
                'role' => 'Admin Keuangan',
            ],
        ];

        foreach ($users as $data) {
            $user = User::firstOrCreate(
                [
                    'email' => $data['email'],
                ],
                [
                    'name' => $data['name'],
                    'password' => Hash::make($data['password']),
                ]
            );

            $user->assignRole($data['role']);
        }
    }
}
