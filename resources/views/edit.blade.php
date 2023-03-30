@extends('layouts.app')
@section('content')
<div class = "row">
    <div class = "col-md-8 col-md-offset-2">
        <h2>商品情報編集フォーム</h2>
        <form method = "POST" action = "{{ route( 'update' ) }}" onSubmit = "return checkSubmit('更新してよろしいですか？')" enctype = "multipart/form-data">
            @csrf
            <input type = "hidden" name = "product_id" value = "{{ $product->product_id }}">
            <div class = "form-group">
                <p>商品名：<input type = "text" name = "product_name" value = "{{ $product->product_name }}" ></p>
                <p>会社名（メーカー名）:
                    <select class="form-select" id="product_id" name="company_id">
                        <option selected = "selected" >選択してください</option>
                        @foreach( $companies as $company)
                        <option value = "{{ $company->company_id }}" @if($company->company_name === $product->company->company_name) selected @endif>{{ $company->company_name }}</option>    
                        @endforeach
                    </select>
                </p>
                <p>価格：<input type = "text" name = "price" id = "price" value = "{{ $product->price }}"></p>
                <p>在庫数：<input type = "text" name = "stock" id = "stock" value = "{{ $product->stock }}"></p>
                <p>コメント：<textarea name = "comment" id = "comment" >{{ $product->comment }}</textarea></p>
                <p><label>商品画像：
                <input type = "file" multiple name = "img_path" id = "img_path" value = "{{ $product->img_path }}"></label>
                </p>
            </div>
            <div class = "mt-5">
                <button type = "submit" class = "btn btn-primary">
                    更新する
                </button>
                <button><a class = "btn btn-secondary" href = "{{ route('products') }}">
                    戻る
                </a></button>
            </div>
        </form>
    </div>
</div>

@endsection

