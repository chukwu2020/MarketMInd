<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Support\Facades\Auth;

class VerificationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Email Verification Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling email verification for any
    | user that recently registered with the application. Emails may also
    | be re-sent if the user didn't receive the original email message.
    |
    */

    // use VerifiesEmails;
// public function verify(EmailVerificationRequest $request)
// {
//     // Check if the user's email is already verified
//     if ($request->user()->hasVerifiedEmail()) {
//         return redirect()->route('user_dashboard')->with('status', 'Email already verified. Welcome!');
//     }

//     // Mark the email as verified
//     if ($request->user()->markEmailAsVerified()) {
//         event(new Verified($request->user()));
//     }
//  auth()->login($request->user());
//     // Redirect to the appropriate dashboard (user or admin) based on their role
//     if ($request->user()->role_as == '1') { // Admin role
//         return redirect()->route('admin_dashboard')->with('status', 'Email verified. Welcome to the Admin Dashboard!');
//     }

//     // For regular users
//     return redirect()->route('user_dashboard')->with('status', 'Email verified. Welcome to your Dashboard!');
// }



    /**
     * Where to redirect users after verification.
     *
     * @var string
     */
    // protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }
}
