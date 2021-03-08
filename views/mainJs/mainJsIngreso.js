$(window).on('load', function() { // makes sure the whole site is loaded
	hidePreloader();
});

init.push(function () {

    $("#signin-form_id").validate({
        focusInvalid: true,
        submitHandler: function(){

            var str = $("#signin-form_id").serialize();
console.log(str);
            $.ajax({

                cache: false,
                type: "POST",
                dataType: "json",
                url: "views/ajax/ingreso",
                data: str,
                beforeSend:function(){
                    $("#btn-ingresar").removeClass("btn-primary").addClass("btn-success");
                    $("#btn-ingresar").attr("disabled","disabled");
                    $("#btn-ingresar").text("Cargando...");
                    $(".remove").remove();
                },
                success: function(response){

                    $(".alerta").html("");

                    if(response.respuesta ==  true){
                        window.location = "index.php?action="+response.contenido;
                        $(".alerta").after('<div class="alert alert-success remove"><button type="button" class="close" data-dismiss="alert">×</button><strong>'+response.mensaje+'</div>')
                    }else{
                        $(".alerta").after('<div class="alert alert-danger remove"><button type="button" class="close" data-dismiss="alert">×</button><strong>'+response.mensaje+'</div>')
                    }

                },
                complete:function(){

                    $("#btn-ingresar").removeClass("btn-success").addClass("btn-primary");
                    $("#btn-ingresar").text("Sign In");
                    $("#btn-ingresar").removeAttr("disabled");
                    
                },
                error: function(e){
                    alert("Error General del sistema");
                    console.log(e);

                    $("#btn-ingresar").removeClass("btn-success").addClass("btn-primary");
                    $("#btn-ingresar").text("Sign In");
                    $("#btn-ingresar").removeAttr("disabled");
                    $(".remove").remove();
                }

            });

            return false;
        },
        errorPlacement: function () {

        }
    });

    $("#btn-ingresar").click(function(){

        $("#signin-form_id").submit();

    });



});
