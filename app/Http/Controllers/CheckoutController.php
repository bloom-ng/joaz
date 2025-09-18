<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\User;
use App\Models\Order;
use App\Models\Setting;
use App\Models\CartItem;
use App\Models\OrderItem;
use App\Models\DeliveryFee;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\PickupAddress;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function showDeliveryForm()
    {
        return view('customer.shop.confirm-delivery');
    }
    public function placeOrder(Request $request)
    {
        $request->validate([
            'address_id' => 'required|exists:addresses,id',
            'delivery_method' => 'required|in:pickup,delivery',
            'payment_currency' => 'required|in:NGN,USD',
            'total_amount' => 'required',
        ]);

        $user = $request->user();

        // ✅ Get cart items from DB instead of session
        $cartItems = CartItem::whereHas('cart', fn($q) => $q->where('user_id', $user->id))
            ->with('product')
            ->get();



        if ($cartItems->isEmpty()) {
            return back()->with('error', 'Cart is empty.');
        }

        // 1️⃣ Create order
        $order = Order::create([
            'user_id' => $user->id,
            'address_id' => $request->address_id,
            'payment_currency' => $request->payment_currency,
            'total_amount' => (float) $request->total_amount,
            'delivery_method' => $request->delivery_method,
            'payment_status' => 'pending',
            'order_status' => 'pending',
            'tracking_number' => Order::generateTrackingNumber(),

        ]);



        // 2️⃣ Attach order items
        foreach ($cartItems as $item) {
            $cartItem = $item;
            $product = $cartItem->product;

            // Check if enough stock is available
            if ($product->quantity < $cartItem->quantity) {
                return back()->with('error', "Not enough stock for {$product->name}");
            }

            OrderItem::create([
                'order_id'   => $order->id,
                'product_id' => $cartItem->product_id,
                'quantity'   => $cartItem->quantity,
                'unit_price' => $cartItem->unit_price,
            ]);

            // Decrease product stock
            $product->decrement('quantity', $cartItem->quantity);
        }

        // 3️⃣ Clear cart after order is placed
        Cart::where('user_id', $user->id)->delete();

        return redirect()->route('orders.processing', $order->id);
    }

    public function processing(Order $order)
    {
        return view('customer.shop.payment-redirect', compact('order'));
    }



    public function processDelivery(Request $request)
    {
        $request->validate([
            'delivery_method' => 'required|in:delivery,pickup',
        ]);

        // store just the method
        session(['checkout.delivery_method' => $request->delivery_method]);


        if ($request->delivery_method === 'pickup') {
            return redirect()->route('select-pickup');
        }

        return redirect()->route('confirm-delivery2');
    }

    public function setDefaultAddress(Request $request)
    {
        $request->validate([
            'address_id' => 'required|exists:addresses,id',
        ]);

        $user = auth()->user();

        // Only update if the address belongs to this user
        $address = $user->addresses()->where('id', $request->address_id)->firstOrFail();

        $user->addresses()->update(['is_default' => false]);
        $address->update(['is_default' => true]);
    }

    public function showPickupSelect()
    {
        $user = auth()->user();
        $defaultAddress = $user->addresses()->where('is_default', true)->first();

        $pickupAddresses = collect(); // empty collection by default

        if ($defaultAddress && $defaultAddress->country) {
            $pickupAddresses = PickupAddress::where('country', $defaultAddress->country)->get();
        }

        $allAddresses = PickupAddress::all();

        return view('customer.shop.pickup', compact('pickupAddresses', 'user', 'defaultAddress', 'allAddresses'));
    }



    public function setPickup(Request $request)
    {
        $request->validate([
            'pickup_address_id' => 'required|exists:pickup_addresses,id',
        ]);

        session(['checkout.pickup_address_id' => $request->pickup_address_id]);

        return redirect()->route('order-summary2');
    }


    public function addAddress(Request $request)
    {
        $request->validate([
            'label' => 'required|string|max:20',
            'address' => 'required|string',
            'country' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'postal_code' => 'nullable|string|max:20',
            'is_default' => 'sometimes|boolean',
        ]);

        $user = auth()->user();

        $user->addresses()->create([
            'label' => $request->label,
            'address' => $request->address,
            'country' => $request->country,
            'state' => $request->state,
            'city' => $request->city,
            'postal_code' => $request->postal_code,
            'is_default' => $request->boolean('is_default', false),
        ]);

        return redirect()->back()->with('success', 'New address added successfully.');
    }

    public function index()
    {
        $user = auth()->user();

        $cart = $user->cart()->with(['items.product.images'])->first();
        $cartItems = $cart ? $cart->items : collect();
        $defaultAddress = $user->addresses()->where("is_default", true)->first();
        $country = $defaultAddress?->country ?? 'United States of America';
        $deliveryFee = DeliveryFee::where('country', $country)->first()
            ?? DeliveryFee::where('country', 'United States of America')->first();
        $VAT = Setting::where('name', 'Value Added Tax')->value('value');
        return view('customer.shop.order-summary2', compact('cartItems', 'deliveryFee', 'VAT'));
    }
}
