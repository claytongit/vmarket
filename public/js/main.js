let supplierTable, productTable;

$(document).ready(function(){
    $('#cnpj').mask('00.000.000/0000-00');
    $('#cep').mask('00000-000',{
        onComplete: function(cep) {
            $.getJSON("https://viacep.com.br/ws/"+ cep +"/json/?callback=?", function(data) {
                if (!("erro" in data)) {
                    $("#endereco").val(data.logradouro);
                    $("#bairro").val(data.bairro);
                    $("#cidade").val(data.localidade);
                    $('#numero').focus();
                } else {
                    $("#endereco").val("");
                    $("#bairro").val("");
                    $("#cidade").val("");
                }
            });
        }
    });
});

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
       modalProductForm.find('input[name="estoque"]').val(result.data.estoque);
       
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
       modalsuppilerForm.find('input[name="cep"]').val(result.data.cep);
       modalsuppilerForm.find('input[name="endereco"]').val(result.data.endereco);
       modalsuppilerForm.find('input[name="numero"]').val(result.data.numero);
       modalsuppilerForm.find('input[name="bairro"]').val(result.data.bairro);
       modalsuppilerForm.find('input[name="cidade"]').val(result.data.cidade);
       
       modalsuppilerForm.modal('show');
    },'json');
});

$(document).on('click', 'input[type="checkbox"][name="main_checkbox"]', function(){    
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