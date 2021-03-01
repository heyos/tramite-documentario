

init.push(function () {

	$('#main-navbar-notifications').slimScroll({ height: 250 });
	$('#main-navbar-messages').slimScroll({ height: 250 });
	$('.slimScroll').slimScroll({ height: 250 });

	$('.alpha').alpha();
	$('.alphanum').alphanum();
	$('.numeric').numeric();

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

function resetFormularioNew(form){

    $(form+' input[type=text]').val('');
    $(form+' input[type=email]').val('');
    $(form+' select').val('');
    $(form+' .select2').val(null).trigger('change');

    $(form+' div').removeClass('has-error');

}

function preloader(){
    $('#status').fadeIn();
    $('#preloader').fadeIn('slow')
}

function hidePreloader(){
    $('#status').fadeOut(); // will first fade out the loading animation
    $('#preloader').fadeOut('slow')
}

function blockPage(){
    // $.blockUI({
    //     message: '<div class="semibold"><span class="ft-refresh-cw icon-spin text-left"></span>&nbsp; Cargando ...</div>',
    //     overlayCSS: {
    //         backgroundColor: '#808080',
    //         opacity: 0.8,
    //         cursor: 'wait'
		//
    //     },
    //     css: {
    //         border: 0,
    //         padding: 0,
		// 		},
		// 		baseZ: 2000
    // });

		$.blockUI({
        message: '<div class="semibold">&nbsp; Cargando ...</div>',
        css: {
					border: 'none',
					padding: '15px',
					backgroundColor: '#000',
					'-webkit-border-radius': '10px',
					'-moz-border-radius': '10px',
					opacity: .5,
					color: '#fff'
				},
				baseZ: 2000
    });

}

function unBlockPage(){
    $.unblockUI();
}

function notification(title,message,type){

    switch(type){
        case 'success':
            $.growl.notice({ title: title, message: message, size: 'large' });
            break;
        case 'error':
            $.growl.error({ title: title, message: message, size: 'large' });
            break;

        case 'warning':
            $.growl.warning({ title: title, message: message, size: 'large' });
            break;

        default:
            $.growl({ title: title, message: message, size: 'large' });
            break;
    }

}

function cargarDataModal(url,type,str,modal,form,callback=null){

    if(type == ''){
        type = 'POST';
    }

    $.ajax({
        beforeSend:function(){
            blockPage();
        },
        url: url,
        cache: false,
        type: type,
        dataType: "json",
        data: str,
        success: function(response){

            unBlockPage();

            if(response.respuesta == true){

                var data = response.data;

                $.each(data,function(e){

                    if($(form+ ' input[type=checkbox][name="'+e+'"]').length > 0){

                        if(data[e] == '1'){
                            $(form+' div.switcher').addClass('checked');
                            $(form+' #'+e).prop('checked',true);
                        }else{
                            $(form+' div.switcher').removeClass('checked');
                            $(form+' #'+e).prop('checked',false);
                        }

                    }else{
                        $(form+' #'+e).val(data[e]);
                    }
                });

				console.log(response)

                if(modal != ''){
                    $(modal).modal('show');
                }

                if(callback){
                    callback(true,data);
                }
                

            }else{
                notification('Error..!', response.message,'error');

                if(callback){
                    callback(false,{});
                }
            }

        },
        error: function(e){
            unBlockPage();
            // msgErrorsForm(e);
			console.log(e);
            if(callback){
                callback(false,e.status);
            }
        }

    });

}

function deleteRow(url,table,params,type){

    var str = params != '' ? params : 'params=';
		var $type = type != '' ? type : 'DELETE';

    bootbox.dialog({
        message: "Esta seguro de eliminar este registro?",
        title: "Eliminar Registro",
        buttons: {
            cancel: {
                label: "Cancelar",
                className: "btn-secondary"
            },
            confirm: {
                label: "Ok",
                className: "btn-success",
                callback: function() {

                    $.ajax({
                        beforeSend:function(){
                            blockPage();
                        },
                        url: url,
                        cache: false,
                        type: $type,
                        dataType: "json",
                        data: str,
                        success: function(response){

                            if(response.respuesta==false){
                                unBlockPage();
                                notification('Advertencia..!', response.message,'error');
                            }else{

                                table.draw();
                                notification('Exito..!', 'Registro eliminado exitosamente','success');

                            }
														console.log(response);

                        },
                        error: function(e){
                            unBlockPage();
                            console.log(e);
                        }

                    });

                }
            }

        },
        className: "bootbox-sm modal-dialog-centered-custom"
    });

}
