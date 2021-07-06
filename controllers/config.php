<?php

class Config {

	public static function rutas(){

		$out = 'DEV'; //TEST - DEV - PROD
		
		$rootFolder = array(
			'DEV' => '../../files-firma/',
			'TEST' => '../files-firma/',
			'PROD' => '../../../../files-firma/'
		);

		$rutas = array(
			'certificado' => $rootFolder[$out].'certificados',
			'documento' => $rootFolder[$out].'documentos',
			'qr' => $rootFolder[$out].'qr',
			'google' => $rootFolder[$out].'google',
			'download' => $rootFolder[$out].'download'
		);

		return $rutas;
	}

}

