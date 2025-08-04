<?php

namespace App\Http\Controllers;

use App\Models\Withdrawal;
use App\Models\WithdrawalCard;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WithdrawalController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $withdrawals = Withdrawal::with(['investment.plan'])
            ->where('user_id', $user->id)
            ->latest()
            ->get();

        return view('dashboard.withdrawal.index', compact('withdrawals'));
    }

    public function generateCard(Request $request)
    {
        $user = Auth::user();

        if ($user->withdrawalCard) {
            return back()->with('error', 'Card already generated.');
        }

        WithdrawalCard::create([
            'user_id' => $user->id,
            'card_number' => str_pad(mt_rand(0, 9999999999999999), 16, '0', STR_PAD_LEFT),
            'pin' => rand(1000, 9999),
            'name_on_card' => $user->name,
            
        ]);

        return back()->with('success', 'Withdrawal card generated!');
    }

    public function viewCard()
    {
        $user = Auth::user();
        $card = WithdrawalCard::where('user_id', $user->id)->first();

        if (!$card) {
            return redirect()->route('withdrawals.generateCard')->with('error', 'No card found. Please generate one first.');
        }

        return view('dashboard.user.card', compact('card'));
    }

    public function showWithdrawForm()
    {
        $user = Auth::user();

        if (!$user->withdrawalCard) {
            return back()->with('error', 'Please generate your withdrawal card before proceeding.');
        }

        return view('dashboard.withdrawal.withdrawer');
    }

    public function withdrawalList()
    {
        $withdrawals = auth()->user()->withdrawals()->latest()->get();
        return view('dashboard.withdrawal.index', compact('withdrawals'));
    }

    public function withdrawFromBalance(Request $request)
    {
        $cardPin = $request->input('digit1') . $request->input('digit2') . $request->input('digit3') . $request->input('digit4');
        $request->merge(['card_pin' => $cardPin]);

        $request->validate([
            'amount' => 'required|numeric|min:1',
            'payment_method' => 'required|string',
            'card_pin' => 'required|string|size:4',
            'wallet_choice' => 'required|string|in:bitcoin,etherium,usdt',
        ]);

        $user = User::find(Auth::id());
        $card = WithdrawalCard::where('user_id', $user->id)->first();

        if (!$card || (string)$card->pin !== (string)$request->card_pin) {
            return back()->with('error', 'Incorrect card PIN.')->withInput();
        }

        if ($request->amount > $user->available_balance) {
            return back()->with('error', 'Insufficient total income to withdraw.');
        }

        // Prevent duplicate withdrawal submissions within 1 minute
        $recent = Withdrawal::where('user_id', $user->id)
            ->where('status', 'pending')
            ->where('created_at', '>=', Carbon::now()->subMinutes(1))
            ->first();

        if ($recent) {
            return back()->with('error', 'You already submitted a withdrawal recently. Please wait.');
        }

        // Create withdrawal
        Withdrawal::create([
            'user_id' => $user->id,
            'amount' => $request->amount,
            'payment_method' => $request->payment_method,
            'wallet_choice' => $request->wallet_choice,
            'status' => 'pending',
            'investment_id' => null,
            'type' => 'balance',
        ]);

        // Deduct from user's available balance
        $user->available_balance -= $request->amount;
        $user->save();

        // Notify user
        $user->notify(new \App\Notifications\TransactionNotification(
            'Withdrawal Submitted',
            'Your withdrawal request of $' . number_format($request->amount, 2) . ' is pending awaiting approval.'
        ));

        return redirect()->route('user.withdrawals.list')->with('success', 'Withdrawal request submitted.');
    }
}
