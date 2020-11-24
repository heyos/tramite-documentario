<?php

require_once "../controllers/globales.php";
require_once "../controllers/tipo_documento.controller.php";
require_once "../models/tipo_documento.model.php";

class TipoDocumentoAjax {

  public $params;

  public function crearTipoDocAjax(){

    $params = $this->params;
    unset($params['accion']);
    unset($params['id']);

    $respuesta = TipoDocumentoController::crearTipoDocumentoCtr($params);

    echo json_encode($respuesta);

  }

  public function editarTipoDocAjax(){
    $params = $this->params;
    unset($params['accion']);

    $respuesta = TipoDocumentoController::editarTipoDocumentoCtr($params);

    echo json_encode($respuesta);
  }

  public function eliminarTipoDocAjax(){
    $params = $this->params;
    $params['table'] = "tipo_documento";
    $params['type'] = "logic";

    $respuesta = TipoDocumentoController::deleteItem($params);

    echo json_encode($respuesta);
  }

  public function mostrarTipoDocAjax(){
    $params = $this->params;
    $params['table'] = "tipo_documento";
    $params['where'] = array(
      ['id',$params['id']]
    );

    $respuesta = TipoDocumentoController::itemDetail($params);

    echo json_encode($respuesta);
  }
}

if(isset($_POST)){

  $item = new TipoDocumentoAjax();
  $item -> params = $_POST;

  switch ($_POST['accion']) {
    case 'add':
      $item -> crearTipoDocAjax();
      break;
    case 'edit':
      $item -> editarTipoDocAjax();
      break;
    case 'delete':
      $item -> eliminarTipoDocAjax();
      break;
    case 'show':
      $item -> mostrarTipoDocAjax();
      break;
    default:
      echo json_encode(array('respuesta' => false , 'message'=>'Error en tiempo de ejecucion.' ));
      break;
  }
}
