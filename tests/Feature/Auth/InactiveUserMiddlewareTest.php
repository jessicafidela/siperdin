<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InactiveUserMiddlewareTest extends TestCase
{
    use RefreshDatabase;

    public function test_deactivated_user_is_logged_out_when_accessing_protected_page(): void
    {
        $user = User::factory()->inactive()->create();

        $this->actingAs($user)
            ->get('/dashboard')
            ->assertRedirect(route('login'));

        $this->assertGuest();
    }
}
