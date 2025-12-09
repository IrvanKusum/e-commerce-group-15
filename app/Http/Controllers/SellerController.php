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
        return view('seller.withdrawal');
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
            'weight' => $request->weight ?? 500, // Default 500g if not provided
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
            'condition' => 'required|in:new,used',
            'description' => 'nullable|string',
        ]);

        $product->update($request->only(['name', 'product_category_id', 'price', 'stock', 'condition', 'description']));

        return redirect()->route('seller.products')->with('success', 'Product updated successfully!');
    }

    public function destroyProduct($id)
    {
        $product = auth()->user()->store->products()->findOrFail($id);
        $product->delete();

        return redirect()->route('seller.products')->with('success', 'Product deleted successfully!');
    }
}
