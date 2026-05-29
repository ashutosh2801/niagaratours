<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Stripe\Checkout\Session;
use Stripe\Stripe;

class StripeController extends Controller
{
    protected function setupStripe()
    {
        $secret = Setting::get('stripe_secret') ?: config('services.stripe.secret');
        Stripe::setApiKey($secret);
    }

    public function success(Request $request)
    {
        $sessionId = $request->query('session_id');
        if (!$sessionId) {
            return redirect()->route('home')->with('error', 'Missing session ID.');
        }

        $this->setupStripe();

        try {
            $session = Session::retrieve($sessionId);

            $order = Order::where('order_number', $session->metadata->order_number ?? '')->first();
            if (!$order) {
                return redirect()->route('home')->with('error', 'Order not found.');
            }

            if ($session->payment_status === 'paid') {
                $order->update(['status' => Order::STATUS_CONFIRMED]);

                Payment::updateOrCreate(
                    ['order_id' => $order->id],
                    [
                        'transaction_id' => $session->payment_intent,
                        'payment_method' => 'stripe',
                        'amount' => $session->amount_total / 100,
                        'currency' => strtoupper($session->currency),
                        'status' => 'completed',
                        'payment_data' => ['session_id' => $sessionId],
                    ]
                );

                session()->flash('booking_success', true);
                session()->flash('order_number', $order->order_number);
            }

            return redirect()->route('booking.confirmation');
        } catch (\Exception $e) {
            Log::error('Stripe success error: ' . $e->getMessage());
            return redirect()->route('home')->with('error', 'Payment verification failed.');
        }
    }

    public function cancel()
    {
        return redirect()->route('home')->with('error', 'Payment was cancelled.');
    }

    public function webhook(Request $request)
    {
        $this->setupStripe();

        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $endpointSecret = config('services.stripe.webhook_secret');

        if (!$endpointSecret) {
            Log::error('Stripe webhook secret not configured');
            return response('Webhook secret not configured', 500);
        }

        try {
            $event = \Stripe\Webhook::constructEvent($payload, $sigHeader, $endpointSecret);
        } catch (\UnexpectedValueException $e) {
            return response('Invalid payload', 400);
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            return response('Invalid signature', 400);
        }

        switch ($event->type ?? '') {
            case 'checkout.session.completed':
                $session = $event->data->object;
                $order = Order::where('order_number', $session->metadata->order_number ?? '')->first();
                if ($order && $order->status === Order::STATUS_PENDING) {
                    $order->update(['status' => Order::STATUS_CONFIRMED]);
                    Payment::updateOrCreate(
                        ['order_id' => $order->id],
                        [
                            'transaction_id' => $session->payment_intent,
                            'payment_method' => 'stripe',
                            'amount' => $session->amount_total / 100,
                            'currency' => strtoupper($session->currency),
                            'status' => 'completed',
                            'payment_data' => ['session_id' => $session->id],
                        ]
                    );
                }
                break;
        }

        return response('OK', 200);
    }
}
