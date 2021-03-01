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

  public function crearPersonaAjax(){
    
    $params = $this->request;
    $params['outType'] = 'return';
    $params['tabla'] = 'persona';
    $respuesta = Persona::nuevoRegistroCtr($params);

    $persona = [];

    if($respuesta['respuesta']){

      $where = array(
        'table' => 'persona',
        'where' => array(
          ['nRutPer',$this->request['nRutPer']],['xTipoPer',$this->request['xTipoPer']]
        )
      );

      $persona = Persona::itemDetail($where);

      if($persona['respuesta']){

        $full = '';
        $data = $persona['data'];
        switch ($this->request['xTipoPer']) {
          case 'n':
            $full = $data['xNombre'].' '.$data['xApePat'].' '.$data['xApeMat'];
            break;
          case 'j':
            $full = $data['xRazSoc'];
            break;
        }

        $persona['data']['fullname'] = $full;

      }
    }

    echo json_encode(array(
        'respuesta' => $respuesta['respuesta'],
        'mensaje' => $respuesta['mensaje'],
        'data' => $persona['data']
      )
    );

  }
}

if(isset($_POST['accion'])){

  $a = new PersonaAjax();
  $a -> request = $_POST;

  switch ($_POST['accion']) {
    case 'search':
      $a -> getDataPersonaAjax();
      break;
    case 'add':
      $a -> crearPersonaAjax();
      break;
    default:
      # code...
      break;
  }
}
