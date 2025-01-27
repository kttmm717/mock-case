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

        <a class="purchase-procedure__btn" href="/purchase/?id={{$item->id}}">購入手続きへ</a>

        <h3 class="item-information">商品説明</h3>
        <p class="item-description">{{$item->item_description}}</p>

        <h3 class="item-information">商品情報</h3>
        <div class="category">
            <span>カテゴリー</span>
            @foreach($categories as $category)
            <span class="category-span">{{$category->content}}</span>
            @endforeach
        </div>
        <div class="condition">
            <span>商品の状態</span>
            <span class="condition-span">{{$condition->content}}</span>
        </div>

        <h3 class="comment">コメント({{$item->comments->count()}})</h3>
        <ul class="comment-information">
            @foreach($item->comments as $comment)
            <li>
                <div class="user">
                    <img class="user__image"
                     src="{{asset('storage/' . $comment->user->profile_image)}}" 
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
                @error('content')
                <p class='error'>{{$message}}</p>
                @enderror
                <button class="submit-comment">コメントを送信する</button>
            </form>
        </ul>
    </div>
</div>
@endsection