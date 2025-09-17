<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class PaymentController extends Controller
{
    protected PaymentService $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    /**
     * Initialize payment for an order.
     */
    public function initialize(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
        ]);

        $order = Order::findOrFail($request->order_id);

        // Ensure user owns it
        if ($order->user_id !== $request->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized access to order'
            ], 403);
        }

        $result = $this->paymentService->initializePayment($order);

        if ($result['success']) {
            // ✅ Send user directly to Paystack checkout
            return redirect()->away($result['authorization_url']);
        }

        return redirect('/')->with('error', 'Payment initialization failed.');
    }


    /**
     * Verify payment after callback.
     */
    public function verify(string $reference)
    {
        return $this->paymentService->verifyPayment($reference);
    }

    /**
     * Handle Paystack callback.
     */
    public function callback(Request $request)
    {
        $reference = $request->query('reference');

        if (!$reference) {
            return redirect('/')->with('error', 'No payment reference provided.');
        }

        $result = $this->paymentService->verifyPayment($reference);

        if ($result['success']) {
            // Payment was successful
            return redirect('/')->with('success', 'Payment completed successfully!');
        } else {
            // Payment failed
            return redirect('/')->with('error', $result['message'] ?? 'Payment failed.');
        }
    }


    /**
     * Handle Paystack webhook.
     */
    public function webhook(Request $request): JsonResponse
    {
        $payload = $request->all();

        if (empty($payload)) {
            return response()->json([
                'success' => false,
                'message' => 'Empty payload'
            ], 400);
        }

        $result = $this->paymentService->handleWebhook($payload);

        return response()->json($result);
    }

    /**
     * Get payment public key for frontend.
     */
    public function getPublicKey(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'public_key' => $this->paymentService->getPublicKey()
        ]);
    }
}
