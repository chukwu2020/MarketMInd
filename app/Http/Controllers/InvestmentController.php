<?php

namespace App\Http\Controllers;

use App\Models\Investment;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class InvestmentController extends Controller
{
    // Display all investments for the logged-in user
    public function index()
    {
        $investments = Investment::with('withdrawals', 'plan')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('dashboard.investments.index', compact('investments'));
    }

    // Show only withdrawn investments
    public function withdrawnInvestments()
    {
        $withdrawnInvestments = Investment::with('plan')
            ->where('user_id', auth()->id())
            ->where('status', Investment::STATUS_WITHDRAWN)
            ->latest()
            ->get();

        return view('dashboard.investments.investmentList', compact('withdrawnInvestments'));
    }

    // Withdraw full investment + profit (adjusted for take-profit)
    public function withdraw($id)
    {
        $investment = Investment::with('withdrawals')
            ->where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        if (!$investment->is_withdrawable || $investment->isWithdrawn()) {
            return back()->with('error', 'Not eligible for withdrawal.');
        }

        $user = auth()->user();

        // Calculate remaining profit after any early take-profit
        $totalProfit = $investment->total_profit - $investment->taken_profit;
        $total = $investment->amount_invested + $totalProfit;

        $user->available_balance += $total;
        $user->total_income += $total;
        $user->save();

        $investment->status = Investment::STATUS_WITHDRAWN;
        $investment->save();

        return redirect()->route('user.withdrawn.investments')->with('success', 'Full withdrawal successful.');
    }

    // Withdraw part of the profit early (up to $50 max)
    public function takeProfit($id)
    {
        $investment = Investment::with('plan', 'withdrawals')
            ->where('user_id', auth()->id())
            ->findOrFail($id);

        if ($investment->is_withdrawable) {
            return back()->with('error', 'Investment is due. You can only withdraw full profit now.');
        }

        $maxAllowed = 50;
        $alreadyTaken = $investment->taken_profit;
        $available = $investment->available_profit;

        if ($alreadyTaken >= $maxAllowed) {
            return back()->with('error', 'You have already taken the maximum allowed profit of $50. wait till due date');
        }

        $remainingLimit = $maxAllowed - $alreadyTaken;
        $takeAmount = min($available, $remainingLimit);

        if ($takeAmount <= 0) {
            return back()->with('error', 'No profit available for withdrawal.');
        }

        $user = auth()->user();
        $user->available_balance += $takeAmount;
        $user->save();

        $investment->withdrawals()->create([
            'user_id' => $user->id,
            'amount' => $takeAmount,
            'type' => 'profit',
        ]);

        return redirect()->route('user_dashboard')->with('success', "Profit of $$takeAmount added to your balance.");
    }
}
