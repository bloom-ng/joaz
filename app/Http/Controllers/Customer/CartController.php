<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        $cart = Cart::with(['items.product.images'])
            ->where('user_id', $userId)
            ->where('is_active', true)
            ->first();

        if (!$cart) {
            $cart = Cart::create([
                'user_id' => $userId,
                'is_active' => true,
            ]);
        }

        return view('customer.cart.index', compact('cart'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);

        // Check stock availability
        if ($product->quantity < $request->quantity) {
            return back()->withErrors(['quantity' => 'Insufficient stock available.']);
        }

        $userId = auth()->id();

        // Get or create cart
        $cart = Cart::firstOrCreate(
            ['user_id' => $userId, 'is_active' => true],
            ['user_id' => $userId, 'is_active' => true]
        );

        // Check if product already in cart
        $existingItem = $cart->items()->where('product_id', $request->product_id)->first();

        if ($existingItem) {
            // Update quantity
            $newQuantity = $existingItem->quantity + $request->quantity;

            if ($product->quantity < $newQuantity) {
                return back()->withErrors(['quantity' => 'Insufficient stock available.']);
            }

            $existingItem->update(['quantity' => $newQuantity]);
        } else {
            // Add new item
            $cart->items()->create([
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
                'unit_price' => $product->price,
            ]);
        }

        return redirect()->route('customer.cart.index')
            ->with('success', 'Product added to cart successfully.');
    }

    public function update(Request $request, CartItem $cartItem)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        // Check if cart item belongs to authenticated user
        if ($cartItem->cart->user_id !== auth()->id()) {
            abort(403);
        }

        $product = $cartItem->product;

        // Check stock availability
        if ($product->quantity < $request->quantity) {
            return back()->withErrors(['quantity' => 'Insufficient stock available.']);
        }

        $cartItem->update(['quantity' => $request->quantity]);

        return redirect()->route('customer.cart.index')
            ->with('success', 'Cart updated successfully.');
    }

    public function remove(CartItem $cartItem)
    {
        // Check if cart item belongs to authenticated user
        if ($cartItem->cart->user_id !== auth()->id()) {
            abort(403);
        }

        $cartItem->delete();

        return redirect()->route('customer.cart.index')
            ->with('success', 'Item removed from cart.');
    }

    public function clear()
    {
        $cart = Cart::where('user_id', auth()->id())
            ->where('is_active', true)
            ->first();

        if ($cart) {
            $cart->items()->delete();
        }

        return redirect()->route('customer.cart.index')
            ->with('success', 'Cart cleared successfully.');
    }
}
