<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SellerController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $store = $user->store;
        
        if (!$store) {
            return redirect()->route('seller.setup');
        }

        $stats = [
            'products_count' => $store->products()->count(),
            'transactions_count' => $store->transactions()->count(),
            'balance' => $store->transactions()->where('payment_status', 'paid')->sum('grand_total') * 0.95,
            'buyer_transactions' => \App\Models\Transaction::where('user_id', $user->id)->count(),
        ];

        // Fetch seller's products for display
        $products = $store->products()->with('productImages')->latest()->take(6)->get();

        return view('seller.dashboard', compact('stats', 'products'));
    }

    public function products()
    {
        $products = auth()->user()->store->products()->with('productImages')->latest()->get();
        $categories = \App\Models\ProductCategory::all();
        return view('seller.products', compact('products', 'categories'));
    }

    public function orders()
    {
        $orders = auth()->user()->store->transactions()
                    ->with(['user', 'transactionDetails.product'])
                    ->latest()
                    ->get();
                    
        return view('seller.orders', compact('orders'));
    }

    public function updateOrderStatus(Request $request, $id)
    {
        $order = \App\Models\Transaction::findOrFail($id);
        
        // Verify this order belongs to the seller's store
        if ($order->store_id !== auth()->user()->store->id) {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'order_status' => 'required|in:pending,processing,shipped,delivered,cancelled'
        ]);

        $order->update([
            'order_status' => $request->order_status
        ]);

        return redirect()->back()->with('success', 'Order status updated successfully!');
    }

    public function setup()
    {
        return view('seller.setup');
    }

    public function withdrawal()
    {
        $store = auth()->user()->store;
        
        if (!$store) {
            return redirect()->route('seller.setup');
        }

        // Calculate available balance: 95% of paid transactions minus approved withdrawals
        $totalEarnings = $store->transactions()
            ->where('payment_status', 'paid')
            ->sum('grand_total') * 0.95; // 95% after 5% platform fee
        
        // Get store balance record or create if doesn't exist
        $storeBalance = \App\Models\StoreBalance::firstOrCreate(
            ['store_id' => $store->id],
            ['balance' => 0]
        );
        
        // Get total withdrawn (approved withdrawals)
        $totalWithdrawn = $storeBalance->withdrawals()
            ->where('status', 'approved')
            ->sum('amount');
        
        $balance = $totalEarnings - $totalWithdrawn;
        
        // Get withdrawal history
        $withdrawals = $storeBalance->withdrawals()
            ->latest()
            ->get()
            ->toArray();
        
        return view('seller.withdrawal', compact('balance', 'withdrawals'));
    }

    public function balance()
    {
        $balance = auth()->user()->store->transactions()->where('payment_status', 'paid')->sum('grand_total') * 0.95;
        return view('seller.balance', compact('balance'));
    }

    public function categories()
    {
        return view('seller.categories');
    }

    public function productImage()
    {
        return view('seller.product-image');
    }

    // Product CRUD Methods
    public function storeProduct(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'product_category_id' => 'required|exists:product_categories,id',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'weight' => 'required|integer|min:1',
            'condition' => 'required|in:new,used',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $product = auth()->user()->store->products()->create([
            'name' => $request->name,
            'slug' => \Illuminate\Support\Str::slug($request->name),
            'product_category_id' => $request->product_category_id,
            'price' => $request->price,
            'stock' => $request->stock,
            'weight' => $request->weight,
            'condition' => $request->condition,
            'description' => $request->description,
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '_' . $image->getClientOriginalName();
            $path = $image->storeAs('products', $filename, 'public');
            
            $product->productImages()->create([
                'image' => '/storage/' . $path,
            ]);
        }

        return redirect()->route('seller.products')->with('success', 'Product added successfully!');
    }

    public function updateProduct(Request $request, $id)
    {
        $product = auth()->user()->store->products()->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'product_category_id' => 'required|exists:product_categories,id',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'weight' => 'required|integer|min:1',
            'condition' => 'required|in:new,used',
            'description' => 'nullable|string',
        ]);

        $product->update($request->only(['name', 'product_category_id', 'price', 'stock', 'weight', 'condition', 'description']));

        return redirect()->route('seller.products')->with('success', 'Product updated successfully!');
    }

    public function destroyProduct($id)
    {
        $product = auth()->user()->store->products()->findOrFail($id);
        $product->delete();

        return redirect()->route('seller.products')->with('success', 'Product deleted successfully!');
    }

    public function processWithdrawal(\Illuminate\Http\Request $request)
    {
        $store = auth()->user()->store;
        
        if (!$store) {
            return redirect()->route('seller.setup');
        }

        // Get or create store balance
        $storeBalance = \App\Models\StoreBalance::firstOrCreate(
            ['store_id' => $store->id],
            ['balance' => 0]
        );

        // Calculate available balance
        $totalEarnings = $store->transactions()
            ->where('payment_status', 'paid')
            ->sum('grand_total') * 0.95;
        
        $totalWithdrawn = $storeBalance->withdrawals()
            ->where('status', 'approved')
            ->sum('amount');
        
        $availableBalance = $totalEarnings - $totalWithdrawn;

        // Validate withdrawal request
        $request->validate([
            'amount' => 'required|numeric|min:50000|max:' . $availableBalance,
            'bank_name' => 'required|string',
            'account_name' => 'required|string|max:255',
            'account_number' => 'required|string|max:50',
        ], [
            'amount.max' => 'Jumlah penarikan melebihi saldo tersedia!',
            'amount.min' => 'Minimal penarikan adalah Rp 50.000!',
        ]);

        // Create withdrawal request with auto-approved status
        $storeBalance->withdrawals()->create([
            'amount' => $request->amount,
            'bank_name' => $request->bank_name,
            'bank_account_name' => $request->account_name,
            'bank_account_number' => $request->account_number,
            'status' => 'approved', // Auto-approve for immediate withdrawal
        ]);

        return redirect()->route('seller.withdrawal')
            ->with('success', 'Penarikan berhasil diproses! Saldo Anda telah dikurangi.');
    }
}
