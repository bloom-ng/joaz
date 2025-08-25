<?php

namespace App\Http\Controllers;

use App\Models\NewsletterSubscription;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class NewsletterSubscriptionController extends Controller
{
    /**
     * Store a new newsletter subscription.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:newsletter_subscriptions,email',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $subscription = NewsletterSubscription::create([
                'email' => $request->email,
                'is_subscribed' => true,
                'unsubscribe_token' => Str::random(32),
                'email_verified_at' => now(),
            ]);

            return back()->with('success', 'Thank you for subscribing to our newsletter!');

        } catch (\Exception $e) {
            return back()
                ->with('error', 'Failed to subscribe. Please try again later.')
                ->withInput();
        }
    }
}
