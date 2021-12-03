var res_regex = /\[AJAX_RES_START\](.+?)\[AJAX_RES_END\]/;

function showConfirm(title,content,type,cb){
    if(type == 1){
        bootbox.dialog({
                    message: content,
                    title: title,
                    buttons: {
                      success: {
                        label: "確定",
                        className: "green",
                        callback : cb
                      }
                    }
                });
    }

    if(type == 2){
        bootbox.dialog({
            message: content,
            title: title,
            buttons: {
                success: {
                label: "確定",
                className: "green",
                callback: cb
                },
                danger: {
                label: "取消",
                className: "red"
                }
            }
        });
    }
}

function showAddDialog(title,res){
    showConfirm(title,res,2,function(){
        var form = $('#add-form');
        var formData = new FormData($('#add-form')[0]);

        $.ajax({
            url: form.data('act'),
            type: 'post',
            headers: {
                'X-AJAX-METHOD': '1'
            },
            cache: false,
            processData: false,
            contentType: false,
            data: formData,
            success: function (e) {
                    var json = null;
                if (typeof e == 'string' && e.length > 0) {
                    var matchs = e.match(res_regex);
                    if (matchs == null || matchs.length < 2) {
                        showConfirm('系統訊息', '系統錯誤',1);
                        console.log(e);
                        return;
                    }
                    try {
                        json = JSON.parse(matchs[1]);
                    } catch (e) {
                        showConfirm('系統訊息', '資料轉換錯誤', 1);
                        
                        return;
                    }
                } else {
                    showConfirm('系統訊息', '系統錯誤', 1);
                    console.log(e);
                    return;
                }

                if (json.error <= 0) {
                    showConfirm('系統訊息', json.message, 1 , function(){
                        location.reload();
                    });
                    return;
                }

                if (json.error > 0) {
                    var url = null;
                    if(json.back_url != null){
                        url = json.back_url;
                    }else{
                        url = actUrl;
                    }
                    showConfirm('系統訊息', json.message, 1,function(){
                        dialogLoadPage(url,title,'add');
                    });
                    return;
                }
            }
        });
    });
}

function showEditDialog(title){
    var form = $('#form_sample_3');
    var formData = new FormData($('#form_sample_3')[0]);

    $.ajax({
        url: form.data('act'),
        type: 'post',
        headers: {
            'X-AJAX-METHOD': '1'
        },
        cache: false,
        processData: false,
        contentType: false,
        data: formData,
        success: function (e) {
                var json = null;
            if (typeof e == 'string' && e.length > 0) {
                var matchs = e.match(res_regex);
                console.log(e);
                if (matchs == null || matchs.length < 2) {
                    showConfirm('系統訊息', '系統錯誤',1);
                    console.log('error');
                    return;
                }
                try {
                    json = JSON.parse(matchs[1]);
                } catch (e) {
                    showConfirm('系統訊息', '資料轉換錯誤', 1);
                    
                    return;
                }
            } else {
                showConfirm('系統訊息', '系統錯誤', 1);
                console.log('error');
                return;
            }

            if (json.error <= 0) {
                showConfirm('系統訊息', json.message, 1 , function(){
                    if(json.back_url != null){
                        location.href = json.back_url;
                    }else{
                        location.reload();
                    }
                });
                return;
            }

            if (json.error > 0) {
                showConfirm('系統訊息', json.message, 1,function(){
                });
                return;
            }
        }
    });
}

function dialogLoadPage(actUrl, title, type) {
    if(type == 'add'){
        $('#dialog-content').load(actUrl,function(res){
            $(this).html('');
            showAddDialog(title,res);
        });
    }
    if(type == 'edit'){
            showEditDialog(title);
    }
}

$(function(){
    $('#btn-delete').on('click', function(){
        return confirm("確認是否要刪除資料？");
    });
});
