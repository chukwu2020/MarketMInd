<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Deposit;
use App\Models\Plan;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class DepositController extends Controller
{
    // Show deposit form
    public function userDeposit()
    {
        $plans = Plan::where('status', 'active')->get();
        $wallets = Wallet::all();
        return view('dashboard.deposit.create-deposit', compact('plans', 'wallets'));
    }

    // Handle user deposit input
    public function userMakeDeposit(Request $request)
    {
        try {
            $request->validate([
                'plan_id' => 'required|exists:plans,id',
                'wallet_id' => 'required|exists:wallets,id',
                'amount' => 'required|numeric|min:1',
            ]);

            $plan = Plan::findOrFail($request->plan_id);

            if ($request->amount < $plan->minimum_amount || $request->amount > $plan->maximum_amount) {
                return back()->with('error', "Deposit amount must be between {$plan->minimum_amount} and {$plan->maximum_amount}.");
            }

            Session::put('deposit_details', [
                'user_id' => Auth::id(),
                'plan_id' => $request->plan_id,
                'wallet_id' => $request->wallet_id,
                'amount_deposited' => $request->amount,
            ]);

            return redirect()->route('deposit.confirm');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    // Confirm deposit step
    public function confirmDeposit()
    {
        if (!Session::has('deposit_details')) {
            // Redirect to deposit form (GET route)
            return redirect()->route('user.deposit')->withErrors(['error' => 'No deposit session found.']);
        }

        $depositDetails = Session::get('deposit_details');
        $wallet = Wallet::find($depositDetails['wallet_id']);

        return view('dashboard.deposit.confirm-deposit', compact('wallet'));
    }

    // Submit deposit with proof
   // Submit deposit with proof
public function submitDeposit(Request $request)
{
    try {
        if (!Session::has('deposit_details')) {
            return redirect()->route('user.deposit-history')->with('success', 'Deposit not successful!');
        }

        $request->validate([
            'proof' => 'required|image|mimes:jpeg,png,jpg|max:5120',

        ]);

        $depositDetails = Session::get('deposit_details');

        // Handle proof image upload using storage
        $proofPath = $request->file('proof')->store('proofs', 'public');

        // Save to DB
        $deposit = new Deposit();
        $deposit->user_id = $depositDetails['user_id'];
        $deposit->plan_id = $depositDetails['plan_id'];
        $deposit->wallet_id = $depositDetails['wallet_id'];
        $deposit->amount_deposited = $depositDetails['amount_deposited'];
        $deposit->status = 0; // pending
        $deposit->proof = $proofPath;
        $deposit->save();

        Session::forget('deposit_details');

        $user = User::find($deposit->user_id);
        $user->notify(new \App\Notifications\TransactionNotification(
            'Deposit Submitted',
            'Your deposit of $' . number_format($deposit->amount_deposited, 2) . ' has been received and is awaiting approval.'
        ));

        return redirect()->route('user.deposit-history')->with('success', 'Deposit submitted successfully. Awaiting approval.');
    } catch (\Exception $e) {
        return back()->with('error', $e->getMessage());
    }
}


    // Show deposit history
    public function depositHistory()
    {
        $deposits = Deposit::with(['plan', 'wallet'])
            ->where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('dashboard.deposit.deposit-history', compact('deposits'));
    }
}
