<?php

namespace App\Http\Controllers;

use App\Models\IdVerification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Notifications\IDVerificationSubmitted;
use Illuminate\Support\Facades\Cache;

class IdController extends Controller
{
    public function create()
    {
        /** @var User $user */
        $user = Auth::user();

        // Eager load the idVerification relationship to avoid N+1 queries
        $user->load('idVerification');

        if ($user->idVerification) {
            return match ($user->idVerification->status) {
                'approved' => redirect()->route('user_dashboard')
                    ->with('info', '✅ Your ID has already been verified.'),
                'pending' => redirect()->route('user_dashboard')
                    ->with('warning', '⏳ Your verification is pending. Please wait for approval.'),
                default => redirect()->route('user_dashboard')
                    ->with('warning', 'Your verification status is unknown. Please contact support.'),
            };
        }

        return view('dashboard.id_verification');
    }

   public function store(Request $request)
    {
        $validated = $request->validate([
            'country' => 'required|string',
            'document' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'selfie' => 'required|image|mimes:jpg,jpeg,png|max:5120|dimensions:min_width=300',
        ]);

        DB::beginTransaction();

        try {
            $user = Auth::user();

            // Delete existing files if they exist
            if ($user->idVerification) {
                Storage::disk('public')->delete([
                    $user->idVerification->document,
                    $user->idVerification->selfie
                ]);
                $user->idVerification()->delete();
            }

            // Store new files - this will automatically go to storage/app/public/id_verifications
            $documentPath = $request->file('document')->store('id_verifications', 'public');
            $selfiePath = $request->file('selfie')->store('id_verifications/selfies', 'public');

            // Create record
            $user->idVerification()->create([
                'country' => $validated['country'],
                'document' => $documentPath,
                'selfie' => $selfiePath,
                'status' => 'pending'
            ]);

            DB::commit();

            return response()->json([
                'success' => 'ID verification submitted successfully!',
                'redirect' => route('user_dashboard')
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("ID Verification Error: {$e->getMessage()}");
            
            return response()->json([
                'error' => 'Verification submission failed. Please try again.'
            ], 500);
        }
    }

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

    public function index()
    {
        // Eager load the user relationship to avoid N+1 queries
        $verifications = IdVerification::with(['user' => function($query) {
            $query->select('id', 'name', 'email'); // Only select necessary columns
        }])->latest()->paginate(10);

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