<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserProfile;
use App\Models\WithdrawalCard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class ProfileController extends Controller
{
    /**
     * Show the user profile view.
     */
    public function userProfile()
    {
        $user = User::with('profile')->find(auth()->id());
        $card = WithdrawalCard::where('user_id', auth()->id())->first();
        return view('dashboard.profile', compact('user', 'card'));
    }

    /**
     * Update the user's profile.
     */
    // ProfileController.php

    public function updateProfile(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();



        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'country' => 'nullable|string|max:100',
            'address' => 'nullable|string|max:255',
            'bitcoin_address' => 'nullable|string|max:255',
            'etherium_address'  => 'nullable|string|max:255',
            'usdt_address' => 'nullable|string|max:255', // FIXED: changed from image to string
        ]);

        // Update User model
        $user->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'country' => $request->country,
        ]);

        // Build profile data array
        $profileData = [
            'address' => $request->address,
            'bitcoin_address' => $request->bitcoin_address,
            'etherium_address' => $request->etherium_address,
            'usdt_address' => $request->usdt_address,
        ];

        // Handle profile picture
        if ($request->hasFile('profile_pic')) {
            $image = $request->file('profile_pic');
            $path = $image->store('profile_pics', 'public');
            $profileData['profile_pic'] = $path;
        }

        // Update or create Profile
        $user->profile()->updateOrCreate([], $profileData);

        return back()->with('success', 'Profile updated successfully.');
    }


    /**
     * Update the user's password.
     */


    public function updatePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);

        try {

            /** @var \App\Models\User $user */
            $user = Auth::user();

            if (!Hash::check($request->old_password, $user->password)) {
                throw ValidationException::withMessages([
                    'old_password' => 'The old password is incorrect.'
                ]);
            }

            $user->update([
                'password' => Hash::make($request->new_password),
            ]);

            return redirect()->route('profile.show')->with('success', 'Password updated successfully.');
        } catch (\Exception $e) {
            Log::error('Password update failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'The Current password is incorrect.');
        }
    }
}
