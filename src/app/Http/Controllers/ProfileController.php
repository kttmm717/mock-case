<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\AddressRequest;
use App\Models\Item;

class ProfileController extends Controller
{
    public function mypageView() {
        $user = Auth::user();
        $items = Item::all();
        return view('mypage', compact('user', 'items'));
    }
    public function editProfile() {
        $user = Auth::user();
        return view('edit-profile', compact('user'));
    }
    public function storeProfile(AddressRequest $request) {
        /** @var User $user */
        $user = Auth::user();
        $form = $request->all();
        unset($form['_token']);
        $user->update($form);
        return redirect('/mypage');
    }
}
