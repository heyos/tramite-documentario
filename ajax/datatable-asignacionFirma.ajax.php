<?php
require_once "../controllers/tipo_documento.controller.php";
require_once "../models/tipo_documento.model.php";

class DatatableTipoDocumento  {

  public $request;

  public function dataTipoDocumento(){

    $columns = "id,
                descripcion
                "; //columnas

    $mantenimiento = isset($this->request['mantenimiento']) && !empty($this->request['mantenimiento']) ? $this->request['mantenimiento'] : 0;

    $searchColumns = ['descripcion']; //columnas donde generar la busqueda
    $orderColumns = [
      0 => 'id',
      1 => 'descripcion'
    ]; //columnas para ordenar

    $params = array(
            "table"=>"tipo_documento",
            "columns"=>$columns,
            "searchColumns"=>$searchColumns,
            "orderColumns" => $orderColumns,
    );

    $options = TipoDocumentoController::dataTable($this->request,$params,'options');
    $records = TipoDocumentoController::dataTable($this->request,$params,'data');
    //$records = array();
    // $test = Controller::dataTable($this->request,$params,'');
    $data = [];

    //-------------------------------------------------

    if(count($records) > 0){

      $i =0;

      // procesando la data para mostrarla en el front
      $id = 0;
      $descripcion = 0;

      foreach ($records as $row) {

        $i++;
        $id = $row['id'];
        $descripcion = $row['descripcion'];
        $button = '';

        if($mantenimiento == '1'){

          $button =  "
                <div class='btn-group'>
                  <button title='Editar' class='btn btn-warning btnEditar btn-sm' id='".$row["id"]."'><i class='fas fa-edit'></i></button>
                  <button title='Agregar Roles' class='btn btn-info btnAddRol btn-sm' id='".$row["id"]."' descripcion='".$descripcion."' ><i class='fas fa-bars'></i></button>
                  <button title='Eliminar' class='btn btn-danger btnEliminar btn-sm' id='".$row["id"]."'><i class='fa fa-times'></i></button>
                </div>
          ";

        }

        $data[] = array(
          "DT_RowIndex" => $i,
          "descripcion" => $descripcion,
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
