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
				
				$orden_firma = 1;
				$totalItems = 0;
				$i = 0;

				$error = 0;

				//guardamos usuarios aptos para firma
				foreach ($usuariosFirma as $lista) {

					$totalItems = count($lista);
					$i = 0;

					foreach ($lista as $usuario) {

						$i++;

						$arr['documento_id'] = $idDocumento;
						$arr['usuario_id'] = $usuario['usuario_id'];
						$arr['orden'] = $usuario['orden'];
						$arr['orden_firma'] = $orden_firma;
						$arr['usuario_crea'] = $params['usuario_crea'];
						$arr['fecha_crea'] = $params['fecha_crea'];

						$res = DocumentoUsuarioModel::create('documento_usuario',$arr);

						if($res == 0){
							$message .= $usuario['fullname'].'<br>';
						}else{
							//guardado exitosamente
							if($i != $totalItems){
								$orden_firma ++;
							}
						}
					}
					$orden_firma++;

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

		$respuestaOk = false;
		$message = "";
		$data = "";

		$estadoFirma = array_key_exists('name_documento', $params) ? 
						$params['name_documento'] != '' ? '1' : '0'
						: '0' ; //1:en proceso de firma - 0:pendiente
		$params['estado_firma'] = $estadoFirma;

		$usuariosFirma = array_key_exists('lista_usuarios_firma', $params) ? json_decode($params['lista_usuarios_firma'],true) : [];
		

		if(count($usuariosFirma) > 0){

			$respuesta = DocumentoModel::update('documento',$params);

			if($respuesta != 0){

				$idDocumento = $respuesta;
				$arr = [];

				//eliminado logico de los usuarios firmantes
				$where = array(
				 	'deleted'=>'1',
				 	'usuario_modifica' => $params['usuario_modifica'],
				 	'fecha_modifica' => $params['fecha_modifica'],
				 	'where' => array(
				 		['documento_id',$idDocumento],
				 		['deleted','0']
				 	)
				);
				$delete = DocumentoUsuarioModel::update('documento_usuario',$where);

				$orden_firma = 1;
				$totalItems = 0;
				$i = 0;

				//guardamos usuarios aptos para firma
				foreach ($usuariosFirma as $lista) {

					$totalItems = count($lista);
					$i = 0;

					foreach ($lista as $usuario) {

						$i++;

						$arr['documento_id'] = $idDocumento;
						$arr['usuario_id'] = $usuario['usuario_id'];
						$arr['orden'] = $usuario['orden'];
						$arr['orden_firma'] = $orden_firma;
						$arr['deleted'] = '0';

						$arr['useDeleted'] = '0';
						$arr['where'] = array(
							['documento_id',$idDocumento],
							['usuario_id',$usuario['usuario_id']]
						);

						$existeUsuario = DocumentoUsuarioModel::firstOrAll('documento_usuario',$arr,'first');

						if(!empty($existeUsuario)){
							$arr['usuario_modifica'] = $params['usuario_modifica'];
							$arr['fecha_modifica'] = $params['fecha_modifica'];
							
						}else{
							$arr['usuario_crea'] = $params['usuario_modifica'];
							$arr['fecha_crea'] = $params['fecha_modifica'];
							$arr['usuario_modifica'] = '';
							$arr['fecha_modifica'] = '';
							
						}

						$res = DocumentoUsuarioModel::createOrUpdate('documento_usuario',$arr);

						if($res == 0){
							$message .= $usuario['fullname'].'<br>';
						}else{
							//actualizado o guardado exitosamente
							if($i != $totalItems){
								$orden_firma ++;
							}
							
						}

					}

					$orden_firma ++;
				}

				$respuestaOk = true;

				if($message !=''){
					$message = "Se actualizo exitosamente el documento.<br><b>Pero hubo error al guardar estos usuarios:<b><br>".$message;
				}else{
					$message = "Se actualizo exitosamente el documento.";
				}

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
	    		'xNombrePaciente' => $documento[10],
	    		'name_tipo_doc' => $documento[11]
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
	    	
	    }else{
	    	$message = "Documento no encontrado.";
	    }

	    return array(
			'respuesta'=>$respuestaOk,
			'message'=>$message,
			'data'=>$data
		);
	}

	static public function updateEstadoDocumento($params){

		$respuestaOk = false;
		$message = "";
		$data = "";

		$params['fecha_modifica'] = date('Y-m-d H:i:s');

		$respuesta = DocumentoModel::update('documento',$params);

		if($respuesta !=0){
			$respuestaOk = true;
		}
		
		return array(
			'respuesta'=>$respuestaOk,
			'mensaje'=>$message,
			'data'=>$respuesta
		);

	}

	static public function firmarDocumento($params){

		$respuestaOk = false;
		$message = "";
		$data = "";

		$arrayDocs = array();

		$where_usuario = array(
			'table' => 'usuario',
			'where' => array(
				['id_usuario',$params['user_id']],
			),
			'useDeleted' => '0'
		);
		$usuarioFirma = Usuario::itemDetail($where_usuario);
		$hashCertificado = $usuarioFirma['respuesta'] ? $usuarioFirma['data']['name_certificado'] : '';
		$hashPassCertificado = $usuarioFirma['respuesta'] ? $usuarioFirma['data']['pass_certificado'] : '';
		
		$nameCertificadoTemp = $params['user'];
		$passCertificadoTemp = $params['name'];

		$verificarCerficado = Globales::verificar($nameCertificadoTemp,$hashCertificado);
		
		if($verificarCerficado){

			$verificarPass = Globales::verificar($passCertificadoTemp,$hashPassCertificado);

			if($verificarPass){

				$arrayDocs = json_decode($params['docus'],true);

				$message = count($arrayDocs);
				foreach ($arrayDocs as $idDocumento) {

					$where_documento = array(
						'id' => $idDocumento
					);

					$documento = self::detalleDocumento($where_documento);
					$documentoPdf = $documento['data']['name_documento'];
					# code...
					FirmaElectronica::firmar($nameCertificadoTemp,$passCertificadoTemp,$documentoPdf,$orden,$pathOut);
					//actualizar orden

				}
				

			}else{
				$message = "No se puede verificar la autenticidad del certificado.";
			}

		}else{
			$message = "Certificado invalido para este usuario y/o no cuenta con uno.";
		}

		
		return array(
			'respuesta'=>$respuestaOk,
			'mensaje'=>$message,
			'data'=>$data
		);
		
	}

}