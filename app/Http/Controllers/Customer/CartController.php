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

        // Get or create cart with items and product relationships
        $cart = Cart::with(['items.product.images'])
            ->where('user_id', $userId)
            ->first();

        if (!$cart) {
            // Create a new cart if none exists
            $cart = Cart::create([
                'user_id' => $userId,
                'total' => 0
            ]);
        } else {
            // Ensure relationships are loaded
            $cart->load(['items.product.images']);
        }

        return view('customer.shop.account-center', compact('cart'));
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
        );

        // Check if cart belongs to authenticated user
        if (Auth::id() !== $cart->user_id) {
            abort(403);
        }

        // Check if product already in cart with same variant
        $query = $cart->items()->where('product_id', $request->product_id);

        if ($request->has('variant_id') && $request->variant_id) {
            $query->where('variant_id', $request->variant_id);
        } else {
            $query->whereNull('variant_id');
        }

        $existingItem = $query->first();

        // Get unit price based on variant if available
        $unitPrice = $product->price_ngn;
        if ($request->has('variant_id') && $variant = $product->variants->find($request->variant_id)) {
            $unitPrice = $variant->price_ngn;
        }

        if ($existingItem) {
            // Update quantity
            $newQuantity = $existingItem->quantity + $request->quantity;

            if ($product->quantity < $newQuantity) {
                return back()->withErrors(['quantity' => 'Insufficient stock available.']);
            }

            // Update the existing item directly
            $existingItem->update([
                'quantity' => $existingItem->quantity + $request->quantity,
                'unit_price' => $unitPrice,
            ]);

            return back()->with('success', 'Product has been successfully added to your cart');
        } else {
            // Add new item with variant if specified

            $cartItemData = [
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
                'unit_price' => $unitPrice,
            ];

            if ($request->has('variant_id') && $request->variant_id) {
                $cartItemData['variant_id'] = $request->variant_id;
            }

            $cart->items()->create($cartItemData);

            return back()->with('success', 'Product added to cart successfully.');
        }
    }

    public function update(Request $request, CartItem $cartItem)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $userId = Auth::id();
        if ($cartItem->cart->user_id !== $userId) {
            return response()->json(['error' => 'Forbidden'], 403);
        }

        $product = $cartItem->product;

        if ($request->has('action')) {
            if ($request->action === 'increment') {
                $newQuantity = $cartItem->quantity + 1;
            } elseif ($request->action === 'decrement') {
                $newQuantity = max(1, $cartItem->quantity - 1);
            } else {
                $newQuantity = $cartItem->quantity;
            }
        } else {
            $request->validate([
                'quantity' => 'required|integer|min:1',
            ]);
            $newQuantity = $request->quantity;
        }

        if ($product->quantity < $newQuantity) {
            return response()->json(['error' => 'Insufficient stock available.'], 422);
        }

        $cartItem->update(['quantity' => $newQuantity]);

        // Calculate updated totals
        $itemTotal = $cartItem->product->price_ngn * $newQuantity;
        $cartTotal = $cartItem->cart->items->sum(fn($item) => $item->product->price_ngn * $item->quantity);

        return response()->json([
            'success' => true,
            'quantity' => $newQuantity,
            'itemTotal' => number_format($itemTotal, 2),
            'cartTotal' => number_format($cartTotal, 2),
        ]);
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

        return back()->with('success', 'Item removed from cart.');
    }

    public function clear()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $cart = Cart::where('user_id', Auth::id())
            ->where('is_active', true)
            ->first();

        if ($cart) {
            $cart->items()->delete();
        }

        return redirect()->route('customer.cart.index')
            ->with('success', 'Cart cleared successfully.');
    }
}
