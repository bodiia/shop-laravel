<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Domain\Auth\Actions\SocialAuthenticationAction;
use Domain\Auth\DTO\SocialAuthenticationDto;
use Illuminate\Http\RedirectResponse;
use Laravel\Socialite\Contracts\Factory as Socialite;

class SocialAuthenticationController extends Controller
{
    public function __construct(private readonly Socialite $socialite)
    {
    }

    public function redirect(string $driver): RedirectResponse
    {
        return $this->socialite->driver($driver)->redirect();
    }

    public function callback(string $driver, SocialAuthenticationAction $action): RedirectResponse
    {
        $data = [
            'type' => $driver,
            'user' => $this->socialite->driver($driver)->user(),
        ];

        auth()->login($action->handle(SocialAuthenticationDto::fromArray($data)));

        return redirect()->intended(RouteServiceProvider::HOME);
    }
}
