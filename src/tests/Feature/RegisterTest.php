<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;


class RegisterTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function name_is_required() {
        $response = $this->post('/register',[
            'name' => '',
            'email' => 'test@example.com',
            'password' => '123456789',
            'password_confirmation' => '123456789'
        ]);
        $response->assertSessionHasErrors([
            'name' => 'お名前を入力してください'
        ]);
    }

    /** @test */
    public function email_is_required() {
        $response = $this->post('/register',[
            'name' => 'テスト 太郎',
            'email' => '',
            'password' => '123456789',
            'password_confirmation' => '123456789'
        ]);
        $response->assertSessionHasErrors([
            'email' => 'メールアドレスを入力してください'
        ]);
    }

    /** @test */
    public function password_is_required() {
        $response = $this->post('/register',[
            'name' => 'テスト 太郎',
            'email' => 'test@example.com',
            'password' => '',
            'password_confirmation' => ''
        ]);
        $response->assertSessionHasErrors([
            'password' => 'パスワードを入力してください'
        ]);
    }

    /** @test */
    public function password_must_be_at_least_8_characters() {
        $response = $this->post('/register', [
            'name' => 'テスト 太郎',
            'email' => 'test@example.com',
            'password' => '12345',
            'password_confirmation' => '12345'
        ]);
        $response->assertSessionHasErrors([
            'password' => 'パスワードは8文字以上で入力してください'
        ]);
    }

    /** @test */
    public  function password_confirmation_must_match() {
        $response = $this->post('/register', [
            'name' => 'テスト 太郎',
            'email' => 'test@example.com',
            'password' => '12345678',
            'password_confirmation' => '00000000'
        ]);
        $response->assertSessionHasErrors([
            'password' => 'パスワードと一致しません'
        ]);
    }

    /** @test */
    public function user_can_register_and_redirect_to_login() {
        $response = $this->post('/register', [
            'name' => 'テスト 太郎',
            'email' => 'test@example.com',
            'password' => '12345678',
            'password_confirmation' => '12345678'
        ]);
        $this->assertDatabaseHas('users', [
            'name' => 'テスト 太郎',
            'email' => 'test@example.com',
        ]);
        $response->assertRedirect('login');
    }

}
