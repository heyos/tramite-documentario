<?php

class DocumentoAjax{

  public $params;

  public function listAptosFirma(){
    $data = '';
    $mensajeError = 'No se puede ejecutar la aplicacion';
    $respuestaOk = false;

    $lista = $this->params['aptos'] != '' ? json_decode($this->params['aptos'],true): array();
    $user = json_decode($this->params['user'],true);
    $orden = $this->params['orden'];

    $lista[$orden][] = $user;
    ksort($lista); //ORDENAMOS ARRAY PARA MANTENER ORDEN SEGUN EL ROL

    if(count($lista) > 0){
      foreach ($lista as $key => $grupo) {
        foreach ($grupo as $usuario) {
          $data .='
            <a href="#" class="list-group-item"
              id_rol= "'.$usuario['rol_id'].'"
              orden_por_rol="'.$usuario['orden'].'"
              usuario_id="'.$usuario['usuario_id'].'"
              fullname="'.$usuario['fullname'].'"
              rol_name="'.$usuario['rol_name'].'"
            >
              <strong>'.$usuario['fullname'].'</strong>
            </a>
          ';
        }
      }
    }

    echo json_encode(array(
      'lista' =>$lista ,
      'contenido'=>$data,
      'mensaje'=>$mensajeError
    ));

  }

}

if(isset($_POST)){

  $a = new DocumentoAjax();
  $a -> params = $_POST;

  switch ($_POST['accion']) {
    case 'lista_aptos':
      $a -> listAptosFirma();
      break;

    default:
      // code...
      break;
  }
}
