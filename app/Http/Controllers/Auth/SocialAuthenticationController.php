<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Domain\Auth\Actions\SocialAuthenticationAction;
use Domain\Auth\DTO\SocialAuthenticationDto;
use Illuminate\Http\RedirectResponse;
use Laravel\Socialite\Contracts\Factory as Socialite;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Middleware;

#[Middleware('web')]
class SocialAuthenticationController extends Controller
{
    public function __construct(private readonly Socialite $socialite)
    {
    }

    #[Get(uri: '/socialite/{driver}/redirect', name: 'socialite.redirect')]
    public function redirect(string $driver): RedirectResponse
    {
        return $this->socialite->driver($driver)->redirect();
    }

    #[Get(uri: '/socialite/{driver}/callback', name: 'socialite.callback')]
    public function callback(string $driver, SocialAuthenticationAction $action): RedirectResponse
    {
        $data = [
            'type' => $driver,
            'user' => $this->socialite->driver($driver)->user(),
        ];

        $action->handle(SocialAuthenticationDto::fromArray($data));

        return redirect()->intended(RouteServiceProvider::HOME);
    }
}
