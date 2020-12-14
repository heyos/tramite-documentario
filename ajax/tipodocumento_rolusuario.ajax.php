<?php

require_once "../controllers/globales.php";
require_once "../controllers/tipodocumento_rolusuario.controller.php";
require_once "../models/tipodocumento_rolusuario.model.php";
require_once "../models/rolUsuario.php";

class TipoDocumentoRolUsuarioAjax {

  public $params;

  public function addRolList(){

    $params = $this->params;
    unset($params['accion']);

    $params['tabla'] = 'tipodocumento_rolusuario';
    $respuesta = TipoDocumentoRolUsuarioController::newItem($params);

    echo json_encode($respuesta);
  }

  public function quitRolList(){
    $params = $this -> params;
    unset($params['accion']);

    $params['table'] = 'tipodocumento_rolusuario';
    $params['type'] = 'logic';

    $respuesta = TipoDocumentoRolUsuarioController::deleteItem($params);

    echo json_encode($respuesta);

  }

  public function lista(){

    $params = $this->params;
    $respuesta = TipoDocumentoRolUsuarioController::listaTipoDocumentoRol($params);

    $idTipoDoc = $params['tipoDocumento_id'];
    $disponibles = '';

    if(count($respuesta['disponibles']) > 0){
      foreach ($respuesta['disponibles'] as $id => $disponible) {
        $disponibles .= '
          <a href="#" tipoDocumento_id = "'.$idTipoDoc.'" id_rol = "'.$id.'" class="list-group-item">
            <strong>'.$disponible.'</strong>
          </a>
        ';
      }
    }

    $ocupados = '';

    if(count($respuesta['ocupados']) > 0){
      foreach ($respuesta['ocupados'] as $id => $ocupado) {
        $ocupados .= '
          <a href="#" type="button" tipoDocumento_id = "'.$idTipoDoc.'" id_rol= "'.$ocupado['rolUsuario_id'].'" id = "'.$id.'" class="list-group-item">
            <strong>'.$ocupado['descripcion'].'</strong>
          </a>
        ';
      }
    }

    $salidaJson = array(
      'disponibles' => $disponibles,
      'ocupados' => $ocupados
    );

    echo json_encode($salidaJson);

  }

}

if(isset($_POST['accion'])){

  $item = new TipoDocumentoRolUsuarioAjax();
  $item -> params = $_POST;

  switch ($_POST['accion']) {
    case 'add':
      $item -> addRolList();
      break;
    case 'quit':
      $item -> quitRolList();
      break;

    case 'list':
      $item -> lista();
      break;
    default:

      break;
  }
}
