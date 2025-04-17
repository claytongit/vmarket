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
    
    requestAjax(form, formdata, supplierTable);
});

$('form#form-product').on('submit', function(e){
    e.preventDefault();

    let form = this;
    let formdata = new FormData(form);
    
    requestAjax(form, formdata, productTable);
});

function requestAjax(form, formdata) {
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
                $(form)[0].reset();
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