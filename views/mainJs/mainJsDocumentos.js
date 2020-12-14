$(window).on('load', function() { // makes sure the whole site is loaded
	hidePreloader();
});

var form = "#formDocumento";

var wizard = ".ui-wizard-documento";

init.push(function () {

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

	$('.search').on('click',function(){

		var input = $(this).attr('data-input');
		var addBtn = $(this).attr('data-show');
		var type = $(this).attr('data-type');
		var displayId = $(this).attr('data-displayId');
		var display = $(this).attr('data-display');

		if($(this).parent().parent().parent().hasClass('has-error')){
			notification('Advertencia','RUT invalido','error');

			return false;
		}

		if($('.rut_cliente').val() == $('.rut_paciente').val()){
			var val = type=='cliente' ? 'paciente' : 'cliente';
			notification('Advertencia','RUT '+type+' no puede ser igual a RUT '+val,'error');
			$('#'+display).val('');
			$('#'+displayId).val('');
			return false;
		}

		var value = $('#'+input).val();
		var str = 'accion=search&type='+type+'&rut='+value;

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
					notification('Advertencia..!','RUT no registrado como '+type,'error');
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

  $(wizard).pixelWizard({
    onChange: function () {
      console.log('Current step: ' + this.currentStep());
    },
    onFinish: function () {
      // Disable changing step. To enable changing step just call this.unfreeze()
      this.freeze();
      console.log('Wizard is freezed');
      console.log('Finished!');
    }
  });

  $('.wizard-next-step-btn').text('Siguiente');
  $('.wizard-prev-step-btn').text('Atras');
  $('.wizard-next-step-btn.finish').text('Guardar documento');

  $('.wizard-next-step-btn').click(function () {

    var error = 0;
    var vacio = 0;

    $('.form-group').each(function(){
      if($(this).hasClass('has-error')){
        error++;
      }
    });

    $('.valid').each(function(){
      if($(this).val() == ''){
        vacio++;
      }
    });

    if(vacio > 0 || error > 0){
      notification('Advertencia ..!','Se detectaron campos sin completar y/o erroneos.','error');
      return;
    }

    $(this).parents(wizard).pixelWizard('nextStep');

  });

  $('.wizard-prev-step-btn').click(function () {
    $(this).parents(wizard).pixelWizard('prevStep');
  });

  $('.wizard-go-to-step-btn').click(function () {
    $(this).parents(wizard).pixelWizard('setCurrentStep', 2);
  });


});
