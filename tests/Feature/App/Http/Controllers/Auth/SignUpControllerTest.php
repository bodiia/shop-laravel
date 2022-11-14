<?php

namespace App\Http\Controllers\Auth;

use App\Listeners\SendGreetingEmailToUser;
use App\Providers\RouteServiceProvider;
use Domain\Auth\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class SignUpControllerTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;

    public function test_a_guest_can_view_signup_page()
    {
        $this
            ->get(route('signup.index'))
            ->assertOk()
            ->assertViewIs('auth.signup');
    }

    public function test_a_guest_can_register()
    {
        Event::fake();
        Notification::fake();

        $request = [
            'name' => $this->faker->firstName(),
            'email' => 'test@gmail.com',
            'password' => '123456789',
            'password_confirmation' => '123456789',
        ];

        $response = $this->post(route('signup.handle'), $request);

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
