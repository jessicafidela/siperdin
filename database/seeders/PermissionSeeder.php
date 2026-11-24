<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Support\Rbac\PermissionMatrix;
use Illuminate\Database\Seeder;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        foreach (PermissionMatrix::permissions() as $name => $description) {
            Permission::updateOrCreate(
                [
                    'name' => $name,
                    'guard_name' => PermissionMatrix::GUARD,
                ],
                [
                    'deskripsi' => $description,
                ]
            );
        }

        // Remove the coarse-grained permission names from the earlier prototype.
        Permission::query()
            ->where('guard_name', PermissionMatrix::GUARD)
            ->whereIn('name', PermissionMatrix::legacyPermissionNames())
            ->delete();

        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }
}
