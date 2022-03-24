<?php
require_once '../controllers/globales.php';
require_once '../controllers/persona.php';
require_once '../models/persona.php';

class PersonaAjax {

  public $request;

  public function getDataPersonaAjax(){

    $request = $this->request;
    $type = $this->request['type'] == 'paciente' ? 'n' : 'j' ;
    $params = array(
      'table'=>'persona',
      'where'=>[['xTipoPer',$type]]
    );

    if($type == 'n'){

      if($request['nTipPerDesc'] == 'Nacional'){
        $params['where'][] = ['nRutPer',$request['rut']];
      }else{
        $params['where'][] = ['xPasaporte',$request['value']];
      }

    }else{
      $params['where'][] = ['nRutPer',$request['rut']];
    }

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

      $type = $params['xTipoPer'];

      $where = array(
        'table' => 'persona',
        'where' => array(
          ['xTipoPer',$type]
        )
      );

      if($type == 'n'){

        if($params['nTipPerDesc'] == 'Nacional'){
          $where['where'][] = ['nRutPer',$params['nRutPer']];
        }else{
          $where['where'][] = ['xPasaporte',$params['xPasaporte']];
        }

      }else{
        $where['where'][] = ['nRutPer',$params['nRutPer']];
      }

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
        'data' => $respuesta['respuesta'] ? $persona['data'] : []
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
