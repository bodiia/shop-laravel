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

class SignInController extends Controller
{
    public function index(): View
    {
        return view('auth.signin');
    }

    public function handle(SignInRequest $request, SignInUserAction $action): RedirectResponse
    {
        if (! $action->handle(SignInUserDto::fromArray($request->validated()))) {
            $errors = [
                'email' => 'The provided credentials do not match our records.',
            ];

            return back()->withErrors($errors)->onlyInput('email');
        }

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    public function logout(LogoutUserAction $action): RedirectResponse
    {
        $action->handle();

        return redirect(RouteServiceProvider::HOME);
    }
}