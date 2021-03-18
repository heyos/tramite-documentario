var form = '#formAsigFirma';
var modalReg = '#modalReg';
var modalLista = '#modalLista';
var input_id = "";
var input_type = "";

init.push(function () {
  
   var table = $('.tablaAsignacionFirma').DataTable( {
      "ajax": {
        url:"ajax/datatable-asignacionFirma.ajax.php",
        data: function(d){
          d.mantenimiento = $('.mantenimiento').val(); //enviar parametros personalizados
          //console.log(d)
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

        {data: 'DT_RowIndex', name: 'DT_RowIndex',className:'text-center'},
        {data: 'fullname', name: 'fullname',className:'text-center'},
        {data: 'username', name: 'username',className:'text-center'},
        {data: 'rol', name: 'rol',className:'text-center'},
        {data: 'logo', name: 'logo',className:'text-center'},
        {data: 'tiene_certificado', name: 'tiene_certificado',className:'text-center'},
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

    $('#DataTables_Table_0_wrapper .table-caption').text('Asignacion de Firmas');
  	$('#DataTables_Table_0_wrapper .dataTables_filter input').attr('placeholder', 'Buscar...');

    $('body').on('click','.btnEditar',function(){
      var id = $(this).attr('id');
      var fullname = $(this).attr('fullname');
      var username = $(this).attr('username');
      $(modalReg+' #myModalLabel').html('Asignar Firma: <strong>'+fullname+'</strong>');
      resetFormularioNew(form);

      $(form+' input[name=id_usuario]').val(id);
      $(form+' input[name=username]').val(username);
      $(modalReg).modal('show');

    });

    $('.cargar').on('click',function(){
      input_id = $(this).attr('open_click');

      $('#'+input_id).click();
      console.log('input_id => ',input_id);

      $('#'+input_id).change(function(){
        var file = this.files[0];
        console.log('file => ',file);
        if(input_id == 'ctr'){
          if(file.type != 'application/x-pkcs12'){
            notification('Advertencia..!','.PFX es el unico formato permitido','error');
            $(this).val('');
            $('button[limpiar="'+input_id+'"]').hide();
            return;
          }
        }

        if(input_id == 'digital'){
          if(file.type != 'image/png'){
            notification('Advertencia..!','.PNG es el unico formato permitido','error');
            $(this).val('');
            $('button[limpiar="'+input_id+'"]').hide();
            return;
          }else{
            var output = document.getElementById('contenedor-img');
            output.src = URL.createObjectURL(file);
          }
        }

        $('button[limpiar="'+input_id+'"]').show();

      });

    });

    // $('#'+input_id).change(function(){
    //   var file = this.files[0];
    //   console.log('file => ',file);
    //   if(input_id == 'ctr'){
    //     if(file.type != 'application/x-pkcs12'){
    //       notification('Advertencia..!','.PFX es el unico formato permitido','error');
    //       $(this).val('');
    //       $('button[limpiar="'+input_id+'"]').hide();
    //       return;
    //     }
    //   }
    // });

    $('#guardar').click(function(){

      var datos = new FormData();
      var digital = $('#digital').prop('files')[0];
      var ctr = $('#ctr').prop('files')[0];

      console.log('digital => ',digital);
      console.log('ctr => ',ctr);

      return;

      datos.append("ctr",ctr);
      datos.append("digital",digital);
      datos.append('oldFile',oldFile);
      datos.append('rut_cliente',rut_cliente);
      datos.append('nombre_paciente',nombre_paciente);
      datos.append('tipo_doc',tipo_doc);

      $.ajax({
        beforeSend: function(){
          blockPage();
        },
        url:"views/ajax/usuario",
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
            $(form +' .tieneDocumento').fadeIn();
            $(form+' .noTieneDocumento').hide();
          }

        },
        error: function(e){
            console.log(e);
            unBlockPage();
        }

      });

    });
    
});