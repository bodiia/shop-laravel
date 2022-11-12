<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\SignUpRequest;
use App\Providers\RouteServiceProvider;
use Domain\Auth\Actions\SignUpUserAction;
use Domain\Auth\DTO\SignUpUserDto;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SignUpController extends Controller
{
    public function index(): View
    {
        return view('auth.signup');
    }

    public function handle(SignUpRequest $request, SignUpUserAction $action): RedirectResponse
    {
        $user = $action->handle(SignUpUserDto::fromArray($request->validated()));

        auth()->login($user);

        return redirect()->intended(RouteServiceProvider::HOME);
    }
}
