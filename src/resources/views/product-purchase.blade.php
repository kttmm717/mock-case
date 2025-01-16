@extends('layouts.default')

@section('title')
商品購入画面
@endsection

@section('css')
<link rel="stylesheet" href="{{asset('css/product-purchase.css')}}">
@endsection

@section('content')
<div class="product-purchase">
    <div class="left">
        <div class="item__information">
            <div class="item__information--image">
                <img src="{{$item->image_url}}" alt="">
            </div>
            <div class="item__information--text">
                <p class="item-name">{{$item->item_name}}</p>
                <p class="item-price">&yen;{{number_format($item->price)}}</p>
            </div>
        </div>
        <div class="payment-method">
            <p class="payment-method__text">支払い方法</p>
            <select class="payment-method__select" name="">
                <option value="">選択してください</option>
                @foreach($payments as $payment)
                <option value="">{{$payment->content}}</option>
                @endforeach
            </select>
        </div>
        <div class="shipping-address">
            <div class="shipping-address__text">
                <p>配送先</p>
                <form action="/purchase/address/?id={{$item->id}}" method="post">
                    @csrf
                    <button class="shipping-address__link">変更する</button>
                </form>
            </div>
            <div class="shipping-address__information">
                <p>〒{{Auth::user()->zipcode}}</p>
                <p>{{Auth::user()->address}}{{Auth::user()->building}}</p>
            </div>
        </div>
    </div>

    <div class="right">
        <table class="purchase-table">
            <tr class="purchase-table__row">
                <th class="purchase-table__header">商品代金</th>
                <td class="purchase-table__date">&yen;{{number_format($item->price)}}</td>
            </tr>
            <tr class="purchase-table__row">
                <th class="purchase-table__header">支払い方法</th>
                <td class="purchase-table__date">コンビニ支払い</td>
            </tr>
        </table>
        <button class="purchase-btn">購入する</button>
    </div>
</div>
@endsection