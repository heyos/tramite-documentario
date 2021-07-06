<?php

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

require_once "../helpers/helper.php";

class ConsultaExterna {

	public $params;

	public function verificarDomainAjax(){

		$response = false;
		$message = "Dominio no permitido para este modulo";

		$origin = $this->params['origin'];

		if(listDomainAccess($origin)){

			$response = true;
			$message = "exito";
		}

		$salida = array(
			'response' => $response,
			'message' => $message
		);

		echo json_encode($salida);

	}
}

if(isset($_POST['accion'])){

	$a = new ConsultaExterna();
	$a -> params =  $_POST;

	switch ($_POST['accion']){

		case 'verificar' :
			$a -> verificarDomainAjax();
			break;

		default :

			echo json_encode(
				array(
					'response' => false,
					'message' => 'Accion no disponible'
				)
			);

			break;
	}
}