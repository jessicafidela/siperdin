<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [

            // User Management
            'view users',
            'create users',
            'update users',
            'delete users',
            'assign roles',

            // Master Data
            'view master data',
            'create master data',
            'update master data',
            'delete master data',

            // Travel
            'create travel',
            'view own travel',
            'view all travel',
            'update travel',
            'delete travel',

            // Finance
            'verify travel',
            'add finance data',
            'complete travel',

            // Document
            'generate travel document',
            'generate finance document',

            // Report
            'view reports',
            'export reports',

        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web',
            ]);
        }
    }
}
