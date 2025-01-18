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
            <span></span>
            <p>{{$user->name}}</p>
        </div>
        <div class="user__text">
            <a href="/mypage/profile">プロフィールを編集</a>
        </div>
    </div>
</div>
<div class="select-tag">
    <div class="select-tag__inner">
        <p class="select-tag__best">出品した商品</p>
        <p class="select-tag__mylist">購入した商品</p>
    </div>
</div>
<div class="catalog-page">
    @foreach($items as $item)
    <div class="catalog-page__group">
        <div class="catalog-page__img">
            <img src="{{$item->image_url}}" alt="">
        </div>
        <div class="catalog-page__name">
            {{$item->item_name}}
        </div>
    </div>
    @endforeach
</div>
@endsection