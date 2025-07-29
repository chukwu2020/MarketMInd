<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserKyc;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class UserKycController extends Controller
{
    public function create()
    {
        $user = Auth::user();
        return view('dashboard.id_verification', compact('user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_document' => 'required|file|mimes:jpg,jpeg,png,pdf',
            'utility_bill' => 'required|file|mimes:jpg,jpeg,png,pdf',
        ]);

        $idPath = $request->file('id_document')->store('kyc_docs');
        $billPath = $request->file('utility_bill')->store('kyc_docs');

        UserKyc::updateOrCreate(
            ['user_id' => Auth::id()],
            [
                'id_document' => $idPath,
                'utility_bill' => $billPath,
                'status' => 'pending',
            ]
        );

        return redirect()->route('user_dashboard')->with('success', 'KYC submitted successfully. Awaiting approval.');
    }




    // KycController.php
public function dismissAlert()
{
    $userId = auth()->id();
    
    // Persist dismissal for, e.g., 7 days
    Cache::put('user_'.$userId.'_id_verification_alert_dismissed', true, now()->addDays(7));

    return response()->json(['message' => 'Alert dismissed']);
}

}
