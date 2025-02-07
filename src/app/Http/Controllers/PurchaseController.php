<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Purchase;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Stripe\Checkout\Session as StripeSession;
use App\Http\Requests\PurchaseRequest;

class PurchaseController extends Controller
{
    public function purchase(PurchaseRequest $request) {
        /**@var User $user */
        $user = Auth::user();
        $item = Item::find($request->item_id);

        $purchaseData = session('purchase_data', []);
        $purchaseData['payment_method'] = $request->paymentMethod; 
        Session::put('purchase_data', $purchaseData);

        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        $checkoutSession = StripeSession::create([
            'payment_method_types' => ['card', 'konbini'],

            'line_items' => [[  
                'price_data' => [
                    'currency' => 'jpy',
                    'product_data' => [  
                        'name' => $item->item_name,
                    ],
                    'unit_amount' => $item->price, 
                ],
                'quantity' => 1,  
            ]],

            'mode' => 'payment',

            'success_url' => route('purchase.success', ['item_id' => $item->id]),

            'cancel_url' => route('purchase.cancel'),

        ]);

        return redirect($checkoutSession->url);
    }

    public function success(Request $request) {
        /** @var User $user */
        $user = Auth::user();
        $item = Item::findOrFail($request->item_id);
        $purchaseData = session('purchase_data', []);

        Purchase::create([
            'user_id' => $purchaseData['user_id'] ?? $user->id,
            'item_id' => $purchaseData['item_id'] ?? $item->id,
            'shipping_zipcode' => $purchaseData['shipping_zipcode'] ?? $user->zipcode,
            'shipping_address' => $purchaseData['shipping_address'] ?? $user->address,
            'shipping_building' => $purchaseData['shipping_building'] ?? $user->building,
            'payment_method' => $purchaseData['payment_method'] ?? 'unknown'
        ]);

        $item->update(['is_sold' => true]);

        Session::forget('purchase_data');

        return view('purchase.success');
    }

    public function cancel() {
        return view('purchase.cancel');
    }
}

