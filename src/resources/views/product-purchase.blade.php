@extends('layouts.default')

@section('title')
商品購入画面
@endsection

@section('css')
<link rel="stylesheet" href="{{asset('css/product-purchase.css')}}">
@endsection

@section('content')
<div id="product-purchase">
    <form class="product-purchase-form" action="/purchase-procedure" method="post">
    @csrf
        <div class="left">
            <div class="item__information">
                <div class="item__information--image">
                    <img src="{{$item->image}}" alt="">
                </div>
                <div class="item__information--text">
                    <p class="item-name">{{$item->item_name}}</p>
                    <p class="item-price">&yen;{{number_format($item->price)}}</p>
                </div>
            </div>
            <div id="payment-app">
                <p class="payment-app__text">支払い方法</p>
                @error('paymentMethod')
                <p class="error">{{$message}}</p>
                @enderror
                <div class="select">
                    <select class="payment-app__select" name="paymentMethod" v-model="paymentMethod">
                        <option value="">選択してください</option>
                        <option value="convenience">コンビニ支払い</option>
                        <option value="card">カード支払い</option>
                    </select>
                </div>
            </div>
            <div class="shipping-address">
                <div class="shipping-address__text">
                    <p>配送先</p>           
                    <a href="/purchase/address/?id={{$item->id}}" class="shipping-address__link">変更する</a>
                </div>
                <!-- エラー機能-->
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
            <input type="hidden" name='item_id' value="{{$item->id}}">
            <input type="hidden" name="_method" value="POST">
            <button type="submit" class="purchase-btn" >購入する</button>                        
        </div>
    </form>
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