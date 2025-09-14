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
        $user = Auth::user();

        // Get or create cart with items and product relationships
        $cart = $user->cart()->with(['items.product.images'])->first();

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

        if (Auth::check()) {
            $user = Auth::user();
            $cart = $user->cart()->with(['items.product.images'])->first();

            if (!$cart) {
                $cart = $user->cart()->create([
                    'total' => 0,
                    'item_count' => 0
                ]);
            }

            $cartItems = $cart->items;
        } else {
            $cartItems = collect(session('cart.items', []));
        }

        // Check if product already in cart with same variant
        $query = $cartItems->where('product_id', $request->product_id);

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

            // Update the existing item
            $existingItem->update([
                'quantity' => $newQuantity,
                'unit_price' => $unitPrice,
            ]);
        } else {
            // Create new cart item
            if (Auth::check()) {
                $cart->items()->create([
                    'product_id' => $product->id,
                    'quantity' => $request->quantity,
                    'unit_price' => $unitPrice,
                    'variant_id' => $request->variant_id ?? null,
                ]);
            } else {
                // Add new item
                $cartItems[] = [
                    'product_id' => $product->id,
                    'quantity' => $request->quantity,
                    'unit_price' => $unitPrice,
                    'variant_id' => $request->variant_id ?? null,
                    'product' => $product->load('images')
                ];
            }
        }

        // Update cart total
        if (Auth::check()) {
            $cart->update([
                'total' => $cart->items->sum(function ($item) {
                    return $item->quantity * $item->unit_price;
                })
            ]);
        } else {
            $cart = [
                'items' => $cartItems,
                'total' => collect($cartItems)->sum(function ($item) {
                    return $item['quantity'] * $item['unit_price'];
                }),
                'item_count' => count($cartItems)
            ];

            // Store cart in session
            session(['cart' => $cart]);
        }

        return back()->with('success', 'Product added to cart successfully!');
    }

    public function update(Request $request, CartItem $cartItem)
    {
        $request->validate([
            'action' => 'required|in:increment,decrement'
        ]);

        if ($cartItem->cart->user_id !== Auth::id()) {
            abort(403);
        }

        // Update quantity based on action
        if ($request->action === 'increment') {
            $cartItem->increment('quantity');
        } else {
            if ($cartItem->quantity > 1) {
                $cartItem->decrement('quantity');
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Quantity cannot be less than 1'
                ]);
            }
        }

        // Refresh the cart item to get updated quantity
        $cartItem->refresh();

        // Update cart total
        $cart = $cartItem->cart;
        $cart->update([
            'total' => $cart->items->sum(function ($item) {
                return $item->quantity * $item->unit_price;
            })
        ]);

        return response()->json([
            'success' => true,
            'quantity' => $cartItem->quantity,
            'itemTotal' => number_format($cartItem->quantity * $cartItem->unit_price, 2),
            'cartTotal' => number_format($cart->total, 2),
            'totalItems' => $cart->items->sum('quantity')
        ]);
    }

    public function remove(CartItem $cartItem, Request $request)
    {
        if ($cartItem->cart->user_id !== Auth::id()) {
            if ($request->ajax()) {
                return response()->json(['error' => 'Unauthorized'], 403);
            }
            abort(403);
        }

        $cart = $cartItem->cart;
        $cartItem->delete();

        // Update cart total
        $cart->update([
            'total' => $cart->items->sum(function ($item) {
                return $item->quantity * $item->unit_price;
            })
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'cartTotal' => number_format($cart->total, 2),
                'totalItems' => $cart->items->sum('quantity')
            ]);
        }

        return back()->with('success', 'Item removed from cart');
    }

    public function clear()
    {
        if (Auth::check()) {
            // For authenticated users
            $user = Auth::user();
            $cart = $user->cart()->with('items')->first();

            if ($cart) {
                $cart->items()->delete();
                $cart->update([
                    'total' => 0,
                    'item_count' => 0
                ]);
            }
        } else {
            // For guests, clear the session cart
            session(['cart' => [
                'items' => [],
                'total' => 0,
                'item_count' => 0
            ]]);
        }

        return redirect()->route('customer.cart.index')
            ->with('success', 'Cart cleared successfully.');
    }

    /**
     * Merge guest cart with user cart after login/registration
     */
    public static function mergeGuestCart($user)
    {
        $guestCart = session('cart');

        if (empty($guestCart['items'])) {
            return;
        }

        // Get or create user's cart
        $userCart = Cart::firstOrCreate(
            ['user_id' => $user->id],
            ['total' => 0]
        );

        foreach ($guestCart['items'] as $item) {
            // Check if product exists and is active
            $product = Product::find($item['product_id']);
            if (!$product) continue;

            // Check if item already exists in user's cart
            $existingItem = $userCart->items()
                ->where('product_id', $item['product_id'])
                ->where('variant_id', $item['variant_id'] ?? null)
                ->first();

            if ($existingItem) {
                // Update quantity if item exists
                $existingItem->update([
                    'quantity' => $existingItem->quantity + $item['quantity']
                ]);
            } else {
                // Add new item
                $userCart->items()->create([
                    'product_id' => $item['product_id'],
                    'variant_id' => $item['variant_id'] ?? null,
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price']
                ]);
            }
        }

        // Update cart total
        $userCart->update([
            'total' => $userCart->items->sum(function ($item) {
                return $item->quantity * $item->unit_price;
            })
        ]);

        // Clear guest cart from session
        session()->forget('cart');
    }
}
