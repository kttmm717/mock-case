<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Auth\Events\Verified;
use App\Models\User;

class VerificationController extends Controller
{
    public function verify($id, $hash)
    {
        $user = User::findOrFail($id);

        // ユーザーのハッシュが一致するかチェック
        if (hash_equals((string) $hash, (string) sha1($user->getEmailForVerification()))) {
            // ユーザーのメールアドレスを確認済みに変更
            $user->markEmailAsVerified();

            // メール認証が完了したことを通知
            event(new Verified($user));
        }

        return redirect('/mypage/profile'); // 認証後のリダイレクト先
    }
}
