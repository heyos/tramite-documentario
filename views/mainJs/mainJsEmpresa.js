$(window).on('load', function() { // makes sure the whole site is loaded
	hidePreloader();
});

init.push(function () {

    $(".validar").alphanum();
    $(".validarNumero").numeric({
        allowMinus   : false,
    });

    $('#file-input').pixelFileInput({ placeholder: 'No selecciono archivo...' });

    $('#file-input').change(function(){

        var imagen = this.files[0];
        var type = imagen.type;

        if(type == "image/jpeg"){

            var datos = new FormData();

            datos.append("imagen",imagen);

            $.ajax({
                url:"views/ajax/empresa",
                method: "POST",
                data: datos,
                dataType: "json",
                cache: false,
                contentType: false,
                processData: false,
                success: function(respuesta){

                    $("#img-empresa").html(respuesta.contenido);
                    $("#imagenName").val(respuesta.imagenName);
                    $("#oldImagenName").val(respuesta.imagenName);

                },
                error: function(){
                    alert("error del sistema");
                }

            });


        }else{
            $.growl.warning({ title: "Un momento..!", message: "Solo se admite formato jpg!" });
        }

    });

    $("#form-empresa").validate({
        submitHandler: function(){

            var str = $("#form-empresa").serialize();

            $.ajax({
                cache: false,
                type: "POST",
                url: "views/ajax/empresa",
                data: str,
                success: function(respuesta){

                    $(".alerta").remove();

                    $("#form-empresa").after(respuesta);

                },
                error: function(){
                    alert("Eror General del sistema");
                }

            });



            return false;
        },
        errorPlacement: function(){

        }
    });

    $("#guardar").click(function(){

        $("#form-empresa").submit();

    });

    //CONFIGURAR EMPRESA

    $("input[name=theme]").click(function(){ //temas

        var id = $(this).val();

        $('.panel-theme input[name=theme]').removeAttr("checked");
        $('.panel-theme').removeClass('panel-success');

        $('.panel-theme input[value='+id+']').prop("checked",true);
        $('#'+id).addClass('panel-success');

    });

    $("input[name=viewMenu]").click(function(){ //temas

        var id = $(this).val();

        $('.panel-menu input[name=viewMenu]').removeAttr("checked");
        $('.panel-menu').removeClass('panel-success');

        $('.panel-menu input[value='+id+']').prop("checked",true);
        $('#'+id).addClass('panel-success');

    });

    $("#formConfi").validate({
        submitHandler: function(){

            var str = $("#formConfi").serialize()+'&accion=config';

            $.ajax({
                cache: false,
                type: "POST",
                url: "views/ajax/opciones",
                data: str,
                dataType:"json",
                success: function(response){

                    if(response.respuesta == false){

                        swal("Error..!",response.mensaje,"error");

                    }else{
                        swal({
                            type:"success",
                            text:response.mensaje,
                            title:"Exito..!"
                        },function(){
                            location.reload();
                        });
                    }



                },
                error: function(){
                    alert("Eror General del sistema");
                }

            });



            return false;
        },
        errorPlacement: function(){

        }
    });

    $("#saveConfig").click(function(){
        $("#formConfi").submit();
    });

});
