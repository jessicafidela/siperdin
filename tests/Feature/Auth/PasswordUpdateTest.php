<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class PasswordUpdateTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_change_own_password_with_current_password(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->from('/profile')
            ->put('/password', [
                'current_password' => 'password',
                'password' => 'New-Strong-Password-2026!',
                'password_confirmation' => 'New-Strong-Password-2026!',
            ]);

        $response->assertSessionHasNoErrors()->assertRedirect('/profile');
        $this->assertTrue(Hash::check('New-Strong-Password-2026!', $user->fresh()->password));
    }

    public function test_current_password_is_required_to_change_password(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->from('/profile')
            ->put('/password', [
                'current_password' => 'wrong-password',
                'password' => 'New-Strong-Password-2026!',
                'password_confirmation' => 'New-Strong-Password-2026!',
            ])
            ->assertSessionHasErrorsIn('updatePassword', 'current_password')
            ->assertRedirect('/profile');
    }
}
