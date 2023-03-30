@extends('layouts.app')
@section('content')
    <body>
            <div class = "input-group">
                <h5>検索フォーム</h5>
                <form action = "{{ route( 'products' ) }}" method = "GET">
                    <p><input type = "text" class = "form-control" id = "product_name" name = product_name value = "{{request('search')}}" placeholder = "商品名を入力"></p>
                    <p><select class = "form-select" id = "company_id" name = "company_name" ></P>
                        <option selected = "selected" value = "">選択してください</option>
                        @foreach( $companies as $company)
                            <option value = "{{ $company->company_id }}">{{ $company->company_name }}</option>
                        @endforeach
                    </select>
                    <p>価格の上限<input placeholder = "上限値を入力" type = "text" name = "max_price" id = "max_price"  class = "price" value  = "{{request('price')}}"></p>
                    <p>価格の下限<input placeholder = "下限値を入力" type = "text" name = "min_price" id = "min_price" class = "price" value  = "{{request('price')}}"></p>
                    <p>在庫の上限<input placeholder = "上限値を入力" type = "text" name = "max_stock" id = "max_stock" class = "stock" value  = "{{request('stock')}}"></p>
                    <p>在庫の下限<input placeholder = "下限値を入力" type = "text" name = "min_stock" id = "min_stock" class = "stock" value  = "{{request('stock')}}"></p>                    <span class = "input-group-btn">
                        <button type = "button" class = "btn btn-default" id = "btn-search">検索</button>
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
                            <tr class = "product_list">
                                <th>@sortablelink('product_id', 'ID')<span id = "sort1" sort = ""></span></th>
                                <th>商品画像</th>
                                <th>@sortablelink('product_name', '商品名')<span id = "sort1" sort = ""></th>
                                <th>@sortablelink('price', '価格')<span id = "sort1" sort = ""></th>
                                <th>@sortablelink('stock', '在庫数')<span id = "sort1" sort = ""></th>
                                <th>@sortablelink('company_id', 'メーカー')</th>
                                <th>詳細表示</th>
                                <th>削除</th>
                            </tr>
                        </thead>
                    <tbody id = 'product_list'>
                    @foreach ( $products as $product )
                        <tr class = 'product_list'>
                            <td>{{ $product->product_id }}</td>
                            <td><img id = "img_path" src = "{{ Storage::url($product->img_path) }}" width = "50px" height = "50px" alt = ""></td>
                            <td>{{ $product->product_name }}</td>
                            <td>{{ $product->price }}</td>
                            <td>{{ $product->stock }}</td>
                            <td id = company_name>{{ $product->company->company_name }}</td>
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

<script>
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
    }
});

//一覧表示・検索（非同期処理）
$(function() {
    $('#btn-search').on('click', function() {
        // console.log('Aaa')
        var product_name = $('#product_name').val();
        var company_id = $('#company_id').val();
        var max_price = $('#max_price').val();
        var min_price = $('#min_price').val();
        var max_stock = $('#max_stock').val();
        var min_stock = $('#min_stock').val();
        $.ajax({
            type : 'POST',
            url : '/product/ajax/search',
            dataType : 'json',
            data : {
                product_name : product_name,
                company_name : company_id,
                max_price : max_price,
                min_price : min_price,
                max_stock : max_stock,
                min_stock : min_stock
            }
        })
        .done(function(data) { //SaleControllerの$productsの検索結果がdataに入っている
            $('#product_list').empty();
            // console.log(data);
            //console.log(data.company_name);
            $('.form-control').val(''); //前回の検索結果が残っている場合はそれを消す
            $('.form-select').val('');
            $('.price').val('');
            $('.stock').val('');

            data.products.forEach(function(product){
                $('.form-control').append(product.product_name);
                $('.form-select').append(product.company_id);
                $('.price').append(product.price);
                $('.stock').append(product.stock);
                $('#img_path').append(product.img_path);
                // console.log(product_id);
            })
            
            //データを表示させる
            $.each(data.products, function(index, val) {
                // console.log(val);
                var product_id = val.product_id;
                var product_name = val.product_name;
                var price = val.price;
                var stock = val.stock;
                var company_name = val.company.company_name;
                // var company_name = val.company_id;
                var img_path = val.img_path;
                var result = '';
                result = `    
                    <tr class = "product_list">
                        <td>${product_id}</td>
                        <td><img id = "img_path" src = ${img_path} }}" width = "50px" height = "50px" alt = ""></td>
                        <td>${product_name}</td>
                        <td>${price}</td>
                        <td>${stock}</td>
                        <td>${company_name}</td>
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
                `

            $('#product_list').append(result);
            });
        })

        //フォームの送信に失敗した場合の処理
        .fail(function(jqXHR, textStatus, errorThrown){
            alert('ファイルの取得に失敗しました。');
            console.log("ajax通信に失敗しました");
            console.log(jqXHR.status);
            console.log(textStatus);
            console.log(errorThrown);
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
@endsection
