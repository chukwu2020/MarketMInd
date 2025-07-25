<?php

namespace App\Http\Controllers;

use App\Models\IdVerification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Notifications\IDVerificationSubmitted;

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
        $request->validate([
            'country' => 'required|string|max:255',
            'document' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'selfie' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $user = Auth::user();

        try {
            DB::beginTransaction();

            // Delete old files and record if exists
            if ($user->idVerification) {
                Storage::disk('public')->delete([
                    $user->idVerification->document,
                    $user->idVerification->selfie,
                ]);
                $user->idVerification->delete();
            }

            // Save new images
            $documentPath = $request->file('document')->store('id_verifications', 'public');
            $selfiePath = $request->file('selfie')->store('id_verifications/selfies', 'public');

            // Create new record
            $verification = IdVerification::create([
                'user_id' => $user->id,
                'country' => $request->country,
                'document' => $documentPath,
                'selfie' => $selfiePath,
                'status' => 'pending',
            ]);

            DB::commit();

            // ✅ Optional: notify user
            try {
                $user->notify(new IDVerificationSubmitted($verification));
            } catch (\Exception $e) {
                Log::warning("Notification error: " . $e->getMessage());
            }

            return redirect()->route('user_dashboard')
                ->with('success', ' ID verification submitted. It will be reviewed shortly.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('ID Verification Failed: ' . $e->getMessage());

            return back()->withInput()
                ->with('error', 'An error occurred while submitting your verification.');
        }
    }

    // Admin: list all verifications
    public function index()
    {
        $verifications = IdVerification::with(['user:id,name,email'])
            ->latest()
            ->paginate(10);

        return view('admin_approve_id_verification', compact('verifications'));
    }
    // Admin: approve
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
}
