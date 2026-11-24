<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_profile_page_displays_account_identity(): void
    {
        $user = User::factory()->create([
            'username' => 'pengguna.uji',
        ]);

        $this->actingAs($user)
            ->get('/profile')
            ->assertOk()
            ->assertSee('pengguna.uji')
            ->assertSee('Informasi Akun');
    }

    public function test_users_cannot_edit_account_identity_themselves(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->patch('/profile', [
                'username' => 'username-baru',
            ])
            ->assertMethodNotAllowed();

        $this->assertDatabaseHas('users', [
            'id_user' => $user->id_user,
            'username' => $user->username,
        ]);
    }

    public function test_users_cannot_delete_their_own_accounts(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->delete('/profile', [
                'password' => 'password',
            ])
            ->assertMethodNotAllowed();

        $this->assertDatabaseHas('users', [
            'id_user' => $user->id_user,
        ]);
    }
}
