<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmailVerificationPromptController extends Controller
{
    /**
     * Display the email verification prompt.
     *
     * @param Request $request
     * @return mixed
     */
    public function __invoke(Request $request)
    {
        $user = Auth::user();
        $redirect = $user->admin ? route('admin.dashboard') : route('user.profile.edit');
        return $request->user()->hasVerifiedEmail()
                    ? redirect()->intended($redirect)
                    : view('auth.verify-email');
    }
}
