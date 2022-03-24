$(window).on('load', function() { // makes sure the whole site is loaded
	hidePreloader();
});

var form = "#formDocumento";
var formPersona = "#formPersona";
var listaAptos = [];

var wizard = ".ui-wizard-documento";

init.push(function () {

  $(wizard).pixelWizard({
    onChange: function () {
      console.log('Current step: ' + this.currentStep());
    },
    onFinish: function () {
      // Disable changing step. To enable changing step just call this.unfreeze()
      //this.freeze();
      console.log('Wizard is freezed');
      console.log('Finished!');
    }
  });

  $('.wizard-next-step-btn').text('Siguiente');
  $('.wizard-prev-step-btn').text('Atras');
  $('.wizard-next-step-btn.finish').text('Guardar documento');

  	$('.wizard-next-step-btn').click(function () {
		var div = $(this).attr('data-div');
	    var error = 0;
	    var vacio = 0;

	    $(form+' .form-group').each(function(){
	      if($(this).hasClass('has-error')){
	        error++;
	      }
	    });

	    $('#'+div+' .valid').each(function(){
	      if($(this).val() == ''){
	        vacio++;
	      }
	    });

	    if(vacio > 0 || error > 0){
	      notification('Advertencia ..!','Se detectaron campos sin completar y/o erroneos.','error');
	      return;
	    }

	    if($('#'+div+' #lista_roles_aptos').length > 0){

	    	var inputUsuariosAptos = $('#'+div+' #lista_aptos').val();
	    	var usuariosAptos = inputUsuariosAptos != '' ? JSON.parse(inputUsuariosAptos) : [];
	    	var totalGrupos = usuariosAptos.length;

	    	var inputRoles = $('#'+div+' #lista_roles_aptos').val();
	    	var roles = inputRoles != '' ? JSON.parse(inputRoles) : [];
	    	var totalUsuariosFirmar = roles.length;

	    	if(totalUsuariosFirmar != totalGrupos){
	    		notification('Advertencia ..!','Seleccione un usuario de cada grupo para continuar.','error');
	      		return;
	    	}

	    	var totalAptos = 0;
	    	usuariosAptos.forEach(grupo => {

	    		if(grupo.length > 0){
	    			totalAptos ++;
	    		}

	    	});

	    	if(totalUsuariosFirmar != totalAptos){
	    		notification('Advertencia ..!','Seleccione un usuario de cada grupo para continuar.','error');
	      		return;
	    	}
	    }

	    $(this).parents(wizard).pixelWizard('nextStep');

  	});

  	$('.wizard-prev-step-btn').click(function () {
   		$(this).parents(wizard).pixelWizard('prevStep');
  	});

  	$('.wizard-go-to-step-btn').click(function () {
  	 	$(this).parents(wizard).pixelWizard('setCurrentStep', 2);
  	});

	//*****************************************************
	let opt = $('#nTipPer').val();
	changeTipoPaciente(opt);

	$('#nTipPer').change(function(){
        let option = $(this).val();
        changeTipoPaciente(option);
    });

	$('.rut_paciente').Rut({
      on_error: function () {

          $('.rut_paciente').parent().parent().addClass('has-error');
          $('.search-paciente').attr('disabled','disabled');
      },
      on_success: function () {
          $('.rut_paciente').parent().parent().removeClass('has-error');
          $('.search-paciente').removeAttr('disabled');
      },
      format_on: 'keyup'
  	});

  	$('.rut_cliente').Rut({
      	on_error: function () {
          	$('.rut_cliente').parent().parent().addClass('has-error');
          	$('.search-cliente').attr('disabled','disabled');
      	},
      	on_success: function () {
          	$('.rut_cliente').parent().parent().removeClass('has-error');
          	$('.search-cliente').removeAttr('disabled');
      	},
      	format_on: 'keyup'
  	});

  	$('.rut_persona').Rut({
      	on_error: function () {
          	$('.rut_persona').parent().parent().addClass('has-error');
        },
      	on_success: function () {
          	$('.rut_persona').parent().parent().removeClass('has-error');
        },
      	format_on: 'keyup'
  	});

	$('.search').on('click',function(){

		var input = $(this).attr('data-input');
		var addBtn = $(this).attr('data-show');
		var type = $(this).attr('data-type');
		var displayId = $(this).attr('data-displayId');
		var display = $(this).attr('data-display');
		var opt = $('#nTipPerDesc').val();

		if($(this).parent().parent().parent().hasClass('has-error')){
			notification('Advertencia','RUT invalido','error');

			return false;
		}

		if(opt == 'Nacional'){
			if($('.rut_cliente').val() == $('.rut_paciente').val()){
				var val = type=='cliente' ? 'paciente' : 'cliente';
				notification('Advertencia','RUT '+type+' no puede ser igual a RUT '+val,'error');
				$('#'+display).val('');
				$('#'+displayId).val('');
				return false;
			}
		}			

		var value = $('#'+input).val();
		var str = 'accion=search&type='+type;

		if(type=='paciente'){
			if(opt == 'Nacional'){
				str += '&rut='+value
			}else{
				str += '&value='+value;
			}

			str += '&nTipPerDesc='+opt;
		}else{
			str += '&rut='+value;
		}
			

		$.ajax({
			beforeSend: function(){
				$('.'+addBtn).hide();
				$('#'+display).val('');
				$('#'+displayId).val('');
				blockPage();
			},
			cache:false,
			type: 'POST',
			dataType: 'json',
			url: 'ajax/persona.ajax.php',
			data:str,
			success:function(response){

				if(response.respuesta == false){
					$('.'+addBtn).show();
					let tip = opt == 'Nacional' ? 'RUT' : 'N° Pasaporte'
					notification('Advertencia..!',tip+' no registrado como '+type,'error');
				}else{
					$('#'+display).val(response.data.fullname);
					$('#'+displayId).val(response.data.id);
				}
				//console.log(response);
				unBlockPage();
			},
			error:function(e) {
				console.log(e);
				unBlockPage();
			}
		});

	});

	//REGISTRAR PERSONA
	$('.add-persona').click(function(){
		var input = $(this).attr('data-input');
		var value = $('#'+input).val();
		var type = $(this).attr('data-type');
		var title = type == 'cliente' ? 'Registrar Cliente' : 'Registrar Paciente';
		var tipoPersona = type == 'cliente' ? 'j' : 'n'; //cliente:j - paciente:n
		var opt = $('#nTipPerDesc').val();

		resetFormulario('formPersona');

		$('#myModalLabel').html(title);
		$('#formPersona #xTipoPer').val(tipoPersona);
		$('.Nacional input').prop('required',false);
		$('.Nacional').hide();
		$('.Nacional input').removeClass('valid');
		$('.Extranjero input').prop('required',false);
		$('.Extranjero').hide();
		$('.Extranjero input').removeClass('valid');

		if(type == 'cliente'){
			$('.natural').hide();
			$('.juridica').show();
			$('.juridica input').addClass('valid');
			$('.natural input').removeClass('valid');
			$('.Nacional input').prop('required',true);
			$('.Nacional').show();
			$('#formPersona #nRutPer').val(value);
		}else{
			//paciente
			$('.natural').show();
			$('.juridica').hide();
			$('.juridica input').removeClass('valid');
			$('.natural input').addClass('valid');
			$('.'+opt+' input').prop('required',true);
			$('.'+opt+' input').addClass('valid');
			$('.'+opt).show();
			if(opt == 'Nacional'){
				$('#formPersona #nRutPer').val(value);
			}else{
				$('#formPersona #xPasaporte').val(value);
			}
		}

		$('#modalReg').modal('show');
	});

	$('#guardarPersona').click(function(){

		var error = 0;
		var vacio = 0;

		$(formPersona+' .form-group').each(function(){
	      if($(this).hasClass('has-error')){
	        error++;
	      }
	    });

	    $(formPersona+' .valid').each(function(){
	      if($(this).val() == ''){
	        vacio++;
	      }
	    });

	    if(vacio > 0 || error > 0){
	      notification('Advertencia ..!','Se detectaron campos sin completar y/o erroneos.','error');
	      return;
	    }

	    var tipo = $('#formPersona #xTipoPer').val();
	    var inputName = tipo == 'j' ? $(form+' #xRazSoc') : $(form+' #xNombrePaciente');
	    var inputId = tipo == 'j' ? $(form+' #cliente_id') : $(form+' #paciente_id');
	    var ocultar = tipo == 'j' ? '.add-cliente' : '.add-paciente';
	    var opt = $('#nTipPerDesc').val();
	    var optVal = $('#nTipPer').val();

	    var str = $(formPersona).serialize()+'&accion=add';

	    if(tipo == 'n'){
	    	str += '&nTipPer='+optVal+'&nTipPerDesc='+opt;
	    }

	    $.ajax({
			beforeSend: function(){
				inputName.val('');
				inputId.val('');
				blockPage();
			},
			cache:false,
			type: 'POST',
			dataType: 'json',
			url: 'ajax/persona.ajax.php',
			data:str,
			success:function(response){

				if(response.respuesta == false){
					notification('Advertencia..!',response.mensaje,'error');
				}else{

					inputName.val(response.data.fullname);
					inputId.val(response.data.id);

					$(form+' '+ocultar).hide();
					$('#modalReg').modal('hide');
				}
				//console.log(response);
				unBlockPage();
			},
			error:function(e) {
				console.log(e);
				unBlockPage();
			}
		});

	});


	$('#tipoDocumento_id').change(function(){
		var tipo = $(this).val();
		var name_tipo_doc = $(form+' #tipoDocumento_id option:selected').text();
		$(form+' #name_tipo_doc').val(name_tipo_doc);
		//console.log('cargo');
		cargarRolesPorTipoDocumento(tipo);
	});

	$('.disponibles').on('click','a',function(e){

		$('.disponibles a').removeClass('active');
		e.preventDefault();

		var $this = $(this);
		var orden = $(this).attr('orden');
		var idRol = $(this).attr('id_rol');
		var rolName = $(this).attr('rol_name');

		$this.addClass('active');
		$('#rol_activo').val(idRol);
		var detalleRolActivo = {
			orden: orden,
			id: idRol,
			name: rolName
		};

		$('#detalle_rol_activo').val(JSON.stringify(detalleRolActivo));

		listUsersPerRol(detalleRolActivo);

	});

	$('.users-disponibles').on('click','a',function(e){
		e.preventDefault();

		var element = [];
		$(this).remove();

		var orden = $(this).attr('orden_por_rol');
		var idRol = $(this).attr('id_rol');
		var rolName = $(this).attr('rol_name');
		var idUsuario = $(this).attr('usuario_id');
		var fullname = $(this).attr('fullname');

		element.push({'rol_id':idRol,
						'usuario_id':idUsuario,
						'fullname':fullname,
						'rol_name':rolName,
						'orden':orden});

		var str = 'accion=lista_aptos&user='+JSON.stringify(element[0])+'&aptos='+$('#lista_aptos').val()+'&orden='+orden;

		$.ajax({
			beforeSend: function(){
				blockPage();
			},
			cache:false,
			type: 'POST',
			dataType: 'json',
			url: 'ajax/documentos.ajax.php',
			data:str,
			success:function(response){

				$('.users-aptos').html(response.contenido);
				$('#lista_aptos').val(JSON.stringify(response.lista));
				console.log('response :>>',response);
				console.log('lista :>>',response.lista);
				unBlockPage();

				var detalleRolActivo = JSON.parse($('#detalle_rol_activo').val());
				listUsersPerRol(detalleRolActivo);

			},
			error:function(e) {
				console.log(e);
				unBlockPage();
			}
		});

	});

	$('.users-aptos').on('click','a',function(e){

		e.preventDefault();

		var $this = $(this);
		var active = $('#rol_activo').val();
		var activeRol = $(this).attr('id_rol');
		var orden = $(this).attr('orden_por_rol');
		var idUsuario = $(this).attr('usuario_id');
		var listaAptos = JSON.parse($('#lista_aptos').val());
		var listaNueva = [];

		if(activeRol == active){
			$this.appendTo('.users-disponibles');
		}else{
			$this.fadeOut();
		}

		listaNueva = listaAptos[orden].filter(user => user.usuario_id != idUsuario);

		listaAptos[orden] = listaNueva;

		$('#lista_aptos').val(JSON.stringify(listaAptos));
		console.log(listaAptos);
		console.log('listaNueva :>>',listaNueva);

	});

	//cargar documento
	$('#adjuntar').click(function(){
		$('#file').click();
	});

	$('#file').on('change',function(){

		var file = this.files[0];
		var oldFile = $('.name_documento').val();
		var rut_cliente = $('#rut_cliente').val();
		var nombre_paciente = $('#xNombrePaciente').val();
		var tipo_doc = $('#name_tipo_doc').val();

		$('.name_documento').val('');

		if(file.type != 'application/pdf'){
			notification('Advertencia..!','Solo se permiten archivos en formato PDF','error');

			return;
		}

		var datos = new FormData();

        datos.append("file",file);
        datos.append("accion",'upload_file');
        datos.append('oldFile',oldFile);
        datos.append('rut_cliente',rut_cliente);
        datos.append('nombre_paciente',nombre_paciente);
        datos.append('tipo_doc',tipo_doc);

        $.ajax({
        	beforeSend: function(){
        		blockPage();
        		$(form +' .tieneDocumento').hide();
				$(form+' .noTieneDocumento').fadeIn();
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

                if(response.respuesta == false){
                	notification('Advertencia..!',response.mensaje,'error');
                }else{
                	$('.name_documento').val(response.data);
                	$('.name_drive').val(response.drive);
                	$(form +' .tieneDocumento').fadeIn();
					$(form+' .noTieneDocumento').hide();
					$(form+' #codigo').val('');
					$(form+' #google_id').val('');
                }

            },
            error: function(e){
                console.log(e);
                unBlockPage();
            }

        });

	});

	$('#ver').click(async function(){

		var name = $(form+' #name_documento').val();
		var id = $(form+' #idDocumento').val();
		var codigo = $(form+' #codigo').val();

		if(name == ''){
			notification('Error..!','Documento no encontrado','error');
			return;
		}

		var formData = new FormData();
    	formData.append('accion','readfile');
    	
    	if(codigo == ''){
    		name = name.replace('.pdf','');
    		formData.append('name',name);
    	}else {
    		formData.append('term',codigo);
    	}
    	

    	blockPage();

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
	

	$('#guardarDocumento').click(function(){

		var id = $('#idDocumento').val();
		var accion = id == '0' ? 'add' : 'edit';
		var str = $(form).serialize()+'&accion='+accion;

		$.ajax({
			beforeSend: function(){
				blockPage();
			},
			cache:false,
			type: 'POST',
			dataType: 'json',
			url: 'ajax/documentos.ajax.php',
			data:str,
			success:function(response){

				console.log(response);
				unBlockPage();

				if(response.respuesta == false){
					notification('Error..!',response.mensaje,'error');
				}else{
					notification('Exito..!',response.mensaje,'success');

					//window.location.href = 'index.php?action=lista_de_documentos';
					window.location.href = 'index.php?action=consultar_documentos';
				}
				
			},
			error:function(e) {
				console.log(e);
				unBlockPage();
			}
		});

	});

	//EDITAR
	//carga inicial si se edita
	
	if($('#idDocumento').length > 0 && $('#idDocumento').val() != '0'){
		var id = $('#idDocumento').val();
		var str = 'accion=detalle&id='+id;
		var url = "ajax/documentos.ajax.php";

		cargarDataModal(url,'',str,'',form,function(result,data){

			if(result){
				cargarRolesPorTipoDocumento(data.tipoDocumento_id);
				$(form +' .users-aptos').html(data.users_aptos);
				$(form+' #lista_aptos').val(data.lista_aptos);
				
				if(![null,''].includes(data.name_documento)){
					$(form +' .tieneDocumento').show();
					$(form+' .noTieneDocumento').hide();

				}else{
					$(form +' .tieneDocumento').hide();
					$(form+' .noTieneDocumento').show();
				}
				
			}
		});

	}

	//LISTA-DE-DOCUMENTOS

	if($('.tablaDocumento').length > 0){

		$('body').on('click','#buscar_documento',function(e){
			table.draw();
			//$("input[type=checkbox]").prop("checked", false);
		});

		var table = $('.tablaDocumento').DataTable( {
	      	"ajax": {
	          url:"ajax/datatable-documentos.ajax.php",
	          data: function(d){
	              d.mantenimiento = $('.mantenimiento').val(); //enviar parametros personalizados
	              d.inicio = $('#fecha_inicio').val();
	              d.fin = $('#fecha_fin').val();
	              d.tipoDoc = $('#tipoDoc').val();
	              d.estadoDoc = $('#estadoDoc').val();
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
	          {data: 'codigo', name: 'codigo',className:'text-center',orderable: false},
	          {data: 'rutCliente', name: 'rutCliente',className:'text-center'},
	          {data: 'nomCliente', name: 'nomCliente',className:'text-center'},
	          {data: 'rutPaciente', name: 'rutPaciente',className:'text-center'},
	          {data: 'nomPaciente', name: 'nomPaciente',className:'text-center'},
	          {data: 'tipoDocumento', name: 'tipoDocumento',className:'text-center'},
	          {data: 'estado', name: 'estado',className:'text-center',searchable: false},
	          {data: 'fechaCrea', name: 'fechaCrea',className:'text-center',searchable: false},
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

	    $('#DataTables_Table_0_wrapper .table-caption').text('Lista de Documentos');
	  	$('#DataTables_Table_0_wrapper .dataTables_filter input').attr('placeholder', 'Buscar...');

	  	$('body').on('click','.tablaDocumento .btnEditar',function(e){

	  		e.preventDefault();

	  		var id = $(this).attr('id');
	  		var str = 'accion=redirigir&id='+id;

	  		$.ajax({
				beforeSend: function(){
					blockPage();
				},
				cache:false,
				type: 'POST',
				dataType: 'json',
				url: 'ajax/documentos.ajax.php',
				data:str,
				success:function(response){

					if(response.respuesta == false){
						notification('Advertencia..!',response.mensaje,'error');
					}else{
						window.location.href = 'index.php?action=crear_documentos';
					}
					
					unBlockPage();
				},
				error:function(e) {
					console.log(e);
					unBlockPage();
				}
			});
	  	});

	  	$('body').on('click','.tablaDocumento .btnVer',async function(e){
	  		e.preventDefault();
			var name = $(this).attr('name_docu');
			var codigo = $(this).attr('codigo');

			if(codigo == ''){
				notification('Error..!','Documento no encontrado','error');
				return;
			}

			blockPage();

			var formData = new FormData();
	    	formData.append('accion','readfile');
	    	formData.append('term',codigo);

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

	    $('body').on('click','.tablaDocumento .btnLista',function(e){
	  		e.preventDefault();

	  		var id = $(this).attr('id');

	  		var datos = new FormData();

	        datos.append("documento_id",id);
	        datos.append("accion",'historial');
	        
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
	                	notification('Advertencia..!','Hubo problemas al cargar la informacion','error');
	                }else{
	                	
	                	$('#contenido').html(response.contenido);

	                	$('#modalUsuariosAsignados').modal({
				            backdrop: 'static',
				            keyboard: false
				        });
	                }

	            },
	            error: function(e){
	                console.log(e);
	                unBlockPage();
	            }

	        });

		});

		$('body').on('click','.tablaDocumento .btnEliminar',function(e){
	  		e.preventDefault();

	  		var id = $(this).attr('id');

	  		var str = 'documento_id='+id+'&accion=anular';

	        var url = 'ajax/documentos.ajax.php';
	        
	        deleteRow(url,table,str,'POST');

		});

	}
		

});

function cargarRolesPorTipoDocumento(tipo){

	$('.disponibles').html('');
	$('.users-disponibles').html('');
	$('.users-aptos').html('');
	$('#lista_aptos').val('');
	$('#lista_roles_aptos').val('');

	if(tipo !=''){
		var str = 'accion=list_rol&tipoDocumento_id='+tipo;
		$.ajax({
			beforeSend: function(){
				blockPage();
			},
			cache:false,
			type: 'POST',
			dataType: 'json',
			url: 'ajax/tipodocumento_rolusuario.ajax.php',
			data:str,
			success:function(response){

				if(response.respuesta == false){
					notification('Advertencia..!',response.mensaje,'error');
				}else{
					$('.disponibles').html(response.roles);
					$('#lista_roles_aptos').val(JSON.stringify(response.dataRoles))
				}
				console.log('cargarRolesPorTipoDocumento',response);
				unBlockPage();
			},
			error:function(e) {
				console.log(e);
				unBlockPage();
			}
		});
	}
}

function listarJsonAptos(){

	$('.users-aptos a').each(function(){

	});

}

function listUsersPerRol(rol){

	var str = 'accion=listPerRol&idRol='+rol.id+'&rolName='+rol.name+'&orden='+rol.orden+'&aptos='+$('#lista_aptos').val();

	$.ajax({
		beforeSend: function(){
			blockPage();
		},
		cache:false,
		type:'POST',
		dataType: 'json',
		url: 'ajax/usuario.ajax.php',
		data: str,
		success: function(response){

			unBlockPage();

			$('.users-disponibles').html(response.usuarios);

		},
		error: function(e){
			unBlockPage();
			console.log(e.responseText);

		}
	});

}

function changeTipoPaciente(option){

    let txt = $('#nTipPer option[value="'+option+'"]:selected').text(); 
    
    $('.valor input').prop('required',false);
    $('.valor input').removeClass('valid')
    $('.valor input').val('');
    $('.valor').hide();
    $('#nTipPerDesc').val('');
    $('.add-paciente').hide();
    $('.search-paciente').prop('disabled',false);
        
    if(['Nacional','Extranjero'].includes(txt.trim())){
        
        $('.'+txt).show();
        $('.'+txt+' input').prop('required',true);
        $('#nTipPerDesc').val(txt);
    }
}
