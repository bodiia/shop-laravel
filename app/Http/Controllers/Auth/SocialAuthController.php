<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Domain\Auth\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{
    public function redirect(string $driver): RedirectResponse
    {
        return Socialite::driver($driver)->redirect();
    }

    public function callback(string $driver): RedirectResponse
    {
        $socialUser = Socialite::driver($driver)->user();

        if (User::query()->where('email', $socialUser->getEmail())->exists()) {
            return to_route('signin.index')
                ->withErrors([
                    'email' => __('validation.unique', ['attribute' =>'email'])
                ]);
        }

        $attributes = [
            'name' => $socialUser->getName() ?? $socialUser->getNickname(),
            'email' => $socialUser->getEmail(),
            'password' => Hash::make($socialUser->getEmail()),
        ];

        $user = User::query()
            ->updateOrCreate([$driver . '_id' => $socialUser->getId()], $attributes);

        auth()->login($user);

        return redirect()->intended(RouteServiceProvider::HOME);
    }
}
