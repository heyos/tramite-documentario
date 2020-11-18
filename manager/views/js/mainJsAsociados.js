var n = 0;

init.push(function () {

    $("#menuSelect").select2();
    
    $('#add-js').click(function(){

        n = n + 1;

        var str = "accion=dataFileSelect";
        
        $.ajax({
            url: "views/ajax/fileJs",
            cache: false,
            type: "POST",
            dataType: "json",
            data: str,
            success: function(response){

                $("#divJs").append('<div id="rowJs'+n+'" class="row"><div class="col-sm-7"><div class="form-group no-margin-hr">'+response.contenido+'</div></div><div class="col-sm-1"><button type="button" onclick="quitarJsAsociado('+n+')" class="btn btn-default">X</button></div></div>');

                $("#rowJs"+n+" .select2").select2();
                $("#rowJs"+n+" .select2").attr("required","required");
                

            },
            error: function(){
                alert("Error General del Sistema");
            }

        });

        
                
    });

    var textMenu = $('select[name="menuSelect"] option:selected').text();
    var typeMenu = $('select[name="menuSelect"] option:selected').attr("data-type");
    $("#textMenu").text(textMenu);

    var term = $("#menuSelect").val();
    infoFileJsMenu(term,typeMenu);

    $("#menuSelect").change(function(){
        var textMenu = $('select[name="menuSelect"] option:selected').text();
        $("#textMenu").text(textMenu);

        var typeMenu = $('select[name="menuSelect"] option:selected').attr("data-type");
        var term = $("#menuSelect").val();
        infoFileJsMenu(term,typeMenu);

        
    });

    $('#formFileJs').validate({
        submitHandler: function(){

            var typeMenu = $('select[name="menuSelect"] option:selected').attr("data-type");
            var str = $('#formFileJs').serialize()+"&accion=add&typeMenu="+typeMenu;

            console.log(str);

            $.ajax({
                url: "views/ajax/menuJsAsociado",
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

                        $("#divJs").empty();

                        $("#trFileEmpty").remove();
                        $("#listadoJsOk").append(response.contenido);
                    
                    }

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

    $('#guardarMenuJs').click(function(){

        var files = $("#divJs .row").length;

        if(files == 0){

            $("#modal-alert").removeClass("modal-success").addClass("modal-warning");
            $("#btn-alert-modal").removeClass("btn-success").addClass("btn-warning");
            $("#alert-modal-title").html("Algo anda mal..!");
            $("#icon-alert").removeClass("fa-check-circle").addClass("fa-warning")
            $("#alert-modal-body").html("Debe agregar almenos un registro.");

            $("#modal-alert").modal("show");

        }else{
            $('#formFileJs').submit();
        }
        
    });

    $('body').on('click','#listadoJsOk a', function(e){

        e.preventDefault();

        var term = $(this).attr("href");
        var accion = $(this).attr("data-accion");

        if(accion == "edit"){

            var fileName = $("#tdFile"+term).text();

            $("#termFile").val(term);
            $("#actualizarFileJs").val(fileName);
            $("#oldFileJs").val(fileName);

            $("#modalFile").modal("show");


        }else{
            eliminarFileJs(term);
        }

        
    });

    //actualizar
    $('#formActualizarFile').validate({
        submitHandler: function(){

            var str = $('#formActualizarFile').serialize()+"&accion=update";

            $.ajax({
                url: "views/ajax/menuJsAsociado",
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

                        var term = $("#menuSelect").val();
                        infoFileJsMenu(term);

                        $("#modalFile").modal("hide");
                    
                    }

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

    $("#btn-actualizarFile").click(function(){
        $('#formActualizarFile').submit();
    });


});

function quitarJsAsociado(n){

    $("#rowJs"+n).remove();
}

function infoFileJsMenu(term,type){

    var str = "accion=data&term="+term+"&typeMenu="+type;

    $.ajax({
        url: "views/ajax/menuJsAsociado",
        cache: false,
        type: "POST",
        dataType: "json",
        data: str,
        success: function(response){

            $("#listadoJsOk").html(response.contenido);
                
        },
        error: function(){
            alert("Error General del Sistema");
        }

    });
}

function eliminarFileJs(term){

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

                    var str = 'accion=delete&term='+term;
                    
                    $.ajax({
                        url: "views/ajax/menuJsAsociado",
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

                                //$("#trFile"+term).remove();
                                var termSelect = $("#menuSelect").val()
                                infoFileJsMenu(termSelect);
                                
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