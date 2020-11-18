init.push(function () {
    

    $('.validarTexto').alpha();

    $('.select2').select2();

    $("#formRolView").validate({
        submitHandler: function(){

            var str = $("#formRolView").serialize();

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

                        $("#modal-alert").removeClass("modal-warning").addClass("modal-success");
                        $("#btn-alert-modal").removeClass("btn-warning").addClass("btn-success");
                        $("#alert-modal-title").html("Exito..!");
                        $("#icon-alert").removeClass("fa-warning").addClass("fa-check-circle")
                        $("#alert-modal-body").html(response.mensaje);

                        $("#modal-alert").modal("show");

                        if($("#idRol").val() == "0"){

                            $("#listadoRolOk").append(response.contenidoView);

                        }else{
                            //actualizar
                            var term = $("#idRol").val();
                            $("#trrol"+term).html(response.contenido);
                            
                        }

                        resetFormRol();

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

    $("#guardarRolView").click(function(){
        $("#formRolView").submit();
    });

    //CAMBIAR LA PAGINA DE INICIO
    $('#pageInicio').change(function(){

        var textMenu = $('select[name="pageInicio"] option:selected').text();
        var str = 'termRol='+$("#termRolInicio").val()+'&page='+$(this).val()+'&namePage='+textMenu;

        $.ajax({
            url: "views/ajax/rolUsuario",
            cache: false,
            type: "POST",
            dataType: "json",
            data: str,
            success: function(response){

                if(response.respuesta == true){

                    $("#listadoRolOk").html(response.contenido);
                }

            },
            error: function(){
                alert("Error General del Sistema");
            }

        });

    });

});

function cargarDataFormularioRolView(id){

    $('#idRol').val(id);

    
    $('#nombreRol').val($('#tdrol'+id).text());
    $('#oldNombreRol').val($('#tdrol'+id).text());
   
    var checkbox = $('#tdmostrar'+id).text();

    if($('#mostrar_inicio').is(':checked')){
        $('#checkbox div').removeClass('checked');
        $('#mostrar_inicio').prop("checked",false);
    }
    
    if(checkbox == '1'){

        $('#checkbox div').addClass('checked');
        $('#mostrar_inicio').prop("checked",true);
    }

}

function eliminarRol(id){

    bootbox.dialog({
        message: "Esta seguro de eliminar este registro?",
        title: "Eliminar Rol Usuario",
        buttons: {
            cancel: {
                label: "Cancelar",
                className: "btn-default"
            },
            confirm: {
                label: "Ok",
                className: "btn-primary",
                callback: function() {

                    var str = 'id_rol='+id;
                    
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

                                $("#modal-alert").removeClass("modal-warning").addClass("modal-success");
                                $("#btn-alert-modal").removeClass("btn-warning").addClass("btn-success");
                                $("#alert-modal-title").html("Exito..!");
                                $("#icon-alert").removeClass("fa-warning").addClass("fa-check-circle")
                                $("#alert-modal-body").html(response.mensaje);

                                $("#modal-alert").modal("show");

                                $("#trrol"+id).remove();
                                
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

function resetFormRol(){

    $("#idRol").val('0');
    $('#oldNombreRol').val('old');
    $('#nombreRol').val('');

    if($('#mostrar_inicio').is(':checked')){
        $('#checkbox div').removeClass('checked');
        $('#mostrar_inicio').prop("checked",false);
    }

}

function darPermisosRol(term){

    window.location = "index.php?action=permisos_usuario&term="+term;


}

function elegirInicioPagina(term,inicio,descripcion){

    var str = 'term='+term+'&inicio='+inicio;

    $.ajax({
        url: "views/ajax/rolUsuario",
        cache: false,
        type: "POST",
        dataType: "json",
        data: str,
        success: function(response){

            $("#termRolInicio").val(term);
            $("#rolInicio").val(descripcion);
            $('#pageInicio').html(response.contenido);
            $('#pageInicio').val(inicio).trigger("change");

            $('#modalInicio').modal("show");

        },
        error: function(){
            alert("Error General del Sistema");
        }

    });
  
}