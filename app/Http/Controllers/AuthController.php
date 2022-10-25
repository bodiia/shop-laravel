<?php

namespace App\Http\Controllers;

use App\Http\Requests\SignInRequest;
use App\Http\Requests\SignUpRequest;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showLoginForm(): View
    {
        return view('auth.login');
    }

    public function showRegisterForm(): View
    {
        return view('auth.signup');
    }

    public function signin(SignInRequest $request): RedirectResponse
    {
        if (! auth()->attempt($request->validated())) {
            return back()
                ->withErrors([
                    'email' => 'The provided credentials do not match our records.',
                ])
                ->onlyInput('email');
        }

        $request->session()->regenerate();

        return redirect()->intended(route('home'));
    }

    public function signup(SignUpRequest $request): RedirectResponse
    {
        $attributes = [...$request->validated(),'password' => Hash::make($request->password)];

        /** @var User&Authenticatable $user */
        $user = User::query()->create($attributes);

        event(new Registered($user));

        auth()->login($user);

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    public function logout(Request $request): RedirectResponse
    {
        auth()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect(RouteServiceProvider::HOME);
    }
}
