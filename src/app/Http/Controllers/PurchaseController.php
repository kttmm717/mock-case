<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Purchase;
use App\Models\Item;
use App\Http\Requests\PurchaseRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;

class PurchaseController extends Controller
{
    public function purchase(Request $request) {
        /**@var User $user */
        $user = Auth::user();
        $item = Item::find($request->item_id);

        $purchaseData = session('purchase_data', []);
        $purchaseData['payment_method'] = $request->paymentMethod; // 保存
        Session::put('purchase_data', $purchaseData);

        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        $checkoutSession = StripeSession::create([
        //stripeの決済ページを作成する関数
        //createメソッドに決済の詳細情報を渡すとstripeの決済ページのURLが返ってくる
        //return redirect($checkoutSession->url);を実行するとstripe決済画面へ移動する
            
            'payment_method_types' => ['card', 'konbini'],
            //どの支払い方法を許可するかを指定

            'line_items' => [[  //購入商品の情報
                'price_data' => [
                    'currency' => 'jpy',
                    'product_data' => [  //商品情報（名前等）
                        'name' => $item->item_name,
                    ],
                    'unit_amount' => $item->price, 
                ],
                'quantity' => 1,  //購入数
            ]],

            'mode' => 'payment',
            //決済モードの設定
            //payment：一括払い（通常）

            'success_url' => route('purchase.success', ['item_id' => $item->id]),
            //success_url：購入成功時のページ

            'cancel_url' => route('purchase.cancel'),
            //cancel_url：ユーザーが決済をキャンセルした場合のページ

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

