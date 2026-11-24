<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Support\Rbac\PermissionMatrix;
use Illuminate\Database\Seeder;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        foreach (PermissionMatrix::rolePermissions() as $roleName => $permissionNames) {
            $role = Role::findByName($roleName, PermissionMatrix::GUARD);
            $role->syncPermissions($permissionNames);
        }

        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }
}
