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
<div class="catalog-page">
    <div class="catalog-page__inner">
        @foreach($items as $item)
        <div class="catalog-page__group">
            <div class="catalog-page__img">
            <img src="{{ strpos($item->image, 'images') !== false ? asset('storage/' . $item->image) : $item->image }}" alt="商品画像">
            </div>
            <div class="catalog-page__name">
                {{$item->item_name}}
            </div>
        </div>
        @endforeach
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const params = new URLSearchParams(window.location.search);
    const page = params.get("page");

    if(page === "sell") {
        document.querySelector(".select-tag__sell").classList.add("selected");
    }
});
</script>

@endsection