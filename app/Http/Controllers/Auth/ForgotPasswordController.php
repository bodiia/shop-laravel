<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ForgotPasswordRequest;
use Domain\Auth\Actions\ForgotPasswordAction;
use Domain\Auth\DTO\ForgotPasswordDto;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;
use Spatie\RouteAttributes\Attributes\Get;
use Spatie\RouteAttributes\Attributes\Middleware;
use Spatie\RouteAttributes\Attributes\Post;

#[Middleware(['web', 'guest'])]
class ForgotPasswordController extends Controller
{
    #[Get(uri: '/forgot-password', name: 'forgot.index')]
    public function index(): View
    {
        return view('auth.forgot-password');
    }

    #[Post(uri: '/forgot-password', name: 'forgot.handle')]
    public function handle(ForgotPasswordRequest $request, ForgotPasswordAction $action): RedirectResponse
    {
        $status = $action->handle(ForgotPasswordDto::fromRequest($request));

        if ($status !== Password::RESET_LINK_SENT) {
            return back()->withErrors(['email' => __($status)]);
        }

        flash()->info(__($status));

        return back();
    }
}
