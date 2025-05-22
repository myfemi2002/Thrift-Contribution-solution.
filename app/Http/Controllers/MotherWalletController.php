<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\MotherWallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class MotherWalletController extends Controller
{
    /**
     * Display a listing of mother wallets.
     */
    public function index(Request $request)
    {
        $query = MotherWallet::latest();
        
        // Add search functionality
        if ($request->has('search')) {
            $search = $request->search;
            $query->where('wallet_address', 'like', "%{$search}%");
        }
        
        $motherWallets = $query->paginate(10);
        
        return view('backend.wallets.mother-wallets.index', compact('motherWallets'));
    }

    /**
     * Show the form for creating a new mother wallet.
     */
    public function create()
    {
        return view('backend.wallets.mother-wallets.create');
    }

    /**
     * Store a newly created mother wallet.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'wallet_address' => 'required|string|unique:mother_wallets,wallet_address',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('message', 'Failed to add wallet address')
                ->with('alert-type', 'error');
        }

        MotherWallet::create([
            'wallet_address' => $request->wallet_address,
            'is_active' => true,
        ]);

        return redirect()->route('admin.wallets.mother.index')
            ->with('message', 'Mother wallet address added successfully')
            ->with('alert-type', 'success');
    }

    /**
     * Show the form for editing a mother wallet.
     */
    public function edit($id)
    {
        $motherWallet = MotherWallet::findOrFail($id);
        return view('backend.wallets.mother-wallets.edit', compact('motherWallet'));
    }

    /**
     * Update the specified mother wallet.
     */
    public function update(Request $request, $id)
    {
        $motherWallet = MotherWallet::findOrFail($id);
        
        $validator = Validator::make($request->all(), [
            'wallet_address' => 'required|string|unique:mother_wallets,wallet_address,' . $id,
            'is_active' => 'nullable',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('message', 'Failed to update wallet address')
                ->with('alert-type', 'error');
        }

        // Update the wallet with received data
        $isActive = $request->has('is_active') ? $request->is_active : 0;
        
        $motherWallet->update([
            'wallet_address' => $request->wallet_address,
            'is_active' => $isActive,
        ]);

        // Redirect back to the appropriate page based on where the request originated
        if ($request->has('referrer') && $request->referrer === 'edit') {
            return redirect()->back()
                ->with('message', 'Mother wallet address updated successfully')
                ->with('alert-type', 'success');
        } else {
            return redirect()->route('admin.wallets.mother.index')
                ->with('message', 'Mother wallet address updated successfully')
                ->with('alert-type', 'success');
        }
    }

    /**
     * Remove the specified mother wallet.
     */
    public function destroy($id)
    {
        $motherWallet = MotherWallet::findOrFail($id);
        
        // Check if the wallet is in use
        if (method_exists($motherWallet, 'userWallets') && $motherWallet->userWallets()->count() > 0) {
            return redirect()->back()
                ->with('message', 'Cannot delete: This wallet is assigned to users')
                ->with('alert-type', 'error');
        }
        
        $motherWallet->delete();
        
        return redirect()->back()
            ->with('message', 'Mother wallet deleted successfully')
            ->with('alert-type', 'success');
    }
}