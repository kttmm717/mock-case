<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>新規登録画面</title>
    <link rel="stylesheet" href="{{asset('css/sanitize.css')}}">
    <link rel="stylesheet" href="{{asset('css/register.css')}}">
</head>
<body>
    <header class="header">
        <div class="header__inner">
            <img class="header-img" src="{{asset('images/logo.svg')}}" alt="">
        </div>
    </header>
    <main>
        <div class="register">
            <div class="register__inner">
                <h2 class="register-title">会員登録</h2>
                <form class="register-form" action="/register" method="post" novalidate>
                    @csrf
                    <div class="register-form__group">
                        <p class="register-form__group--item">ユーザー名</p>
                        <input type="text" name='name'>
                        @error('name')
                        <p class="error">{{$message}}</p>
                        @enderror
                    </div>
                    <div class="register-form__group">
                        <p class="register-form__group--item">メールアドレス</p>
                        <input type="text" name='email'>
                        @error('email')
                        <p class="error">{{$message}}</p>
                        @enderror
                    </div>
                    <div class="register-form__group">
                        <p class="register-form__group--item">パスワード</p>
                        <input type="password" name='password'>
                        @error('password')
                        <p class="error">{{$message}}</p>
                        @enderror
                    </div>
                    <div class="register-form__group">
                        <p class="register-form__group--item">確認用パスワード</p>
                        <input type="password" name='password_confirmation'>
                        @error('password_confirmation')
                        <p class="error">{{$message}}</p>
                        @enderror
                    </div>
                    <div class="register-form__button">
                        <button>登録する</button>
                    </div>
                </form>
                <div class="register-link">
                    <a href="/login">ログインはこちら</a>
                </div>
            </div>
        </div>
    </main>
</body>
</html>