$(window).on('load', function() { // makes sure the whole site is loaded
	hidePreloader();
});

init.push(function () {

    if($('.tablaDocumento').length > 0){

    	$('body').on('click','#buscar_documento',function(e){
			table.draw();
			$("input[type=checkbox]").prop("checked", false);
		});

		var table = $('.tablaDocumento').DataTable( {
	      	"ajax": {
	          url:"ajax/datatable-firmar_documentos.ajax.php",
	          data: function(d){
	              d.mantenimiento = $('.mantenimiento').val(); //enviar parametros personalizados
	              d.idDocus = localStorage.getItem('arrId') ? localStorage.getItem('arrId') : JSON.stringify([]) ;
	              d.inicio = $('#fecha_inicio').val();
	              d.fin = $('#fecha_fin').val();
	              d.tipoDoc = $('#tipoDoc').val();
	              //d.estadoDoc = $('#estadoDoc').val();
	              d.view = 'descargar';
	              //console.log(d);
	          },
	          complete: function(res){
	              //console.log(res);
	              hidePreloader();
	              unBlockPage();
	      	}
	      },
	      "deferRender": true,
	      "retrieve": true,
	      "processing": true,
	      "serverSide":true,
	      columns: [

	          {data: 'DT_RowIndex', name: 'DT_RowIndex',className:'text-center',searchable: false},
	          {data: 'rutCliente', name: 'rutCliente',className:'text-center'},
	          {data: 'nomCliente', name: 'nomCliente',className:'text-center'},
	          {data: 'rutPaciente', name: 'rutPaciente',className:'text-center'},
	          {data: 'nomPaciente', name: 'nomPaciente',className:'text-center'},
	          {data: 'tipoDocumento', name: 'tipoDocumento',className:'text-center'},
	          {data: 'estado', name: 'estado',className:'text-center'},
	          {data: 'fechaCrea', name: 'fechaCrea',className:'text-center'},
	          {data: 'descargar', name: 'descargar',className:'text-center',orderable: false,searchable: false},
	          {data: 'action', name: 'action', className:'text-center',orderable: false, searchable: false},

	      ],
	      "language": {

	          "sProcessing":     "Procesando...",
	          "sLengthMenu":     "Por Pagina _MENU_",
	          "sZeroRecords":    "No se encontraron resultados",
	          "sEmptyTable":     "Ningún dato disponible en esta tabla",
	          "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_",
	          "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0",
	          "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
	          "sInfoPostFix":    "",
	          "sSearch":         "",
	          "sUrl":            "",
	          "sInfoThousands":  ",",
	          "sLoadingRecords": "Cargando...",
	          "oPaginate": {
	          "sFirst":    "Primero",
	          "sLast":     "Último",
	          "sNext":     "Siguiente",
	          "sPrevious": "Anterior"
	          },
	          "oAria": {
	            "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
	            "sSortDescending": ": Activar para ordenar la columna de manera descendente"
	          }

	      }

	    });

	    $('#DataTables_Table_0_wrapper .table-caption').text('Lista de Documentos Firmados');
	  	$('#DataTables_Table_0_wrapper .dataTables_filter input').attr('placeholder', 'Buscar...');

	  	$('.px').on('click',function(){

			if($(this).prop('checked')){
				$("input[type=checkbox]").prop("checked", true);
			}else{
				$("input[type=checkbox]").prop("checked", false);
			}

		});

		//DESCARGA_LOTE
		$('#descarga_lote').on('click',function(){
			
			//localStorage.removeItem('arrId');
			var i = 0;
			var arrId = [];

			$('.check_download').each(function(){

				var $this = $(this);
				
				if($this.prop('checked')){
					i++;
					var id = $this.attr('id');
					arrId.push(id);
				}

			});

			if(arrId.length > 0){
				//localStorage.setItem('arrId',JSON.stringify(arrId));

				var formData = new FormData();
				formData.append('accion','readfile');
				formData.append('name',name);

			var url = 'ajax/documentos.ajax.php';

				descargarDocumento(arrId);

			}else{				
				notification('Advertencia..!','Debe seleccionar almenos un documento','error');
			}

			console.log(arrId);

		});

		$('body').on('click','.tablaDocumento .btnDownload',async function(e){

			e.preventDefault();
			var name = $(this).attr('name_docu');
			var arr = name.split('/');
			var nameFile = arr[arr.length-1];
			name = name.replace('.pdf','');
			var datos = 'accion=readfile&name='+name;

			var formData = new FormData();
			formData.append('accion','readfile');
			formData.append('name',name);

			var url = 'ajax/documentos.ajax.php';

			await descargarDocumento(formData,url,nameFile);

		});
 	}

});

async function descargarDocumento(formData,url,nameFile){

	blockPage();

	const response = await fetch(url,{
			            method: 'post',
			            body: formData,
          			});
	var blob = await response.blob();
	var blobUrl = URL.createObjectURL(blob);

	// if(blob.type == 'application/pdf' || ){
	// 	window.open(blobUrl, "Visualizar", "width=900,height=1000");
	// }else{
	// 	notification('Error..!','Documento no encontrado','error');
	// }
	const a = document.createElement('a');
  	a.href = blobUrl; //window.URL.createObjectURL(new Blob([json]));
  	a.target = 'blank'
  	a.download = nameFile;
  	a.click();

	unBlockPage();

}