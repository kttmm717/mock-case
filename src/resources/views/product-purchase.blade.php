@extends('layouts.default')

@section('title')
商品購入画面
@endsection

@section('css')
<link rel="stylesheet" href="{{asset('css/product-purchase.css')}}">
@endsection

@section('content')
<div id="product-purchase">
    <div class="left">
        <div class="item__information">
            <div class="item__information--image">
                <img src="{{asset('storage/' . $item->image)}}" alt="">
            </div>
            <div class="item__information--text">
                <p class="item-name">{{$item->item_name}}</p>
                <p class="item-price">&yen;{{number_format($item->price)}}</p>
            </div>
        </div>
        <div id="payment-app">
            <p class="payment-app__text">支払い方法</p>
            <select class="payment-app__select" v-model="paymentMethod">
                <option value="">選択してください</option>
                <option value="convenience">コンビニ支払い</option>
                <option value="card">カード支払い</option>
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
                <td class="purchase-table__date">
                    <div v-if="paymentMethod === 'convenience'">コンビニ支払い</div>
                    <div v-if="paymentMethod === 'card'">カード支払い</div>
                </td>
            </tr>
        </table>
        <form action="/purchase-procedure/?id={{$item->id}}" method="post">
            @csrf
            <button class="purchase-btn">
                購入する
            </button>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/vue@2.6.14/dist/vue.js"></script>
<script>
    new Vue({
        el: '#product-purchase',
        data: {
            paymentMethod: ''
        },
        watch: {
            paymentMethod(newValue) {
                console.log("選択された支払い方法:", newValue);
            }
        }
    });
</script>

@endsection