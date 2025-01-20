<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\AddressRequest;
use App\Models\Purchase;

class ProfileController extends Controller
{
    public function mypageView(Request $request) {
        $page = $request->query('page');
        $user = auth()->user();

        if($page === 'sell') {
            $items = $user->sales;
            return view('mypage.sell', compact('items', 'user'));
        } elseif($page === 'buy') {
            /** @var \Illminate\Database\Eloquent\Collection|Purchase[] $purchases */
            $purchases = $user->purchases()->with('item')->get();           
            return view('mypage.buy', compact('purchases', 'user'));
        } else {
            return view('mypage', compact('user'));
        }
    }
    public function editProfile() {
        $user = Auth::user();
        return view('edit-profile', compact('user'));
    }
    public function storeProfile(AddressRequest $request) {
        if($request->hasFile('profile_image')) {
            $profile_image = $request->file('profile_image')->store('profile_images', 'public');
        }
        /** @var User $user */
        $user = Auth::user();
        $user->update([
            'profile_image' => $profile_image,
            'name' => $request->name,
            'zipcode' => $request->zipcode,
            'address' => $request->address,
            'building' => $request->building
        ]);
        return redirect('/mypage');
    }
}
