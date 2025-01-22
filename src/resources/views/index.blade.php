@extends('layouts.default')

@section('title')
商品一覧画面
@endsection

@section('css')
<link rel="stylesheet" href="{{asset('css/index.css')}}">
@endsection

@section('content')
<div class="select-tag">
    <div class="select-tag__inner">
        <a class="select-tag__best" href="{{'/?page=best'}}">おすすめ</a>
        <a class="select-tag__mylist" href="{{'/?page=mylist'}}">マイリスト</a>
    </div>
</div>

@endsection
