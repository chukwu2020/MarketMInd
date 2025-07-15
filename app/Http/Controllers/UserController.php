<?php

namespace App\Http\Controllers;

use App\Models\ContactUSMessage;
use App\Models\Deposit;
use App\Models\Investment;
use App\Models\Message;
use App\Models\Plan;
use App\Models\User;
use App\Models\Wallet;
use App\Models\Withdrawal;
use App\Models\WithdrawalCard;

use App\Mail\OtpMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;

class UserController extends Controller
{
    public function signup()
    {
        return view('auth.register');
    }

    public function createUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'        => 'required|string',
            'username'    => 'required|string|unique:users,username|max:255',
            'email'       => 'required|email|unique:users,email|max:255',
            'phone'       => 'required|string|max:20',
            'country' => 'nullable|string|max:100',
            'password'    => [
                'required',
                'min:8',
                'max:40',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/'
            ],
            'referral_id' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $referrerInput = session('referrer') ?? $request->input('referral_id');
        $referredBy = null;

        if ($referrerInput) {
            $referrerUser = User::where('referral_link', 'LIKE', "%$referrerInput")->first();
            if ($referrerUser) {
                $referredBy = $referrerUser->id;
            }
        }

        $newOtp = rand(100000, 999999);

        $user = new User();
        $user->name = $request->name;


        $user->username = $request->username;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->country = $request->country;
        $user->password = Hash::make($request->password);
        $user->role_as = '0';
        $user->email_verification_otp = $newOtp;
        $user->referred_by = $referredBy;
        $user->email_verification_token = Str::random(40);

        if ($user->save()) {
            $refCode = 'BGS-' . now()->format('Y-W') . '-' . strtoupper(Str::random(4)) . '-' . $user->id;
            $user->referral_link = url('sign-up') . '?ref=' . $refCode;
            $user->save();

            session()->forget('referrer');

            $verificationUrl = URL::temporarySignedRoute(
                'verify.otp',
                now()->addMinutes(30),
                ['token' => $user->email_verification_token]
            );

            Mail::to($user->email)->send(new OtpMail($newOtp, $verificationUrl));

            return redirect()->route('verify.otp', ['token' => $user->email_verification_token]);
        }

        return back()->with('error', 'Registration failed');
    }

    public function showVerifyOtpForm(Request $request, $token)
    {
        $user = User::where('email_verification_token', $token)->firstOrFail();
        $maskedEmail = $this->maskEmail($user->email);

        return view('auth.verify', [
            'token' => $token,
            'email' => $maskedEmail
        ]);
    }

    public function submitOtp(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'otp'   => 'required|numeric|digits:6'
        ]);

        $user = User::where('email_verification_token', $request->token)->firstOrFail();

        if ($user->email_verification_otp != $request->otp) {
            return back()->withErrors(['otp' => 'Invalid verification code.']);
        }

        $user->update([
            'email_verified_at'        => now(),
            'email_verification_token' => null,
            'email_verification_otp'   => null
        ]);

        return redirect()->route('login')->with('success', 'Registration sucessful and Email verified. Please login.');
    }

    public function resendOtp(Request $request)
    {
        $request->validate([
            'token' => 'required',
        ]);

        try {
            $user = User::where('email_verification_token', $request->token)->firstOrFail();
            $newOtp = rand(100000, 999999);
            $user->email_verification_otp = $newOtp;
            $user->save();

            $verificationUrl = URL::temporarySignedRoute(
                'verify.otp',
                now()->addMinutes(30),
                ['token' => $user->email_verification_token]
            );

            Mail::to($user->email)->send(new OtpMail($newOtp, $verificationUrl));

            return back()->with('success', 'A new OTP has been sent to your email.');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to resend OTP. Try again later.');
        }
    }

    private function maskEmail($email)
    {
        $parts = explode('@', $email);
        $username = $parts[0];
        $domain = $parts[1] ?? '';

        $masked = substr($username, 0, 1) . str_repeat('*', max(0, strlen($username) - 2)) . substr($username, -1);

        return $masked . '@' . $domain;
    }

    public function user_dashboard()
    {
        $user = auth()->user();

        $cardExists = WithdrawalCard::where('user_id', $user->id)->exists();
        $totalInvested = $user->investments()->sum('amount_invested');
        $transactions = collect();

        $deposits = Deposit::where('user_id', $user->id)->latest()->take(5)->get()->map(function ($deposit) {
            return [
                'type'      => 'Deposit',
                'amount'    => $deposit->amount_deposited,
                'status'    => $deposit->status ? 'Completed' : 'Pending',

                'date'      => $deposit->created_at,
                'reference' => 'DEP-' . $deposit->id,
                'icon'      => 'bank-transfer-in'
            ];
        });

        $withdrawals = Withdrawal::where('user_id', $user->id)->latest()->take(5)->get()->map(function ($withdrawal) {
            return [
                'type'      => 'Withdrawal',
                'amount'    => $withdrawal->amount,

                'status' => $withdrawal->status === 'pending' ? 'Pending' : 'Approved',

                'date'      => $withdrawal->created_at,
                'reference' => 'WD-' . $withdrawal->id,
                'icon'      => 'bank-transfer-out'
            ];
        });

 if (session('certShowAt') && session('certShowAt') < now()->timestamp) {
        session()->forget('certShowAt');
    }
    $overlayCountToday = session('overlayCountToday', 0);



    $recentActivities = $transactions->merge($deposits)->merge($withdrawals)
        ->sortByDesc('date')
        ->take(5);

    return view('dashboard.index', compact('user', 'cardExists', 'totalInvested', 'recentActivities','overlayCountToday'));
}

    public function plans_header()
    {
        $plans = Plan::where('status', 'active')->get();
        return view('snippets.plans_header', compact('plans'));
    }

    public function About_Us()
    {
        return view('snippets.AboutUs_header');
    }

    public function services()
    {
        return view('snippets.services_header');
    }

    public function contactus()
    {
        return view('snippets.contactus_header');
    }

    public function send(Request $request)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'phone'   => 'nullable|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        $validated['user_id'] = auth()->id();

        ContactUSMessage::create($validated);

        return back()->with('success', 'Message sent successfully!');
    }
}
