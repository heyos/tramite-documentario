<?php

require_once "controller.php";

class DocumentoController extends Controller {

	public static function crearDocumento($params){

		$respuestaOk = false;
		$message = "";
		$data = "";

		$estadoFirma = array_key_exists('name_documento', $params) ? 
						$params['name_documento'] != '' ? '1' : '0'
						: '0' ; //1:en proceso de firma - 0:pendiente
		$params['estado_firma'] = $estadoFirma;

		$usuariosFirma = array_key_exists('lista_usuarios_firma', $params) ? json_decode($params['lista_usuarios_firma'],true) : [];

		if(count($usuariosFirma) > 0){

			$data = $params;

			$respuesta = DocumentoModel::create('documento',$params);

			if($respuesta != 0){

				$idDocumento = $respuesta;
				$arr = [];

				//guardamos usuarios aptos para firma
				foreach ($usuariosFirma as $lista) {
					foreach ($lista as $usuario) {
						$arr['documento_id'] = $idDocumento;
						$arr['usuario_id'] = $usuario['usuario_id'];
						$arr['orden'] = $usuario['orden'];
						$arr['usuario_crea'] = $params['usuario_crea'];
						$arr['fecha_crea'] = $params['fecha_crea'];

						$res = DocumentoUsuarioModel::create('documento_usuario',$arr);

						if($res == 0){
							$message .= $usuario['fullname'].'<br>';
						}
					}
				}

				$respuestaOk = true;

				if($message !=''){
					$message = "Se guardo exitosamente el documento.<br><b>Pero hubo error al guardar estos usuarios:<b><br>".$message;
				}else{
					$message = "Se guardo exitosamente el documento.";
				}

				$data = $usuariosFirma;

			}else{
				$message = "Error al guardar el documento.";
			}

		}else{
			$message = 'Debe seleccionar almenos un usuario para firmar.';
		}

		return array(
			'respuesta'=>$respuestaOk,
			'mensaje'=>$message,
			'data'=>$data
		);
	}

	static public function editarDocumento($params){

	}

	static public function detalleDocumento($params){

		$data = [];
		$respuestaOk = false;
		$message = "";
		$contenidoAptos = '';

		$id = $params['id'];

		$columns = "d.id,
                d.cliente_id,
                d.paciente_id,
                d.tipoDocumento_id,
                d.name_documento,
                d.estado_firma,
                d.lista_usuarios_firma,
                c.nRutPer,
                c.xRazSoc,
                p.nRutPer,
                CONCAT(p.xNombre,' ',p.xApePat,' ',p.xApeMat) as paciente,
                tp.descripcion
                "; //columnas

        $params = array(
	      	"table"=>"documento d",
	      	"columns"=>$columns,
	      	"join" => array (
		        ['persona c','c.id','d.cliente_id'],
		        ['persona p','p.id','d.paciente_id'],
		        ['tipo_documento tp','tp.id','d.tipoDocumento_id']
	      	),
	      	"where" => array(
	      		['d.id',$id]
	      	)
	    );

	    $respuesta = DocumentoModel::all($params);

	    if(count($respuesta) > 0){
	    	$respuestaOk = true;
	    	$documento = $respuesta[0];

	    	$data = array(
	    		'idDocumento' => $documento[0],
	    		'cliente_id' =>$documento[1],
	    		'paciente_id' =>$documento[2],
	    		'tipoDocumento_id' => $documento[3],
	    		'name_documento' => $documento[4],
	    		'lista_aptos' => $documento[6],
	    		'rut_cliente' => $documento[7],
	    		'xRazSoc' => $documento[8],
	    		'rut_paciente' => $documento[9],
	    		'xNombrePaciente' => $documento[10]
	    	);

	    	$lista = json_decode($documento[6],true);

	    	$contenidoAptos = '';

	    	foreach ($lista as $key => $grupo) {
		        foreach ($grupo as $usuario) {
		          	$contenidoAptos .='
			            <a href="#" class="list-group-item"
			              id_rol= "'.$usuario['rol_id'].'"
			              orden_por_rol="'.$usuario['orden'].'"
			              usuario_id="'.$usuario['usuario_id'].'"
			              fullname="'.$usuario['fullname'].'"
			              rol_name="'.$usuario['rol_name'].'"
			            >
			              <strong>'.$usuario['fullname'].'</strong>
			            </a>
		          	';
		        }
	      	}

	      	$data['users_aptos'] = $contenidoAptos;
	    	//$data = $documento;
	    }else{
	    	$message = "Documento no encontrado.";
	    }

	    return array(
			'respuesta'=>$respuestaOk,
			'message'=>$message,
			'data'=>$data
		);
	}

}