init.push(function () {
    

    $('.validarTexto').alphanum();

    $('#checkbox > input').switcher();

    $('#registrarRol').click(function(){

        resetFormRol();

        $('#myModalLabel').html("Registrar Rol Usuario");
        $('#modalRol').modal("show");

    });

    //$('.select2').select2();

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

                        $('#modalRol').modal("hide");
                        $("#modal-alert").modal("show");

                        
                        cargarData('','dataRol','contenidoRol');
                        
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

                    cargarData('','dataRol','contenidoRol');
                    
                }

            },
            error: function(){
                alert("Error General del Sistema");
            }

        });

    });

    //paginacion de datos
    cargarData('','dataRol','contenidoRol');

    $('#por_pag').change(function(){
        cargarData('','dataRol','contenidoRol');
    });

    $('#buscar_term').keyup(function(){
        cargarData('','dataRol','contenidoRol');
    })

    //al dar click en los paginadores
    $("body").on("click","#pagi li a",function (e){

        e.preventDefault();

        var num = $(this).attr("href");
    
        if(num != 0){
            cargarData(num,'dataRol','contenidoRol');
        }
    
    });

});

function cargarDataFormularioRol(id,checkbox){

    $('#termRol').val(id);
    $('#nombreRol').val($('#tdRol'+id).text());
    $('#oldNombreRol').val($('#tdRol'+id).text());

    $('#myModalLabel').html("Actualizar Rol Usuario");
    
    //var checkbox = $('#tdmostrar'+id).text();

    if($('#mostrar_inicio').is(':checked')){
        $('#checkbox div').removeClass('checked');
        $('#mostrar_inicio').prop("checked",false);
    }
    
    if(checkbox == '1'){

        $('#checkbox div').addClass('checked');
        $('#mostrar_inicio').prop("checked",true);
    }

    $('#modalRol').modal("show");

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

                                cargarData('','dataRol','contenidoRol');
                                
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

    $("#termRol").val('0');
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

