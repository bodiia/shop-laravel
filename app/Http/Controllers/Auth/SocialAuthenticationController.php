<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Domain\Auth\Actions\SocialAuthenticationAction;
use Domain\Auth\DTO\SocialAuthenticationDto;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthenticationController extends Controller
{
    public function redirect(string $driver): RedirectResponse
    {
        return Socialite::driver($driver)->redirect();
    }

    public function callback(string $driver, SocialAuthenticationAction $action): RedirectResponse
    {
        $data = [
            'type' => $driver,
            'user' => Socialite::driver($driver)->user(),
        ];

        Auth::login($action->handle(SocialAuthenticationDto::fromArray($data)));

        return Redirect::intended(RouteServiceProvider::HOME);
    }
}
