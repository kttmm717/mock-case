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
use App\Models\Like;
use Illuminate\Support\Facades\Session;

class ItemController extends Controller
{
    public function index(Request $request) {
        if(Auth::check()) {
            $page = $request->query('page', 'best');
            $user = auth()->user();

            if($page === 'mylist') {
                $likes = $user->likes()->with('item')->get();
                return view('index.mylist', compact('likes'));
            }else {
                $items = Item::all();
                return view('index.best', compact('items'));
            }
        } else {
            $page = $request->query('page', 'best');
            $user = auth()->user();

            if($page === 'best') {
                $items = Item::all();
                return view('index.best', compact('items'));
            }else {
                return view('index');
            }
        }
    }
    public function detail(Request $request) {
        $item = Item::find($request->id);
        $conditionId = $item->condition_id;
        $condition = Condition::find($conditionId);
        $categoryIds = $item->category_ids;
        $categories = Category::find($categoryIds);
        return view('product-detail', compact('item', 'condition', 'categories'));
    }
    public function procedureView(Request $request) {
        if(Auth::check()) {
            $item = Item::find($request->id);
            $payments = Payment::all();
            $user = Auth::user();
            return view('product-purchase', compact('item', 'payments', 'user'));
        } else {
            return view('auth.login');
        }
    }
    public function editAddress(Request $request) {
        $item = Item::find($request->id);
        return view('cange-address', compact('item'));
    }
    public function updateAddress(Request $request) {
        /** @var User $user */
        $user = Auth::user();
        $item = Item::find($request->id);
        $form = $request->only(['shipping_zipcode', 'shipping_address', 'shipping_building']);
        
        $purchaseData = [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'shipping_zipcode' => $form['shipping_zipcode'] ?? $user->zipcode,
            'shipping_address' => $form['shipping_address'] ?? $user->address,
            'shipping_building' => $form['shipping_building'] ?? $user->building
        ];
        
        Session::put('purchase_data', $purchaseData);

        return view('product-purchase', compact('item', 'user'));
    }
    public function sellView() {
        if(Auth::check()) {
            $categories = Category::all();
            $conditions = Condition::all();
            return view('product-listing', compact('categories', 'conditions'));    
        } else {
            return view('auth.login');
        }
    }
    public function sale(ExhibitionRequest $request) {
        $image = $request->file('image')->store('item_images', 'public');
        $sale = Sale::create([
            'user_id' => auth()->id(),
            'image' => $image,
            'condition_id' => $request->condition_id,
            'name' => $request->name,
            'content' => $request->content,
            'price' => $request->price
        ]);
        $sale->categories()->attach($request->categories);
        return redirect('/mypage');
    }
    public function search(Request $request) {
        $keyword = $request->keyword;
        $page = $request->query('page', 'best');
        $userId = auth()->id();

        if ($page == 'mylist') {
            $likes = Like::with('item')
                ->where('user_id', $userId)
                ->whereHas('item', function ($query) use ($keyword) {
                    $query->where('item_name', 'LIKE', "%{$keyword}%");
                })
                ->get();
            return view("index.mylist", compact('likes', 'keyword'));
        } else {
            $items = Item::keywordSearch($keyword)->get();
            return view("index.best", compact('items', 'keyword'));
        }
        
    }
}
