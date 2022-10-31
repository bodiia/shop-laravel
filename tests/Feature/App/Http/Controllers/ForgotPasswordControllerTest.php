<?php

namespace Tests\Feature\App\Http\Controllers;

use Database\Factories\UserFactory;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\RequestFactories\ForgotPasswordRequestFactory;
use Tests\TestCase;

class ForgotPasswordControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_guest_can_view_forgot_password_page()
    {
        $this
            ->get(route('forgot.index'))
            ->assertOk()
            ->assertViewIs('auth.forgot-password');
    }

    public function test_a_user_receives_email_with_a_password_reset_link()
    {
        Notification::fake();

        $attributes = ['email' => 'test@gmail.com'];

        $user = UserFactory::new()->create($attributes);

        $request = ForgotPasswordRequestFactory::new()->create($attributes);

        $this
            ->post(route('forgot.handle'), $request)
            ->assertValid()
            ->assertRedirect();

        Notification::assertSentTo($user, ResetPassword::class);
    }
}
