<?php

class ResumenDocumentoUsuarioAjax {

	public $params;

	public function generarSesionEstadoAjax(){

		$respuestaOk = false;
		$mensajeError = 'no disponible';

	    $params = $this->params;
	    $estado = isset($params['term']) ? $params['term']: '';

	    if($estado !=''){
	      	session_start();
	      	$_SESSION['estadoDocumento'] = $estado;

	      	$respuestaOk = true;
	      	$mensajeError = 'se genero exitosamente';
	    }

	    $salidaJson = array(
	    	'respuesta' => $respuestaOk,
	    	'mensaje' => $mensajeError
	    );

	    echo json_encode($salidaJson);
  	}

}

if(isset($_POST)){

	$accion = isset($_POST['accion']) ? $_POST['accion'] : '';

	$a = new ResumenDocumentoUsuarioAjax();
	$a -> params = $_POST;

	switch ($accion) {
		case 'generar':
			
			$a -> generarSesionEstadoAjax();

			break;
		
		default:
			$salidaJson = array(
		    	'respuesta' => 'false',
		    	'mensaje' => 'accion no disponible'
		    );

		    echo json_encode($salidaJson);
			break;
	}
}