<?php
require_once "../controllers/usuario.php";
require_once "../models/usuario.php";

class DatatableAsignacionFirma  {

  public $request;

  public function dataListaUsuarios(){

    $columns = "u.id_usuario,
                CONCAT(u.nombres,' ',u.apellidos) fullname,
                u.username,
                r.descripcion,
                u.logo,
                u.tiene_certificado
                "; //columnas

    $mantenimiento = isset($this->request['mantenimiento']) && !empty($this->request['mantenimiento']) ? $this->request['mantenimiento'] : 0;

    $searchColumns = [
    "CONCAT(u.nombres,' ',u.apellidos)",
    "u.username",
    "r.descripcion"
    ]; //columnas donde generar la busqueda

    $orderColumns = [
      0 => 'u.id_usuario',
      1 => 'fullname',
      2 => 'u.username',
      3 => 'r.descripcion'
    ]; //columnas para ordenar

    $params = array(
      "table"=>"usuario u",
      "columns"=>$columns,
      "searchColumns"=>$searchColumns,
      "orderColumns" => $orderColumns,
      "join"=>array(
        ['rol_usuario r','r.id_rol','u.id_rol']
      ),
      "where"=>array(
        ['u.borrado','0'],
      ),
      "useDeleted"=>'0'
    );

    $options = Usuario::dataTable($this->request,$params,'options');
    $records = Usuario::dataTable($this->request,$params,'data');
    //$records = array();
    // $test = Controller::dataTable($this->request,$params,'');
    $data = [];

    //-------------------------------------------------

    if(count($records) > 0){

      $i =0;

      // procesando la data para mostrarla en el front
      $id = 0;
      $fullname = '';
      $username = '';
      $rol = '';
      $logo = '';
      $tiene_certificado = '';
      $text_certificado = '';

      foreach ($records as $row) {

        $i++;
        $id = $row[0];
        $fullname = $row[1];
        $username = $row[2];
        $rol = $row[3];
        $logo = $row[4];
        $tiene_certificado = $row[5];
        $text_certificado = $tiene_certificado == '1' ? 
          '<span class="label label-success"><i class="fas fa-check-circle"></i></span>':
          '<span class="label label-warnig"><i class="fas fa-exclamation-triangle"></i></span>';
        $button = '';

        if($mantenimiento == '1'){

          $button =  "
            <div class='btn-group'>
              <button title='Editar' class='btn btn-success btnEditar btn-sm' 
              fullname='".$fullname."' id='".$id."' username='".$username."' >
                <i class='fas fa-file-signature'></i>
              </button>
              <button title='Eliminar' class='btn btn-danger btnEliminar btn-sm' id='".$id."'><i class='fa fa-times'></i></button>
            </div>
          ";

        }

        $data[] = array(
          "DT_RowIndex" => $i,
          "fullname" => $fullname,
          "username" => $username,
          "rol" => $rol,
          "logo" => $logo,
          "tiene_certificado" => $text_certificado,
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
  $data = new DatatableAsignacionFirma();
  $data -> request = $_GET;
  $data -> dataListaUsuarios();
}
