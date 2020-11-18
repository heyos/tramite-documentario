
init.push(function () {
	
	$('#main-navbar-notifications').slimScroll({ height: 250 });
	$('#main-navbar-messages').slimScroll({ height: 250 });
	
    //para generar un slider dentro de un div
	//$('#contenido').slimScroll({ height: 250, alwaysVisible: true, color: '#888',allowPageScroll: true });

    $("#codDescarga").alphanum({
        allow:"-"
    });

});

function cargarData(term,accion,div){

    var queryString = location.search;
    var cadena = queryString.split("=");
    var action = cadena[1];

    num = 1;

    if(term != ''){
        num = term;
    }

    var str= 'accion='+accion+'&page='+action+'&por_pag='+$('#por_pag').val()+'&buscar='+$('#buscar_term').val()+'&num='+num;

    $.ajax({
        beforeSend: function(){
            $('#loading').show();
            $('#'+div).empty();
        },
        type: "POST",
        url: "views/datatableajax/datosPaginacion",
        data: str,
        success: function(data) {
            
            $('#loading').hide();
            $('#'+div).html(data);
                
        }
    });
}

function verSitio(){
    
    var protocol = location.protocol;
    var host = location.host
    var url = protocol+'//'+host+'/punto_venta/';

    window.open(url,"_blank");

}

function enviarEmailFile(){
    
    var codigo = $("#codDescarga").val();
    var accion = $("#codDescarga").attr("data-accion");

    var str = "codigo="+codigo+'&accion='+accion;

    $.ajax({
        beforeSend: function(){
            
            text = '<img src="views/images/loader5.gif"><strong>Enviando email, espere porfavor...</strong>';
            
            $('#loadingSend').html(text);
            $('#loadingSend').show();

            $('#btn-detalle').attr("disabled","disabled");
            
        },
        type: "POST",
        url: "views/ajax/buy",
        dataType: "json",
        data: str,
        success: function(response) {
            
            $('#loadingSend').html(response.mensaje);
            $('#btn-detalle').removeAttr("disabled");

        },
        error: function(){
            alert("error");
        }
    });
    
}
