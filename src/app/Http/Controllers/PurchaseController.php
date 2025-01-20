<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Purchase;

class PurchaseController extends Controller
{
    public function purchase(Request $request) {
        Purchase::create([
            'user_id' => auth()->id(),
            'item_id' => $request->id
        ]);
        return redirect('/mypage');
    }
}
