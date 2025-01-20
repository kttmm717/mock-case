@extends('layouts.default')

@section('title')
商品一覧画面
@endsection

@section('css')
<link rel="stylesheet" href="{{asset('css/index.css')}}">
@endsection

@section('content')
<div class="select-tag">
    <div class="select-tag__inner">
        <p class="select-tag__best">おすすめ</p>
        <p class="select-tag__mylist">マイリスト</p>
    </div>
</div>
<div class="catalog-page">
    @foreach($items as $item)
    <div class="catalog-page__group">
        <div class="catalog-page__img">
            <img src="{{$item->image}}" alt="商品画像">
        </div>
        <div class="catalog-page__name">
            {{$item->item_name}}
        </div>
    </div>
    @endforeach
</div>
@endsection
