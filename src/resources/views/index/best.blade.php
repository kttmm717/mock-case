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
        <a class="select-tag__best" href="{{ '/?page=best' }}">おすすめ</a>
        <a class="select-tag__mylist" href="{{ url('/find?page=mylist&keyword=' . request('keyword')) }}">マイリスト</a>
    </div>
</div>
<div class="catalog-page">
    <div class="catalog-page__inner">
        @foreach($items as $item)
        <div class="catalog-page__group">
            <a href="/item?id={{$item->id}}">
                <div class="catalog-page__img">
                    <img src="{{ strpos($item->image, 'images') !== false ? asset('storage/' . $item->image) : $item->image }}" alt="商品画像">
                </div>
                <div class="catalog-page__name">
                    {{$item->item_name}}
                </div>
            </a>
            @if($item->is_sold)
            <p class="sold-label">Sold</p>
            @endif
        </div>
        @endforeach
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    // 現在のURLのクエリパラメータを取得
    const params = new URLSearchParams(window.location.search);
    const page = params.get("page");

    //'selected' クラスを追加
    if (page === "best") {
        document.querySelector(".select-tag__best").classList.add("selected");
    } 
});
</script>

@endsection
