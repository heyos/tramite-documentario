init.push(function () {
    

    $('.validarTextoBus').alphanum({
        allow :"."
    });

    $('#open-modalFile').click(function(){

        resetFormFile();

        $('#accion').val("add");
        $('#titleModal').html("Registrar File JS");
        $('#modalFile').modal("show");

    });

    $("#formFile").validate({
        submitHandler: function(){

            var str = $("#formFile").serialize();

            $.ajax({
                url: "views/ajax/fileJs",
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

                        $('#modalFile').modal("hide");
                        $("#modal-alert").modal("show");

                        
                        cargarData('','dataFile','contenidoFile');
                        
                        resetFormFile();

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

    $("#btn-saveFile").click(function(){
        $("#formFile").submit();
    });

    //editar - eliminar
    $("body").on("click","#listadoFileOk a",function(e){

        e.preventDefault();

        var term = $(this).attr("href");
        var accion = $(this).attr("data-accion");

        if(accion == "edit"){

            $("#termFile").val(term);
            $("#accion").val(accion);
            $("#fileJs").val($("#tdFile"+term).text());
            $("#oldFileJs").val($("#tdFile"+term).text());

            $('#titleModal').html("Actualizar File JS");
            $('#modalFile').modal("show");

        }else{
            eliminarFile(term);
        }

    });


    //paginacion de datos
    cargarData('','dataFile','contenidoFile');

    $('#por_pag').change(function(){
        cargarData('','dataFile','contenidoFile');
    });

    $('#buscar_term').keyup(function(){
        cargarData('','dataFile','contenidoFile');
    })

    //al dar click en los paginadores
    $("body").on("click","#pagi li a",function (e){

        e.preventDefault();

        var num = $(this).attr("href");
    
        if(num != 0){
            cargarData(num,'dataFile','contenidoFile');
        }
    
    });

});

function cargarDataFormularioRol(id){

    $('#termRol').val(id);
    $('#nombreRol').val($('#tdRol'+id).text());
    $('#oldNombreRol').val($('#tdRol'+id).text());

    $('#myModalLabel').html("Actualizar Rol Usuario");
    
    $('#modalRol').modal("show");

}

function eliminarFile(id){

    bootbox.dialog({
        message: "Esta seguro de eliminar este registro?",
        title: "Eliminar File JS",
        buttons: {
            cancel: {
                label: "Cancelar",
                className: "btn-default"
            },
            confirm: {
                label: "Ok",
                className: "btn-primary",
                callback: function() {

                    var str = 'accion=delete&termFile='+id;
                    
                    $.ajax({
                        url: "views/ajax/fileJs",
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

                                cargarData('','dataFile','contenidoFile');
                                
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

function resetFormFile(){

    $("#termFile").val('0');
    $('#fileJs').val('');
    $('#oldFileJs').val('old.js');

}


