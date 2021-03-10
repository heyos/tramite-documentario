var form = '#formAsigFirma';
var modalReg = '#modalReg';
var modalLista = '#modalLista';

init.push(function () {

   var table = $('.tablaAsignacionFirma').DataTable( {
      "ajax": {
          url:"ajax/datatable-asignacionFirma.ajax.php",
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

    $('#DataTables_Table_0_wrapper .table-caption').text('Asignacion de Firma');
  	$('#DataTables_Table_0_wrapper .dataTables_filter input').attr('placeholder', 'Buscar...');

    $('.btn-registrar').click(function(){
      $(modalReg+' #myModalLabel').text('Asignar Firma');
      resetFormularioNew(form);
      $(form+' input[name=id]').val('0');
      $(modalReg).modal('show');

    });
    
});