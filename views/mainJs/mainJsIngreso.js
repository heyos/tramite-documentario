$(window).on('load', function() { // makes sure the whole site is loaded
	hidePreloader();
});

init.push(function () {

    $("#signin-form_id").validate({
        focusInvalid: true,
        submitHandler: function(){

            var str = $("#signin-form_id").serialize();

            $.ajax({

                cache: false,
                type: "POST",
                dataType: "json",
                url: "views/ajax/ingreso",
                data: str,
                beforeSend:function(){
                    $("#btn-ingresar").removeClass("btn-primary").addClass("btn-success");
                    $("#btn-ingresar").attr("disabled","disabled");
                    $("#btn-ingresar").text("Cargando...");
                    $(".remove").remove();
                },
                success: function(response){

                    $(".alerta").html("");

                    if(response.respuesta ==  true){
                        window.location = "index.php?action="+response.contenido;
                        $(".alerta").after('<div class="alert alert-success remove"><button type="button" class="close" data-dismiss="alert">×</button><strong>'+response.mensaje+'</div>')
                    }else{
                        $(".alerta").after('<div class="alert alert-danger remove"><button type="button" class="close" data-dismiss="alert">×</button><strong>'+response.mensaje+'</div>')
                    }

                },
                complete:function(){

                    $("#btn-ingresar").removeClass("btn-success").addClass("btn-primary");
                    $("#btn-ingresar").text("Sign In");
                    $("#btn-ingresar").removeAttr("disabled");
                    
                },
                error: function(e){
                    alert("Error General del sistema");
                    console.log(e);

                    $("#btn-ingresar").removeClass("btn-success").addClass("btn-primary");
                    $("#btn-ingresar").text("Sign In");
                    $("#btn-ingresar").removeAttr("disabled");
                    $(".remove").remove();
                }

            });

            return false;
        },
        errorPlacement: function () {

        }
    });

    $("#btn-ingresar").click(function(){

        $("#signin-form_id").submit();

    });

    //action=consulta
    if($('#form-consulta').length > 0){

        $('#form-consulta').submit(function(e){
            e.preventDefault();

            if($('#term').val() == ''){
                notification('Adevertencia..!','Ingrese un codigo valido','warning');

                return;
            }
            
            var str = $(this).serialize();
            str += '&accion=consulta_reporte';

            $.ajax({
                beforeSend:function(){
                    blockPage();
                    $('.default').show();
                    $('#qr').hide().html('');
                    $('.temp').remove();
                    $('#name_tipo_doc').html('TIPO DOCUMENTO');
                    $('#cliente_full').html('-');
                    $('#paciente_full').html('-');
                },
                url: 'ajax/documentos.ajax.php',
                method: "POST",
                cache: false,
                dataType: "json",
                data: str,
                success: function(response){
                    unBlockPage();
                    if(response.respuesta==false){
                      notification('Advertencia..!', response.message,'error');
                    }else{
                        var data = response.data;
                        $('.default').hide();
                        $('#name_tipo_doc').html(data.name_tipo_doc);
                        $('#cliente_full').html(data.cliente_full);
                        $('#paciente_full').html(data.paciente_full);
                        $('#afterFirmantes').after(data.firmantes);
                        $('#afterCreacion').after(data.crea);
                        $('#qr').show().html(data.qr);
                    }
                    console.log(response.data);

                },
                error: function(e){
                    unBlockPage();
                    console.log(e);
                }

            });
            

            return;

        });

    }
    
    //action=ver
    var urlParams = new URLSearchParams(window.location.search);
    //var cadena = queryString.split("=");
    //var action = cadena[1];

    if(urlParams.get('term')){

        console.log(urlParams.get('term'));
        var term = urlParams.get('term');

        visualizar(term);

    }

    //dashboard
    if($('.estado').length > 0){

        $('body').on('click','.estado',function(){
            var estado = $(this).data('estado');

            var str = 'accion=generar&term='+estado;
            
            $.ajax({
                beforeSend:function(){
                    blockPage();
                },
                url: 'ajax/resumen_documento_usuario.ajax.php',
                method: "POST",
                cache: false,
                dataType: "json",
                data: str,
                success: function(response){
                    unBlockPage();

                    if(response.respuesta==false){

                      notification('Advertencia..!', response.message,'error');

                    }else{
                        window.location.href = 'index.php?action=firmar_documentos';
                    }
                    

                },
                error: function(e){
                    unBlockPage();
                    console.log(e);
                }

            });
        });
    }

});

async function visualizar(term){

    var formData = new FormData();
    formData.append('accion','readfile');
    formData.append('term',term);

    var url = 'ajax/documentos.ajax.php';
    const response = await fetch(url,{
                        method: 'post',
                        body: formData,
                    });
    var blob = await response.blob();
    var blobUrl = URL.createObjectURL(blob);

    window.location.href = blobUrl;
    
}
