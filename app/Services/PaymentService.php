<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PaymentService
{
    private string $secretKey;
    private string $publicKey;
    private string $baseUrl = 'https://api.paystack.co';

    public function __construct()
    {
        $this->secretKey = config('services.paystack.secret_key');
        $this->publicKey = config('services.paystack.public_key');
    }

    /**
     * Initialize a payment transaction with Paystack.
     */
    public function initializePayment(Order $order): array
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->secretKey,
                'Content-Type' => 'application/json',
            ])->post($this->baseUrl . '/transaction/initialize', [
                'amount' => $this->convertToKobo($order->total_amount),
                'email' => $order->user->email,
                'currency' => $order->payment_currency,
                'reference' => $this->generateReference(),
                'callback_url' => route('payment.callback'),
                'metadata' => [
                    'order_id' => $order->id,
                    'user_id' => $order->user_id,
                    'custom_fields' => [
                        [
                            'display_name' => 'Order ID',
                            'variable_name' => 'order_id',
                            'value' => $order->id
                        ]
                    ]
                ]
            ]);

            if ($response->successful()) {
                $data = $response->json();

                // Create transaction record
                Transaction::create([
                    'order_id' => $order->id,
                    'gateway' => 'paystack',
                    'transaction_reference' => $data['data']['reference'],
                    'amount' => $order->total_amount,
                    'currency' => $order->payment_currency,
                    'status' => 'pending',
                    'response_payload' => $data
                ]);

                return [
                    'success' => true,
                    'authorization_url' => $data['data']['authorization_url'],
                    'reference' => $data['data']['reference'],
                    'access_code' => $data['data']['access_code']
                ];
            }

            Log::error('Paystack initialization failed', [
                'order_id' => $order->id,
                'response' => $response->json()
            ]);

            return [
                'success' => false,
                'message' => 'Failed to initialize payment'
            ];
        } catch (\Exception $e) {
            Log::error('Paystack initialization error', [
                'order_id' => $order->id,
                'error' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'message' => 'Payment initialization error'
            ];
        }
    }

    /**
     * Verify a payment transaction with Paystack.
     */
    public function verifyPayment(string $reference): array
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->secretKey,
                'Content-Type' => 'application/json',
            ])->get($this->baseUrl . '/transaction/verify/' . $reference);

            if ($response->successful()) {
                $data = $response->json();

                $transaction = Transaction::where('transaction_reference', $reference)->first();

                if (!$transaction) {
                    return [
                        'success' => false,
                        'message' => 'Transaction not found'
                    ];
                }

                $order = $transaction->order;
                $status = $data['data']['status'];

                // Update transaction status
                $transaction->update([
                    'status' => $status === 'success' ? 'successful' : 'failed',
                    'paid_at' => $status === 'success' ? now() : null,
                    'response_payload' => $data
                ]);

                // Update order payment status
                if ($status === 'success') {
                    $order->update(['payment_status' => 'paid']);

                    // Create delivery record if delivery method is delivery
                    if ($order->delivery_method === 'delivery') {
                        $order->delivery()->create([
                            'status' => 'pending',
                            'estimated_delivery' => now()->addDays(3)
                        ]);
                    }
                } else {
                    $order->update(['payment_status' => 'failed']);
                }

                return [
                    'success' => true,
                    'status' => $status,
                    'order_id' => $order->id,
                    'amount' => $data['data']['amount'] / 100
                ];
            }

            Log::error('Paystack verification failed', [
                'reference' => $reference,
                'response' => $response->json()
            ]);

            return [
                'success' => false,
                'message' => 'Failed to verify payment'
            ];
        } catch (\Exception $e) {
            Log::error('Paystack verification error', [
                'reference' => $reference,
                'error' => $e->getMessage()
            ]);

            return [
                'success' => false,
                'message' => 'Payment verification error'
            ];
        }
    }

    /**
     * Handle Paystack webhook.
     */
    public function handleWebhook(array $payload): array
    {
        try {
            // Verify webhook signature
            if (!$this->verifyWebhookSignature($payload)) {
                return [
                    'success' => false,
                    'message' => 'Invalid webhook signature'
                ];
            }

            $event = $payload['event'];
            $data = $payload['data'];

            switch ($event) {
                case 'charge.success':
                    return $this->handleSuccessfulCharge($data);

                case 'charge.failed':
                    return $this->handleFailedCharge($data);

                case 'transfer.success':
                    return $this->handleSuccessfulTransfer($data);

                default:
                    Log::info('Unhandled Paystack webhook event', ['event' => $event]);
                    return [
                        'success' => true,
                        'message' => 'Event handled'
                    ];
            }
        } catch (\Exception $e) {
            Log::error('Webhook handling error', [
                'error' => $e->getMessage(),
                'payload' => $payload
            ]);

            return [
                'success' => false,
                'message' => 'Webhook processing error'
            ];
        }
    }

    /**
     * Handle successful charge webhook.
     */
    private function handleSuccessfulCharge(array $data): array
    {
        $reference = $data['reference'];
        $transaction = Transaction::where('transaction_reference', $reference)->first();

        if (!$transaction) {
            return [
                'success' => false,
                'message' => 'Transaction not found'
            ];
        }

        $order = $transaction->order;

        // Update transaction
        $transaction->update([
            'status' => 'successful',
            'paid_at' => now(),
            'response_payload' => $data
        ]);

        // Update order
        $order->update(['payment_status' => 'paid']);

        // Create delivery record if needed
        if ($order->delivery_method === 'delivery' && !$order->delivery) {
            $order->delivery()->create([
                'status' => 'pending',
                'estimated_delivery' => now()->addDays(3)
            ]);
        }

        return [
            'success' => true,
            'message' => 'Payment processed successfully'
        ];
    }

    /**
     * Handle failed charge webhook.
     */
    private function handleFailedCharge(array $data): array
    {
        $reference = $data['reference'];
        $transaction = Transaction::where('transaction_reference', $reference)->first();

        if (!$transaction) {
            return [
                'success' => false,
                'message' => 'Transaction not found'
            ];
        }

        $order = $transaction->order;

        // Update transaction
        $transaction->update([
            'status' => 'failed',
            'response_payload' => $data
        ]);

        // Update order
        $order->update(['payment_status' => 'failed']);

        return [
            'success' => true,
            'message' => 'Payment failure processed'
        ];
    }

    /**
     * Handle successful transfer webhook.
     */
    private function handleSuccessfulTransfer(array $data): array
    {
        // Handle refunds or transfers
        Log::info('Transfer successful', $data);

        return [
            'success' => true,
            'message' => 'Transfer processed'
        ];
    }

    /**
     * Verify webhook signature.
     */
    private function verifyWebhookSignature(array $payload): bool
    {
        $signature = request()->header('X-Paystack-Signature');

        if (!$signature) {
            return false;
        }

        $computedSignature = hash_hmac('sha512', json_encode($payload), $this->secretKey);

        return hash_equals($computedSignature, $signature);
    }

    /**
     * Convert amount to kobo (smallest currency unit).
     */
    private function convertToKobo(float $amount): int
    {
        return (int) ($amount * 100);
    }

    /**
     * Generate unique reference.
     */
    private function generateReference(): string
    {
        return 'PAY_' . time() . '_' . uniqid();
    }

    /**
     * Get public key for frontend.
     */
    public function getPublicKey(): string
    {
        return $this->publicKey;
    }
}
