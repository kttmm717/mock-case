<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function email_is_required() {
        $response = $this->post('/login', [
            'email' => '',
            'password' => '12345678'
        ]);
        $response->assertSessionHasErrors([
            'email' => 'メールアドレスを入力してください'
        ]);
    }

    /** @test */
    public function password_is_required() {
        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => ''
        ]);
        $response->assertSessionHasErrors([
            'password' => 'パスワードを入力してください'
        ]);
    }

    /** @test */
    public function unregistered_user_cannot_login() {
        $response = $this->post('/login', [
            'email' => 'notexist@example.com',
            'password' => '12345678'
        ]);
        $response->assertSessionHasErrors([
            'email' => 'ログイン情報が登録されていません'
        ]);
    }

    /** @test */
    public function login_successds_with_correct_information() {
        User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('12345678') //パスワードハッシュ化
        ]);
        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => '12345678' //正しいパスワード
        ]);
        $this->assertAuthenticated(); //認証されているか確認
        $response->assertRedirect('/mypage/profile');
    }
}
