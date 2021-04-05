$(window).on('load', function() { // makes sure the whole site is loaded
	hidePreloader();
});

localStorage.removeItem('arrId');

init.push(function () {

	$('.calendar').datepicker({
		dateFormat: 'dd-mm-yy',
		changeMonth: true
	});
	
	$('body').on('click','#buscar_documento',function(e){
		table.draw();
		$("input[type=checkbox]").prop("checked", false);
	});	

	$('body').on('keyup', function(e) { // makes sure the whole site is loaded
		var charCode = e.charCode || e.keyCode || e.which;
	    if (charCode == 27){
	        console.log("Escape is not allowed!");
	        return false;
	    }
	});

    if($('.tablaDocumento').length > 0){

		var table = $('.tablaDocumento').DataTable( {
	      	"ajax": {
	          url:"ajax/datatable-firmar_documentos.ajax.php",
	          data: function(d){
	              d.mantenimiento = $('.mantenimiento').val(); //enviar parametros personalizados
	              d.idDocus = localStorage.getItem('arrId') ? localStorage.getItem('arrId') : JSON.stringify([]) ;
	              d.inicio = $('#fecha_inicio').val();
	              d.fin = $('#fecha_fin').val();
	              d.tipoDoc = $('#tipoDoc').val();
	              d.estadoDoc = $('#estadoDoc').val();
	              console.log(d);
	          },
	          complete: function(res){
	              console.log(res);
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

	    $('#DataTables_Table_0_wrapper .table-caption').text('Lista de Documentos por Firmar');
	  	$('#DataTables_Table_0_wrapper .dataTables_filter input').attr('placeholder', 'Buscar...');

	  	//acciones de los botones
	  	$('body').on('click','.tablaDocumento .btnUpload',function(e){

	  		//e.preventDefault();

	  		var id = $(this).attr('id');
	  		var rut_cliente = $(this).attr('rut_cliente');
	  		var nombre_paciente = $(this).attr('nombre_paciente');
	  		var tipo_doc = $(this).attr('tipo_doc_des');

	  		$('#file_'+id).click();


	  		$('#file_'+id).change(function(){
	  			
	  			var file = this.files[0];

	  			if(file.type != 'application/pdf'){
					notification('Advertencia..!','Solo se permiten archivos en formato PDF','error');

					return;
				}

				var datos = new FormData();

		        datos.append("file",file);
		        datos.append("accion",'upload_file');
		        datos.append('id',id);
		        datos.append('rut_cliente',rut_cliente);
        		datos.append('nombre_paciente',nombre_paciente);
        		datos.append('tipo_doc',tipo_doc);

		        $.ajax({
		        	beforeSend: function(){
		        		blockPage();
		        	},
		            url:"ajax/documentos.ajax.php",
		            method: "POST",
		            data: datos,
		            dataType: "json",
		            cache: false,
		            contentType: false,
		            processData: false,
		            success: function(response){

		                unBlockPage();

		                if(response.respuesta_upload == false){
		                	notification('Advertencia..!','Hubo problemas al cargar el archivo','error');
		                }else{
		                	notification('Exito..!','Archivo cargado exitosamente','success');
		                	table.draw();
		                }

		            },
		            error: function(e){
		                console.log(e);
		                unBlockPage();
		            }

		        });
	  		});

	  		
	  	});

	  	$('body').on('click','.tablaDocumento .btnVer',async function(e){
	  		e.preventDefault();
			var name = $(this).attr('name_docu');

			if(name == ''){
				notification('Error..!','Documento no encontrado','error');
				return;
			}

			blockPage();

			name = name.replace('.pdf','');
			var datos = 'accion=readfile&name='+name;

			var formData = new FormData();
	    	formData.append('accion','readfile');
	    	formData.append('name',name);

	    	var url = 'ajax/documentos.ajax.php';
	    	const response = await fetch(url,{
					            method: 'post',
					            body: formData,
		          			});
	    	var blob = await response.blob();
	    	var blobUrl = URL.createObjectURL(blob);

	    	if(blob.type == 'application/pdf'){
	    		window.open(blobUrl, "Visualizar", "width=900,height=1000");
	    	}else{
	    		notification('Error..!','Documento no encontrado','error');
	    	}

	    	unBlockPage();

	    });

	    $('body').on('click','.tablaDocumento .btnFirmar',function(e){
	  		e.preventDefault();

	  		var id = $(this).attr('id');

			$('#id').val(id);
			$('#txt_response').hide();

			$('#form-firma').show();
		    $('#div_msj').remove();

			$('#modalFirma').modal({
	            backdrop: 'static',
	            keyboard: false
	        });

	    });

	    $('.updateDatatable').click(function(){
	    	
	    	table.draw();
			
		});

		$('#firmar').on('click',function(){

			var arrayDocs = [];
			var id = $('#form-firma #id').val();

			if (id == '') {
				var docus = localStorage.getItem('arrId');
			}else{
				arrayDocs.push(id);
				docus = JSON.stringify(arrayDocs);
			}

			//console.log(docus);
			var str = $('#form-firma').serialize()+'&accion=firmar&docus='+docus;
			//console.log(str);
			$.ajax({
		        beforeSend: function(){
		          blockPage();
		          //$().show();
		        },
		        cache: false,
		        url:"ajax/firmar_documentos.ajax.php",
		        dataType: 'json',
		        type:'POST',
		        data:str,
		        success:function(response){
		        	//div msj exito
		          if(response.respuesta == false){
		            unBlockPage();
		            notification('Error..!',response.mensaje,'error');
		            $('#form-firma').show();
		            $('#div_msj').remove();
		          }else{
		          	localStorage.removeItem('arrId');
		          	$("input[type=checkbox]").prop("checked", false);
		          	unBlockPage();
		            notification('Exito..!',response.mensaje,'success');
		            $('#div_msj').remove();
		            $('#form-firma').hide();		            
		            $('#form-firma').after(	'<div class="row" id="div_msj">'+
		            							'<div class="col-sm-12">'+
		            								'<div class="note note-success">'+
		            									'<i class="fa fa-check-circle" style="color:green"></i> Se firmo correctamente.'+
		            								'</div>'+
		            								'<img src="views/images/empresa/contratodigital.jpg">'+
		            							'</div>'+
		            						'</div>');
		          }
		          console.log(response);
		        },
		        error: function(e){
		          unBlockPage();
		          console.log(e.responseText);
		        }
	      	});

		    return false;

		});

		$('.px').on('click',function(){

			if($(this).prop('checked')){
				$("input[type=checkbox]").prop("checked", true);
			}else{
				$("input[type=checkbox]").prop("checked", false);
			}

		});

		//FIRMA_LOTE
		$('#firma_lote').on('click',function(){
			$('#form-firma #id').val('');
			localStorage.removeItem('arrId');
			var i = 0;
			var arrId = [];

			$('.check_firma').each(function(){

				var $this = $(this);
				
				if($this.prop('checked')){
					i++;
					var id = $this.attr('id');
					arrId.push(id);
				}

			});

			if(arrId.length > 0){
				localStorage.setItem('arrId',JSON.stringify(arrId));

				$('#modalFirma').modal({
		            backdrop: 'static',
		            keyboard: false
		        });

			}else{				
				notification('Advertencia..!','Debe seleccionar almenos un documento','error');
			}

			

			//
			console.log(arrId);

		});

	}


    
});
