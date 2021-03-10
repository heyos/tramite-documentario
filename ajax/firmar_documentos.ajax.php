<?php

require_once "../vendor/autoload.php";
require_once "../controllers/firma_electronica.controller.php";
require_once "../controllers/globales.php";


require_once "../controllers/documentos.controller.php";
require_once "../controllers/documento_usuario.controller.php";
require_once "../controllers/usuario.php";

require_once "../models/documento_usuario.model.php";
require_once "../models/documentos.model.php";
require_once "../models/usuario.php";

class FirmarDocumentoAjax{

	public $params;

	public function generarFirmaAjax(){

		session_start();

		$params = $this->params;
		$params['user'] = 'hreyes'; //$_SESSION['user'];
		$params['user_id'] = $_SESSION['usuario_id'];

		$respuesta = DocumentoController::firmarDocumento($params);
		
		echo json_encode($respuesta);
		
	}
}

if(isset($_POST['accion'])){

	$a = new FirmarDocumentoAjax();
	$a -> params = $_POST;

	switch ($_POST['accion']) {
		case 'firmar':
			$a -> generarFirmaAjax();
			break;
		
		case 'lote':
			
			break;
		default:
			# code...
			break;
	}
}