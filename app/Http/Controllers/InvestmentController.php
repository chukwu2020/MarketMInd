<?php

namespace App\Http\Controllers;

use App\Models\Investment;
use Illuminate\Support\Facades\Auth;

class InvestmentController extends Controller
{
    public function index()
    {
            $investments = Investment::with('withdrawals', 'plan') // eager load relationships
    ->where('user_id', auth()->id())
    ->latest()
    ->get();


        return view('dashboard.investments.index', compact('investments'));
    }
public function withdraw($id)
{
    $investment = Investment::findOrFail($id);

    if ($investment->user_id !== Auth::id()) {
        return back()->with('error', 'Unauthorized.');
    }

    if (!$investment->is_withdrawable || $investment->status === 'withdrawn') {
        return back()->with('error', 'Not eligible for withdrawal.');
    }

    $user = $user = \App\Models\User::find(auth()->id());
    $total = $investment->amount_invested + $investment->total_profit;

    $user->available_balance = $user->available_balance + $total;
    $user->total_income = $user->total_income + $total;
    $user->save(); // ✅ updates balances

    $investment->status = 'withdrawn';
    $investment->save();

    return redirect()->route('user.withdrawn.investments')->with('success', 'Withdrawal successful.');
}
public function withdrawnInvestments()
{
    $user = auth()->user();

        $withdrawnInvestments = Investment::with('plan') // 👈 Eager load 'plan'
        ->where('user_id', auth()->id())
        ->whereRaw("LOWER(TRIM(status)) = 'withdrawn'")
        ->latest()
        ->get();

    return view('dashboard.investments.investmentList', compact('withdrawnInvestments'));
}




}
