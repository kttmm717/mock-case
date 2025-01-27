@extends('layouts.default')

@section('content')
    <h1>購入が完了しました！</h1>
    <p>商品が発送されるまでお待ちください。</p>
    <a href="{{ url('/mypage') }}">マイページへ</a>
@endsection
