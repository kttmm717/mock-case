@extends('layouts.default')

@section('title')
商品一覧画面
@endsection

@section('css')
<link rel="stylesheet" href="{{asset('css/mypage.css')}}">
@endsection

@section('content')
<div class="user">
    <div class="user__inner">
        <div class="user__information">
            <img src="{{asset('storage/' . $user->profile_image)}}" alt="プロフィール画像">
            <p>{{$user->name}}</p>
        </div>
        <div class="user__text">
            <a href="/mypage/profile">プロフィールを編集</a>
        </div>
    </div>
</div>
<div class="select-tag">
    <div class="select-tag__inner">
    <a class="select-tag__sell" href="{{'/mypage/?page=sell'}}">出品した商品</a>
    <a class="select-tag__buy" href="{{'/mypage/?page=buy'}}">購入した商品</a>
    </div>
</div>

@endsection