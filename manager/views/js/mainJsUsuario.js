init.push(function () {

    resetFormularioUsuario();

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
                        if($("#idRol").val() == "0"){

                            $("#modalRol").modal("hide");

                            $("#modal-alert").removeClass("modal-warning").addClass("modal-success");
                            $("#btn-alert-modal").removeClass("btn-warning").addClass("btn-success");
                            $("#alert-modal-title").html("Exito..!");
                            $("#icon-alert").removeClass("fa-warning").addClass("fa-check-circle")
                            $("#alert-modal-body").html(response.mensaje);

                            $("#modal-alert").modal("show");

                            $("#rol_usuario").append(response.extra);
                            $("#rol_usuario").val(response.contenido).trigger("change");

                        }else{
                            //actualizar
                            
                        }
                    }

                    //console.log(response);

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

            var str = $("#formUsuario").serialize();

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

                        if($("#term").val() == "0"){

                            $("#listadoOk").append(response.contenido);
                            
                        }else{
                            //actualizar
                            $("#tr"+term).html(response.contenido);
                        }

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

});

function cargarDataFormularioUsuario(id){

    $('#term').val(id);
    $('#nombre').val($("#tdnom"+id).text());
    $('#apellidos').val($("#tdape"+id).text());
    $('#dni').val($("#tddni"+id).text());
    $('#telefono').val($("#tdnum"+id).text());
    $('#rol_usuario').val($("#tdrol"+id).text()).trigger("change");
    $('#usuario').val($("#tduser"+id).text());
    $('#password').val("");

}

function resetFormularioUsuario(){
    $('#term').val("0");
    $('#nombre').val("");
    $('#apellidos').val("");
    $('#dni').val("");
    $('#telefono').val("");
    $('#usuario').val("");
    $('#password').val("");
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

                    var str = 'id_usuario='+id;
                    
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

                                $("#tr"+id).remove();
                                
                            }
                        
                            //console.log(response);

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