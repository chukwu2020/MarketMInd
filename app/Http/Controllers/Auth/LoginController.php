<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use \Illuminate\Foundation\Auth\AuthenticatesUsers;

    /**
     * Show the login form.
     *
     * Redirect logged-in users to their dashboard immediately.
     */
    public function showLoginForm()
    {
        if (auth()->check()) {
            // Redirect already logged-in users
            return redirect()->route('user_dashboard');
        }

        return view('auth.login');
    }

    /**
     * Override the login method to safely logout old session if already logged in.
     */
    public function login(Request $request)
    {
        $this->validateLogin($request);

        // If user is already logged in, logout old session & invalidate
        if (Auth::check()) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }

        // Attempt login using trait method
        if ($this->attemptLogin($request)) {
            // Regenerate session after successful login to prevent fixation
            $request->session()->regenerate();

            return $this->sendLoginResponse($request);
        }

        // Failed login response
        return $this->sendFailedLoginResponse($request);
    }

    /**
     * Handle what happens after successful authentication.
     */
    protected function authenticated(Request $request, $user)
    {
        session()->forget('clearCertOverlay');
        session()->put('clearCertOverlay', true);

        $today = now()->toDateString();
        $shownToday = session("certShownDate") === $today;
        $count = session("certShownCount", 0);

        if (!$shownToday || $count < 2) {
            session([
                'certShowAt' => now()->addMinute()->timestamp,
                'certShownDate' => $today,
                'certShownCount' => $shownToday ? $count + 1 : 1,
            ]);
        }

        if (is_null($user->email_verified_at)) {
            Auth::logout();

            return redirect()->route('login')->withErrors([
                'email' => 'You must verify your email address before logging in.'
            ]);
        }

        if ($user->role_as == 1) { // Admin
            return redirect()->route('admin_dashboard')->with('message', 'Welcome to your admin dashboard');
        } elseif ($user->role_as == 0) { // User
            return redirect()->route('user_dashboard')->with('message', 'Welcome to your user dashboard');
        } else {
            Auth::logout();
            return redirect()->route('login')->withErrors([
                'role_as' => 'Your account role is not valid.'
            ]);
        }
    }

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }
}
