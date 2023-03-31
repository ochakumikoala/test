function checkSubmit(msg){
    // if(window.confirm(msg)){
    //
    // } else {
    //     return false;
    // }

    if(!window.confirm(msg)){
        return false;
    }else {
        var clickEle = $(this)
        var product_id = clickEle.attr('data-user_id');
        $.ajax({
        type : 'DELETE',
        url : '/destroy/' + product_id,
        dataType : 'json',
        data : {'id': product_id},
        })
    }
}

function search(product_name = '', company_id = '') {
    const params = {
        product_name: product_name,
        company_id: company_id,
    };

    const query_params = new URLSearchParams(params);
    $.ajax('/api/list?' + query_params)
        .then(function (data) {
            console.log(data);
            const table = document.getElementById('product_list');
            table.replaceChildren();
            $.each(JSON.parse(data), function(index, element){
                const csrfToken = document.querySelector('meta[name="csrf-token"]').content
                const insertURL = `<tr><td>${element.product_id}</td><td><img src="${element.img_path}" width="50px" alt=""></td><td>${element.product_name}</td><td>${element.price}</td><td>${element.stock}</td><td>${element.company.company_name ?? ''}</td><td><a href="${element.detail}" class="btn btn-primary">詳細表示</a></td><td><form action="${element.delete}" method="POST" onSubmit="return checkSubmit('削除しますか？')"><input type="hidden" name="_token" value="${csrfToken}" /><button type="submit" class="btn btn-danger">削除</button></form></td></tr>`;
                table.insertAdjacentHTML('beforeend', insertURL);
            });
        })
        .catch(function (error) {
            console.log('error');
            console.log(error);
        });
}

window.addEventListener('load', function () {
    search();
    });