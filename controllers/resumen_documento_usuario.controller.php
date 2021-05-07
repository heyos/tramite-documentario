<?php

require_once "controller.php";

class ResumenDocumentoUsuarioController extends Controller {

	public static function columnName($estado){
		$column = '';
		switch ($estado) {
			case '0':
				$column = 'pendientes';
				break;
			case '1':
				$column = 'proceso_de_firma';
				break;
			case '2':
				$column = 'firmado_todos';
				break;
			case '3':
				$column = 'rechazados';
				break;
			
			default:
				$column = 'pendientes';
				break;
		}

		return $column;

	}

	public static function detalleResumen($usuario_id){

		$table = 'resumen_documento_usuario';

		$where = array(
			'where' => array(
				['usuario_id',$usuario_id]
			),
			'useDeleted' => '0'
		);

		$datos = ResumenDocumentoUsuarioModel::firstOrAll($table,$where,'first');

		return $datos;
	}

	public static function crearResumen($params,$type='add'){

		$respuestaOk = false;
      	$mensajeError = "No se puede ejecutar la aplicacion";
      	$contenidoOk = [];

		$table = "resumen_documento_usuario";
		$column = self::columnName($params['estado']);		

		$num = 0;

		$datos = self::detalleResumen($params['usuario_id']);

		if(!empty($datos)){

			$num = $datos[$column];

			if($type == 'quit'){
				$num -=1;
				$num = $num > 0 ? $num : 0;
			}else{
				$num += 1;
			}
			
		}else{
			$num = $type == 'quit' ? 0 : 1;
		}

		$descripcion = $column.' | documento_id:'.$params['documento_id'];
		$data = array(
			$column => $num,
			'fecha_modificacion' => date('Y-m-d'),
			'descripcion' => $column,
			'usuario_id' => $params['usuario_id'],
			'where' => array(
				['usuario_id' , $params['usuario_id']]
			),
			'useDeleted' => '0'
		);

		$respuesta = ResumenDocumentoUsuarioModel::createOrUpdate($table,$data);

		if($respuesta > 0){
			$respuestaOk = true;
			$mensajeError = "Se completo el proceso correctamente";
		}

		$salidaJson = array('respuesta'=>$respuestaOk,
                          	'mensaje'=>$mensajeError,
                          	'data'=>$contenidoOk);

      	return $salidaJson;

	}

	public static function updateResumen($params){

		$mensajeError = '';
		$respuestaOk = false;

		$estado = 0;
		$totalFirmantes = 0;
		$totalFirmas = 0;
		
		$where_usuarios = array(
			'where' => array(
				['documento_id',$params['documento_id']]
			)
		);

		$usuarios = DocumentoUsuarioModel::firstOrAll('documento_usuario',$where_usuarios,'all');		

		if(count($usuarios) > 0){

			$where_documento = array(
				'where' => array(
					['id',$params['documento_id']]
				)
			);

			$documento = DocumentoModel::firstOrAll('documento',$where_documento,'first');
			$estado = !empty($documento) ? $documento['estado_firma'] : 0;

			if($estado == 1){

				$whereFirmantes = array(
					'columns' => 'COUNT(*) AS cantidad',
					'table' => 'documento_usuario',
					'where' => array(
						['documento_id',$params['documento_id']],
					)
				);
				$data = DocumentoUsuarioModel::all($whereFirmantes);
				$totalFirmantes = count($data) > 0 ? $data[0]['cantidad'] : 0;
				
				$whereFirmantes['where'][] = ['firmado','1'];
				$dataFirmas = DocumentoUsuarioModel::all($whereFirmantes);
				$totalFirmas = count($data) > 0 ? $dataFirmas[0]['cantidad'] : 0;

				$estado = $totalFirmantes == $totalFirmas ? 2 : $estado;

			}

			$estado_old = $params['estado_old'];
			$column = self::columnName($estado);
			$column_old = self::columnName($estado_old);
			
			$i = 0;

			foreach ($usuarios as $item) {

				$resumen = self::detalleResumen($item['usuario_id']);

				$cantidad = !empty($resumen) ? $resumen[$column] + 1 : 0;
				$cantidad_old = !empty($resumen) ? $resumen[$column_old] - 1 : 0;

				$cantidad_old = $cantidad_old > 0 ? $cantidad_old : 0;
				
				$descripcion = $column.' | documento_id:'.$params['documento_id'];
				$update = array(
					$column_old => $cantidad_old,
					$column => $cantidad,
					'descripcion' => $descripcion,
					'fecha_modificacion' => date('Y-m-d'),
					'where' => array(
						['usuario_id',$item['usuario_id']]
					),
					'useDeleted' => '0'
				);

				$resumen = ResumenDocumentoUsuarioModel::createOrUpdate('resumen_documento_usuario',$update);			

				if($resumen > 0){
					$i++;
				}
			}
				
			$respuestaOk = $i == count($usuarios) ? true : false;
			$mensajeError = $respuestaOk ? 'Se actualizo' : $mensajeError;
		}			

		$salidaJson = array(
			'respuesta' => $respuestaOk,
			'mensaje' => $mensajeError,
			'data' => $estado.' firmas:'.$totalFirmas.' firmantes:'.$totalFirmantes
		);

		return $salidaJson;

	}

}