<?php

namespace App\Http\Controllers\Customer;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Address;
use App\Models\DeliveryFee;
use Illuminate\Http\Request;
use App\Services\PaymentService;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    protected $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    public function index(Request $request)
    {
        $query = Order::with(['items.product.images'])
            ->where('user_id', auth()->id());

        if ($request->has('order_status') && in_array($request->status, ['pending', 'processing', 'shipped', 'delivered', 'cancelled'])) {
            $query->where('order_status', $request->status);
        }

        $orders = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('customer.shop.account-center', compact('orders'));
    }

    public function guestCheckout()
    {
        $cartItems = session()->get('cart')['items'] ?? [];
        $total_usd = 0;
        $total_ngn = 0;

        foreach ($cartItems as $item) {
            $total_usd += $item['product']->price_usd * $item['quantity'];
            $total_ngn += $item['product']->price_ngn * $item['quantity'];
        }


        if (empty($cartItems)) {
            return redirect()->back()->with('error', 'Your cart is empty.');
        }

        $guestDetails = session("guest_details");

        $deliveryFee = null;

        if ($guestDetails && isset($guestDetails['country'])) {
            $deliveryFee = DeliveryFee::where('country', $guestDetails['country'])->first();
        }

        // fallback to USA if nothing found
        if (!$deliveryFee) {
            $deliveryFee = DeliveryFee::where('country', 'United States of America')->first();
        }

        $deliveryFeeAmount = $deliveryFee ? $deliveryFee->amount : 0;

        $VAT = session('vat', 0);

        $vat_usd = ($total_usd + $deliveryFeeAmount) * ($VAT / 100);
        $vat_ngn = ($total_ngn + $deliveryFeeAmount) * ($VAT / 100);

        return view('customer.shop.guest-order', compact(
            'cartItems',
            'total_ngn',
            'total_usd',
            'deliveryFeeAmount',
            'VAT',
            'vat_ngn',
            'vat_usd'
        ));
    }



    public function show(Order $order)
    {
        // Check if order belongs to authenticated user
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $order->load(['items.product.images', 'address', 'delivery']);

        return view('customer.orders.show', compact('order'));
    }

    public function productOrder($id)
    {
        $user = auth()->user();

        // Find the order by id, making sure it belongs to this user
        $order = Order::with(["items.product.images"])
            ->where("user_id", $user->id)
            ->where("id", $id)
            ->firstOrFail();

        return view("customer.shop.order-product", compact("order", "user"));
    }



    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'address_id' => 'required|exists:addresses,id',
    //         'delivery_method' => 'required|in:pickup,delivery',
    //         'payment_method' => 'required|in:paystack,cash_on_delivery',
    //         'notes' => 'nullable|string|max:500',
    //     ]);

    //     // Verify address belongs to user
    //     $address = Address::where('id', $request->address_id)
    //         ->where('user_id', auth()->id())
    //         ->firstOrFail();

    //     // Get user's active cart
    //     $cart = Cart::with(['items.product'])
    //         ->where('user_id', auth()->id())
    //         ->where('is_active', true)
    //         ->first();

    //     if (!$cart || $cart->items->isEmpty()) {
    //         return back()->withErrors(['cart' => 'Your cart is empty.']);
    //     }

    //     // Check stock availability
    //     foreach ($cart->items as $item) {
    //         if ($item->product->quantity < $item->quantity) {
    //             return back()->withErrors(['stock' => "Insufficient stock for {$item->product->name}."]);
    //         }
    //     }

    //     DB::beginTransaction();

    //     try {
    //         // Calculate totals
    //         $subtotal = $cart->items->sum(function ($item) {
    //             return $item->quantity * $item->unit_price;
    //         });

    //         $deliveryFee = $request->delivery_method === 'delivery' ? 1000 : 0; // 1000 NGN
    //         $total = $subtotal + $deliveryFee;

    //         // Create order
    //         $order = Order::create([
    //             'user_id' => auth()->id(),
    //             'order_number' => 'ORD-' . strtoupper(uniqid()),
    //             'status' => 'pending',
    //             'subtotal' => $subtotal,
    //             'delivery_fee' => $deliveryFee,
    //             'total' => $total,
    //             'delivery_method' => $request->delivery_method,
    //             'payment_method' => $request->payment_method,
    //             'notes' => $request->notes,
    //             'address_id' => $address->id,
    //         ]);

    //         // Create order items
    //         foreach ($cart->items as $item) {
    //             $order->items()->create([
    //                 'product_id' => $item->product_id,
    //                 'quantity' => $item->quantity,
    //                 'unit_price' => $item->unit_price,
    //                 'total_price' => $item->quantity * $item->unit_price,
    //             ]);

    //             // Update product stock
    //             $item->product->decrement('quantity', $item->quantity);
    //         }

    //         // Deactivate cart
    //         $cart->update(['is_active' => false]);

    //         // If payment method is Paystack, initialize payment
    //         if ($request->payment_method === 'paystack') {
    //             $paymentData = $this->paymentService->initializePayment([
    //                 'amount' => $total * 100, // Convert to kobo
    //                 'email' => auth()->user()->email,
    //                 'reference' => $order->order_number,
    //                 'callback_url' => route('payment.callback'),
    //                 'metadata' => [
    //                     'order_id' => $order->id,
    //                     'user_id' => auth()->id(),
    //                 ],
    //             ]);

    //             DB::commit();

    //             return response()->json([
    //                 'success' => true,
    //                 'payment_url' => $paymentData['authorization_url'],
    //                 'order_id' => $order->id,
    //             ]);
    //         }

    //         DB::commit();

    //         return redirect()->route('customer.orders.show', $order)
    //             ->with('success', 'Order placed successfully!');
    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         return back()->withErrors(['error' => 'Failed to create order. Please try again.']);
    //     }
    // }
}
