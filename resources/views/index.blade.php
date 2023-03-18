@extends('layouts.app')
@section('content')
    <body>
            <div class = "input-group">
                <h5>検索フォーム</h5>
                <form action = "{{ route( 'products' ) }}" method = "GET">
                    <p><input type = "text" class = "form-control" id = "product_name" name = product_name value = "{{request('search')}}" placeholder = "商品名を入力"></p>
                    <p><select class = "form-select" id = "company_id" name = "company_name"></P>
                        <option selected = "selected" value = "">選択してください</option>
                        @foreach( $companies as $company)
                            <option value = "{{ $company->company_id }}">{{ $company->company_name }}</option>
                        @endforeach
                    </select>
                    <p>価格の上限<input placeholder = "上限値を入力" type = "text" name = "max_price" class = "price" value  = "{{request('price')}}"></p>
                    <p>価格の下限<input placeholder = "下限値を入力" type = "text" name = "min_price" class = "price" value  = "{{request('price')}}"></p>
                    <p>在庫の上限<input placeholder = "上限値を入力" type = "text" name = "max_stock" class = "stock" value  = "{{request('stock')}}"></p>
                    <p>在庫の下限<input placeholder = "下限値を入力" type = "text" name = "min_stock" class = "stock" value  = "{{request('stock')}}"></p>
                    <span class = "input-group-btn">
                        <button type = "submit" class = "btn btn-default" id = "btn btn-search">検索</button>
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
                    <table id = "_table" class = "table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>@sortablelink('product_id', 'ID')<span id = "sort1" sort = ""></span></th>
                                <th>商品画像</th>
                                <th>@sortablelink('product_name', '商品名')<span id = "sort1" sort = ""></th>
                                <th>@sortablelink('price', '価格')<span id = "sort1" sort = ""></th>
                                <th>@sortablelink('stock', '在庫数')<span id = "sort1" sort = ""></th>
                                <th>@sortablelink('company_name', 'メーカー')</th>
                                <th>詳細表示</th>
                                <th>削除</th>
                            </tr>
                        </thead>
                    <tbody id = 'product_list'>
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
@endsection

<!-- <script src = "{{ mix('/js/index.js') }}"></script> -->
<script>
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
    }
});

//一覧表示・検索（非同期処理）
$(function() {
    $('.btn-search').on('click', function() {
        var product_name = $('#product_name').val();
        var company_name = $('#company_name').val();
        var price = $('#max_price').val();
        var price = $('#min_price').val();
        var stock = $('#max_stock').val();
        var stock = $('#min_stock').val();

        $.ajax({
            type : 'GET',
            url : 'posts'+$("#key").val(),
            dataType : 'json',
            data : {
                keyword : product_name,
                select : company_name,
                price : price,
                stock : stock
            }
        })
        .done(function(data) {
            $('.form-control').empty();//前回の検索結果が残っている場合はそれを消す
            data.forEach(function(product_id){
                $('.form-control').append('<th>${product_name}</th>');//form-controlを指定しているからappendの中身は<th>だけでもいける？
                $('.form-select').append('<th>${company->company_name}</th>');
                $('.price').append('<th>${price}</th>');
                $('.stock').append('<th>${stock}</th>');
                // console.log(product_id);
            })
        })
        //フォームの送信に失敗した場合の処理
        .fail(function() {
          alert('error');
        });
    });
});


//削除（非同期処理）
$(function() {
    $('.btn-danger').on('click', function() {
        var deleteConfirm = confirm('削除してよろしいでしょうか？');
        if(deleteConfirm == true) {
            var clickEle = $(this)
            var product_id = clickEle.attr('data-user_id');
            $.ajax({
                type : 'DELETE',
                url : '/destroy/' + product_id,
                dataType : 'json',
                data : {'id': product_id},
            })
        } else {
            (function(e) {
                e.preventDefault()
            });
        };
    });
});
</script>