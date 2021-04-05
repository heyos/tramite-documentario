<?php
require_once "../controllers/documentos.controller.php";
require_once "../models/documentos.model.php";

class DatatableTipoDocumento  {

  public $request;

  public function dataTipoDocumento(){

    $columns = "d.id,
                d.cliente_id,
                d.paciente_id,
                d.tipoDocumento_id,
                d.name_documento,
                d.estado_firma,
                c.nRutPer,
                c.xRazSoc,
                p.nRutPer,
                CONCAT(p.xNombre,' ',p.xApePat,' ',p.xApeMat) as paciente,
                tp.descripcion,
                DATE(d.fecha_crea),
                d.codigo,
                d.orden_firmante
                "; //columnas

    $mantenimiento = isset($this->request['mantenimiento']) && !empty($this->request['mantenimiento']) ? $this->request['mantenimiento'] : 0;

    $searchColumns = [
      'CONCAT(p.xNombre," ",p.xApePat," ",p.xApeMat)',
      'tp.descripcion',
      'c.xRazSoc',
      'c.nRutPer',
      'p.nRutPer',
      'd.codigo'
    ]; //columnas donde generar la busqueda

    $orderColumns = [
      0 => 'd.id',
      1 => 'c.nRutPer',
      2 => 'c.xRazSoc',
      3 => 'p.nRutPer',
      4 => 'paciente',
      5 => 'tp.descripcion'
    ]; //columnas para ordenar

    $params = array(
      "table"=>"documento d",
      "columns"=>$columns,
      "searchColumns"=>$searchColumns,
      "orderColumns" => $orderColumns,
      "join" => array (
        ['persona c','c.id','d.cliente_id'],
        ['persona p','p.id','d.paciente_id'],
        ['tipo_documento tp','tp.id','d.tipoDocumento_id']
      ),
      'order' => 'd.fecha_crea',
      'dir' => 'DESC'
    );

    $options = DocumentoController::dataTable($this->request,$params,'options');
    $records = DocumentoController::dataTable($this->request,$params,'data');
    //$records = array();
    // $test = Controller::dataTable($this->request,$params,'');
    $data = [];

    //-------------------------------------------------

    if(count($records) > 0){

      $i =0;

      // procesando la data para mostrarla en el front
      $id = 0;
      $rutCliente = '' ;
      $nomCliente = '' ;
      $rutPaciente = '' ;
      $nomPaciente = '' ;
      $tipoDocumento = '';
      $descripcion = "";
      $estado = '';
      $labelEstado = '';
      $fechaCrea = '';
      $codigo = '';
      $ordenFirma = 0;

      foreach ($records as $row) {

        $i++;
        $id = $row[0];
        $estado = $row[5];
        $rutCliente = $row[6] ;
        $nomCliente = $row[7] ;
        $rutPaciente = $row[8] ;
        $nomPaciente = $row[9] ;
        $tipoDocumento = $row[10];
        $fechaCrea = date('d/m/Y',strtotime($row[11]));
        $codigo = $row[12];
        $ordenFirma = $row[13];
        $button = '';

        switch ($estado) {
          case '0':
            $css = "label-warning";
            $txt = 'Pendiente';

            break;
          case '1':
            $css = "label-info";
            $txt = 'En proceso de firma';

            break;
          case '2':
            $css = "label-success";
            $txt = 'Firmado por todos';
            break;
          case '3':
            $css = "label-danger";
            $txt = 'Cancelado';
            break;
          default:
            
            break;
        }

        $labelEstado = '<span class="label '.$css.' ">'.$txt.'</span>';

        if($mantenimiento == '1'){

          $button =  "
            <div class='btn-group'>
          ";

          if($ordenFirma == 1){
            $button .= "
              <button title='Editar' class='btn btn-warning btnEditar btn-sm' id='".$id."'><i class='fas fa-edit'></i></button>
            ";
          }

          $button .= "
              <button title='Eliminar' class='btn btn-danger btnEliminar btn-sm' id='".$id."'><i class='fa fa-times'></i></button>
            </div>
          ";
        }

        $data[] = array(
          "DT_RowIndex" => $i,
          "codigo" => $codigo,
          "rutCliente" => $rutCliente,
          "nomCliente" => $nomCliente,
          "rutPaciente" => $rutPaciente,
          "nomPaciente" => $nomPaciente,
          "tipoDocumento" => $tipoDocumento,
          "estado" => $labelEstado,
          "fechaCrea" => $fechaCrea,
          "action" => $button
        );

      }

    }else{
      // $var = '';

      // $data[] = array(
      //     "DT_RowIndex" => '',
      //     "codigo" => '',
      //     "proveedor_name" => $var,
      //     "total" =>'',
      //     "fecha_hora" => '',
      //     "action" => ''
      //   );
    }

    $options['data'] = $data;

    echo json_encode($options);

  }
}

if(isset($_GET)){
  $data = new DatatableTipoDocumento();
  $data -> request = $_GET;
  $data -> dataTipoDocumento();
}
