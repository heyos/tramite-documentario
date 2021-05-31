<?php
require_once "../controllers/config.php";
require_once "../controllers/globales.php";
require_once "../controllers/documentos.controller.php";
require_once "../controllers/documento_usuario.controller.php";
require_once "../controllers/resumen_documento_usuario.controller.php";
require_once "../models/documentos.model.php";
require_once "../models/documento_usuario.model.php";
require_once "../models/resumen_documento_usuario.model.php";

require_once "../vendor/autoload.php";
require_once "../library/phpqrcode/qrlib.php";
require_once "../controllers/drive.controller.php";

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
    $resumen = [];
    $fileIdDrive = "";
    $id_principal = '';
    $id_sub = '';
    $fileIdDrive = '';

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

      $newFileName = $name_documento.'.'.$fileExtension;

      if (in_array($fileExtension, $allowedfileExtensions)) {
        
        //TEMP
        $uploadDir = Config::rutas();
        $uploadRoot = $uploadDir['documento'].'/';
        $uploadFileDir = date('Y-m-d').'/'.$rut_cliente;
        $dest_path = $uploadRoot.$uploadFileDir .'/'. $newFileName;

        if($id == 0) {

          $uploadFileDir = $uploadRoot.$uploadFileDir;

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

          }else{
            $message = 'There was some error moving the file to upload directory. 
            Please make sure the upload directory is writable by web server.';
          }
        
        }else{

          $this->file['nameNew'] = $newFileName;

          $estructura = array(
            'principal' => date('Y-m-d'), //date('Y-m-d'),
            'sub' => $rut_cliente
          );

          $carpetaId_principal = GoogleDrive::crearCarpeta($estructura['principal']);
          $carpetaId_sub = '';
          
          if($carpetaId_principal !=''){
            
            $carpetaId_sub = GoogleDrive::crearCarpeta($estructura['sub'],$carpetaId_principal);

          }

          if($carpetaId_sub !=''){
            $fileIdDrive = GoogleDrive::uploadFile($this->file,$carpetaId_sub);
          }

          if($fileIdDrive !=''){

            $respuestaOk = true;
            $path = $this->file['nameNew'];
            $google_id = '{\"folder_id\" : \"'.$carpetaId_sub.'\",\"file_id\" : \"'.$fileIdDrive.'\"}';

            $params = array(
              'id'=>$id,
              'estado_firma' => '1',
              'name_documento' => $path,
              'google_id' => $google_id,
              'usuario_modifica' => $user,
              'fecha_carga_doc' => date('Y-m-d')
            );

            $documento = DocumentoController::updateEstadoDocumento($params);

            $respuesta_upload = $documento['respuesta'];

            if($documento['respuesta']){

              $old = array(
                'estado_old' => '0',
                'documento_id' => $id
              );

              $resumen = ResumenDocumentoUsuarioController::updateResumen($old);

            }else {
              $respuestaOk = false;
              $message = "Error al actualizar la subida del documento";
            }
            
          }else{
            $message = 'There was some error moving the file to upload directory in DRIVE';
          }

        }          
        
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
      'respuesta_upload' => $respuesta_upload,
      'resumen' => $resumen,
      'drive' => $fileIdDrive
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

    $ruta = '';
    $name = '';
    $file = '';
    $arr = [];
    $downloadDir = '';

    $dir = Config::rutas();
    $dirName = $dir['documento'].'/';

    $ruta = '';

    if(isset($this->params['name'])){

      $file = $this->params['name'];
      $ruta = $dirName.$file.'.pdf';
      
    }elseif (isset($this->params['term'])) {
      //buscar por codigo del documento
      $data = array(
        'codigo' => $this->params['term']
      );
      $documento = DocumentoController::detalleDocumento($data);

      if($documento['respuesta']){

        //$file = str_replace('.pdf','',$file);
        $downloadDir = $dir['download'];

        $documentoPdf = $documento['data']['name_documento'];
            
        $arrDrive = json_decode($documento['data']['google_id'],true);
        $inFolderId = $arrDrive['folder_id'];

        $fileDrive = GoogleDrive::downloadFile($documentoPdf,$downloadDir,$inFolderId);
        $ruta = $fileDrive['data'];

      }
    }

    if(file_exists($ruta)){

      $arr = explode('/',$ruta);
      $name = end($arr);

      header("Content-type: application/pdf");
      header("Content-Disposition: inline; filename=".$name);

      readfile($ruta);

      if(isset($this->params['term'])){
        unlink($ruta);
      }

    }else{
      echo $ruta;
      echo "<h1><b>ERROR:>> Documento no encontrado y/o aun no se adjunta uno</b></h1>";
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

  public function historialUsuariosFirmaAjax(){

    $params = $this->params;
    $respuesta = DocumentoUsuarioController::historialUsuariosFirma($params);

    $contenido = '';

    if($respuesta['respuesta']){
      $contenido = DocumentoUsuarioController::generarContenidoFirmantes($respuesta['data']);

      $respuesta['contenido'] = $contenido;

      unset($respuesta['data']);
    }

    echo json_encode($respuesta);
    
  }

  public function anularDocumentoAjax(){
    session_start();
    $params = $this->params;
    $user = $_SESSION['user'];
    $usuario_id = $_SESSION['usuario_id'];

    $data = array(
      'table' => 'documento',
      'usuario_modifica' => $user,
      'fecha_modifica' => date('Y-m-d'),
      'estado_firma' => '3',
      'where' => array(
        ['id',$params['documento_id']]
      )
    );

    //obtener estado antes de actualizarlo
    $documento = DocumentoController::itemDetail($data);
    $estado = $documento['respuesta'] ? $documento['data']['estado_firma'] : 0;

    $respuesta = DocumentoController::updateItem($data);
    $mensaje = $respuesta['respuesta'] ? 'Se anulo el documento exitosamente.' : $respuesta['mensaje'];
    $respuesta['message'] = $mensaje;

    
    if($respuesta['respuesta']){

      $old = array(
        'estado_old' => $estado,
        'documento_id' => $params['documento_id']
      );

      $resumen = ResumenDocumentoUsuarioController::updateResumen($old);

    }
      
    echo json_encode($respuesta);
  }

  public function descargarPorLoteAjax(){

    $params = $this->params;

    $config = Config::rutas();
    $rutaAbsoluta = $config['documento'];

    $arrRutas = DocumentoController::descargarPorLote($params);

    $zip = new ZipArchive();
    
    $nombreArchivoZip = $rutaAbsoluta."/".date('d.m.Y.H.i.s').".zip";

    if (!$zip->open($nombreArchivoZip, ZipArchive::CREATE | ZipArchive::OVERWRITE)) {
        exit("Error abriendo ZIP en $nombreArchivoZip");
    }
    
    $file = '';
    foreach ($arrRutas as $documento) {
      //$file = $rutaAbsoluta."/".$documento['ruta'];
      $file = $documento['ruta'];
      $zip->addFile($file, $documento['name_doc']);
      //echo $file.'<br>';

    }

    $resultado = $zip->close();
    
    if ($resultado) {

      foreach ($arrRutas as $documento) {
        unlink($documento['ruta']);
      }

      header('Content-Type: application/octet-stream');
      header("Content-Transfer-Encoding: Binary");
      header("Content-disposition: attachment; filename=$nombreArchivoZip");
      // Leer el contenido binario del zip y enviarlo
      readfile($nombreArchivoZip);

      unlink($nombreArchivoZip);
      
    } else {
      echo "Error creando archivo";
    }

  }

  public function consultaReporteDocumentoAjax(){

    $params = $this->params;
    $data = array(
      'codigo' => $params['term']
    );

    $respuesta = DocumentoController::consultaReporteDocumento($data);

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

    case 'edit':
      $a -> editDocumentAjax();
      break;

    case 'readfile':
      $a -> readFileDocumentAjax();
      break;

    case 'redirigir':
      $a -> generarSesionIdDocumentoAjax();
      break;

    case 'historial':
      $a -> historialUsuariosFirmaAjax();
      break;

    case 'anular':
      $a -> anularDocumentoAjax();
      break;
    case 'download_lote':
      $a -> descargarPorLoteAjax();
      break;

    case 'consulta_reporte':
      $a -> consultaReporteDocumentoAjax();
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
