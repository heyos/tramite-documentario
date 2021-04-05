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

      $(form+' input[type=file]').val('');
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
        //console.log('file => ',file);
        if(input_id == 'ctr'){
          if(file.type != 'application/x-pkcs12'){
            notification('Advertencia..!','.PFX es el unico formato permitido','error');
            $(this).val('');
            $('button[limpiar="'+input_id+'"]').hide();
            return;
          }
        }

        if(input_id == 'digital'){
          var output = document.getElementById('contenedor-img');
          var src = 'views/images/firma-default.png';
          
          switch (file.type){
            case 'image/png':
            case 'image/jpeg':
              output.src = URL.createObjectURL(file);
              break;
            default:
              notification('Advertencia..!','.PNG y/o .JPEG es el unico formato permitido','error');
              $(this).val('');
              $('button[limpiar="'+input_id+'"]').hide();
              output.src = src;
              return;
              break;
          }

        }

        $('button[limpiar="'+input_id+'"]').show();

      });

    });

    $('#guardar').click(function(){

      var datos = new FormData();
      var digital = $('#digital').prop('files')[0];
      var ctr = $('#ctr').prop('files')[0];
      var clave = $('#clave').val();
      var user = $('#username').val();
      var id = $('#id_usuario').val();

      datos.append("ctr",ctr);
      datos.append("digital",digital);
      datos.append('term',id);
      datos.append('user',user);
      datos.append('clave',clave);
      datos.append('accion','credencial');
      
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
            table.draw();
            notification('Exito..!',response.mensaje,'success');

            $(modalReg).modal('hide');
            $('.quitar').hide();
          }

          console.log('response => ',response);

        },
        error: function(e){
            console.log(e);
            unBlockPage();
        }

      });

    });

    $('body').on('click','.btnEliminar',function(e){

      var term = $(this).attr('id');
      var str = 'accion=quitar&term='+term;

      bootbox.dialog({
          message: "Esta seguro de quitar el certificado de este registro?",
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
                    url: 'views/ajax/usuario',
                    method: "POST",
                    cache: false,
                    dataType: "json",
                    data: str,
                    success: function(response){

                      if(response.respuesta==false){
                          unBlockPage();
                          notification('Advertencia..!', response.mensaje,'error');
                      }else{

                        table.draw();
                        notification('Exito..!', response.mensaje,'success');

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
      
    });

      
});