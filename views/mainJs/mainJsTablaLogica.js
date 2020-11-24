$(window).on('load', function() { // makes sure the whole site is loaded
	hidePreloader();
});

var contenedor = 'contenidoTablas';
var datosTabla = 'dataTablaLogica';

init.push(function () {

    $('.alphanum').alphanum({
        allow:'_'
    });


    $('.checkbox_val > input').switcher();

    $('.label-head label').addClass('text-primary');

    $('#registrarTabla').click(function(){

        resetForm();

        var inputs = generarInputs();

        $('#inputs').append(inputs);

        $('.label-head label').addClass('text-primary');
        $('.checkbox_val > input').switcher();

        $('.alphanum').alphanum({
            allow:'_'
        });

        $('#myModalLabel').html("Registrar Tabla Logica");
        $('#modalTabla').modal("show");

    });

    $("#formTabla").validate({
        submitHandler: function(){

            var str = $("#formTabla").serialize();

            console.log(str);

            $.ajax({
                url: "views/ajax/tablaLogica",
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

                        cargarData('',datosTabla,contenedor);

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
    cargarData('',datosTabla,contenedor);

    $('#por_pag').change(function(){
        cargarData('',datosTabla,contenedor);
    });

    $('#buscar_term').keyup(function(){
        cargarData('',datosTabla,contenedor);
    })

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
            cargarDataFormulario(term);
        }else{
            eliminarTabla(term);
        }

    });

});

function generarInputs(){

    var inputs = "";
    var tab= {1:'TAB_DESC',2:'TAB_ID',3:'TAB_X1',4:'TAB_X2',5:'TAB_N1',6:'TAB_N2'};
    var etiquetas = {1:'',2:'ID Tabla',3:'Campo Caracter 1',4:'Campo Caracter 2',5:'Campo Numerico 1',6:'Campo Numerico 2'};
    var tipoInput = {1:'string',2:'string',3:'string',4:'string',5:'numerico',6:'numerico'};
    var display = '';

    for (var i = 1; i < 7; i++) {

        if(tab[i] == 'TAB_DESC'){
            display = 'style="display:none"';
        }

        var selectedString = 'selected';
        var selectedNumerico = '';

        if(tipoInput[i]=='numerico'){
            selectedString = '';
            selectedNumerico = 'selected';
        }

        inputs += '<div id="divInput_'+i+'" '+display+'>'+
                      '<div class="form-group label-head">'+
                            '<input type="hidden" id="xidelem_'+i+'" name="xidelem['+tab[i]+']" value="'+tab[i]+'" class="form-control" required>'+
                            '<input type="hidden" id="labelForm_'+i+'" name="labelForm['+tab[i]+']" value="'+etiquetas[i]+'" class="form-control">'+
                            '<label class="col-sm-2 col-xs-12 control-label">'+etiquetas[i]+'</label>'+
                            '<div class="col-sm-6 text-center">'+
                                '<div class="row">'+
                                    '<div class="col-xs-12 col-sm-7">'+
                                        '<input type="text" id="xvalor1_'+i+'" name="xvalor1['+tab[i]+']" class="form-control alphanum" >'+
                                    '</div>'+
                                    '<div class="col-xs-12 col-sm-5">'+
                                        '<input type="text" id="xvalor2_'+i+'" name="xvalor2['+tab[i]+']" class="form-control alphanum" >'+
                                    '</div>'+
                                '</div>'+
                            '</div>'+
                            '<div class="col-sm-2" style="display:none">'+
                                '<select id="validar_'+i+'" name="validar['+tab[i]+']"  class="form-control">'+
                                    '<option value="string" '+selectedString+'>String</option>'+
                                    '<option value="numerico" '+selectedNumerico+'>Numerico</option>'+
                                '</select>'+
                            '</div>'+
                            '<div class="col-sm-2 checkbox_val text-center">'+
                                '<input type="checkbox" id="mostrar_'+i+'" name="mostrar['+tab[i]+']" value="1" class="switcher" data-class="switcher-success">'+
                            '</div>'+
                        '</div>'+
                    '</div>';

        display = '';
    }

    return inputs;

}

function resetForm(){

    $('#inputs').html('');
    $('#estado').val('0');
    $('#cidtabla').val('');
    $('#old_cidtabla').val('');

}

function cargarDataFormulario(tabla){

    var str = 'tipoRegistro=rows&tabla='+tabla;

    $.ajax({
        url: "views/ajax/tablaLogica",
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

                resetForm();

                $('#estado').val('1');

                $('#cidtabla').val(tabla);
                $('#old_cidtabla').val(tabla);
                $('#inputs').append(response.contenido);

                $('.checkbox_val > input').switcher();
                $('.label-head label').addClass('text-primary');

                $('#myModalLabel').html("Editar Tabla Logica");
                $('#modalTabla').modal("show");


            }

        },
        error: function(){
            alert("Error General del Sistema");
        }

    });

}

function eliminarTabla(id){

    bootbox.dialog({
        message: "Esta seguro de eliminar este registro? Se eliminara la tabla y todos sus registros",
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

                    var str = 'tipoRegistro=delete&term='+id;

                    $.ajax({
                        url: "views/ajax/tablaLogica",
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

                                var contenedor = 'contenidoTablas';
                                var datosTabla = 'dataTablaLogica';

                                cargarData('',datosTabla,contenedor);

                            }

                        console.log(response);

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
