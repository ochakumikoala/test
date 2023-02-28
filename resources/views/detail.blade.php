@extends('layouts.app')
@section('content')
<!DOCTYPE html>
<html lang = "{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset = "utf-8">
        <meta name = "viewport" content = "width = device-width, initial-scale = 1">

        <title>商品詳細</title>

        <!-- Fonts -->
        <link href = "https://fonts.googleapis.com/css2?family = Nunito:wght@200;600&display = swap" rel = "stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 70px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class = "content">
            <div class = "title m-b-md">
                <h4>商品詳細</h4>
                <p>{{ $product->img_path }}</p>
                <p>商品名：{{ $product->product_name }}</p>
                <p>メーカー（会社名）：{{ $product->company->company_name }}</p>
                <p>価格：{{ $product->price }}円</p>
                <p>在庫数：{{ $product->stock }}</p>
                <p>コメント：{{ $product->comment }}</p>
                <p>登録日：{{ $product->created_at }}</p>
                <p>更新日：{{ $product->update_at }}</p>
                <a href = "{{ route( 'edit', [ 'id' => $product->product_id ]) }}" class = "btn btn-primary">編集する</a>
                <button><a class = "btn btn-secondary" href = "{{ route('products') }}">
                    戻る
                </a></button>
            </div>
        </div>
    </body>
</html>
@endsection