var accion = 'dataTabla';
var contenedor = 'contenidoDatosTabla';

init.push(function () {

    //aqui tu codigo
    $('#tbl').select2();

    $('#tbl').on('change',function(){
        cargarDatosTabla('',accion,contenedor);
    });

    $('#openModalTabla').click(function(){

        resetForm();

        var tbl = $('#tbl').val();

        mostrarInputsTabla(tbl);

    });

    $('#exportarExcel').click(function(){
        var term = $('#tbl').val();
        var url = "views/excel/generarExcel.php?term="+term;
        window.open(url,"_blank");
    });

    $("#formTabla").validate({
        submitHandler: function(){

            var str = $("#formTabla").serialize();

            $.ajax({
                url: "views/ajax/datosTabla",
                cache: false,
                type: "POST",
                dataType: "json",
                data: str,
                success: function(response){

                    if(response.respuesta == false){

                        $("#modal-alert").removeClass("modal-success").addClass("modal-warning");
                        $("#btn-alert-modal").removeClass("btn-success").addClass("btn-warning");
                        $("#alert-modal-title").html("Algo anda mal..!");
                        $("#icon-alert").removeClass("fa-check-circle").addClass("fa-warning")
                        $("#alert-modal-body").html(response.mensaje);

                        $("#modal-alert").modal("show");

                    }else{

                        $("#modal-alert").removeClass("modal-warning").addClass("modal-success");
                        $("#btn-alert-modal").removeClass("btn-warning").addClass("btn-success");
                        $("#alert-modal-title").html("Exito..!");
                        $("#icon-alert").removeClass("fa-warning").addClass("fa-check-circle")
                        $("#alert-modal-body").html(response.mensaje);

                        $('#modalTabla').modal("hide");
                        $("#modal-alert").modal("show");

                        cargarDatosTabla('',accion,contenedor);
                        
                    }

                },
                error: function(){
                    alert("Error General del Sistema");
                }

            });


            return false;
        },
        errorPlacement:function(){

        }
    });

    //guardar tabla
    $('#guardarTabla').click(function(){
        $("#formTabla").submit();
    });


    //paginacion de datos
    cargarDatosTabla('',accion,contenedor);

    $('#por_pag').change(function(){
        cargarDatosTabla('',accion,contenedor);
    });

    $('#buscar_term').keyup(function(){
        cargarDatosTabla('',accion,contenedor);
    })

    //al dar click en los paginadores
    $("body").on("click","#pagi li a",function (e){

        e.preventDefault();

        var num = $(this).attr("href");
    
        if(num != 0){
            cargarDatosTabla(num,accion,contenedor);
        }
    
    });

    $("body").on("click","#listadoOk a",function (e){

        e.preventDefault();

        var accion = $(this).attr('data-accion');
        var term = $(this).attr('href');
        var codigo = $(this).attr('data-cod');

        if(accion == 'editar'){
            cargarDataFormulario(term,codigo);
        }else{
            eliminarTabla(codigo,term);
        }

    });

});

function resetForm(){

    $('#inputs').html('');
    $('#accion').val('add');
    
}

function mostrarInputsTabla(tabla){

    var str = "accion=inputs&tabla="+tabla;

    $.ajax({
        type: "POST",
        cache: false,
        url: "views/ajax/datosTabla",
        dataType: 'json',
        data: str,
        success: function(response) {
            
            $('#inputs').html(response.contenido);
            $('#cidtabla').val(tabla);

            $('#myModalLabel').html("Registrar Datos en Tabla: <strong>"+tabla+"</strong>");
            $('#modalTabla').modal("show");

            $('.alphanum').alphanum();
            $('.numeric').numeric();
            
        
        },
        error: function(){
            alert('Error General del Sistema');
        }
    });
}

function cargarDataFormulario(tabla,codigo){

    var str = 'accion=dataFormulario&tabla='+tabla+'&codigo='+codigo;

    console.log(str);
    $.ajax({
        type: "POST",
        cache: false,
        url: "views/ajax/datosTabla",
        dataType: 'json',
        data: str,
        success: function(response) {
            
            $('#inputs').html(response.contenido);
            $('#cidtabla').val(tabla);
            
            $('#myModalLabel').html("Registrar Datos en Tabla: <strong>"+tabla+"</strong>");
            $('#modalTabla').modal("show");
            
            $('.alphanum').alphanum();
            $('.numeric').numeric();
        
        },
        error: function(){
            alert('Error General del Sistema');
        }
    });

}

//funcion que carga la informacion paginada
function cargarDatosTabla(term,accion,div){

    var queryString = location.search;
    var cadena = queryString.split("=");
    var action = cadena[1];

    var tbl = $('#tbl').val();

    num = 1;

    if(term != ''){
        num = term;
    }

    var str= 'accion='+accion+'&page='+action+'&por_pag='+$('#por_pag').val()+'&buscar='+$('#buscar_term').val()+'&num='+num+'&mantenimiento='+$("#mantenimiento").val()+'&tabla='+tbl;

    $.ajax({
        beforeSend: function(){
            $('#loading').show();
            $('#'+div).empty();
        },
        type: "POST",
        url: "views/datatableajax/datosPaginacion",
        data: str,
        success: function(data) {
            
            $('#loading').hide();
            $('#'+div).html(data);
                
        }
    });

}

function eliminarTabla(id,tbl){

    bootbox.dialog({
        message: "Esta seguro de eliminar este registro?",
        title: "Eliminar Tabla Logica",
        buttons: {
            cancel: {
                label: "Cancelar",
                className: "btn-default"
            },
            confirm: {
                label: "Ok",
                className: "btn-primary",
                callback: function() {

                    var str = 'accion=delete&term='+id+'&tabla='+tbl;

                    $.ajax({
                        url: "views/ajax/datosTabla",
                        cache: false,
                        type: "POST",
                        dataType: "json",
                        data: str,
                        success: function(response){

                            if(response.respuesta == false){

                                $("#modal-alert").removeClass("modal-success").addClass("modal-warning");
                                $("#btn-alert-modal").removeClass("btn-success").addClass("btn-warning");
                                $("#alert-modal-title").html("Algo anda mal..!");
                                $("#icon-alert").removeClass("fa-check-circle").addClass("fa-warning")
                                $("#alert-modal-body").html(response.mensaje);

                                $("#modal-alert").modal("show");

                            }else{

                                $("#modal-alert").removeClass("modal-warning").addClass("modal-success");
                                $("#btn-alert-modal").removeClass("btn-warning").addClass("btn-success");
                                $("#alert-modal-title").html("Exito..!");
                                $("#icon-alert").removeClass("fa-warning").addClass("fa-check-circle")
                                $("#alert-modal-body").html(response.mensaje);

                                $("#modal-alert").modal("show");

                                var contenedor = 'contenidoDatosTabla';
                                var accion = 'dataTabla';

                                cargarDatosTabla('',accion,contenedor);
                                
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