$(window).on('load', function() { // makes sure the whole site is loaded
	hidePreloader();
});

init.push(function () {

    $('.validarTexto').alpha();
    $('.validarTextoNum').alphanum();
    $('.validarNum').numeric();

    $("#rol_usuario").select2({
        placeholder: "Seleccionar un Rol"
    });

    $("#add_rol").click(function(){

        $("#formRol div").removeClass("has-error");
        $("#myModalLabel").html("Registrar Rol Usuario");
        $("#formRol .vacio").val("");
        $("#mostrar_inicio").removeAttr("checked");
        $("#modalRol").modal("show");


    });

    $('#rutUser').Rut({
        on_error: function () {
            $('#rutUser').parent().addClass('has-error');

        },
        on_success: function () {
            $('#rutUser').parent().removeClass('has-error');
        },
        format_on: 'keyup'
    });


    //ROL USUARIO
    $("#formRol").validate({
        submitHandler: function(){

            var str = $("#formRol").serialize();

            $.ajax({
                url: "views/ajax/rolUsuario",
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
                        if($("#termRol").val() == "0"){

                            $("#modalRol").modal("hide");

                            $("#modal-alert").removeClass("modal-warning").addClass("modal-success");
                            $("#btn-alert-modal").removeClass("btn-warning").addClass("btn-success");
                            $("#alert-modal-title").html("Exito..!");
                            $("#icon-alert").removeClass("fa-warning").addClass("fa-check-circle")
                            $("#alert-modal-body").html(response.mensaje);

                            $("#modal-alert").modal("show");

                            $("#rol_usuario").append(response.extra);
                            $("#rol_usuario").val(response.contenido).trigger("change");

                        }
                    }

                    console.log(response);

                },
                error: function(){
                    alert("Error General del Sistema");
                }

            });


            return false;
        },
        errorPlacement: function(){

        }
    });

    $("#guardarRol").click(function(){

        $("#formRol").submit();
    });

    $('#checkbox > input').switcher();

    //USUARIO
    $("#formUsuario").validate({
        submitHandler: function(){

            var str = $("#formUsuario").serialize()+"&accion=guardar";

            console.log(str);

            $.ajax({
                url: "views/ajax/usuario",
                cache: false,
                type: "POST",
                dataType: "json",
                data: str,
                success: function(response){

                    var term = $("#term").val();

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



                        resetFormularioUsuario();
                    }

                    console.log(response);

                },
                error: function(){
                    alert("Error General del Sistema");
                }

            });


            return false;
        },
        errorPlacement: function(){

        }
    });

    $("#guardar").click(function(){

        $("#formUsuario").submit();
    });

    //paginacion de datos
    cargarData('','dataUsuario','contenidoUsuario');

    $('#por_pag').change(function(){
        cargarData('','dataUsuario','contenidoUsuario');
    });

    $('#buscar_term').keyup(function(){
        cargarData('','dataUsuario','contenidoUsuario');
    })

    //al dar click en los paginadores
    $("body").on("click","#pagi li a",function (e){

        e.preventDefault();

        var num = $(this).attr("href");

        if(num != 0){
            cargarData(num,'dataUsuario','contenidoUsuario');
        }

    });

    $("body").on("click","#listadoOk a",function (e){

        e.preventDefault();

        var accion = $(this).attr('data-accion');
        var term = $(this).attr('href');

        if(accion == 'editar'){
            cargarDataFormularioUsuario(term);
        }else{
            eliminarUsuario(term);
        }
    });

});

function cargarDataFormularioUsuario(id){

    var str = 'accion=editar&term='+id;

    $.ajax({
        url: "views/ajax/usuario",
        cache: false,
        type: "POST",
        dataType: "json",
        data: str,
        success: function(response){

            window.location.href = "index.php?action=registrar_usuarios";

        },
        error: function(){
            alert("Error General del Sistema");
        }

    });

}

function resetFormularioUsuario(){
    $('#term').val("0");
    $('#nombre').val("");
    $('#apellidos').val("");
    $('#dni').val("");
    $('#telefono').val("");
    $('#usuario').val("");
    $('#password').val("");
    $('#password').attr("required",true);
}

function eliminarUsuario(id){

    bootbox.dialog({
        message: "Esta seguro de eliminar este registro?",
        title: "Eliminar Usuario",
        buttons: {
            cancel: {
                label: "Cancelar",
                className: "btn-default"
            },
            confirm: {
                label: "Ok",
                className: "btn-primary",
                callback: function() {

                    var str = 'accion=eliminar&term='+id;

                    $.ajax({
                        url: "views/ajax/usuario",
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

                                cargarData('','dataUsuario','contenidoUsuario');

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
