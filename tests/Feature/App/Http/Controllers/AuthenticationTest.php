<?php

namespace App\Http\Controllers;

use App\Http\Requests\SignInRequest;
use App\Http\Requests\SignUpRequest;
use App\Listeners\SendGreetingEmailToUser;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_guest_can_view_login_page()
    {
        $this
            ->get(route('login.form'))
            ->assertOk()
            ->assertViewIs('auth.login');
    }

    public function test_a_guest_can_view_register_page()
    {
        $this
            ->get(route('signup.form'))
            ->assertOk()
            ->assertViewIs('auth.signup');
    }

    public function test_a_guest_can_view_forgot_password_page()
    {
        $this
            ->get(route('password.request'))
            ->assertOk()
            ->assertViewIs('auth.forgot-password');
    }

    public function test_a_guest_can_login()
    {
        $attributes = [
            'email' => 'test@gmail.com',
            'password' => '123456789',
        ];

        $user = User::factory()->create([
            ...$attributes,
            'password' => Hash::make($attributes['password'])
        ]);

        $request = SignInRequest::factory()->create($attributes);

        $this
            ->post(route('login.signin'), $request)
            ->assertValid()
            ->assertRedirect(RouteServiceProvider::HOME);

        $this->assertAuthenticatedAs($user);
    }

    public function test_a_user_can_logout()
    {
        $user = User::factory()->create();

        $this
            ->actingAs($user)
            ->delete(route('logout'));

        $this->assertGuest();
    }

    public function test_a_registration_create_a_user()
    {
        Event::fake();
        Notification::fake();

        $request = SignUpRequest::factory()->create();

        $response = $this->post(route('register.signup'), $request);

        $response
            ->assertValid()
            ->assertRedirect(RouteServiceProvider::HOME);

        $this->assertDatabaseHas('users', ['email' => $request['email']]);

        $user = User::query()->firstWhere('email', $request['email']);

        $this->assertAuthenticatedAs($user);

        Event::assertDispatched(Registered::class);
        Event::assertListening(Registered::class, SendGreetingEmailToUser::class);
    }
}
