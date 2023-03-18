$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
    }
});

//一覧表示・検索（非同期処理）
$(function() {
    $('.btn-search').on('click', function() {
        //入力された値を取得して変数に格納する
        var keyword = $('#product_name').val();
        $.ajax({
            type : 'GET',
            url : 'posts'+$("#key").val(),
            dataType : 'json',
            data : {
                'id': product_id},
        })
        .done(function(data) {
            console.log(data);
            let html;
            
        })
        //↓フォームの送信に失敗した場合の処理
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