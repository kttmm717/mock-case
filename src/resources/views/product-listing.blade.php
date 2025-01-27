@extends('layouts.default')

@section('title')
商品出品画面
@endsection

@section('css')
<link rel="stylesheet" href="{{asset('css/product-listing.css')}}">
@endsection

@section('content')
<div class="sell">
    <div class="sell__inner">
        <h2 class="sell__title">商品の出品</h2>
        <form class="sell-form" action="sale" method="post" enctype="multipart/form-data">
            @csrf

            <p class="section-item">商品画像</p>
            @error('image')
            <p class="error">{{$message}}</p>
            @enderror
            <div class="sell__img">
                <div class="sell__img--area">
                    <label for="file-upload">画像を選択する</label>
                    <input type="file" id='file-upload' name='image' accept=".jpeg, .jpg, png">
                </div>
            </div>

            <h3 class="section-title">商品の詳細</h3>

            <p class="section-item">カテゴリー</p>
            @error('categories')
            <p class="error">{{$message}}</p>
            @enderror
            <div class="sell__category">
                @foreach($categories as $category)
                <input
                    type="checkbox"
                    name="categories[]"
                    id="category-{{$category->id}}"
                    value="{{$category->id}}">
                <label for="category-{{$category->id}}" class="category-label">
                    {{$category->content}}
                </label>
                @endforeach
            </div>

            <p class="section-item">商品の状態</p>
            @error('condition_id')
            <p class="error">{{$message}}</p>
            @enderror
            <select class="item-condition__select" name="condition_id">
                <option value="">選択してください</option>
                @foreach($conditions as $condition)
                <option value="{{$condition->id}}" {{old('condition_id') == $condition->id ? 'selected' : ''}}>
                    {{$condition->content}}
                </option>
                @endforeach
            </select>

            <h3 class="section-title">商品名と説明</h3>

            <p class="section-item">商品名</p>
            @error('name')
            <p class="error">{{$message}}</p>
            @enderror
            <input class="item-name__input" type="text" name='name' value="{{old('name')}}">

            <p class="section-item">商品の説明</p>
            @error('content')
            <p class="error">{{$message}}</p>
            @enderror
            <textarea class="item-discription__textarea" name="content">{{old('content')}}</textarea>

            <p class="section-item">販売価格</p>
            @error('price')
            <p class="error">{{$message}}</p>
            @enderror
            <div class="yen-wrapper">
                <span class="yen">￥</span>
                <input class="item-price__input" type="text" name='price' value="{{old('price')}}">
            </div>

            <button class="sell-btn">出品する</button>
        </form>
    </div>
</div>


@endsection