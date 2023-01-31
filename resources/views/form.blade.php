@extends('layouts.app')
@section('content')
<div class = "row">
    <div class = "col-md-8 col-md-offset-2">
        <h2>商品新規登録フォーム</h2>
        <form method = "POST" action = "{{ route('store') }}" onSubmit = "return checkSubmit()" id = "regist" enctype = "multipart/form-data">
            @csrf
            <div class = "form-group">
                <input type = "hidden" name = "productId" id = "product_id">
                <p>商品名：<input type = "text" name = "productName" value = "{{ old('productName') }}"></p>
                <p>会社名（メーカー名）:
                    <select class = "form-select" id = "product_id" name = "company_id">
                        <option selected = "selected" value = "">選択してください</option>
                        @foreach( $companies as $company)
                            <option value = "{{ $company->company_id }}">{{ $company->companyName }}</option>
                        @endforeach
                    </select>
                </p>
                <p>価格：<input type = "text" name = "price" id = "price" value = "{{ old('price') }}"></p>
                <p>在庫数：<input type = "text" name = "stock" id = "stock" value = "{{ old('stock') }}">
                <p>コメント：<textarea name = "comment" id = "comment">{{ old('comment') }}</textarea></p>
                <p>商品画像：<input type = "file" multiple name = "imgPath" id = "img_path" value = "{{ old('imgPath') }}"></p>
            </div>
            <div class = "mt-5">
                <button type = "submit" class = "btn btn-primary">
                    登録する
                </button>
                <button type = "button"><a class = "btn btn-secondary" href = "{{ route( 'products' ) }}">
                    戻る
                </a></button>
            </div>
        </form>
    </div>
</div>
@endsection
<script>
function checkSubmit(){
    if(window.confirm('登録してよろしいですか？')){
        $('form').submit(function(){
            $this.attr('action', '/database.products_list');
            alert('登録しました！');
        });
    } else {
        return false;
    }
}
</script>
