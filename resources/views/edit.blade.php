@extends('layouts.app')
@section('content')
<div class = "row">
    <div class = "col-md-8 col-md-offset-2">
        <h2>商品情報編集フォーム</h2>
        <form method = "POST" action = "{{ route( 'update' ) }}" onSubmit = "return checkSubmit('更新してよろしいですか？')" enctype = "multipart/form-data">
            @csrf
            <input type = "hidden" name = "id" value = "{{ $product->id }}">
            <div class = "form-group">
                <p>商品名：<input type = "text" name = "productName" value = "{{ $product->productName }}" ></p>
                <p>会社名（メーカー名）:
                    <select class="form-select" id="product_id" name="company_id">
                        <option selected="selected" value="">選択してください</option>
                        @foreach( $companies as $company)
                            <option value="{{ $company->company_id }}" @if($company->companyName === $product->companyName) selected @endif>{{ $company->companyName }}</option>
                        @endforeach
                    </select>
                </p>
                <p>価格：<input type = "text" name = "price" id = "price" value = "{{ $product->price }}"></p>
                <p>在庫数：<input type = "text" name = "stock" id = "stock" value = "{{ $product->stock }}">
                <p>コメント：<textarea name = "comment" id = "comment" value = "{{ $product->comment }}"></textarea></p>
                <p>商品画像：<input type = "file" multiple name = "imgPath" id = "img_path" value = "{{ $product->imgPath }}"></p>
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

<script src = "{{ mix('js/common.js') }}"></script>
