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
            <img src="{{$item->image}}" alt="">
        </div>
    </aside>
    <div class="main">
        <h2 class="item__name">{{$item['item_name']}}</h2>
        <p class="brand-name">ブランド名</p>
        <p class="price">&yen;{{number_format($item->price)}} <span class="price__span">(税込)</span></p>
        
        <div class="icon">
            <div class="like">
            @if($item->likes->where('user_id', auth()->id())->count())
            <!-- いいね済みの場合 -->
                <form class="like-form" action="/posts/{{$item->id}}/like" method="post">
                    @csrf
                    @method('delete')
                    <button type="submit">
                        <i class="fas fa-star"></i>
                    </button>
                </form>
            @else
            <!-- いいねしていない場合 -->
                <form class="like-form" action="/posts/{{$item->id}}/like" method="post">
                    @csrf
                    <button type="submit">
                        <i class="far fa-star"></i>
                    </button>
                </form>
            @endif
            <!-- いいね数表示 -->
            <span class="like-span">{{$item->likes->count()}}</span>
            </div>

            <!-- コメントアイコン -->
            <div class="comment-icon">
                <i class="far fa-comment"></i>
                <span>{{$item->comments->count()}}</span>
            </div>
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

        <h3 class="comment">コメント({{$item->comments->count()}})</h3>
        <ul class="comment-information">
            @foreach($item->comments as $comment)
            <li>
                <div class="user">
                    <img class="user__image"
                     src="{{$comment->user->profile_image}}" 
                     alt="{{$comment->user->name}}">
                    <p class="user__name">{{$comment->user->name}}</p>
                </div>
                <p class="comment__content">{{$comment->content}}</p>
                
            </li>
            @endforeach
            <form class="comment-form" action="/items/{{$item->id}}/comments" method="post">
                @csrf
                <p class="comment__textarea">商品へのコメント</p>
                <textarea class="comment-form__textarea" name="content"></textarea>
                <button class="submit-comment">コメントを送信する</button>
            </form>
        </ul>
    </div>
</div>
@endsection