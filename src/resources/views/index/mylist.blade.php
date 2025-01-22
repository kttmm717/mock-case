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
        <a class="select-tag__best" href="{{'/?page=best'}}">おすすめ</a>
        <a class="select-tag__mylist" href="{{'/?page=mylist'}}">マイリスト</a>
    </div>
</div>
<div class="catalog-page">
    @foreach($likes as $like)
    <div class="catalog-page__group">
        <div class="catalog-page__img">
            <img src="{{$like->item->image}}" alt="商品画像">
        </div>
        <div class="catalog-page__name">
            {{$like->item->item_name}}
        </div>
        @if($like->item->is_sold)
        <p class="sold-label">Sold</p>
        @endif
    </div>
    @endforeach
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    // 現在のURLのクエリパラメータを取得
    const params = new URLSearchParams(window.location.search);
    const page = params.get("page");

    //'selected' クラスを追加
    if(page === "mylist") {
        document.querySelector(".select-tag__mylist").classList.add("selected");
    }
});
</script>

@endsection
