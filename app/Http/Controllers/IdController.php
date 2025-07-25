<?php

namespace App\Http\Controllers;

use App\Models\Idverification;
use Illuminate\Http\Request;

class IdController extends Controller
{

public function showForm()
{
    $countries = ['USA', 'UK', 'Canada', 'Germany', 'France', 'Japan', 'Australia']; // or pull from DB

    return view('dashboard.id_verification', compact('countries'));
}

public function upload(Request $request)
{
    $request->validate([
        'country' => 'required|string|not_in:Nigeria',
        'document' => 'required|file|mimes:jpeg,png,jpg,pdf|max:5120',
        'selfie' => 'nullable|file|mimes:jpeg,png,jpg|max:5120',
    ]);

    $user = auth()->user();

    
    $documentPath = $request->file('document')->store('id_uploads', 'public');

    $selfiePath = $request->file('selfie') ? $request->file('selfie')->store('id_uploads') : null;

    // Create or update the ID verification record for this user
    Idverification::updateOrCreate(
        ['user_id' => $user->id],
        [
            'country' => $request->country,
            'document' => $documentPath,
            'selfie' => $selfiePath,
            'status' => 'pending',
        ]
    );

   
     return redirect()->route('user_dashboard')->with('success', 'Your ID has been submitted for verification.');
}

}
