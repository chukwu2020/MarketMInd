<?php

namespace App\Http\Controllers;

use App\Models\IdVerification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Notifications\IDVerificationSubmitted;
use Illuminate\Support\Facades\Cache;

class IdController extends Controller
{
    // Show the ID verification form
    public function create()
    {
        $user = Auth::user();

        if ($user->idVerification) {
            $status = $user->idVerification->status;

            if ($status === 'approved') {
                return redirect()->route('user_dashboard')
                    ->with('info', '✅ Your ID has already been verified.');
            }

            if ($status === 'pending') {
                return redirect()->route('user_dashboard')
                    ->with('warning', '⏳ Your verification is pending. Please wait for approval.');
            }
        }

        return view('dashboard.id_verification');
    }

    // Store ID verification submission
public function store(Request $request)
{
    $validated = $request->validate([
        'country' => 'required|string',
        'document' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
        'selfie' => 'required|image|mimes:jpg,jpeg,png|max:5120|dimensions:min_width=300',
    ]);

    try {
        DB::beginTransaction();
        $user = Auth::user();

        // Clean up existing verification
        if ($verification = $user->idVerification) {
            Storage::disk('public')->delete([
                $verification->document,
                $verification->selfie
            ]);
            $verification->delete();
        }

        // Store new files
        $documentPath = $request->file('document')->store('id_verifications', 'public');
        $selfiePath = $request->file('selfie')->store('id_verifications/selfies', 'public');

        // Create record
        $verification = IdVerification::create([
            'user_id' => $user->id,
            'country' => $validated['country'],
            'document' => $documentPath,
            'selfie' => $selfiePath,
            'status' => 'pending'
        ]);

        DB::commit();

        // Send notification with error handling
        try {
            $user->notify(new IDVerificationSubmitted($verification));
            Log::info("Notification sent successfully for user {$user->id}");
        } catch (\Exception $e) {
            Log::error("Failed to send notification: {$e->getMessage()}");
            // Continue with redirect even if notification fails
        }

        return redirect()->route('user_dashboard')
            ->with('success', 'ID verification submitted successfully!');

    } catch (\Exception $e) {
        DB::rollBack();
        Log::error("ID Verification Error: {$e->getMessage()}");
        return back()->withInput()->with('error', 'Verification submission failed. Please try again.');
    }
}

// Controller (IdController.php)
public function dismissAlert(Request $request)
{
    try {
        Cache::forever('user_' . auth()->id() . '_id_verification_alert_dismissed', true);
        return response()->json(['status' => 'success']);
    } catch (\Exception $e) {
        Log::error('Failed to dismiss alert: ' . $e->getMessage());
        return response()->json(['status' => 'error'], 500);
    }
}



    // Admin: list all verifications
    public function index()
    {
        $verifications = IdVerification   ::with(['user:id,name,email'])
            ->latest()
            ->paginate(10);

        return view('admin.admin_approve_id_verification', compact('verifications'));
    }
    public function approve($id)
    {
        $verification = IdVerification::findOrFail($id);

        if ($verification->status === 'approved') {
            return back()->with('info', '✅ Already approved.');
        }

        $verification->update(['status' => 'approved']);

        return back()->with('success', 'Verification approved.');
    }

    // Admin: reject
    public function reject(Request $request, $id)
    {
        $verification = IdVerification::findOrFail($id);

        if ($verification->status === 'rejected') {
            return back()->with('info', '❌ Already rejected.');
        }

        $verification->update(['status' => 'rejected']);

        return back()->with('success', 'Verification rejected.');
    }



    // Controller (IdController.php)


    
}
