<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Support\Rbac\PermissionMatrix;
use Illuminate\Database\Seeder;
use Spatie\Permission\PermissionRegistrar;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Guest is a public visitor, not an authenticated Spatie role.
        Role::query()
            ->where('guard_name', PermissionMatrix::GUARD)
            ->where('name', 'Guest')
            ->delete();

        foreach (PermissionMatrix::roles() as $name => $description) {
            Role::updateOrCreate(
                [
                    'name' => $name,
                    'guard_name' => PermissionMatrix::GUARD,
                ],
                [
                    'deskripsi' => $description,
                    'status' => 'aktif',
                ]
            );
        }

        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }
}
