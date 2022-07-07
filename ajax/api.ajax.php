<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

require_once "../controllers/documentos.controller.php";
require_once "../models/documentos.model.php";
require_once "../models/documento_usuario.model.php";

class DatatableTipoDocumento  {

  public $request;

  public function dataTipoDocumento(){

    $status = false;
    $message = "";

    $request = $this->request;
    $length = array_key_exists('length',$request) ? $request['length'] : 15;
    $columns = "d.id,
                d.name_documento,
                c.nRutPer,
                d.codigo,
                d.google_id,
                d.fecha_carga_doc,
                DATE(d.fecha_crea)
                "; //columnas

    $where = array(
      ['d.old','1'],
      ['d.fecha_migracion IS NULL'],
      ['d.google_id IS NOT NULL']
    );

    $params = array(
      "table"=>"documento d",
      "columns"=>$columns,
      "join" => array (
        ['persona c','c.id','d.cliente_id'],
      ),
      'where' => $where,
      'start' => 0,
      'length' => $length,
      'order' => 'd.fecha_crea',
      'dir' => 'DESC'
    );

    $records = Model::all($params);
    $data = [];

    //-------------------------------------------------

    if(count($records) > 0){

      $i =0;

      // procesando la data para mostrarla en el front
      $id = 0;
      $name_docu = '';
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
      $xPasaporte ='';
      $google_id = "";
      $fechaSubida = "";

      foreach ($records as $row) {

        $i++;
        $id = $row[0];
        $name_documento = $row[1];
        $rutCliente = $row[2] ;
        $codigo = $row[3];
        $google_id = $row[4];
        $fechaSubida = $row[6];
        
        $data[] = array(
          "documento_id" => $id,
          "codigo" => $codigo,
          "rut_cliente" => $rutCliente,
          "name_documento" => $name_documento,
          "google_id" => $google_id,
          "fecha_carga_doc" => $fechaSubida
        );

      }

      $salida = array(
        'status' => true,
        'message' => "exito",
        'data' => $data
      );

    }else{
      $salida = array(
        'status' => false,
        'message' => "Error o no se encontro informacion",
        'data' => $data
      );
    }

    echo json_encode($salida);

  }

  public function updateData(){
    $status = false;
    $message = "";

    $params = $this->request;

    $params['table'] = 'documento';
    $arrError = [];

    if(array_key_exists('data',$params)){

      $data = json_decode($params['data'],true);

      foreach ($data as $item) {
        
        $local = $item;
        //unset($item[])
        $item['table'] = 'documento';
        $item['fecha_migracion'] = date('Y-m-d H:i:s');

        $res = DocumentoController::updateItem($item);

        if(!$res['respuesta']){
          $arrError[] = $local;
        }
      }

      $status = true;

    }else{
      $message = "Debes enviar un array de datos";
    }

    echo json_encode(array(
      'status' => $status,
      'message' => $message,
      'arrError' => $arrError
    ));
   }
}

if(isset($_REQUEST)){
  $data = new DatatableTipoDocumento();
  $data -> request = $_REQUEST;

  switch ($_REQUEST['action']) {
    case 'data':
      $data -> dataTipoDocumento();
      break;
    case 'update':
      $data -> updateData();
      break;
    default:
      echo json_encode(array(
      'status' => false,
      'message' => "No se puede ejecutar la aplicacion",
      'arrError' => []
    ));
      break;
  }
  
}
