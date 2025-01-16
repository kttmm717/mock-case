<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログイン画面</title>
    <link rel="stylesheet" href="{{asset('css/sanitize.css')}}">
    <link rel="stylesheet" href="{{asset('css/login.css')}}">
</head>
<body>
    <header class="header">
        <div class="header__inner">
            <img class="header-img" src="{{asset('images/logo.svg')}}" alt="">
        </div>
    </header>
    <main>
        <div class="login">
            <div class="login__inner">
                <h2 class="login-title">ログイン</h2>
                <form class="login-form" action="/login" method="post">
                    @csrf
                    <div class="login-form__group">
                        <p class="login-form__group--item">ユーザー名/メールアドレス</p>
                        <input type="text">
                        @error('email')
                        <p class="error">{{$message}}</p>
                        @enderror
                    </div>
                    <div class="login-form__group">
                        <p class="login-form__group--item">パスワード</p>
                        <input type="password">
                        @error('password')
                        <p class="error">{{$message}}</p>
                        @enderror
                    </div>
                    <div class="login-form__button">
                        <button>ログインする</button>
                    </div>
                </form>
                <div class="register-link">
                    <a href="/register">会員登録はこちら</a>
                </div>
            </div>
        </div>
    </main>
</body>
</html>