init.push(function () {

    $(".validar").alpha();

    $(".validarTextNum").alphanum();

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


});