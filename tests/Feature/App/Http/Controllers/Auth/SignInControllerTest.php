<?php

namespace App\Http\Controllers\Auth;

use App\Providers\RouteServiceProvider;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class SignInControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_guest_can_view_signin_page()
    {
        $this
            ->get(route('signin.index'))
            ->assertOk()
            ->assertViewIs('auth.signin');
    }

    public function test_a_guest_can_login()
    {
        $attributes = [
            'email' => 'test@gmail.com',
            'password' => '123456789',
        ];

        $user = UserFactory::new()->create([
            ...$attributes,
            'password' => Hash::make($attributes['password'])
        ]);

        $this
            ->post(route('signin.handle'), $attributes)
            ->assertValid()
            ->assertRedirect(RouteServiceProvider::HOME);

        $this->assertAuthenticatedAs($user);
    }

    public function test_a_user_can_logout()
    {
        $user = UserFactory::new()->create();

        $this
            ->actingAs($user)
            ->delete(route('signin.logout'));

        $this->assertGuest();
    }
}
