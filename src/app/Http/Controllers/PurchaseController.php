<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Purchase;
use App\Models\Item;
use App\Http\Requests\PurchaseRequest;

class PurchaseController extends Controller
{
    public function purchase(PurchaseRequest $request) {
        $item = Item::findOrFail($request->item_id);

        Purchase::create([
            'user_id' => auth()->id(),
            'item_id' => $request->item_id,
            'payment_method' => $request->paymentMethod
        ]);
        $item->update(['is_sold' => true]);
        
        return redirect('/mypage');
    }
}
