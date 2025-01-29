@extends('layouts.default')

@section('content')
    <h1>決済がキャンセルされました。</h1>
    <p>もう一度購入を試す場合は、商品ページに戻ってください。</p>
    <a href="{{ url('/') }}">ホームへ戻る</a>
@endsection
