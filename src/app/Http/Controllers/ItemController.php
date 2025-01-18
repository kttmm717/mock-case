<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ExhibitionRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use App\Models\Payment;
use App\Models\User;
use App\Models\Category;
use App\Models\Condition;
use App\Models\Sale;

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
    public function procedureView(Request $request) {
        $item = Item::find($request->id);
        $payments = Payment::all();
        $user = Auth::user();
        return view('product-purchase', compact('item', 'payments', 'user'));
    }
    public function editAddress(Request $request) {
        $item = Item::find($request->id);
        return view('cange-address', compact('item'));
    }
    public function updateAddress(Request $request) {
        /** @var User $user */
        $user = Auth::user();
        $form = $request->only(['zipcode', 'address', 'building']);
        $user->update($form);
        $item = Item::find($request->id);
        $payments = Payment::all();
        return view('product-purchase', compact('item', 'payments', 'user'));
    }
    public function sellView() {
        $categories = Category::all();
        $conditions = Condition::all();
        return view('product-listing', compact('categories', 'conditions'));
    }
    public function sale(ExhibitionRequest $request) {
        $image = $request->file('image')->store('images', 'public');
        $sale = Sale::create([
            'user_id' => auth()->id(),
            'image' => $image,
            'condition_id' => $request->condition_id,
            'name' => $request->name,
            'content' => $request->content,
            'price' => $request->price
        ]);
        $sale->categories()->attach($request->categories);
        return redirect('/');
    }
}
