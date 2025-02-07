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
                    <input type="file" id='file-upload' name='image'accept="image/jpeg, image/png">
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
                <option class="item-condition__select--option" value="{{$condition->id}}" {{old('condition_id') == $condition->id ? 'selected' : ''}}>
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

            <p class="section-item">ブランド名</p>
            <input class="brand-name__input" type="text" name='brand_name' value="{{old('brand_name')}}">

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

<script>
    function adjustLastRowAlignment() {
        const container = document.querySelector(".sell__category");
        const items = Array.from(container.children).filter(el => el.matches("label")); // ラベルのみ取得

        if (items.length === 0) return;

        const existingDummy = container.querySelector(".dummy-space");
        if (existingDummy) {
            existingDummy.remove();
        }

        items.forEach(item => item.style.margin = "10px 5px");

        const containerWidth = container.clientWidth;
        
        let rowItems = [];
        let rowWidth = 0;
        
        for (const item of items) {
            const itemWidth = item.offsetWidth + 10; 
            if (rowWidth + itemWidth > containerWidth) {
                rowItems = [];
                rowWidth = 0;
            }
            rowItems.push(item);
            rowWidth += itemWidth;
        }
        if (rowItems.length > 0) {
            const dummy = document.createElement("div");
            dummy.classList.add("dummy-space");
            dummy.style.flex = "1 1 auto"; 
            dummy.style.visibility = "hidden";
            container.appendChild(dummy);
        }
    }
    window.addEventListener("resize", adjustLastRowAlignment);

    adjustLastRowAlignment();

    function removeFirstOptionOnSelect() {
        const select = document.querySelector(".item-condition__select");
        const firstOption = select.querySelector("option[value='']");

        if (firstOption && select.value === "") {
            firstOption.remove(); 
        }
    }

    function updateSelectedOption() {
        const select = document.querySelector(".item-condition__select");
        const options = select.options;

        for (let option of options) {
            option.textContent = option.textContent.replace(/^✔ /, "");
        }

        if (select.value !== "" && select.selectedIndex >= 0) {
            options[select.selectedIndex].textContent = "✔ " + options[select.selectedIndex].textContent;
        }
    }

    document.querySelector(".item-condition__select").addEventListener("mousedown", removeFirstOptionOnSelect);
    document.querySelector(".item-condition__select").addEventListener("change", updateSelectedOption);

    updateSelectedOption();

</script>


@endsection