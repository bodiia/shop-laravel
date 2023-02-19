<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ResetPasswordRequest;
use Domain\Auth\Actions\ResetPasswordAction;
use Domain\Auth\DTO\ResetPasswordDto;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Middleware;
use Spatie\RouteAttributes\Attributes\Post;

#[Middleware(['web', 'guest'])]
class ResetPasswordController extends Controller
{
    #[Get(uri: '/reset-password/{token}', name: 'password.reset')]
    public function index(string $token): View
    {
        return view('auth.reset-password', ['token' => $token]);
    }

    #[Post(uri: '/reset-password', name: 'password.reset.handle')]
    public function handle(ResetPasswordRequest $request, ResetPasswordAction $action): RedirectResponse
    {
        $status = $action->handle(ResetPasswordDto::fromRequest($request));

        if ($status !== Password::PASSWORD_RESET) {
            return back()->withErrors(['email' => __($status)]);
        }

        flash()->info(__($status));

        return to_route('signin.index');
    }
}
