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
        if (Auth::check()) {
            // For authenticated users, use database cart
            $cart = Cart::with(['items.product.images'])
                ->where('user_id', Auth::id())
                ->firstOrCreate(
                    ['user_id' => Auth::id()],
                    ['total' => 0]
                );
            $cart->load(['items.product.images']);
        } else {
            // For guests, use session cart
            $cart = session('cart', [
                'items' => [],
                'total' => 0,
                'item_count' => 0
            ]);
            
            // If we have items in the session, load the product data
            if (!empty($cart['items'])) {
                $productIds = array_column($cart['items'], 'product_id');
                $products = Product::with('images')->whereIn('id', $productIds)->get()->keyBy('id');
                
                foreach ($cart['items'] as &$item) {
                    if (isset($products[$item['product_id']])) {
                        $item['product'] = $products[$item['product_id']];
                    }
                }
            }
            
            // Convert to object for consistent view handling
            $cart = (object) $cart;
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

        if (Auth::check()) {
            // For authenticated users
            $cart = Cart::firstOrCreate(
                ['user_id' => Auth::id()],
                ['total' => 0]
            );

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

                // Update the existing item
                $existingItem->update([
                    'quantity' => $newQuantity,
                    'unit_price' => $unitPrice,
                ]);
            } else {
                // Create new cart item
                $cart->items()->create([
                    'product_id' => $product->id,
                    'quantity' => $request->quantity,
                    'unit_price' => $unitPrice,
                    'variant_id' => $request->variant_id ?? null,
                ]);
            }

            // Update cart total
            $cart->update([
                'total' => $cart->items->sum(function ($item) {
                    return $item->quantity * $item->unit_price;
                })
            ]);
        } else {
            // For guests, use session
            $cart = session('cart', [
                'items' => [],
                'total' => 0,
                'item_count' => 0
            ]);

            // Check if item already exists in cart
            $itemKey = null;
            foreach ($cart['items'] as $key => $item) {
                if ($item['product_id'] == $request->product_id && 
                    $item['variant_id'] == ($request->variant_id ?? null)) {
                    $itemKey = $key;
                    break;
                }
            }

            $unitPrice = $product->price_ngn;
            if ($request->has('variant_id') && $variant = $product->variants->find($request->variant_id)) {
                $unitPrice = $variant->price_ngn;
            }

            if ($itemKey !== null) {
                // Update existing item
                $newQuantity = $cart['items'][$itemKey]['quantity'] + $request->quantity;
                
                if ($product->quantity < $newQuantity) {
                    return back()->withErrors(['quantity' => 'Insufficient stock available.']);
                }

                $cart['items'][$itemKey]['quantity'] = $newQuantity;
                $cart['items'][$itemKey]['unit_price'] = $unitPrice;
            } else {
                // Add new item
                $cart['items'][] = [
                    'product_id' => $product->id,
                    'quantity' => $request->quantity,
                    'unit_price' => $unitPrice,
                    'variant_id' => $request->variant_id ?? null,
                    'product' => $product->load('images')
                ];
            }

            // Update cart totals
            $cart['total'] = collect($cart['items'])->sum(function ($item) {
                return $item['quantity'] * $item['unit_price'];
            });
            $cart['item_count'] = count($cart['items']);

            // Store cart in session
            session(['cart' => $cart]);
        }

        return back()->with('success', 'Product added to cart successfully!');
    }

    public function update(Request $request, $itemId = null)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $newQuantity = $request->quantity;

        if (Auth::check()) {
            // For authenticated users
            $cartItem = CartItem::findOrFail($itemId);
            
            // Check if cart belongs to authenticated user
            if ($cartItem->cart->user_id !== Auth::id()) {
                return response()->json(['error' => 'Forbidden'], 403);
            }

            $product = $cartItem->product;

            // Check stock
            if ($product->quantity < $newQuantity) {
                return response()->json(['error' => 'Insufficient stock available.'], 422);
            }

            // Update the cart item
            $cartItem->update(['quantity' => $newQuantity]);

            // Update cart total
            $cart = $cartItem->cart;
            $cart->update([
                'total' => $cart->items->sum(function($item) {
                    return $item->quantity * $item->unit_price;
                })
            ]);

            $itemTotal = $cartItem->unit_price * $newQuantity;
            $cartTotal = $cart->total;
        } else {
            // For guests, use session
            $cart = session('cart', [
                'items' => [],
                'total' => 0,
                'item_count' => 0
            ]);

            // Find the item in the cart
            $itemKey = null;
            foreach ($cart['items'] as $key => $item) {
                if ($item['id'] == $itemId) {
                    $itemKey = $key;
                    break;
                }
            }

            if ($itemKey === null) {
                return response()->json(['error' => 'Item not found in cart'], 404);
            }

            // Check stock
            $product = Product::findOrFail($cart['items'][$itemKey]['product_id']);
            if ($product->quantity < $newQuantity) {
                return response()->json(['error' => 'Insufficient stock available.'], 422);
            }

            // Update the item
            $cart['items'][$itemKey]['quantity'] = $newQuantity;
            
            // Update cart totals
            $cart['total'] = collect($cart['items'])->sum(function($item) {
                return $item['quantity'] * $item['unit_price'];
            });
            
            // Save to session
            session(['cart' => $cart]);
            
            $itemTotal = $cart['items'][$itemKey]['unit_price'] * $newQuantity;
            $cartTotal = $cart['total'];
        }

        return response()->json([
            'success' => true,
            'quantity' => $newQuantity,
            'itemTotal' => number_format($itemTotal, 2),
            'cartTotal' => number_format($cartTotal, 2),
        ]);
    }


    public function remove($itemId = null)
    {
        if (Auth::check()) {
            // For authenticated users
            $cartItem = CartItem::findOrFail($itemId);
            
            // Check if cart belongs to authenticated user
            if ($cartItem->cart->user_id !== Auth::id()) {
                abort(403);
            }

            $cartItem->delete();
            
            // Update cart total
            $cart = $cartItem->cart;
            $cart->update([
                'total' => $cart->items->sum(function($item) {
                    return $item->quantity * $item->unit_price;
                })
            ]);
        } else {
            // For guests, use session
            $cart = session('cart', [
                'items' => [],
                'total' => 0,
                'item_count' => 0
            ]);

            // Find and remove the item
            foreach ($cart['items'] as $key => $item) {
                if ($item['id'] == $itemId) {
                    unset($cart['items'][$key]);
                    break;
                }
            }
            
            // Re-index array
            $cart['items'] = array_values($cart['items']);
            
            // Update cart totals
            $cart['total'] = collect($cart['items'])->sum(function($item) {
                return $item['quantity'] * $item['unit_price'];
            });
            $cart['item_count'] = count($cart['items']);
            
            // Save to session
            session(['cart' => $cart]);
        }

        return back()->with('success', 'Item removed from cart.');
    }

    public function clear()
    {
        if (Auth::check()) {
            // For authenticated users
            $cart = Cart::where('user_id', Auth::id())
                ->where('is_active', true)
                ->first();

            if ($cart) {
                $cart->items()->delete();
                $cart->update(['total' => 0]);
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
