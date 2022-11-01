<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ForgotPasswordRequest;
use Domain\Auth\Actions\ForgotPasswordAction;
use Domain\Auth\DTO\ForgotPasswordDto;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;

class ForgotPasswordController extends Controller
{
    public function index(): View
    {
        return view('auth.forgot-password');
    }

    public function handle(ForgotPasswordRequest $request, ForgotPasswordAction $action): RedirectResponse
    {
        $status = $action->handle(ForgotPasswordDto::fromRequest($request));

        if ($status !== Password::RESET_LINK_SENT) {
            $errors = ['email' => __($status)];

            return back()->withErrors($errors);
        }

        flash()->info(__($status));

        return back();
    }
}
