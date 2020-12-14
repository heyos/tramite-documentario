var form = '#formTipoDoc';
var modalReg = '#modalReg';
var modalLista = '#modalLista';

init.push(function () {

    var table = $('.tablaTipoDocumento').DataTable( {
      "ajax": {
          url:"ajax/datatable-tipoDocumento.ajax.php",
          data: function(d){
              d.mantenimiento = $('.mantenimiento').val(); //enviar parametros personalizados
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
          {data: 'descripcion', name: 'descripcion',className:'text-center'},
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

    $('#DataTables_Table_0_wrapper .table-caption').text('Tipo Documento');
  	$('#DataTables_Table_0_wrapper .dataTables_filter input').attr('placeholder', 'Buscar...');

    $('.btn-registrar').click(function(){
      $(modalReg+' #myModalLabel').text('Registrar Tipo Documento');
      resetFormularioNew(form);
      $(form+' input[name=id]').val('0');
      $(modalReg).modal('show');

    });

    //GUADAR FORM
    $('#guardar').on('click',function(){

      var accion = $(form+' #id').val() == '0' ? 'add' : 'edit';
      var data = $(form).serialize()+'&accion='+accion;

      console.log(accion);

      $.ajax({
        beforeSend: function(){
          blockPage();
        },
        cache: false,
        url:"ajax/tipo_documento.ajax.php",
        dataType: 'json',
        type:'POST',
        data:data,
        success:function(response){

          if(response.respuesta == false){
            unBlockPage();
            notification('Error..!',response.message,'error');
          }else{
            notification('Exito..!',response.message,'success');
            $(modalReg).modal('hide');
            table.draw();
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

    //CARGAR DATA EN MODAL PARA ACTUALIZAR
    $('.tablaTipoDocumento').on('click','.btnEditar',function(e){

      e.preventDefault();
      var id = $(this).attr('id');
      var url = 'ajax/tipo_documento.ajax.php';
      var str = 'accion=show&id='+id;

      $(modalReg+' #myModalLabel').text('Editar Tipo Documento');
      cargarDataModal(url,'POST',str,modalReg,form);

    });

    //DELETE ITEM
    $('.tablaTipoDocumento').on('click','.btnEliminar',function(e){

      e.preventDefault();
      var id = $(this).attr('id');
      var url = 'ajax/tipo_documento.ajax.php';
      var str = 'accion=delete&id='+id;

      deleteRow(url,table,str,'POST');

    });

    //ROLES DE USUARIO - TIPO DOCUMENTO
    $('.tablaTipoDocumento').on('click','.btnAddRol',function(e){

      e.preventDefault();
      var id = $(this).attr('id');
      var descripcion = $(this).attr('descripcion');

      var data = 'accion=list&tipoDocumento_id='+id;

      $.ajax({
        beforeSend: function(){
          blockPage();
        },
        cache:false,
        type:'POST',
        dataType: 'json',
        url: 'ajax/tipodocumento_rolusuario.ajax.php',
        data: data,
        success: function(response){

          $('.disponibles').html(response.disponibles);
          $('.ocupados').html(response.ocupados);

          $(modalLista+' #myModalLabel').text(descripcion);
          $(modalLista).modal('show');

          unBlockPage();
        },
        error: function(e){
          unBlockPage();
          console.log(e.responseText);
          //alert(e);
        }
      });

    });

    $('.disponibles').on('click', 'a', function(){

      var  $this = $(this);

      var rolUsuario_id = $(this).attr('id_rol');
      var tipoDocumento_id = $(this).attr('tipoDocumento_id');
      var data = 'accion=add&rolUsuario_id='+rolUsuario_id+'&tipoDocumento_id='+tipoDocumento_id;

      $.ajax({
         beforeSend: function(){
           blockPage();
         },
         cache:false,
         type:'POST',
         dataType: 'json',
         url: 'ajax/tipodocumento_rolusuario.ajax.php',
         data: data,
         success: function(response){

           unBlockPage();

           if(response.respuesta == false){
             notification('Error..!',response.message,'error');
           }else{
             $this.attr('id',response.id);
             $this.appendTo('.ocupados');
           }

         },
         error: function(e){
           unBlockPage();
           console.log(e.responseText);

         }
      });

    });

    $('.ocupados').on('click', 'a', function(){

       var $this = $(this);

       var id = $this.attr('id');
       var data = 'accion=quit&id='+id;

       $.ajax({
          beforeSend: function(){
            blockPage();
          },
          cache:false,
          type:'POST',
          dataType: 'json',
          url: 'ajax/tipodocumento_rolusuario.ajax.php',
          data: data,
          success: function(response){

            unBlockPage();

            if(response.respuesta == false){
              notification('Error..!',response.message,'error');
            }else{
              $this.attr('id','0');
              $this.appendTo('.disponibles');
            }

            console.log(response);

          },
          error: function(e){
            unBlockPage();
            console.log(e.responseText);

          }
       });
    });

});
