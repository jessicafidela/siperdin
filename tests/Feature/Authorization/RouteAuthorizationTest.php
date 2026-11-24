<?php

namespace Tests\Feature\Authorization;

use App\Models\User;
use Database\Seeders\PermissionSeeder;
use Database\Seeders\RolePermissionSeeder;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RouteAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed([
            RoleSeeder::class,
            PermissionSeeder::class,
            RolePermissionSeeder::class,
        ]);
    }

    public function test_public_landing_page_is_accessible_without_a_guest_role(): void
    {
        $this->get('/')->assertOk();
        $this->assertGuest();
    }

    public function test_dashboard_requires_an_active_authenticated_internal_user(): void
    {
        $this->get('/dashboard')->assertRedirect(route('login'));

        foreach (['Superadmin', 'Operator Data', 'Operator Satker', 'Admin Keuangan'] as $roleName) {
            $user = User::factory()->create();
            $user->assignRole($roleName);

            $this->actingAs($user)
                ->get('/dashboard')
                ->assertOk();
        }
    }

    public function test_only_superadmin_can_open_user_management_route(): void
    {
        $superadmin = User::factory()->create();
        $superadmin->assignRole('Superadmin');

        $this->actingAs($superadmin)->get('/user')->assertOk();

        foreach (['Operator Data', 'Operator Satker', 'Admin Keuangan'] as $roleName) {
            $user = User::factory()->create();
            $user->assignRole($roleName);

            $this->actingAs($user)
                ->get('/user')
                ->assertForbidden();
        }
    }

    public function test_only_master_data_roles_can_open_master_data_routes(): void
    {
        foreach (['Operator Satker', 'Admin Keuangan'] as $roleName) {
            $user = User::factory()->create();
            $user->assignRole($roleName);

            $this->actingAs($user)
                ->get('/satuan-kerja')
                ->assertForbidden();
        }
    }
}
