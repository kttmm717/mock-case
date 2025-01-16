<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use App\Models\Payment;
use App\Models\User;

class ItemController extends Controller
{
    public function index() {
        $items = Item::all();
        return view('index', compact('items'));
    }
    public function detail(Request $request) {
        $item = Item::find($request->id);
        return view('product-detail', compact('item'));
    }
    public function procedure(Request $request) {
        $item = Item::find($request->id);
        $payments = Payment::all();
        $user = Auth::user();
        return view('product-purchase', compact('item', 'payments', 'user'));
    }
    public function edit(Request $request) {
        $item = Item::find($request->id);
        return view('cange-address', compact('item'));
    }
    public function update(Request $request) {
        /** @var User $user */
        $user = Auth::user();
        $form = $request->only(['zipcode', 'address', 'building']);
        $user->update($form);
        $item = Item::find($request->id);
        $payments = Payment::all();
        return view('product-purchase', compact('item', 'payments', 'user'));
    }
}
