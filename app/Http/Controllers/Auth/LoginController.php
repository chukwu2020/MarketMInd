<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Auth\Events\Registered;

class LoginController extends Controller
{
    use \Illuminate\Foundation\Auth\AuthenticatesUsers;

    /**
     * Show the login form.
     *
     * @return \Illuminate\View\View
     */
  public function showLoginForm()
{
    if (auth()->check()) {
        // Redirect already logged-in users
        return redirect()->route('user_dashboard'); // or any dashboard/home route
    }

    return view('auth.login'); // Continue if not logged in
}


    /**
     * Handle the authenticated user.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\Response
     * 
     */

    // protected $redirectTo = '/home';



    protected function authenticated(Request $request, $user)
    {

 

     session()->forget('clearCertOverlay'); // remove it after one use
session()->put('clearCertOverlay', true); // to trigger Alpine reset

    $today = now()->toDateString();
    $shownToday = session("certShownDate") === $today;
    $count = session("certShownCount", 0);

    // Only set to show if under daily limit
    if (!$shownToday || $count < 2) {
        // Set a timestamp for when it should appear (1 minute from now)
        session([
            'certShowAt' => now()->addMinute()->timestamp,
            'certShownDate' => $today,
            'certShownCount' => $shownToday ? $count + 1 : 1
        ]);
    }

        if (is_null($user->email_verified_at)) {
            Auth::logout();

            return redirect()->route('login')->withErrors([
                'email' => 'You must verify your email address before logging in.'
            ]);
        }

        if ($user->role_as == 1) { // Admin role
            return redirect()->route('admin_dashboard')->with('message', 'Welcome to your admin dashboard');
        } elseif ($user->role_as == 0) { // User role
            return redirect()->route('user_dashboard')->with('message', 'Welcome to your user dashboard');
        } else {
            Auth::logout();
            return redirect()->route('login')->withErrors([
                'role_as' => 'Your account role is not valid.'
            ]);
        }
    }




    /**
     * Send the verification email to the user.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */



    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout'); // Ensure only guests can access login
        $this->middleware('auth')->only('logout');  // Only logged-in users can logout
    }
}
