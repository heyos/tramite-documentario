var n = 0;

init.push(function () {

    $('.validarUrl').alphanum({
        allow: '_'
    });

    $('.urlMenu').alphanum({
        allow: '_,#'
    });



    $('.validarTextoMenu').alphanum();

    $('.validarTextoIcono').alpha({
        allow: '-'
    });
    
    $('.info button').popover();

    $(".add button").tooltip();

    $('.checkbox > input').switcher();

    $('#formMenu .checkbox div').addClass('checked');
    $('#visibleMenu').prop("checked",true);

    $('#actualizarNombreSubMenu').keyup(function(){
        
        var value = $(this).val().replace(/ /g,"_").toLowerCase();

        $('#actualizarUrlSubMenu').val(value);


    });

    $('#add-submenu').click(function(){

        n = n + 1;

        $("#divSubMenu").append('<div id="row'+n+'" class="row"><div class="col-sm-5"><div class="form-group no-margin-hr"><input data-input="input'+n+'" name="nombreSub[]" placeholder="Nombre SubMenu" class="form-control valsub validarTextoMenu"></div></div><div class="col-sm-6"><div class="form-group no-margin-hr"><input id="input'+n+'" name="urlSub[]" placeholder="nombre_submenu" class="form-control validarUrl" readonly="readonly"></div></div><div class="col-sm-1"><button type="button" onclick="quitarMenuLevel('+n+')" class="btn btn-default">X</button></div></div>');

        $('.validarUrl').alphanum({
            allow: '_'
        });

        $('.validarTextoMenu').alphanum();

        $('#divSubMenu .validarTextoMenu').attr("required","required");
        $('#divSubMenu .validarUrl').attr("required","required");

        $('.valsub').keyup(function(){
            var input = $(this).attr('data-input');
            var value = $(this).val().replace(/ /g,"_");

            $('#'+input).val(value);

        });
        
    });


    $("#formMenu").validate({
        submitHandler: function(){

            var str = $("#formMenu").serialize();

            $.ajax({
                url: "views/ajax/menu",
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

                        $("#divEstructuraMenu").append(response.contenido);
                        
                        //reset form  
                        $("#formMenu")[0].reset();
                        $("#divSubMenu").empty();

                        $('#formMenu .checkbox div').addClass('checked');
                        $('#visibleMenu').prop("checked",true);

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

    $("#guardarMenu").click(function(){
        $("#formMenu").submit();
    });

    //actualizar Menu
    $("#formActualizarMenu").validate({
        submitHandler: function(){

            var str = $("#formActualizarMenu").serialize();

            console.log(str);

            $.ajax({
                url: "views/ajax/menu",
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

                        $('#modalMenu').modal("hide");

                        var termMenu = $("#termMenu").val();
                        var accion = $('#accionMenu').val();

                        var nameUbiAccion = $('#nameUbiAccion').val(); //nos indica en que ventana ejecutaremos el registro

                        if(nameUbiAccion == 'registrar_menu'){
                            //registrar_menu
                            if(accion == "eliminarMenu"){
                                $("#div"+termMenu).remove();
                            }else{
                                $("#div"+termMenu).html(response.contenido);

                            }

                        }else{
                            //menu_dinamico
                            if(accion == "eliminarMenu"){
                                $('#li'+termMenu).remove();
                            }else if(accion=="actualizarMenu"){
                                
                                if($('#actualizarUrlMenu').val() !='#'){
                                    $('#li'+termMenu).removeClass('mm-dropdown');
                                }else{
                                    $('#li'+termMenu).addClass('mm-dropdown');
                                }

                                $('#li'+termMenu).html(response.contenidoDin);

                            }else{
                                //addMenu
                                $('#afterAdd').after(response.contenido);
                            }

                        }

                            
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

    $(".button-accion").click(function(){
        var accion = $(this).attr("data-accion");

        $('#accionMenu').val(accion);

        $("#formActualizarMenu").submit();
        
    });

    //add-update sub menu
    $("#formActualizarSubMenu").validate({
        submitHandler: function(){

            var str = $("#formActualizarSubMenu").serialize();

            $.ajax({
                url: "views/ajax/menu",
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

                        $('#modalSubMenu').modal("hide");
                        $("#modal-alert").modal("show");

                        var termMenu = $("#termMenu_sub").val();
                        var termSub = $("#termSubMenu").val()
                        var accion = $('#accionSub').val();

                        var nameUbiAccion = $('#nameUbiAccion').val(); //nos indica en que ventana ejecutaremos el registro

                        if(nameUbiAccion == "registrar_menu"){
                            //registrar_menu
                            if(accion == "eliminarSubMenu"){
                                $("#divSub"+termSub).remove();
                            }else{
                                
                                if(accion == "add"){
                                    $("#stat_sub"+termMenu+" .after").before(response.contenido);
                                }else{
                                    $("#divSub"+termSub).html(response.contenido);
                                }

                            }

                        }else{
                            //menu_dinamico
                            if(accion == "eliminarSubMenu"){
                                $("#liSub"+termSub).remove();
                            }else{
                                
                                if(accion == "add"){

                                    $("#after"+termMenu).before(response.contenidoDin);
                                    
                                }else{
                                    //actualizar
                                    $("#liSub"+termSub).html(response.contenidoDin);
                                    
                                }

                            }
                        }

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

    $(".button-accion-sub").click(function(){
        var accion = $(this).attr("data-accion");

        if(accion!=""){
            $('#accionSub').val(accion);
        }

        $("#formActualizarSubMenu").submit();
        
    });

    
    

});

function quitarMenuLevel(n){

    $("#row"+n).remove();
}

function actualizarDatosMenu(termMenu){ //funcion para obtener los datos para actualizar del menu

    var str = "menu="+termMenu;

    $.ajax({
        url: "views/ajax/menu",
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

                var datos = response.contenido;
                
                var tieneSubMenu = datos["tieneSubMenu"];

                $("#termMenu").val(termMenu);
                $("#actualizarNombreMenu").val(datos["nombreMenu"]);
                $("#actualizarIcono").val(datos["icono"]);
                $("#actualizarUrlMenu").val(datos["url"]);
                $("#tieneSubMenu").val(datos["tieneSubMenu"]);

                if(tieneSubMenu == true){
                    $('#alert-info').show();
                }else{
                    $('#alert-info').hide();
                }

                if(datos["visible"] == '1'){
                    $('#formActualizarMenu .checkbox div').addClass('checked');
                    $('#actualizarVisibleMenu').prop("checked",true);
                }else{
                    $('#formActualizarMenu .checkbox div').removeClass('checked');
                    $('#actualizarVisibleMenu').prop("checked",false);
                }

                $("#eliminarMenu").show();
                $("#actualizarMenu").show();
                $("#addMenu").hide();

                $('#modal-title-menu').text("Actualizar Menu");
                
                $('#modalMenu').modal("show");

            }

        },
        error: function(){
            alert("Error General del Sistema");
        }

    });

}

function agregarMenu(){ //abre el modal para registrar un nuevo menu

    $('#alert-info').hide();

    $("#eliminarMenu").hide();
    $("#actualizarMenu").hide();
    $("#addMenu").show();

    $('#termMenu').val('0');
    $('#tieneSubMenu').val('0');
    $('#actualizarNombreMenu').val('');
    $('#actualizarIcono').val('');
    $('#actualizarUrlMenu').val('');

    $('#modal-title-menu').text("Agregar Menu");

    $('#formActualizarMenu .checkbox div').addClass('checked');
    $('#actualizarVisibleMenu').prop("checked",true);

    $('#modalMenu').modal("show");


}

function agregarSubMenu(termMenu,termSubMenu,accion){

    $('#titleModalSubMenu').html('Agregar Sub Menu');

    $('#cancelarSubMenu').show();
    $('#eliminarSubMenu').hide();

    $("#termMenu_sub").val(termMenu);
    $("#termSubMenu").val("0");
    $("#accionSub").val(accion);

    $("#actualizarNombreSubMenu").val("");
    $("#actualizarUrlSubMenu").val("");

    if (accion == 'update') {

        $('#titleModalSubMenu').html('Actualizar Sub Menu');
        $('#cancelarSubMenu').hide();
        $('#eliminarSubMenu').show();
    
        $("#termSubMenu").val(termSubMenu);
        
        var str = "subMenu="+termSubMenu;

        //obtenemos sus datos
        $.ajax({
            url: "views/ajax/menu",
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

                    var datos = response.contenido;
                    
                    $("#actualizarNombreSubMenu").val(datos["nombreSub"]);
                    $("#actualizarUrlSubMenu").val(datos["url"]);
                    
                }

            },
            error: function(){
                alert("Error General del Sistema");
            }

        });

    }

    $('#modalSubMenu div').removeClass("has-error");

    $('#modalSubMenu').modal("show");
    

}

function clickPermiso(idMenu,accion,value,idSub,rol){

    var str = "idMenu="+idMenu+"&accion="+accion+"&value="+value+"&idSub="+idSub+"&rol="+rol;

    console.log(str);

    $.ajax({
        cache: false,
        type: 'POST',
        dataType:'json',
        url: 'views/ajax/menu',
        data: str + '&id='+Math.random(),
        success: function(respuesta){

            if(respuesta.respuesta ==  true){
                
                switch(accion){
                    case "acceso":

                        $('#padre_'+idMenu).html(respuesta.contenido);

                        if(value == 0 && accion=="acceso"){

                            $(".clicksub_si"+idMenu).removeClass("btn-primary").addClass("btn-default");
                            $(".clicksub_no"+idMenu).removeClass("btn-default").addClass("btn-primary");
                        }

                        break;

                    case "mantenimiento":
                        $('#mantenimiento_'+idMenu).html(respuesta.contenido);
                        break;

                    case "accesoSub":

                        $('#hijo_'+idSub).html(respuesta.contenido);

                        break;

                    default:
                        break;
                }
            }

            console.log(respuesta);
            
            
        },
        error: function(){
            //swal('Advertencia','Error General del Sistema.','error');
            alert("Error General del Sistema");
        }

    });

}

