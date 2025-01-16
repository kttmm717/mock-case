@extends('layouts.default')

@section('title')
プロフィール編集画面
@endsection

@section('css')
<link rel="stylesheet" href="{{asset('css/edit-profile.css')}}">
@endsection

@section('content')
<div class="edit-profile">
    <div class="edit-profile__inner">
        <h2 class="edit-profile-title">プロフィール設定</h2>
        <form class="edit-profile-form" action="/mypage/profile/update" method="post">
            @csrf
            <div class="edit-profile-form__img">
                <div class="img"></div>
                <p class="edit-profile-form__img--text">画像を選択する</p>
            </div>
            <div class="edit-profile-form__group">
                <p class="edit-profile-form__group--item">ユーザー名</p>
                <input type="text" name='name'>
                @error('name')
                <p class="error">{{$message}}</p>
                @enderror
            </div>
            <div class="edit-profile-form__group">
                <p class="edit-profile-form__group--item">郵便番号</p>
                <input type="text" name='zipcode'>
                @error('zipcode')
                <p class="error">{{$message}}</p>
                @enderror
            </div>
            <div class="edit-profile-form__group">
                <p class="edit-profile-form__group--item">住所</p>
                <input type="text" name='address'>
                @error('address')
                <p class="error">{{$message}}</p>
                @enderror
            </div>
            <div class="edit-profile-form__group">
                <p class="edit-profile-form__group--item">建物名</p>
                <input type="text" name='building'>
                @error('building')
                <p class="error">{{$message}}</p>
                @enderror
            </div>
            <div class="edit-profile-form__button">
                <button>更新する</button>
            </div>
        </form>
    </div>
</div>
@endsection