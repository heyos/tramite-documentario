<?php

class EstadoDocumentoController {

	public static function allData(){
		$respuestaOk = true;
		//0:pendiente | 1:en proceso de firma | 2: firmado por todos | 3:cancelado
		$contenidoOk = array(
			array(
				'id'=>'0',
				'descripcion' => 'Pendiente'
			),
			array(
				'id'=>'1',
				'descripcion' => 'En proceso de firma'
			),
			array(
				'id'=>'2',
				'descripcion' => 'Firmado por todos'
			),
			array(
				'id'=>'3',
				'descripcion' => 'Cancelado'
			),
		);

		$salida = array(
			'contenido' => $contenidoOk,
			'respuesta' => $respuestaOk
		);

		return $salida;
	}
	
}