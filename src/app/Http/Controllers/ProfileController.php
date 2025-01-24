<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\AddressRequest;
use App\Models\Purchase;
use App\Http\Requests\ProfileRequest;

class ProfileController extends Controller
{
    public function mypageView(Request $request) {
        if(Auth::check()) {
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
        } else {
            return view('auth.login');
        }
    }
    public function editProfile() {
        $user = Auth::user();
        return view('edit-profile', compact('user'));
    }
    public function storeProfile(AddressRequest $addressrequest, ProfileRequest $profilerequest) {
        if($profilerequest->hasFile('profile_image')) {
            $profile_image = $profilerequest->file('profile_image')->store('profile_images', 'public');
        }
        /** @var User $user */
        $user = Auth::user();
        $data = [
            'name' => $addressrequest->name,
            'zipcode' => $addressrequest->zipcode,
            'address' => $addressrequest->address,
            'building' => $addressrequest->building
        ];
        if(isset($profile_image)) {
            $data['profile_image'] = $profile_image;
        }
        $user->update($data);

        return redirect('/mypage');
    }
}
