<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        $superadmin = Role::findByName('Superadmin');
        $operatorData = Role::findByName('Operator Data');
        $adminKeuangan = Role::findByName('Admin Keuangan');
        $operatorSatker = Role::findByName('Operator Satker');

        // Superadmin
        $superadmin->syncPermissions([
            'view users',
            'create users',
            'update users',
            'delete users',
            'assign roles',

            'view master data',
            'create master data',
            'update master data',
            'delete master data',

            'view all travel',

            'view reports',
            'export reports',
        ]);

        // Operator Data
        $operatorData->syncPermissions([
            'view users',
            'create users',
            'update users',
            'delete users',
            'assign roles',

            'view master data',
            'create master data',
            'update master data',
            'delete master data',
        ]);

        // Admin Keuangan
        $adminKeuangan->syncPermissions([
            'view own travel',

            'verify travel',
            'add finance data',
            'complete travel',

            'generate finance document',

            'view reports',
        ]);

        // Operator Satker
        $operatorSatker->syncPermissions([
            'create travel',

            'view own travel',
            'update travel',
            'delete travel',

            'generate travel document',

            'view reports',
        ]);
    }
}
