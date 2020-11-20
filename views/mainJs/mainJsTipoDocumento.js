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
          "sLengthMenu":     "Mostrar _MENU_ registros",
          "sZeroRecords":    "No se encontraron resultados",
          "sEmptyTable":     "Ningún dato disponible en esta tabla",
          "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_",
          "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0",
          "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
          "sInfoPostFix":    "",
          "sSearch":         "Buscar:",
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

});
