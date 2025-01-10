<?php

namespace App\Http\Controllers\tenant\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;
class VerifyEmailController extends Controller
{
    /**
     * Handle email verification.
     *
     * @param  \Illuminate\Foundation\Auth\EmailVerificationRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke(EmailVerificationRequest $request)
    {
        $request->fulfill();

        return redirect()->route('admin.dashboard')->with('status', 'email-verified');
    }
}
