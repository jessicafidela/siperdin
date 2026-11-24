<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PasswordResetTest extends TestCase
{
    use RefreshDatabase;

    public function test_email_password_reset_screen_is_not_available(): void
    {
        $this->get('/forgot-password')->assertNotFound();
    }

    public function test_email_password_reset_submission_is_not_available(): void
    {
        $this->post('/forgot-password', ['email' => 'user@example.test'])->assertNotFound();
    }
}
