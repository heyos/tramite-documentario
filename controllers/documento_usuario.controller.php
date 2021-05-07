<?php

require_once "controller.php";

class DocumentoUsuarioController extends Controller {

	static public function historialUsuariosFirma($params){

		if(array_key_exists('type',$params) && $params['type']=='codigo'){

			$where = array(
				['d.codigo',$params['codigo']]
			);			

		}else{
			$where = array(
				['du.documento_id',$params['documento_id']]
			);
		}

		$respuestaOk = false;
		$mensajeError = "No se puede ejecutar la aplicacion";
		$contenidoOk = "";

		$columns = "
			du.firmado,
			du.fecha_firma,
			CONCAT(u.nombres,' ',u.apellidos),
			u.id_rol,
			r.descripcion
		";

		$data = array(
			"table"=>"documento_usuario du",
			"columns"=>$columns,
			"join" => array(
				['usuario u','u.id_usuario','du.usuario_id'],
				['rol_usuario r','r.id_rol','u.id_rol'],
				['documento d','d.id','du.documento_id']
			),
			"where" => $where
		);

		$usuariosFirma = DocumentoUsuarioModel::all($data);

		$respuestaOk = count($usuariosFirma) > 0 ? true : false;

		$salidaJson = array(
			'respuesta' => $respuestaOk,
			'mensaje' => $mensajeError,
			'contenido' => $contenidoOk,
			'data' => $usuariosFirma
		);

		return $salidaJson;

	}

	static public function generarContenidoFirmantes($usuarios){

		$contenido = "";

		$cssLabel = '';
		$icon = '';

		foreach ($usuarios as $usuario) {

			$cssLabel = $usuario[0] == '1' ? 'label-success':'label-warning';
			$icon = $usuario[0] == '1' ? 'fa-check':'fa-clock-o';
			$fecha_firma = $usuario[1] != '' ? date('d/m/Y',strtotime($usuario[1])) : '';
			
			$contenido .= '
				<div class="row">
	                <div class="col-sm-5 text-center">
	                    '.$usuario[2].'
	                </div>
	                <div class="col-sm-2 text-center">
	                    <label class="label '.$cssLabel.'">
	                        <i class="fa '.$icon.'"></i> 
	                    </label>
	                </div>
	                <div class="col-sm-5 text-center">
	                    '.$fecha_firma.'
	                </div>
	            </div>
			';
		}

		return $contenido;
	}

	public static function generarContenidoFirmantesConsulta($usuarios){
		
		$contenido = "";

		$cssLabel = '';
		$icon = '';

		foreach ($usuarios as $usuario) {

			$css = $usuario[0] == '1' ? 'bg-success':'bg-warning';
			$cssText = $usuario[0] == '1' ? 'text-success':'text-warning';
			$icon = $usuario[0] == '1' ? 'fa-check':'fa-clock-o';
			$fecha_firma = $usuario[1] != '' ? date('d/m/Y',strtotime($usuario[1])) : '--/--/----';
			$rol_descripcion = strtoupper($usuario[4]);
			$user = strtoupper($usuario[2]);
			
			$contenido .= '
				<div class="tl-entry temp">
		            <div class="tl-time">
		                '.$fecha_firma.'
		            </div>
		            <div class="tl-icon '.$css.'"><i class="fa '.$icon.'"></i></div>
		            <div class="panel tl-body">
		                <h4 class="'.$cssText.'"><b>'.$rol_descripcion.'</b></h4>
		                '.$user.'
		            </div>
		        </div>
			';
		}

		return $contenido;
	}


}