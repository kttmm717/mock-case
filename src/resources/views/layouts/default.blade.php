<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{asset('css/sanitize.css')}}">
    <link rel="stylesheet" href="{{asset('css/default.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    @yield('css')
</head>
<body>
    <header class="header">
        <div class="header__inner">
            <img class="header-img" src="{{asset('images/logo.svg')}}" alt="">
            <input class="header__input" type="text" placeholder="なにをお探しですか？">
            <nav class="header-nav">
                <ul class="header-nav-ul">
                    <li class="header-nav-ul__li">
                        <form class="logout__form" action="/logout" method="post">
                            @csrf
                            <button>ログアウト</button>
                        </form>
                    </li>
                    <li class="header-nav-ul__li"><a class="mypage__link" href="/mypage">マイぺージ</a></li>
                    <li class="header-nav-ul__li"><a class="listing__link" href="/sell">出品</a></li>
                </ul>
            </nav>
        </div>
    </header>
    
@yield('content')

</body>
</html>