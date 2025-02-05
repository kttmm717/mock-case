@extends('layouts.default')

@section('title')
商品購入画面
@endsection

@section('css')
<link rel="stylesheet" href="{{asset('css/product-purchase.css')}}">
@endsection

@section('content')
<div id="product-purchase">
    <form class="product-purchase-form" action="{{ route('purchase') }}" method="post">
    @csrf
        <div class="left">
            <div class="item__information">
                <div class="item__information--image">
                <img src="{{ strpos($item->image, 'images') !== false ? asset('storage/' . $item->image) : $item->image }}" alt="商品画像">
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
                        <option class="payment-app__select--option" value="konbini">コンビニ支払い</option>
                        <option class="payment-app__select--option" value="card">カード支払い</option>
                    </select>
                </div>
            </div>
            <div class="shipping-address">
                <div class="shipping-address__text">
                    <p>配送先</p>           
                    <a href="/purchase/address/?id={{$item->id}}" class="shipping-address__link">変更する</a>
                </div>
                <div class="shipping-address__information">
                    <p>〒{{session('purchase_data')['shipping_zipcode'] ?? $user->zipcode}}</p>
                    <p>{{session('purchase_data')['shipping_address'] ?? $user->address}}
                       {{session('purchase_data')['shipping_building'] ?? $user->building}}
                    </p>
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
                        <div v-if="paymentMethod === 'konbini'">コンビニ支払い</div>
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

    function removeFirstOptionOnSelect() {
        const select = document.querySelector(".payment-app__select");
        const firstOption = select.querySelector("option[value='']");

        if (firstOption && select.value === "") {
            firstOption.remove(); 
        }
    }

    function updateSelectedOption() {
        const select = document.querySelector(".payment-app__select");
        const options = select.options;

        for (let option of options) {
            option.textContent = option.textContent.replace(/^✔ /, "");
        }

        if (select.value !== "" && select.selectedIndex >= 0) {
            options[select.selectedIndex].textContent = "✔ " + options[select.selectedIndex].textContent;
        }
    }

    document.querySelector(".payment-app__select").addEventListener("mousedown", removeFirstOptionOnSelect);
    document.querySelector(".payment-app__select").addEventListener("change", updateSelectedOption);

    updateSelectedOption();
</script>

@endsection

