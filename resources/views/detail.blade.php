@extends('layouts.app')
@section('content')
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