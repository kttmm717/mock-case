<?php

namespace App\Http\Controllers;


use App\Models\Purchase;
use App\Models\Item;
use App\Http\Requests\PurchaseRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class PurchaseController extends Controller
{
    public function purchase(PurchaseRequest $request) {
        /** @var User $user */
        $user = Auth::user();
        $item = Item::find($request->item_id);
        $item->update(['is_sold' => true]);
        $purchaseData = session('purchase_data', []);

        Purchase::create([
            'user_id' => $purchaseData['user_id'] ?? $user->id,
            'item_id' => $purchaseData['item_id'] ?? $item->id,
            'shipping_zipcode' => $purchaseData['shipping_zipcode'] ?? $user->zipcode,
            'shipping_address' => $purchaseData['shipping_address'] ?? $user->address,
            'shipping_building' => $purchaseData['shipping_building'] ?? $user->building,
            'payment_method' => $request->paymentMethod
        ]);

        Session::forget('purchase_data');

        return redirect('/mypage');
    }
}
