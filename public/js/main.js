let supplierTable, productTable;

if (!$.fn.DataTable.isDataTable('table#supplier')) {
    supplierTable = initDataTable({
        selector: 'table#supplier',
        ajaxUrl: '/get-suppliers',
        checkboxName: 'supplier_checkbox',
        columns: [
            { data: 'checkbox', name: 'checkbox', orderable: false, searchable: false },
            { data: 'nome', name: 'Nome' },
            { data: 'cnpj', name: 'Cnpj' },
            { data: 'actions', name: 'actions', orderable: false, searchable: false }
        ]
    });
}

if (!$.fn.DataTable.isDataTable('table#products')) {
    productTable = initDataTable({
        selector: 'table#products',
        ajaxUrl: '/product/get-products',
        checkboxName: 'product_checkbox',
        columns: [
            { data: 'checkbox', name: 'checkbox', orderable: false, searchable: false },
            { data: 'nome', name: 'Nome' },
            { data: 'preco', name: 'Preço' },
            { data: 'estoque', name: 'Estoque' },
            { data: 'suppliers', name: 'Fornecedores' },
            { data: 'actions', name: 'actions', orderable: false, searchable: false }
        ]
    });
}

$('form#form-supplier').on('submit', function(e){
    e.preventDefault();

    let form = this;
    let formdata = new FormData(form);
    requestAjax(form, formdata, supplierTable, false);
});

$('form#form-product').on('submit', function(e){
    e.preventDefault();

    let form = this;
    let formdata = new FormData(form);
    requestAjax(form, formdata, productTable, false);
});

$('form#update_product_form').on('submit', function(e){
    e.preventDefault();

    let form = this;
    let formdata = new FormData(form);
    requestAjax(form, formdata, productTable, modalProductForm);
});

$('form#update_suppiler_form').on('submit', function(e){
    e.preventDefault();

    let form = this;
    let formdata = new FormData(form);
    requestAjax(form, formdata, supplierTable, modalsuppilerForm);
});

$(document).on('click','button#deleteSupplierBtn', function(){
    let id = $(this).data('id');

    requestAjaxDelete('Tem certeza?', 'Você deseja deletar este fornecedor', id, '/delete', supplierTable, false)
});

$(document).on('click','button#deleteProductBtn', function(){
    let id = $(this).data('id');

    requestAjaxDelete('Tem certeza?', 'Você deseja deletar este produto', id, '/product/delete', productTable, false)
});

$(document).on('change','input[type="checkbox"][name="product_checkbox"]', function(){
    console.log('product_checkbox');
    if( $('input[type="checkbox"][name="product_checkbox"]').length == $('input[type="checkbox"][name="product_checkbox"]:checked').length ){
        $('input[type="checkbox"][name="main_checkbox"]').prop('checked',true);
    }else{
        $('input[type="checkbox"][name="main_checkbox"]').prop('checked',false);
    }
    toggleBtnState('product_checkbox', 'multipleDeleteProductBtn');
});

$(document).on('click','button#multipleDeleteProductBtn', function(){
    let selectedCheckeds = [];
    $('input[type="checkbox"][name="product_checkbox"]:checked').each(function(){
        selectedCheckeds.push($(this).data('id'));
    });

    if( selectedCheckeds.length > 0 ){
        requestAjaxDelete(
            'Tem certeza?', 
            'Você deseja excluir os ' + selectedCheckeds.length + ' produtos selecionados?', 
            selectedCheckeds, 
            '/product/delete-multiple',
            productTable,
            true
        );
        $('button#multipleDeleteProductBtn').addClass('d-none');
    }
});

$(document).on('change','input[type="checkbox"][name="supplier_checkbox"]', function(){
    console.log('supplier_checkbox');
    if( $('input[type="checkbox"][name="supplier_checkbox"]').length == $('input[type="checkbox"][name="supplier_checkbox"]:checked').length ){
        $('input[type="checkbox"][name="main_checkbox"]').prop('checked',true);
    }else{
        $('input[type="checkbox"][name="main_checkbox"]').prop('checked',false);
    }
    toggleBtnState('supplier_checkbox', 'multipleDeleteProductBtn');
});

$(document).on('click','button#multipleDeleteSupplierBtn', function(){
    let selectedCheckeds = [];
    $('input[type="checkbox"][name="supplier_checkbox"]:checked').each(function(){
        selectedCheckeds.push($(this).data('id'));
    });

    if( selectedCheckeds.length > 0 ){
        requestAjaxDelete(
            'Tem certeza?', 
            'Você deseja excluir os ' + selectedCheckeds.length + ' fornecedores selecionados?', 
            selectedCheckeds, 
            '/delete-multiple',
            supplierTable,
            true
        );
        $('button#multipleDeleteSupplierBtn').addClass('d-none');
    }
});

let modalProductForm = $('#modal-form-product');

$(document).on('click','button#editProductBtn', function(){
    let id = $(this).data('id');
    let url = "/product/get-product";
    modalProductForm.find('form')[0].reset();
    modalProductForm.find('span.error-text').text('');

    $.get(url, {id:id}, function(result){
       modalProductForm.find('input[name="product_id"]').val(result.data.id);
       modalProductForm.find('input[name="nome"]').val(result.data.nome);
       modalProductForm.find('input[name="preco"]').val(result.data.preco);
       modalProductForm.find('textarea[name="descricao"]').val(result.data.descricao);
       modalProductForm.find('input[name="descricao"]').val(result.data.descricao);
       
       modalProductForm.modal('show');
    },'json');
});

let modalsuppilerForm = $('#modal-form-suppiler');

$(document).on('click','button#editSupplierBtn', function(){
    let id = $(this).data('id');
    let url = "/get-supplier";
    modalsuppilerForm.find('form')[0].reset();
    modalsuppilerForm.find('span.error-text').text('');

    $.get(url, {id:id}, function(result){
       modalsuppilerForm.find('input[name="suppiler_id"]').val(result.data.id);
       modalsuppilerForm.find('input[name="nome"]').val(result.data.nome);
       modalsuppilerForm.find('input[name="cnpj"]').val(result.data.cnpj);
       modalsuppilerForm.find('input[name="endereco"]').val(result.data.endereco);
       modalsuppilerForm.find('input[name="numero"]').val(result.data.numero);
       modalsuppilerForm.find('input[name="bairro"]').val(result.data.bairro);
       modalsuppilerForm.find('input[name="cidade"]').val(result.data.cidade);
       
       modalsuppilerForm.modal('show');
    },'json');
});

$(document).on('click', 'input[type="checkbox"][name="main_checkbox"]', function(){
    console.log('main_checkbox');
    
    if($('input[type="checkbox"][name="product_checkbox"]')) {
        if( this.checked ){
            $('input[type="checkbox"][name="product_checkbox"]').each(function(){
                this.checked = true;
            });
        }else{
            $('input[type="checkbox"][name="product_checkbox"]').each(function(){
                this.checked = false;
            });
        }

        toggleBtnState('product_checkbox', 'multipleDeleteProductBtn');
    }
    
    if($('input[type="checkbox"][name="supplier_checkbox"]')) {
        if( this.checked ){
            $('input[type="checkbox"][name="supplier_checkbox"]').each(function(){
                this.checked = true;
            });
        }else{
            $('input[type="checkbox"][name="supplier_checkbox"]').each(function(){
                this.checked = false;
            });
        }

        toggleBtnState('supplier_checkbox', 'multipleDeleteSupplierBtn');
    }
});

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