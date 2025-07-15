<?php

namespace App\Http\Controllers;

use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WalletController extends Controller
{
    //

    public function addWallet()
    {
        return view('admin.wallets.add-wallet');
    }


    public function storeWallet(Request $request)
    {
        // Validate inputs
        $validator = Validator::make($request->all(), [
            'crypto_name' => 'required|string|max:255',
            'wallet_address' => 'required|string|unique:wallets,wallet_address|max:255',
        ], [
            'crypto_name.required' => 'Crypto name is required.',
            'wallet_address.required' => 'Wallet address is required.',
            'wallet_address.unique' => 'This wallet address is already registered.',
        ]);

        // If validation fails, redirect back with errors
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Store the wallet
        Wallet::create([
            'crypto_name' => $request->crypto_name,
            'wallet_address' => $request->wallet_address,
        ]);

        // Redirect with success message
        return redirect()->back()->with('success', 'Wallet address saved successfully.');
    }

    // Display a list of all wallets
    public function index()
    {
        $wallets = Wallet::paginate(10);
        return view('admin.wallets.wallet-list', compact('wallets'));
    }


    // Delete a wallet
    public function destroy($id)
    {
        $wallet = Wallet::findOrFail($id);
        $wallet->delete();

        return redirect()->back()->with('success', 'Wallet deleted successfully.');
    }
}
