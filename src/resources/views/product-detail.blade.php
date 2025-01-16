@extends('layouts.default')

@section('title')
商品詳細画面
@endsection

@section('css')
<link rel="stylesheet" href="{{asset('css/product-detail.css')}}">
@endsection

@section('content')
<div class="product-detail">
    <aside>
        <div class="aside__image">
            <img src="{{$item->image_url}}" alt="">
        </div>
    </aside>
    <div class="main">
        <h2 class="item__name">{{$item['item_name']}}</h2>
        <p class="brand-name">ブランド名</p>
        <p class="price">&yen;{{number_format($item->price)}} <span class="price__span">(税込)</span></p>
        <div>
            <!-- いいね機能・コメント機能 -->
        </div>
        <form class="purchase-procedure__btn" action="/purchase/?id={{$item->id}}" method="post">
            @csrf
            <button>購入手続きへ</button>
        </form>

        <h3 class="item-information">商品説明</h3>
        <p class="item-description">{{$item->item_description}}</p>

        <h3 class="item-information">商品情報</h3>
        <div class="category">
            <span>カテゴリー</span>
            <span>洋服</span>
            <span>メンズ</span>
        </div>
        <div class="condition">
            <span>商品の状態</span>
            <span>良好</span>
        </div>

        <h3 class="comment">コメント(1)</h3>
        <div class="comment-information">
            <div class="user">
                <p class="user__image"></p>
                <p class="user__name">admin</p>
            </div>
            <p class="comment_content">こちらにコメントが入ります。</p>
            <p class="comment__textarea">商品へのコメント</p>
            <form class="comment-form" action="">
                <textarea name=""></textarea>
                <button class="submit-comment">コメントを送信する</button>
            </form>
        </div>
    </div>
</div>
@endsection