var init = [];

init.push(function () {
	//$('#main-navbar-notifications').slimScroll({ height: 250 });
	$('#main-navbar-messages').slimScroll({ height: 250 });
	

	//para generar un slider dentro de un div
	$('#contenido').slimScroll({ height: 250, alwaysVisible: true, color: '#888',allowPageScroll: true });

	//grafica
	var str = 'accion=grafica';
	accionData('phpAjaxVentas.php','grafica',str);

	//detalle venta
	$('#detalle-diario').on('click',function (e){

		e.preventDefault();

		var accion = $(this).attr('data-accion');
		var str = 'accion='+accion;
		var url = 'phpAjaxVentas.php';

		accionData(url,accion,str)

	});

	

});



window.PixelAdmin.start(init);

$('#main-navbar-notifications').slimScroll({ height: 250 });


function accionData(url,accion,str){

	$.ajax({
		cache: false,
		dataType: 'json',
		type: 'POST',
		url: 'includes/'+url,
		data: str,
		success: function(response){

			if(response.respuesta == false){
				alert(response.mensaje);
			}else{

				switch (accion){

					case 'grafica':

						var uploads_data = response.contenido;

						Morris.Line({
							element: 'hero-graph',
							data: uploads_data,
							xkey: 'day',
							ykeys: ['v'],
							labels: ['Valor'],
							lineColors: ['#fff'],
							lineWidth: 2,
							pointSize: 4,
							gridLineColor: 'rgba(255,255,255,.5)',
							resize: true,
							gridTextColor: '#fff',
							xLabels: "day",
							xLabelFormat: function(d) {
								return ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov', 'Dic'][d.getMonth()] + ' ' + d.getDate(); 
							},
						});
					
						break;

					case 'detalle-diario':

						$('#data-detalle-contenido').empty().append(response.contenido);
						//alert(response.contenido);
						$('#modal-contenido').modal('show');
						break;

				}
			}

		},
		error: function(){
			alert('Error General del Sistema.');
		}
	});


}


