<?php

namespace App\Http\Controllers;

use App\Models\ContactUSMessage;
use App\Models\Deposit;
use App\Models\Idverification;
use App\Models\Investment;
use App\Models\Message;
use App\Models\Plan;
use App\Models\User;
use App\Models\UserKyc;
use App\Models\Withdrawal;
use App\Models\WithdrawalCard;
use App\Notifications\IDVerificationSubmitted;
use App\Notifications\TransactionNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function userIndex(Request $request)
    {
        $query = User::with(['investments', 'profile', 'withdrawalCard']) // eager load all needed
            ->where('role_as', 0);

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $status = $request->input('status');
            if ($status == 'Active') {
                $query->where('active', 1);
            } elseif ($status == 'Inactive') {
                $query->where('active', 0);
            }
        }

        $users = $query->paginate(10);

        // Optional: calculate total invested manually (you already eager loaded 'investments')
        foreach ($users as $user) {
            $user->total_invested = $user->investments->sum('amount_invested');
        }

        return view('admin.users.index', compact('users'));
    }



    public function userDestroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('user.index')->with('success', 'User deleted successfully.');
    }


    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }



    public function pendingDeposits()
    {
        $deposits = Deposit::with('user', 'plan', 'wallet')
            ->where('status', 0)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.deposits.pending', compact('deposits'));
    }

    public function approvedDeposits()
    {
        $deposits = Deposit::with(['user', 'plan', 'wallet'])
            ->where('status', 1)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.deposits.approved', compact('deposits'));
    }
    public function approveDeposit($id)
    {
        $deposit = Deposit::findOrFail($id);

        // ✅ Prevent double-approval
        if ($deposit->status === 1) {
            return redirect()->back()->with('error', 'This deposit has already been approved.');
        }

        $plan = Plan::find($deposit->plan_id);

        if (!$plan) {
            return back()->with('error', 'Investment plan not found');
        }

        $roi = $plan->interest_rate;
        $totalProfit = ($deposit->amount_deposited * $roi / 100) * $plan->duration;

        Investment::create([
            'user_id' => $deposit->user_id,
            'plan_id' => $deposit->plan_id,
            'amount_invested' => $deposit->amount_deposited,
            'roi' => $roi,
            'total_profit' => $totalProfit,
            'start_date' => Carbon::now(),
            'end_date' => Carbon::now()->addDays($plan->duration),
            'withdrawn' => 0,
        ]);

        $deposit->status = 1;
        $deposit->save();

        $user = $deposit->user;
        $user->notify(new TransactionNotification(
            '🎉 Congratulations! Deposit Approved!',
            'Your deposit of $' . number_format($deposit->amount_deposited, 2) . ' has been approved and your investment has started.'
        ));

        return redirect()->back()->with('success', 'Deposit approved and investment started');
    }






    public function showApprovedWithdrawals()
    {
        $approvedWithdrawals = Withdrawal::where('status', 'approved')
            ->with(['user'])
            ->latest()
            ->get();

        $withdrawalCards = WithdrawalCard::all();


        return view('admin.deposits.withdrawal_approved', compact('approvedWithdrawals', 'withdrawalCards'));
    }

    public function withdrawaldestroy($id)
    {
        $withdrawal = Withdrawal::findOrFail($id);

        if ($withdrawal->status !== 'approved') {
            return back()->with('error', 'Only approved withdrawals can be deleted.');
        }

        $withdrawal->delete();

        return back()->with('success', 'Approved withdrawal deleted successfully.');
    }



    public function updateBalance(Request $request, $id)
    {
        $request->validate([
            'available_balance' => 'required|numeric|min:0',
            'investments.*' => 'nullable|numeric|min:0',


        ]);

        $user = User::findOrFail($id);
        $user->available_balance = $request->input('available_balance');

        $user->save();

        return redirect()->route('user.index')->with('success', 'User balance updated successfully.');
    }

    public function admin_dashboard()
    {
        $totalUsers = User::count();
        $totalDeposits = User::sum('available_balance');
        $totalWithdrawals = Withdrawal::where('status', 'approved')->sum('amount');
        $amount_invested = Investment::sum('amount_invested');



        return view('admin.index', compact(
            'totalUsers',
            'totalDeposits',
            'totalWithdrawals',
            'amount_invested'
        ));
    }

    public function adminViewWithdrawals()
    {
        // Eager load user and profile to avoid N+1 queries
        $withdrawals = Withdrawal::with(['user.profile', 'user.withdrawalCard'])
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.deposits.withdrawal_pending', compact('withdrawals'));
    }



    public function approveBalanceWithdrawal($id)
    {
        $withdrawal = Withdrawal::findOrFail($id);

        // ✅ Skip if already approved
        if ($withdrawal->status === 'approved') {
            return back()->with('error', 'This withdrawal has already been approved.');
        }

        $withdrawal->status = 'approved';
        $withdrawal->save();

        $user = $withdrawal->user;
        $user->notify(new TransactionNotification(
            '🎉 Congratulations!',
            'Your withdrawal of $' . number_format($withdrawal->amount, 2) . ' has been approved successfully!'
        ));

        return back()->with('success', 'Withdrawal approved successfully.');
    }

    // message

    public function index()
    {


        $messages = ContactUSMessage::orderBy('created_at', 'desc')->paginate(20);

        return view('admin.contactUs.index', compact('messages'));
    }
    // contact us
    public function destroy($id)
    {
        $message = Message::findOrFail($id);
        $message->delete();

        return redirect()->route('admin.messages.index')->with('success', 'Message deleted successfully.');
    }



    //profile


    public function profile()
    {
        $user = User::with('profile')->find(auth()->id());
        return view('admin.profile', compact('user'));
    }






    public function updateProfile(Request $request)
    {


        /** @var \App\Models\User $user */
        $user = auth()->user();


        if ($request->hasFile('profile_pic')) {
            $file = $request->file('profile_pic');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads'), $filename);

            // Create or update profile
            $profile = $user->profile ?? new \App\Models\UserProfile();
            $profile->user_id = $user->id;
            $profile->profile_pic = $filename;
            $profile->save();
        }

        // Update name, phone, address, etc.
        $user->update([
            'name' => $request->input('name'),
            'phone' => $request->input('phone'),
            // do not update email if it's readonly
        ]);

        if ($user->profile) {
            $user->profile->update([
                'address' => $request->input('address'),
                'bitcoin_address' => $request->input('bitcoin_address'),
                'etherium_address' => $request->input('etherium_address'),
            ]);
        }

        return redirect()->back()->with('success', 'Profile updated successfully.');
    }




    // admin verify identity

public function kycindex()
{
    $kycs = UserKyc::with('user')->latest()->get();
    return view('admin.admin_approve_id_verification', compact('kycs'));
}

public function review($id)
{
    $kyc = UserKyc::with('user')->findOrFail($id);
    return view('admin.kyc.review', compact('kyc'));
}

public function update(Request $request, $id)
{
    $request->validate([
        'status' => 'required|in:approved,rejected',
        'admin_note' => 'nullable|string|max:1000',
    ]);

    $kyc = UserKyc::findOrFail($id);
    $kyc->status = $request->status;
    $kyc->admin_note = $request->admin_note;
    $kyc->save();

    return redirect()->route('admin.kyc.index')->with('success', 'KYC status updated successfully.');
}

public function approve($id)
{
    $kyc = UserKyc::findOrFail($id);
    $kyc->status = 'approved';
    $kyc->admin_note = 'Approved by admin';
    $kyc->save();

    return redirect()->back()->with('success', 'KYC approved.');
}

public function reject($id)
{
    $kyc = UserKyc::findOrFail($id);
    $kyc->status = 'rejected';
    $kyc->admin_note = 'Rejected by admin';
    $kyc->save();

    return redirect()->back()->with('success', 'KYC rejected.');
}
}
