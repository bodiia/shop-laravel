<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\SignInRequest;
use App\Providers\RouteServiceProvider;
use Domain\Auth\Actions\LogoutUserAction;
use Domain\Auth\Actions\SignInUserAction;
use Domain\Auth\DTO\SignInUserDto;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Spatie\RouteAttributes\Attributes\Delete;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Middleware;
use Spatie\RouteAttributes\Attributes\Post;

#[Middleware('web')]
class SignInController extends Controller
{
    #[Get(uri: '/signin', name: 'signin.index')]
    public function index(): View
    {
        return view('auth.signin');
    }

    #[Post(uri: '/signin', name: 'signin.handle', middleware: 'throttle:auth')]
    public function handle(SignInRequest $request, SignInUserAction $action): RedirectResponse
    {
        if (! $action->handle(SignInUserDto::fromRequest($request))) {
            return back()->withErrors([
                'email' => __('auth.failed'),
            ])->onlyInput('email');
        }

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    #[Delete(uri: '/logout', name: 'signin.logout')]
    public function logout(LogoutUserAction $action): RedirectResponse
    {
        $action->handle();

        return redirect(RouteServiceProvider::HOME);
    }
}
