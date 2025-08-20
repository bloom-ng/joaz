<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        $userId = Auth::id();

        $cart = Cart::with(['items.product.images'])
            ->where('user_id', $userId)
            ->first();

        if (!$cart) {
            $cart = Cart::create([
                'user_id' => $userId,
                'total' => 0
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

        if (!Auth::check()) {
            return redirect()->route('login');
        }
        $userId = Auth::id();

        // Get or create cart
        $cart = Cart::firstOrCreate(
            ['user_id' => $userId],
            ['total' => 0]
        );

        // Check if cart belongs to authenticated user
        if (Auth::id() !== $cart->user_id) {
            abort(403);
        }

        // Check if product already in cart
        $existingItem = $cart->items()->where('product_id', $request->product_id)->first();

        if ($existingItem) {
            // Update quantity
            $newQuantity = $existingItem->quantity + $request->quantity;

            if ($product->quantity < $newQuantity) {
                return back()->withErrors(['quantity' => 'Insufficient stock available.']);
            }

            $cartItem = $cart->items()->updateOrCreate(
                [
                    'product_id' => $product->id,
                    'variant_id' => $request->variant_id ?? null,
                ],
                [
                    'quantity' => DB::raw('quantity + ' . $request->quantity),
                    'price' => $product->price_ngn,
                ]
            );

            // Update cart total
            $cart->updateTotal();

            return back()->with('success', 'Product has been successfully added to your cart');
        } else {
            // Add new item
            $cart->items()->create([
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
                'unit_price' => $product->price,
            ]);

            return redirect()->route('customer.cart.index')
                ->with('success', 'Product added to cart successfully.');
        }
    }

    public function update(Request $request, CartItem $cartItem)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        // Check if cart belongs to authenticated user
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        $userId = Auth::id();

        if ($cartItem->cart->user_id !== $userId) {
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
        // Check if cart belongs to authenticated user
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        $userId = Auth::id();

        if ($cartItem->cart->user_id !== $userId) {
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
