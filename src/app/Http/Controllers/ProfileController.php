<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\AddressRequest;


class ProfileController extends Controller
{
    public function profile() {
        return view('edit-profile');
    }
    public function storeProfile(AddressRequest $request) {
        /** @var User $user */
        $user = Auth::user();
        $form = $request->all();
        unset($form['_token']);
        $user->update($form);
        return redirect('/');
    }
}
