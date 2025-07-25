<?php

namespace App\Http\Controllers;

use App\Models\Investment;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class InvestmentController extends Controller
{
    public function index()
    {
        $investments = Investment::with('withdrawals', 'plan')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('dashboard.investments.index', compact('investments'));
    }

    public function withdraw($id)
    {
        $investment = Investment::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        // Check if the investment is due and not already withdrawn
        if (!$investment->is_withdrawable || $investment->isWithdrawn()) {
            return back()->with('error', 'Not eligible for withdrawal.');
        }

        // Get current user (Eloquent model)
        $user = User::findOrFail(auth()->id());

        // Add investment + profit to user balance
        $total = $investment->amount_invested + $investment->total_profit;

        $user->available_balance += $total;
        $user->total_income += $total;
        $user->save(); // ✅ will now work

        $investment->status = Investment::STATUS_WITHDRAWN;
        $investment->save();

        return redirect()->route('user.withdrawn.investments')->with('success', 'Withdrawal successful.');
    }

    public function withdrawnInvestments()
    {
        $withdrawnInvestments = Investment::with('plan')
            ->where('user_id', auth()->id())
            ->where('status', Investment::STATUS_WITHDRAWN)
            ->latest()
            ->get();

        return view('dashboard.investments.investmentList', compact('withdrawnInvestments'));
    }






    
}
