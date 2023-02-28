@extends('layouts.app')
@section('content')
<!DOCTYPE html>
<html lang = "{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset = "utf-8">
        <meta name = "viewport" content = "width = device-width, initial-scale = 1">

        <title>在庫管理システム</title>

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
                font-size: 50px;
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
            <div class = "input-group">
                <h5>検索フォーム</h5>
                <form action = "{{ route( 'products' ) }}" method = "GET">
                    <p>
                        <input type = "text" class = "form-control" name = "product_name" value = "{{request('search')}}" placeholder = "商品名を入力"></p>
                        <select class = "form-select" id = "company_id" name = "company_name">
                            <option selected = "selected" value = "">選択してください</option>
                            @foreach( $companies as $company)
                                <option value = "{{ $company->company_id }}">{{ $company->company_name }}</option>
                            @endforeach
                        </select>
                    <span class = "input-group-btn">
                        <button type = "submit" class = "btn btn-default">検索</button>
                    </span>
                </form>
            </div>

            <div class = "content">
                <div class = "title m-b-md">
                    <h5>商品一覧</h5>
                    @if( session( 'err_msg' ))
                        <p class = "text-danger">
                            {{ session( 'err_msg' )}}
                        </p>
                    @endif
                </div>

                <div class = "links">
                    <table>
                        <tr>
                            <th>ID</th>
                            <th>商品画像</th>
                            <th>商品名</th>
                            <th>価格</th>
                            <th>在庫数</th>
                            <th>メーカー</th>
                            <th>詳細表示</th>
                            <th>削除</th>
                        </tr>
                    <tbody>
                    @foreach ( $products as $product )
                        <tr>
                            <td>{{ $product->product_id }}</td>
                            <td><img src = "{{ Storage::url($product->img_path) }}" width = "50px" alt = ""></td>
                            <td>{{ $product->product_name }}</td>
                            <td>{{ $product->price }}</td>
                            <td>{{ $product->stock }}</td>
                            <td>{{ $product->company->company_name }}</td>
                            <td><a href = "{{ route( 'detail', [ 'id' => $product->product_id ]) }}" class = "btn btn-primary">詳細表示</a></td>
                            <td>
                                <form action = "{{ route( 'delete', [ 'id' => $product->product_id ]) }}" method = "POST" onSubmit = "return checkSubmit('削除しますか？')">
                                    @csrf
                                    @method('delete')
                                    <button type = "submit" class = "btn btn-danger">
                                    削除
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                    </table>
                    <button><a href = "{{ route('create') }}">新規登録</a></button>
                </div>
            </div>
        </div>
    </body>
</html>
@endsection

<script src = "{{ mix('/js/common.js') }}"></script>
