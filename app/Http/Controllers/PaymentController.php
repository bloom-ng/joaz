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
    public function initialize(Request $request): JsonResponse
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
        ]);

        $order = Order::findOrFail($request->order_id);

        // Check if user owns the order
        if ($order->user_id !== $request->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized access to order'
            ], 403);
        }

        $result = $this->paymentService->initializePayment($order);

        return response()->json($result);
    }

    /**
     * Verify payment after callback.
     */
    public function verify(string $reference): JsonResponse
    {
        $result = $this->paymentService->verifyPayment($reference);

        return response()->json($result);
    }

    /**
     * Handle Paystack callback.
     */
    public function callback(Request $request): JsonResponse
    {
        $reference = $request->query('reference');

        if (!$reference) {
            return response()->json([
                'success' => false,
                'message' => 'No reference provided'
            ], 400);
        }

        $result = $this->paymentService->verifyPayment($reference);

        return response()->json($result);
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
