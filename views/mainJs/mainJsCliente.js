var contenedor = 'contenidoTablas';
var datosTabla = 'dataCliente';

$(window).on('load', function() { // makes sure the whole site is loaded
	hidePreloader();
});

init.push(function () {

    $('.alpha').alpha();

    $('.alphanum').alphanum({
            allow:'_-'
    });

    $('.num').numeric();

    $('.btn-registrar').click(function(){

        resetFormulario('formCliente');

        $('#formCliente input[name=accion]').val('add');

        $('#myModalLabel').html("Registrar Cliente");
        $('#modalTabla').modal("show");

    });

    $('#nRutPer').Rut({
        on_error: function () {
            $('#nRutPer').parent().addClass('has-error');

        },
        on_success: function () {
            $('#nRutPer').parent().removeClass('has-error');
        },
        format_on: 'keyup'
    });

    $("#formCliente").validate({
        submitHandler: function(){

            var str = $("#formCliente").serialize();

            $.ajax({
                cache: false,
                type: "POST",
                dataType:"json",
                url: "views/ajax/persona",
                data: str,
                success: function(response){

                    if(response.respuesta == false){

                        swal('Error..!',response.mensaje,'warning');

                    }else{

                        swal({
                            type: 'success',
                            text: response.mensaje,
                            title: 'Exito..!'
                        },function(){
                            cargarData('',datosTabla,contenedor);
                        });

                        $('#modalTabla').modal("hide");

                    }

                },
                error: function(e){
                    // alert("Error General del sistema");
                    console.log(e);
                }

            });

            return false;
        },
        errorPlacement: function(){

        }
    });

    $("#guardar").click(function(){

        $("#formCliente").submit();

    });

    //paginacion de datos
    cargarData('',datosTabla,contenedor);

    $('#por_pag').change(function(){
        cargarData('',datosTabla,contenedor);
    });

    $('#buscar_term').keyup(function(){
        cargarData('',datosTabla,contenedor);
    });

    //al dar click en los paginadores
    $("body").on("click","#pagi li a",function (e){

        e.preventDefault();

        var num = $(this).attr("href");

        if(num != 0){
            cargarData(num,datosTabla,contenedor);
        }

    });

    $("body").on("click","#listadoOk a",function (e){

        e.preventDefault();

        var accion = $(this).attr('data-accion');
        var term = $(this).attr('href');

        if(accion == 'editar'){
            resetFormulario('formCliente');
            cargarDataFormulario(term);
            $('#myModalLabel').html("Editar Cliente");
            $('#modalTabla').modal("show");
        }else{
            if(accion=='delete'){
                eliminarElemento(term);
            }else{

            	resetFormulario('form-direccion');
                $('#form-direccion input[name=nIdPersona]').val(term);
                $('#form-direccion input[name=accion]').val('adddireccion');
                cargarDataDirecciones('','dataDirecciones','contenidoDirecciones');
                $('#modalTablaDetalle').modal("show");
                $('.nuevoregistro').hide();
            }

        }

    });

    //DIRECCIONES
    $("#form-direccion").validate({
        submitHandler: function(){

            var str = $("#form-direccion").serialize();

            $.ajax({
                beforeSend:function(){
                    $("#form-direccion button[type=submit]").prop('disabled',true);
                    $("#form-direccion button[type=submit]").html('Cargando...');
                },
                cache: false,
                type: "POST",
                dataType:"json",
                url: "views/ajax/persona",
                data: str,
                success: function(response){

                    $("#form-direccion button[type=submit]").prop('disabled',false);
                    $("#form-direccion button[type=submit]").html('Guardar');

                    if(response.respuesta == false){

                        swal('Error..!',response.mensaje,'warning');

                    }else{
                        $('.nuevoregistro').hide();
                        swal({
                            type: 'success',
                            text: response.mensaje,
                            title: 'Exito..!'
                        },function(){
                            resetFormulario('form-direccion');
                            cargarDataDirecciones('','dataDirecciones','contenidoDirecciones');
                            $('#form-direccion input[name=accion]').val('adddireccion');
                        });

                    }

                },
                error: function(e){
                    // alert("Error General del sistema");
                    console.log(e);
                }

            });

            return false;
        },
        errorPlacement: function(){

        }
    });

    $('body').on('click','.listadoOk2 a',function(e){

        e.preventDefault();

        var accion = $(this).attr('data-accion');
        var term = $(this).attr('href');

        if(accion == 'editar'){
            resetFormulario('form-direccion');
            cargarDataFormulario(term,'form-direccion','datosdireccion');
            $('#form-direccion input[name=accion]').val('editdireccion');
            $('.nuevoregistro').show();
        }else{
            if(accion=='delete'){
                eliminarElemento(term,'deletedireccion');
            }else{
                if(accion=='contacto'){
                    var faena = $(this).data('faena');
                    var ref = $('#form-direccion input[name=nIdPersona]').val();

                    $('.text-modal-contacto').text(faena+' - Contactos');
                    resetFormulario('form-contacto');
                    resetFormulario('form-direccion');
                    $('#modalTablaDetalle').modal("hide");
                    $('#modalTablaDetalleContactos').modal("show");
                    $('.nuevoregistro').hide();
                    $('#form-contacto input[name=nIdDireccion]').val(term);
                    $('#form-contacto input[name=nIdPersona_ref]').val(ref);
                    $('#form-contacto input[name=accion]').val('addcontacto');
                    cargarDataContactos('','dataContactos','contenidoContactos');
                }
            }

        }
    });

    $('#direcciones .por_pag').change(function(){
        cargarDataDirecciones('','dataDirecciones','contenidoDirecciones');
    });

    $('#direcciones .buscar_term').keyup(function(){
        cargarDataDirecciones('','dataDirecciones','contenidoDirecciones');
    });

    $("body").on("click","#direcciones #pagi li a",function (e){

        e.preventDefault();

        var num = $(this).attr("href");

        if(num != 0){
            cargarDataDirecciones(num,'dataDirecciones','contenidoDirecciones');
        }

    });

    //CONTACTOS
    $("#form-contacto").validate({
        submitHandler: function(){

            var str = $("#form-contacto").serialize();

            $.ajax({
                beforeSend:function(){
                    $("#form-direccion button[type=submit]").prop('disabled',true);
                    $("#form-direccion button[type=submit]").html('Cargando...');
                },
                cache: false,
                type: "POST",
                dataType:"json",
                url: "views/ajax/persona",
                data: str,
                success: function(response){

                    $("#form-direccion button[type=submit]").prop('disabled',false);
                    $("#form-direccion button[type=submit]").html('Guardar');

                    if(response.respuesta == false){

                        swal('Error..!',response.mensaje,'warning');

                    }else{
                        $('.nuevoregistro').hide();
                        swal({
                            type: 'success',
                            text: response.mensaje,
                            title: 'Exito..!'
                        },function(){
                            resetFormulario('form-contacto');
                            $('#form-contacto input[name=accion]').val('addcontacto');
                            cargarDataContactos('','dataContactos','contenidoContactos');

                        });

                    }

                },
                error: function(e){
                    console.log(e);
                }

            });

            return false;
        },
        errorPlacement: function(){

        }
    });

    $('.close-open').click(function(){
        var open = $(this).data('open');

        cargarDataDirecciones(num,'dataDirecciones','contenidoDirecciones');

        $('#'+open).modal('show');
    });

    $('body').on('click','.listadoOk3 a',function(e){

        e.preventDefault();

        var accion = $(this).attr('data-accion');
        var term = $(this).attr('href');

        if(accion == 'editar'){
            resetFormulario('form-contacto');
            cargarDataFormulario(term,'form-contacto','datosContacto');
            $('#form-contacto input[name=accion]').val('editcontacto');
            $('.nuevoregistro').show();
        }else{
            if(accion=='delete'){
                eliminarElemento(term,'deletecontacto');
            }

        }
    });

    $('#contactos .por_pag').change(function(){
        cargarDataContactos('','dataContactos','contenidoContactos');
    });

    $('#contactos .buscar_term').keyup(function(){
        cargarDataContactos('','dataContactos','contenidoContactos');
    });

    $("body").on("click","#contactos #pagi li a",function (e){

        e.preventDefault();

        var num = $(this).attr("href");

        if(num != 0){
            cargarDataContactos(num,'dataContactos','contenidoContactos');
        }

    });

});

function cargarDataFormulario(term,form='',accion=''){

    if(form==""){
        form = '#formCliente';
        accion = 'datos';
    }else{
        form = '#'+form;
    }

    var str = 'id='+term+'&accion='+accion;

    $.ajax({
        cache: false,
        url: 'views/ajax/persona',
        method: 'POST',
        dataType:'json',
        data: str,
        success: function(response){

            if(response.respuesta == false){
                swal('Error..!',response.mensaje,'warning');
            }else{

                $(form+' #accion').val('edit');
                var datos = response.contenido;
                $.each(datos,function(key,value){

                    $(form+' #'+key).val(value);
                    if($(form+' #'+key).hasClass('select2')){
                        $(form+' #'+key).trigger('change');
                    }
                });

            }
        },
        error: function(e){
            console.log(e);
        }
    });
}

function eliminarElemento(id,accion=""){

    if(accion==""){
        accion='delete';
    }

    bootbox.dialog({
        message: "Esta seguro de eliminar este registro?",
        title: "Eliminar Registro",
        buttons: {
            cancel: {
                label: "Cancelar",
                className: "btn-default"
            },
            confirm: {
                label: "Ok",
                className: "btn-primary",
                callback: function() {

                    var str = 'accion='+accion+'&id='+id;

                    $.ajax({
                        url: "views/ajax/persona",
                        cache: false,
                        type: "POST",
                        dataType: "json",
                        data: str,
                        success: function(response){

                            if(response.respuesta == false){

                                swal('Error..!',response.mensaje,'warning');

                            }else{

                                swal({
                                    title: 'Exito..!',
                                    type: 'success',
                                    text: response.mensaje
                                },function(){

                                    switch (accion) {
                                    	case 'delete':
                                    		var contenedor = 'contenidoTablas';
                                        	var datosTabla = 'dataCliente';

                                        	cargarData('',datosTabla,contenedor);
                                    		break;

                                    	case 'deletedireccion':
                                    		cargarDataDirecciones('','dataDirecciones','contenidoDirecciones');
                                    		break;

                                    	case 'deletecontacto':
                                    		cargarDataContactos('','dataContactos','contenidoContactos');
                                    		break;
                                    }

                                });

                            }

                        },
                        error: function(e){
                            console.log(e);
                        }

                    });

                }
            }

        },
        className: "bootbox-sm"
    });

}

function cargarDataDirecciones(term,accion,div){

    var queryString = location.search;
    var cadena = queryString.split("=");
    var action = cadena[1];

    num = 1;

    if(term != ''){
        num = term;
    }
    var id = $('#form-direccion input[name=nIdPersona]').val();
    var str= 'id='+id+'&tipo=direccion&accion='+accion+'&page='+action+'&por_pag='+$('#direcciones .por_pag').val()+'&buscar='+$('#direcciones .buscar_term').val()+'&num='+num+'&mantenimiento='+$("#direcciones .mantenimiento").val();

    $.ajax({
        beforeSend: function(){
            $('#direcciones .loading').show();
            $('#'+div).empty();
        },
        type: "POST",
        url: "views/datatableajax/datosPaginacion",
        data: str,
        success: function(data) {

            $('#direcciones .loading').hide();
            $('#'+div).html(data);

        }
    });
}

function cargarDataContactos(term,accion,div){

    var queryString = location.search;
    var cadena = queryString.split("=");
    var action = cadena[1];

    num = 1;

    if(term != ''){
        num = term;
    }
    var id = $('#form-contacto input[name=nIdDireccion]').val();
    var str= 'id='+id+'&tipo=contacto&accion='+accion+'&page='+action+'&por_pag='+$('#contactos .por_pag').val()+'&buscar='+$('#contactos .buscar_term').val()+'&num='+num+'&mantenimiento='+$("#contactos .mantenimiento").val();

    $.ajax({
        beforeSend: function(){
            $('#contactos .loading').show();
            $('#'+div).empty();
        },
        type: "POST",
        url: "views/datatableajax/datosPaginacion",
        data: str,
        success: function(data) {

            $('#contactos .loading').hide();
            $('#'+div).html(data);

        },
        error: function(e){
        	console.log(e);
        }
    });
}
