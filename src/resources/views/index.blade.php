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
        <a class="select-tag__best" href="{{url('/?page=best' . (request('keyword') ? '&keyword='.request('keyword') : '')) }}">おすすめ</a>
        <a class="select-tag__mylist" href="{{url('/?page=mylist' . (request('keyword') ? '&keyword='.request('keyword') : '')) }}">マイリスト</a>
    </div>
</div>

@endsection

