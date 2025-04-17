$('form#form-supplier').on('submit', function(e){
    e.preventDefault();

    let form = this;
    let formdata = new FormData(form);
    requestAjax(form, formdata)

    console.log("Formulario do supplier!");
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
            console.log(data);
        },
        error:function(data){
            $.each(data.responseJSON.errors, function(prefix, val){
                $(form).find('span.'+prefix+'_error').text(val[0]);
            });
        }
    });
}