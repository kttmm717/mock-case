<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthenticatedSessionController extends Controller
{
    public function store(Request $request) {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if(Auth::attempt($request->only('email', 'password'))) {
            $request->session()->regenerate();
            $user = Auth::user();

            if($user->is_first_login) {
                $user->update(['is_first_login' => false]);
                return redirect('/mypage/profile');
            }
            return redirect('/');
        } else {
            throw ValidationException::withMessages([
                'email' => ['ログイン情報が登録されていません']
            ]);
        }       
    }
}
