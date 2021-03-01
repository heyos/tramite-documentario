<?php
require_once "../controllers/config.php";
require_once "../controllers/globales.php";
require_once "../controllers/documentos.controller.php";
require_once "../models/documentos.model.php";
require_once "../models/documento_usuario.model.php";

require_once "../vendor/autoload.php";
require_once "../controllers/dropbox.controller.php";

class DocumentoAjax{

  public $params;
  public $file;
  private $rootFolder = '';

  public function listAptosFirma(){
    $data = '';
    $mensajeError = 'No se puede ejecutar la aplicacion';
    $respuestaOk = false;

    $lista = $this->params['aptos'] != '' ? json_decode($this->params['aptos'],true): array();
    $user = json_decode($this->params['user'],true);
    $orden = $this->params['orden'];

    //$lista[$orden][] = $user;
    $lista[$orden] = array($user);
    ksort($lista); //ORDENAMOS ARRAY PARA MANTENER ORDEN SEGUN EL ROL

    if(count($lista) > 0){

      foreach ($lista as $key => $grupo) {
        foreach ($grupo as $usuario) {
          $data .='
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
    }

    echo json_encode(array(
      'lista' =>$lista ,
      'contenido'=>$data,
      'mensaje'=>$mensajeError
    ));

  }

  public function uploadTempFile(){

    $respuestaOk = false;
    $newFileName = '';
    $path = '';
    $message = '';
    $respuesta_upload = false;

    $oldFile = array_key_exists('oldFile', $this->params) ? $this->params['oldFile'] : '';
    $id = array_key_exists('id', $this->params) ? $this->params['id'] : 0; //parametro desde mainJsFirmaDocumentos.js

    $user = '';
    $rut_cliente = $this->params['rut_cliente'];
    $rut_cliente = str_replace('.','_',$rut_cliente);
    $nombre_paciente = str_replace(' ','_',$this->params['nombre_paciente']);
    $tipo_doc = str_replace(' ','_',$this->params['tipo_doc']);
    $id_name_doc = $id == 0 ? uniqid() : $id;
    $name_documento = $rut_cliente.'-'.$nombre_paciente.'-'.$tipo_doc.'-'.$id_name_doc;

    if($id != 0){
      session_start();
      $user = $_SESSION['user'];
    }

    if(!is_null($this->file)){

      $fileTmpPath = $this->file["tmp_name"];
      $fileName = str_replace(' ','', $this->file['name']);
      $fileSize = $this->file['size'];
      $fileType = $this->file['type'];
      $fileNameCmps = explode(".", $fileName);
      $name = $fileNameCmps[0];
      $fileExtension = strtolower(end($fileNameCmps));

      $allowedfileExtensions = array('pdf');

      if (in_array($fileExtension, $allowedfileExtensions)) {
        
        $newFileName = $name_documento.'.'.$fileExtension;

        //TEMP
        $uploadDir = Config::rutas();
        $uploadRoot = $uploadDir['documento'].'/';
        $uploadFileDir = $uploadRoot.date('Y-m-d').'/'.$rut_cliente;
        $dest_path = $uploadFileDir .'/'. $newFileName;

        if(!is_dir($uploadFileDir)){
          mkdir($uploadFileDir,0777,true);
        }

        if(move_uploaded_file($fileTmpPath, $dest_path)){
          $message ='File is successfully uploaded.';
          $respuestaOk = true;

          if($oldFile !='' && file_exists($uploadFileDir.'/'.$oldFile)){
            unlink($uploadFileDir.'/'.$oldFile); //eliminamos antiguo archivo
          }

          $path = str_replace($uploadRoot,'',$dest_path);

          //verificamos que es de un documento creado
          if($id != 0){
            $params = array(
              'id'=>$id,
              'estado_firma' => '1',
              'name_documento' => $path,
              'usuario_modifica' => $user,
              'fecha_carga_doc' => date('Y-m-d')
            );

            $documento = DocumentoController::updateEstadoDocumento($params);

            $respuesta_upload = $documento['respuesta'];
          }             

        }else{
          $message = 'There was some error moving the file to upload directory. Please make sure the upload directory is writable by web server.';
        }

        //DRIVE
        // $uploadFileDir = date('YYYY-m-d').'/'.$rut_cliente;
        // $dest_path = '/'.$uploadFileDir .'/'. $newFileName;
        // $respuestaOk = DropboxController::upload($fileTmpPath, '/'.$newFileName);

      }else{
        $message = "Solo se permite PDF";
      }

    }else{
      $message = "No se cargo nigun archivo";
    }

    echo json_encode(array(
      'data'=>$path,
      'respuesta'=>$respuestaOk,
      'mensaje'=>$message,
      'respuesta_upload' => $respuesta_upload
    )); 

  }

  public function saveDocumentAjax(){

    $params = $this->params;
    //$accion = $params['accion'];
    unset($params['accion']);

    $params['usuario_crea'] = $params['usuario'];
    $params['fecha_crea'] = date('Y-m-d H:i:s');

    unset($params['usuario']);
    unset($params['id']);

    $respuesta = DocumentoController::crearDocumento($params);
    
    echo json_encode($respuesta);

  }

  public function detalleDocumentoAjax(){

    $params = $this->params;

    $respuesta = DocumentoController::detalleDocumento($params);

    echo json_encode($respuesta);

  }

  public function editDocumentAjax(){

    $params = $this->params;

    $params['usuario_modifica'] = $params['usuario'];
    $params['fecha_modifica'] = date('Y-m-d H:i:s');

    unset($params['accion']);
    unset($params['usuario']);

    $respuesta = DocumentoController::editarDocumento($params);

    echo json_encode($respuesta);
    
  }

  public function readFileDocumentAjax(){

    $file = $this->params['name'];
    $dir = Config::rutas();
    $dirName = $dir['documento'].'/';
    $ruta = $dirName.$file.'.pdf';
    if(file_exists($ruta)){

      header("Content-type: application/pdf");
      header("Content-Disposition: inline; filename=documento.pdf");

      readfile($ruta);

    }else{
      echo "ERROR:>> Documento no encontrado";
    }
  }

  public function generarSesionIdDocumentoAjax(){

    $params = $this->params;
    $id = $params['id'];

    $where = array(
      'table' => 'documento',
      'where' => array(
        ['id',$id]
      )
    );

    $documento = DocumentoController::itemDetail($where);

    if($documento['respuesta']){
      session_start();
      $_SESSION['idDocumento'] = $id;
    }

    echo json_encode($documento);
  }

}

if(isset($_POST)){

  $a = new DocumentoAjax();
  $a -> params = $_POST;

  switch ($_POST['accion']) {
    case 'lista_aptos':
      $a -> listAptosFirma();
      break;

    case 'upload_file':

      $a -> file = isset($_FILES["file"]) ? $_FILES["file"] : null;
      $a -> uploadTempFile();
      
      break;

    case 'add':
      $a -> saveDocumentAjax();
      break;

    case 'detalle':
      $a -> detalleDocumentoAjax();
      break;

    case 'edit':
      $a -> editDocumentAjax();
      break;

    case 'readfile':
      $a -> readFileDocumentAjax();
      break;

    case 'redirigir':
      $a -> generarSesionIdDocumentoAjax();
      break;

    default:
      echo json_encode(array(
          'respuesta' => false,
          'mensaje' => 'Accion no disponible'
        )
      );
      break;
  }
}
