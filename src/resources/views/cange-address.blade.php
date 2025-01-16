@extends('layouts.default')

@section('title')
商品購入画面
@endsection

@section('css')
<link rel="stylesheet" href="{{asset('css/cange-address.css')}}">
@endsection

@section('content')
<div class="cange-address">
    <div class="cange-address__inner">
        <h2 class="cange-address__title">住所の変更</h2>
        <form class="cange-address-form" action="/purchase/address/update?id={{$item->id}}" method="post">
            @csrf
            <div class="cange-address-form__group">
                <p>郵便番号</p>
                <input type="text" name='zipcode'>
            </div>
            <div class="cange-address-form__group">
                <p>住所</p>
                <input type="text" name='address'>
            </div>
            <div class="cange-address-form__group">
                <p>建物名</p>
                <input type="text" name='building'>
            </div>
            <button class="cange-address__btn">更新する</button>
        </form>
    </div>
</div>
@endsection