<?php

namespace App\Http\Controllers\Auth;

use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\User;
use Mockery;
use Tests\TestCase;

class SocialAuthenticationControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_signin_with_socials()
    {
        $abstractUser = Mockery::mock(User::class);

        $abstractUser->shouldReceive('getId')->andReturn(rand());
        $abstractUser->shouldReceive('getName')->andReturn(Str::random(10));
        $abstractUser->shouldReceive('getEmail')->andReturn(Str::random() . '@gmail.com');
        $abstractUser->shouldReceive('getNickname')->andReturn(Str::random(10));

        Socialite::shouldReceive('driver->user')->andReturn($abstractUser);

        $this
            ->get(route('socialite.callback', ['driver' => 'github']))
            ->assertRedirect(RouteServiceProvider::HOME);

        $this->assertDatabaseHas('users', [
            'github_id' => $abstractUser->getId(),
            'email' => $abstractUser->getEmail()
        ]);
    }
}
