<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\SignUpRequest;
use App\Providers\RouteServiceProvider;
use Domain\Auth\Contracts\RegisterUserContract;
use Domain\Auth\DTO\RegisterUserDto;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SignUpController extends Controller
{
    public function index(): View
    {
        return view('auth.signup');
    }

    public function handle(SignUpRequest $request, RegisterUserContract $action): RedirectResponse
    {
        $action->handle(RegisterUserDto::fromRequest($request));

        return redirect()->intended(RouteServiceProvider::HOME);
    }
}
