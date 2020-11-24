$(window).on('load', function() { // makes sure the whole site is loaded
	hidePreloader();
});

init.push(function () {



});


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
