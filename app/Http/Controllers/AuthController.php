<?php

namespace App\Http\Controllers;

use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Requests\SignInRequest;
use App\Http\Requests\SignUpRequest;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Laravel\Socialite\Facades\Socialite;

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

    public function forgot(): View
    {
        return view('auth.forgot-password');
    }

    public function forgotPassword(ForgotPasswordRequest $request): RedirectResponse
    {
        $status = Password::sendResetLink($request->validated());

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['message' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    }

    public function reset(string $token): View
    {
        return view('auth.reset-password', ['token' => $token]);
    }

    public function resetPassword(ResetPasswordRequest $request): RedirectResponse
    {
        $status = Password::reset($request->validated(), function (User $user, string $password) {
            $user
                ->forceFill(['password' => Hash::make($password)])
                ->setRememberToken(Str::random(60));

            $user->save();

            event(new PasswordReset($user));
        });

        return $status === Password::PASSWORD_RESET
            ? to_route('login.form')->with(['message' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    }

    public function githubRedirect(): RedirectResponse
    {
        return Socialite::driver('github')->redirect();
    }

    public function github(): RedirectResponse
    {
        $githubUser = Socialite::driver('github')->user();

        if (User::query()->where('email', $githubUser->getEmail())->exists()) {
            return to_route('login.form')->withErrors([
                'email' => __('validation.unique', ['attribute' =>'email'])
            ]);
        }

        $attributes = [
            'name' => $githubUser->getName() ?? $githubUser->getNickname(),
            'email' => $githubUser->getEmail(),
            'password' => Hash::make($githubUser->getEmail()),
        ];

        /** @var User&Authenticatable $user */
        $user = User::query()
            ->updateOrCreate(['github_id' => $githubUser->getId()], $attributes);

        auth()->login($user);

        return redirect()->intended(RouteServiceProvider::HOME);
    }
}
