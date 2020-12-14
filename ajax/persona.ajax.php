<?php
require_once '../controllers/globales.php';
require_once '../controllers/persona.php';
require_once '../models/persona.php';

class PersonaAjax {

  public $request;

  public function getDataPersonaAjax(){

    $type = $this->request['type'] == 'paciente' ? 'n' : 'j' ;
    $params = array(
      'table'=>'persona',
      'where'=>[['nRutPer',$this->request['rut']],['xTipoPer',$type]]
    );
    $respuesta = Persona::itemDetail($params);

    if($respuesta['respuesta']){
      $full = '';
      $data = $respuesta['data'];
      switch ($this->request['type']) {
        case 'paciente':
          $full = $data['xNombre'].' '.$data['xApePat'].' '.$data['xApeMat'];
          break;
        case 'cliente':
          $full = $data['xRazSoc'];
          break;
      }

      $respuesta['data']['fullname'] = $full;
    }


    echo json_encode($respuesta);
  }
}

if(isset($_POST['accion'])){

  $a = new PersonaAjax();
  $a -> request = $_POST;

  switch ($_POST['accion']) {
    case 'search':
      $a -> getDataPersonaAjax();
      break;

    default:
      # code...
      break;
  }
}
