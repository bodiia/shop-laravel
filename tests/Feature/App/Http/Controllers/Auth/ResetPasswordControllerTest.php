<?php

namespace App\Http\Controllers\Auth;

use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Password;
use Tests\TestCase;

class ResetPasswordControllerTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;

    public function test_a_user_can_view_reset_password_page()
    {
        $attributes = ['email' => 'test@gmail.com'];

        $user = UserFactory::new()->create($attributes);

        $token = Password::createToken($user);

        $this
            ->get(route('password.reset', ['token' => $token]))
            ->assertOk()
            ->assertViewIs('auth.reset-password');
    }

    public function test_a_user_can_reset_their_password()
    {
        Event::fake();

        $attributes = ['email' => 'test@gmail.com'];

        $user = UserFactory::new()->create($attributes);

        $token = Password::createToken($user);

        $request = [
            ...$attributes,
            'password' => '123456789',
            'password_confirmation' => '123456789',
            'token' => $token,
        ];

        $this
            ->post(route('password.reset.handle'), $request)
            ->assertValid()
            ->assertRedirect();

        $userWithUpdatedPassword = $user->fresh();

        $this->assertNotEquals($userWithUpdatedPassword->password, $user->password);
    }
}
