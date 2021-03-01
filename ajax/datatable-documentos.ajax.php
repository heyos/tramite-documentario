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
                tp.descripcion
                "; //columnas

    $mantenimiento = isset($this->request['mantenimiento']) && !empty($this->request['mantenimiento']) ? $this->request['mantenimiento'] : 0;

    $searchColumns = [
      'CONCAT(p.xNombre," ",p.xApePat," ",p.xApeMat)',
      'tp.descripcion',
      'c.xRazSoc',
      'c.nRutPer',
      'p.nRutPer',
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

      foreach ($records as $row) {

        $i++;
        $id = $row[0];
        $rutCliente = $row[6] ;
        $nomCliente = $row[7] ;
        $rutPaciente = $row[8] ;
        $nomPaciente = $row[9] ;
        $tipoDocumento = $row[10];
        $button = '';

        if($mantenimiento == '1'){

          $button =  "
                <div class='btn-group'>
                  <button title='Editar' class='btn btn-warning btnEditar btn-sm' id='".$id."'><i class='fas fa-edit'></i></button>
                  <button title='Eliminar' class='btn btn-danger btnEliminar btn-sm' id='".$id."'><i class='fa fa-times'></i></button>
                </div>
          ";
        }

        $data[] = array(
          "DT_RowIndex" => $i,
          "rutCliente" => $rutCliente,
          "nomCliente" => $nomCliente,
          "rutPaciente" => $rutPaciente,
          "nomPaciente" => $nomPaciente,
          "tipoDocumento" => $tipoDocumento,
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
