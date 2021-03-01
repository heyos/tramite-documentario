<?php

class Config {

	public static function rutas(){

		$out = 'DEV'; //TEST - DEV - PROD
		
		$rootFolder = array(
			'DEV' => '../../files-firma/',
			'TEST' => '../files-firma/',
			'PROD' => ''
		);

		$rutas = array(
			'certificado' => $rootFolder[$out].'certificados',
			'documento' => $rootFolder[$out].'documentos'
		);

		return $rutas;
	}
}