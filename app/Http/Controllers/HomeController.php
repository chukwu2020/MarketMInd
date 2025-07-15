<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    

public function index()
{
    if (!Auth::user()->hasVerifiedEmail()) {
        return view('auth.verify');
    }

    // Continue to dashboard if verified
    return view('login');
}


    public function signout()
    {
        Auth::guard('web')->logout();
        return redirect()->route('login')->with('message', 'You have successfully logged out');
    }
}
