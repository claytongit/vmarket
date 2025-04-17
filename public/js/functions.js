function requestAjax(form, formdata, table, modal) {
    $.ajax({
        url:$(form).attr('action'),
        method:$(form).attr('method'),
        data:formdata,
        processData:false,
        dataType:'json',
        contentType:false,
        beforeSend:function(){
            $(form).find('span.error-text').text('');
        },
        success:function(data){
            if( data.status == 1 ){
                toastr.success(data.message);
                if (modal) {
                    modal.modal('hide');
                }else {
                    $(form)[0].reset();
                }
                table.ajax.reload(null, false);
            }else{
                toastr.error(data.message);
            }
        },
        error:function(data){
            $.each(data.responseJSON.errors, function(prefix, val){
                $(form).find('span.'+prefix+'_error').text(val[0]);
            });
        }
    });
}

function requestAjaxDelete(title, html, ids, url, table, multiple) {
    swal.fire({
        title: title,
        html: html,
        showCancelButton:true,
        showCloseButton:true,
        confirmButtonText:'Sim, Deletar',
        cancelButtonText:'Cancelar',
        confirmButtonColor:'#556ee6',
        cancelButtonColor:'#d33',
        width:300,
        allowOutsideClick:false
    }).then(function(result){
        if( result.value ){
            var data = multiple ? {checked_ids:ids} : {id:ids};
            $.post(url, data, function(result){
                if( result.status == 1 ){
                    table.ajax.reload(null, false);
                    toastr.success(result.message);
                }else{
                    toastr.error(result.message);
                }
            },'json');
        }
    });
}

function initDataTable({ selector, ajaxUrl, columns, checkboxName }) {
    if (!$(selector).length) return;

    return $(selector).DataTable({
        processing: true,
        info: true,
        serverSide: true,
        responsive: true,
        autoWidth: false,
        pageLength: 10,
        aLengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, 'All']],
        ajax: ajaxUrl,
        columns: columns
    }).on('draw', function () {
        $(`input[type="checkbox"][name="${checkboxName}"]`).prop('checked', false);
        $('input[type="checkbox"][name="main_checkbox"]').prop('checked', false);
        $('button#multipleDeleteBtn').text('Delete').addClass('d-none');
    });
}

function toggleBtnState(name_checkbox, name_button){
    let selectedItems = $('input[type="checkbox"][name="' + name_checkbox + '"]:checked').length;

    if( selectedItems > 1 ){
        $('button#' + name_button).text('Delete ('+selectedItems+')').removeClass('d-none');
    }else{
        $('button#' + name_button).addClass('d-none');
    }
}