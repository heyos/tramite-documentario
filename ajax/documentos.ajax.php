<?php
require_once "../controllers/globales.php";
require_once "../controllers/documentos.controller.php";
require_once "../models/documentos.model.php";
require_once "../models/documento_usuario.model.php";

class DocumentoAjax{

  public $params;
  public $file;

  public function listAptosFirma(){
    $data = '';
    $mensajeError = 'No se puede ejecutar la aplicacion';
    $respuestaOk = false;

    $lista = $this->params['aptos'] != '' ? json_decode($this->params['aptos'],true): array();
    $user = json_decode($this->params['user'],true);
    $orden = $this->params['orden'];

    $lista[$orden][] = $user;
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
    $message = '';

    if(!is_null($this->file)){

      $fileTmpPath = $this->file["tmp_name"];
      $fileName = str_replace(' ','', $this->file['name']);
      $fileSize = $this->file['size'];
      $fileType = $this->file['type'];
      $fileNameCmps = explode(".", $fileName);
      $fileExtension = strtolower(end($fileNameCmps));

      $allowedfileExtensions = array('pdf');

      if (in_array($fileExtension, $allowedfileExtensions)) {
        
        $newFileName = md5(time() . $fileName ). '.' . $fileExtension;
        $uploadFileDir = '../temp/';
        $dest_path = $uploadFileDir . $newFileName;
         
        if(move_uploaded_file($fileTmpPath, $dest_path)){
          $message ='File is successfully uploaded.';
          $respuestaOk = true;
        }else{
          $message = 'There was some error moving the file to upload directory. Please make sure the upload directory is writable by web server.';
        }

      }else{
        $message = "Solo se permite PDF";
      }

    }else{
      $message = "No se cargo nigun archivo";
    }

    echo json_encode(array(
      'data'=>$newFileName,
      'respuesta'=>$respuestaOk,
      'mensaje'=>$message
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
    default:
      // code...
      break;
  }
}
