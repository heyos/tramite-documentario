
init.push(function () {
	
	$('#main-navbar-notifications').slimScroll({ height: 250 });
	$('#main-navbar-messages').slimScroll({ height: 250 });
	

	//para generar un slider dentro de un div
	//$('#contenido').slimScroll({ height: 250, alwaysVisible: true, color: '#888',allowPageScroll: true });

	


	//grafica
	//var str = 'accion=grafica';
	//accionData('phpAjaxVentas.php','grafica',str);

	//detalle venta
/*	
	$('#detalle-diario').on('click',function (e){

		e.preventDefault();

		var accion = $(this).attr('data-accion');
		var str = 'accion='+accion;
		var url = 'phpAjaxVentas.php';

		accionData(url,accion,str)

	});

*/
   

    $('.calendar').datepicker({
        format: 'dd-mm-yyyy',
        todayHighlight: true,
        autoclose: true
    });

    $('.select2').select2();

    $('.nuevoregistro').click(function(){

        var form = $(this).data('form');
        var accion = $(this).data('accion');
        resetFormulario(form);

        $('.nuevoregistro').hide();
        $('#'+form+ ' input[name=accion]').val(accion);

    });

});

//funcion que carga la informacion paginada
function cargarData(term,accion,div){

    var queryString = location.search;
    var cadena = queryString.split("=");
    var action = cadena[1];

    num = 1;

    if(term != ''){
        num = term;
    }

    var str= 'accion='+accion+'&page='+action+'&por_pag='+$('#por_pag').val()+'&buscar='+$('#buscar_term').val()+'&num='+num+'&mantenimiento='+$("#mantenimiento").val();

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

function resetFormulario(form){

    $('#'+form+' input[type=text]').val('');
    $('#'+form+' input[type=email]').val('');
    $('#'+form+' select').val('');
    $('#'+form+' .select2').val(null).trigger('change');

    $('#'+form+' div').removeClass('has-error');

    
}

