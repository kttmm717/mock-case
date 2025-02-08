<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Webhook;
use App\Models\Purchase;
use App\Models\Item;

class KonbiniPaymentController extends Controller
{
    public function handleWebhook(Request $request)
    {
        $payload = $request->getContent();
    $sigHeader = $request->header('Stripe-Signature');
    $endpointSecret = env('STRIPE_WEBHOOK_SECRET');

    try {
        $event = Webhook::constructEvent($payload, $sigHeader, $endpointSecret);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Invalid signature'], 400);
    }

    if ($event->type === 'payment_intent.succeeded') {
        $paymentIntent = $event->data->object;
        $userId = $paymentIntent->metadata->user_id ?? null;
        $itemId = $paymentIntent->metadata->item_id ?? null;

        if (!$userId || !$itemId) {
            return response()->json(['error' => 'Missing metadata'], 400);
        }
        Purchase::create([
            'user_id' => $userId,
            'item_id' => $itemId,
            'shipping_zipcode' => $paymentIntent->metadata->shipping_zipcode,
            'shipping_address' => $paymentIntent->metadata->shipping_address,
            'shipping_building' => $paymentIntent->metadata->shipping_building,
            'payment_method' => $paymentIntent->metadata->payment_method
        ]);

        $item = Item::find($itemId);
        $item->update(['is_sold' => true]);
    }

    return response()->json(['status' => 'success']);
    }
}
