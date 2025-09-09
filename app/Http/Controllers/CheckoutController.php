<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function showDeliveryForm()
    {
        return view('customer.shop.confirm-delivery');
    }

    public function processDelivery(Request $request)
    {
        $request->validate([
            'delivery_method' => 'required|in:delivery,pickup',
        ]);

        // store just the method
        session(['checkout.delivery_method' => $request->delivery_method]);


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

    // Assuming you have a relationship in User model: user()->cartItems()
    $cart = $user->cart()->with(['items.product.images'])->first();
    $cartItems = $cart ? $cart->items : collect();

    // // Calculate totals
    // $subTotal = $cart->sum(fn($item) => $item->product->price * $item->quantity);
    // $delivery = 5000;
    // $vat = 500;
    // $grandTotal = $subTotal + $delivery + $vat;

    return view('customer.shop.order-summary2', compact('cartItems'));
}

}
