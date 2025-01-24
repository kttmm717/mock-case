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
        <form class="edit-profile-form" action="/mypage/profile/update" method="post" enctype="multipart/form-data">
            @csrf
            <div class="edit-profile-form__img">
                <img id="preview" src="{{asset('storage/' . $user->profile_image)}}" alt="">
                <input type="file" id="profile_image" name="profile_image">
                <label for="profile_image" class="edit-profile-form__img--text">画像を選択する</label>
            </div>
            @error('profile_image')
                <p class="error">{{$message}}</p>
            @enderror

            <div class="edit-profile-form__group name">
                <p class="edit-profile-form__group--item">ユーザー名</p>
                <input type="text" name='name' value="{{old('name', auth()->user()->name)}}">
                @error('name')
                <p class="error">{{$message}}</p>
                @enderror
            </div>

            <div class="edit-profile-form__group">
                <p class="edit-profile-form__group--item">郵便番号</p>
                <input type="text" name='zipcode' value="{{old('zipcode', auth()->user()->zipcode)}}">
                @error('zipcode')
                <p class="error">{{$message}}</p>
                @enderror
            </div>

            <div class="edit-profile-form__group">
                <p class="edit-profile-form__group--item">住所</p>
                <input type="text" name='address' value="{{old('address', auth()->user()->address)}}">
                @error('address')
                <p class="error">{{$message}}</p>
                @enderror
            </div>

            <div class="edit-profile-form__group">
                <p class="edit-profile-form__group--item">建物名</p>
                <input type="text" name='building' value="{{old('building', auth()->user()->building)}}">
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

<script>
    document.getElementById('profile_image').addEventListener('change', function(event) {
        const file = event.target.files[0];
        if(file) {
            const reader = new FileReader();

            reader.onload = function(e) {
                const preview = document.getElementById('preview');
                preview.src = e.target.result;
                preview.style.display = 'block';
            };

            reader.readAsDataURL(file);
        }
    });
</script>

@endsection