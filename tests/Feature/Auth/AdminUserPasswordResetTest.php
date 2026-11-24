<?php

namespace Tests\Feature\Auth;

use App\Models\Permission;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminUserPasswordResetTest extends TestCase
{
    use RefreshDatabase;

    public function test_authorized_administrator_can_reset_another_users_password(): void
    {
        $admin = User::factory()->create();
        $target = User::factory()->create();

        $admin->givePermissionTo(Permission::create([
            'name' => 'users.reset-password',
            'guard_name' => 'web',
        ]));

        $response = $this->actingAs($admin)->put(route('user.reset-password', $target), [
            'password' => 'New-Strong-Password-2026!',
            'password_confirmation' => 'New-Strong-Password-2026!',
        ]);

        $response->assertRedirect();
        $this->assertTrue(Hash::check('New-Strong-Password-2026!', $target->fresh()->password));
        $this->assertDatabaseHas('activity_log', [
            'id_user' => $admin->id_user,
            'aktivitas' => 'reset_password_pengguna',
        ]);
    }

    public function test_administrator_cannot_use_admin_reset_route_for_own_account(): void
    {
        $admin = User::factory()->create();
        $admin->givePermissionTo(Permission::create([
            'name' => 'users.reset-password',
            'guard_name' => 'web',
        ]));

        $this->actingAs($admin)
            ->put(route('user.reset-password', $admin), [
                'password' => 'New-Strong-Password-2026!',
                'password_confirmation' => 'New-Strong-Password-2026!',
            ])
            ->assertForbidden();
    }
}
