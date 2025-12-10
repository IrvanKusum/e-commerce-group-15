<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Store;
use App\Models\Product;
use App\Models\Transaction;

class AdminController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users' => User::count(),
            'total_stores' => Store::count(),
            'pending_stores' => Store::where('is_verified', false)->count(),
            'total_products' => Product::count(),
            'total_transactions' => Transaction::count(),
        ];
        
        return view('admin.dashboard', compact('stats'));
    }

    public function users()
    {
        $users = User::all();
        return view('admin.users', compact('users'));
    }

    public function stores()
    {
        $stores = Store::with('user')->get();
        return view('admin.stores', compact('stores'));
    }

    public function verifyStore(Request $request)
    {
        $request->validate([
            'store_id' => 'required|exists:stores,id',
            'action' => 'required|in:approve,reject',
        ]);

        $store = Store::findOrFail($request->store_id);

        if ($request->action === 'approve') {
            $store->update(['is_verified' => true]);
            return redirect()->route('admin.stores')->with('success', 'Store approved successfully!');
        } else {
            // Reject and delete the store
            $store->delete();
            return redirect()->route('admin.stores')->with('success', 'Store rejected and removed.');
        }
    }
}
