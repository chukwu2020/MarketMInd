<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\OtpPasswordResetMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class ForgotPasswordController extends Controller
{
    public function showOtpRequestForm()
    {
        return view('auth.passwords.email');
    }

    public function showLinkRequestForm()
    {
        return redirect()->route('password.request');
    }

    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $otp = rand(100000, 999999);

        DB::table('password_resets')->updateOrInsert(
            ['email' => $request->email],
            ['token' => $otp, 'created_at' => now()]
        );

        $user = User::where('email', $request->email)->first(); // ✅ fetch user

        // ✅ pass both $otp and $user
        Mail::to($request->email)->send(new OtpPasswordResetMail($otp, $user));

        session(['otp_email' => $request->email]);

        return redirect()->route('password.otp.form')
            ->with('status', 'An OTP has been sent to your email.');
    }

    public function showOtpVerifyForm()
    {
        $email = session('otp_email');
        if (!$email) {
            return redirect()->route('password.request')
                ->withErrors(['email' => 'Session expired. Please request a new OTP.']);
        }

        return view('auth.passwords.otp_verify', compact('email'));
    }

    public function verifyOtpAndReset(Request $request)
    {
        $messages = [
            'password.regex' => 'Password must contain at least one uppercase letter, one lowercase letter, and one number.',
        ];

        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|digits:6',
            'password' => [
                'required',
                'confirmed',
                'min:8',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
            ],
        ], $messages);

        $user = User::where('email', $request->email)->first();
        $record = DB::table('password_resets')->where('email', $request->email)->first();

        if (!$user || !$record || $record->token != $request->otp || now()->diffInMinutes($record->created_at) > 15) {
            return back()->withErrors(['otp' => 'Invalid or expired OTP.']);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        DB::table('password_resets')->where('email', $request->email)->delete();

        return redirect()->route('login')->with('success', 'Password successfully reset!');
    }
}
