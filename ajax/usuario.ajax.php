<?php

require_once "../controllers/globales.php";
require_once "../models/usuario.php";
require_once "../controllers/usuario.php";

class UsuarioAjax {

  public $params;

  public function listUserPerRolAjax(){
    $data = '';

    $idRol = $this->params['idRol'];
    $rolName = $this->params['rolName'];
    $orden = $this->params['orden'];
    $usuarios = Usuario::listUserPerRol($idRol);
    $usuariosAptosFirma = $this->params['aptos'] !='' ? json_decode($this->params['aptos'],true):array();
    $listaVerificar = count($usuariosAptosFirma) > 0 && array_key_exists($orden, $usuariosAptosFirma) ? $usuariosAptosFirma[$orden] : array();

    if($usuarios['respuesta']){
      $band = false;

      foreach ($usuarios['data'] as $usuario) {

        if(count($listaVerificar) > 0){

          foreach ($listaVerificar as $key => $datos) {
            $band = $datos['usuario_id'] == $usuario['id_usuario'] ? true:false;
            if($band){
              break;
            }
          }
        }

        if($band){
          continue;
        }

        $full = $usuario['nombres'].' '.$usuario['apellidos'];
        $data .='
          <a href="#" id_rol= "'.$idRol.'" orden_por_rol="'.$orden.'" usuario_id="'.$usuario['id_usuario'].'" fullname="'.$full.'" rol_name="'.$rolName.'"
            class="list-group-item">
            <strong>'.$full.'</strong>
          </a>
        ';
      }

    }

    echo json_encode(array(
      'usuarios'=>$data
    ));
  }

}

if(isset($_POST)){

  $a = new UsuarioAjax();
  $a -> params = $_POST;

  switch ($_POST['accion']) {
    case 'listPerRol':
      $a->listUserPerRolAjax();
      break;

    default:
      // code...
      break;
  }
}
