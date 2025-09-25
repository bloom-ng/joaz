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
            'quantity'   => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);

        // Stock check
        if ($product->quantity < $request->quantity) {
            return back()->withErrors(['quantity' => 'Insufficient stock available.']);
        }

        // Unit price (variant or default)
        $unitPrice = $product->price_ngn;
        if ($request->has('variant_id') && $variant = $product->variants->find($request->variant_id)) {
            $unitPrice = $variant->price_ngn;
        }

        if (Auth::check()) {
            // ---------- LOGGED-IN USER ----------
            $user = Auth::user();
            $cart = $user->cart()->with('items')->first();

            if (!$cart) {
                $cart = $user->cart()->create(['total' => 0, 'item_count' => 0]);
            }

            $existingItem = $cart->items()
                ->where('product_id', $product->id)
                ->where('variant_id', $request->variant_id ?? null)
                ->first();

            if ($existingItem) {
                $newQuantity = $existingItem->quantity + $request->quantity;

                if ($product->quantity < $newQuantity) {
                    return back()->withErrors(['quantity' => 'Insufficient stock available.']);
                }

                $existingItem->update([
                    'quantity'   => $newQuantity,
                    'unit_price' => $unitPrice,
                ]);
            } else {
                $cart->items()->create([
                    'product_id' => $product->id,
                    'variant_id' => $request->variant_id ?? null,
                    'quantity'   => $request->quantity,
                    'unit_price' => $unitPrice,
                ]);
            }

            // Update totals
            $cart->load('items');
            $cart->update([
                'total'      => $cart->items->sum(fn($item) => $item->quantity * $item->unit_price),
                'item_count' => $cart->items->sum('quantity'),
            ]);
        } else {
            // ---------- GUEST (SESSION) ----------
            $cart = session('cart', ['items' => [], 'total' => 0, 'item_count' => 0]);
            $cartItems = collect($cart['items']);

            // find existing index (if any)
            $index = $cartItems->search(function ($item) use ($product, $request) {
                return $item['product_id'] === $product->id
                    && (($item['variant_id'] ?? null) === ($request->variant_id ?? null));
            });

            if ($index !== false) {
                // read-modify-write (avoid indirect modification error)
                $existing = $cartItems->get($index);

                $newQuantity = $existing['quantity'] + $request->quantity;

                if ($product->quantity < $newQuantity) {
                    return back()->withErrors(['quantity' => 'Insufficient stock available.']);
                }

                $existing['quantity']   = $newQuantity;
                $existing['unit_price'] = $unitPrice;

                // put the modified item back
                $cartItems->put($index, $existing);
            } else {
                // add new item
                $cartItems->push([
                    'product_id' => $product->id,
                    'variant_id' => $request->variant_id ?? null,
                    'quantity'   => $request->quantity,
                    'unit_price' => $unitPrice,
                    'product'    => $product->load('images'),
                ]);
            }

            // Recalculate totals and persist session
            $cart['items']      = $cartItems->values()->toArray();
            $cart['total']      = collect($cart['items'])->sum(fn($i) => $i['quantity'] * $i['unit_price']);
            $cart['item_count'] = collect($cart['items'])->sum('quantity');

            session(['cart' => $cart]);
        }

        return back()->with('success', 'Product added to cart successfully!');
    }

    public function updateItem(Request $request)
    {
        $request->validate([
            'cart_item_id' => 'required|exists:cart_items,id',
            'action' => 'required|in:increment,decrement',
        ]);

        $cartItem = \App\Models\CartItem::findOrFail($request->cart_item_id);

        // Ensure the item belongs to the logged-in user
        if ($cartItem->cart->user_id !== auth()->id()) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        if ($request->action === 'increment') {
            $cartItem->increment('quantity');
            return redirect()->back()->with('success', 'Item quantity increased.');
        } else {
            $cartItem->decrement('quantity');

            if ($cartItem->quantity <= 0) {
                $cartItem->delete();
                return redirect()->back()->with('success', 'Item removed from cart.');
            }

            return redirect()->back()->with('success', 'Item quantity decreased.');
        }
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
            if ($cartItem->quantity > 0) {
                $cartItem->decrement('quantity');

                // If quantity reaches 0, delete the item
                if ($cartItem->quantity <= 0) {
                    $cartItem->delete();
                    return response()->json([
                        'success' => true,
                        'quantity' => 0,
                        'itemTotal' => 0,
                        'cartTotal' => $cartItem->cart->total - $cartItem->unit_price,
                        'totalItems' => $cartItem->cart->items->sum('quantity') - 1,
                        'removed' => true
                    ]);
                }
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Quantity cannot be less than 0'
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


}
