var contenedor = 'contenidoTablas';
var datosTabla = 'dataPaciente';

init.push(function () {

    $('.alpha').alpha();

    $('.alphanum').alphanum({
            allow:'_-'
    });

    $('.num').numeric();

    $('.btn-registrar').click(function(){

        resetFormulario('formPaciente');

        $('#formPaciente input[name=accion]').val('add');

        $('#myModalLabel').html("Registrar Paciente");
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

    $("#formPaciente").validate({
        submitHandler: function(){

            var str = $("#formPaciente").serialize();

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

        $("#formPaciente").submit();

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
            resetFormulario('formPaciente');
            cargarDataFormulario(term);
            $('#myModalLabel').html("Editar Paciente");
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
                            $('#form-direccion input[name=accion]').val('adddireccion');
                            cargarDataDirecciones('','dataDirecciones','contenidoDirecciones');
                            
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
    
});

function cargarDataFormulario(term,form='',accion=''){

    if(form==""){
        form = '#formPaciente';
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

                                    if(accion=='delete'){
                                        var contenedor = 'contenidoTablas';
                                        var datosTabla = 'dataPaciente';

                                        cargarData('',datosTabla,contenedor);
                                    }else {
                                        cargarDataDirecciones('','dataDirecciones','contenidoDirecciones');
                                    }
                                        
                                });

                            }
                        
                        },
                        error: function(){
                            alert("Error General del Sistema");
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