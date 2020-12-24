<?php

require_once "controller.php";

class TipoDocumentoController extends Controller {

  static function crearTipoDocumentoCtr($params){

    $mensajeError = "No se puede ejecutar la aplicacion";
    $respuestaOk = false;

    $table = "tipo_documento";
    $paramsVerificar = array(
      'where'=>array(['descripcion',$params['descripcion']])
    );

    $dataVerificar = TipoDocumentoModel::firstOrAll($table,$paramsVerificar,'first');

    if(!empty($dataVerificar)){
      $mensajeError = "Registro existente";
    }else{
      $respuesta = TipoDocumentoModel::create($table,$params);

      if($respuesta != 0){
        $respuestaOk = true;
        $mensajeError = 'Registro creado exitosamente.';
      }else{
        $mensajeError = 'Ocurrio un error al crear el registro.';
      }
    }

    $salida = array(
      'respuesta'=>$respuestaOk,
      'message'=>$mensajeError
    );

    return $salida;

  }

  static function editarTipoDocumentoCtr($params){

    $mensajeError = "No se puede ejecutar la aplicacion";
    $respuestaOk = false;

    $table = "tipo_documento";
    $paramsVerificar = array(
      'where'=>array(
        ['descripcion',$params['descripcion']],
        ['id','<>',$params['id']]
      )
    );

    $dataVerificar = TipoDocumentoModel::firstOrAll($table,$paramsVerificar,'first');

    if(!empty($dataVerificar)){
      $mensajeError = "Registro existente";
    }else{
      $respuesta = TipoDocumentoModel::update($table,$params);

      if($respuesta != 0){
        $respuestaOk = true;
        $mensajeError = 'Registro actualizado exitosamente.';
      }else{
        $mensajeError = 'Ocurrio un error al actualizar el registro.';
      }

    }

    $salida = array(
      'respuesta'=>$respuestaOk,
      'message'=>$mensajeError
    );

    return $salida;
  }

  public static function allData(){
    $contenidoOk = [];
    $respuestaOk = false;

    $table = "tipo_documento";
    $params = array(
      'table'=> $table
    );

    $data = TipoDocumentoModel::all($params);

    if(count($data) > 0){
      $contenidoOk = $data;
      $respuestaOk = true;
    }

    $salida = array(
      'contenido'=>$contenidoOk,
      'respuesta'=>$respuestaOk
    );

    return $salida;
  }


}
