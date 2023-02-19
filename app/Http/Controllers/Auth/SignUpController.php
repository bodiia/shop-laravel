<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\SignUpRequest;
use App\Providers\RouteServiceProvider;
use Domain\Auth\Actions\SignUpUserAction;
use Domain\Auth\DTO\SignUpUserDto;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Middleware;
use Spatie\RouteAttributes\Attributes\Post;

#[Middleware('web')]
class SignUpController extends Controller
{
    #[Get(uri: '/signup', name: 'signup.index')]
    public function index(): View
    {
        return view('auth.signup');
    }

    #[Post(uri: '/signup', name: 'signup.handle', middleware: 'throttle:auth')]
    public function handle(SignUpRequest $request, SignUpUserAction $action): RedirectResponse
    {
        $action->handle(SignUpUserDto::fromRequest($request));

        return redirect()->intended(RouteServiceProvider::HOME);
    }
}
