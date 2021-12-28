<?php

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

//error_reporting(E_ALL);

require_once "models/enlaces.php" ;
require_once "models/menu.php";
require_once "models/rolUsuario.php";
require_once "models/empresa.php";
require_once "models/fileJs.php";
require_once "models/usuario.php";
require_once "models/opciones.php";
require_once "models/model.php";

require_once "controllers/template.php" ;
require_once "controllers/enlaces.php" ;
require_once "controllers/globales.php";
require_once "controllers/rolUsuario.php";
require_once "controllers/menu.php";
require_once "controllers/empresa.php";
require_once "controllers/fileJs.php";
require_once "controllers/usuario.php";
require_once "controllers/opciones.php";
require_once "controllers/controller.php";


//MODULOS
require_once "models/datosTabla.php";
require_once "models/tablaLogica.php";
require_once "models/persona.php";
require_once "models/direccion_contacto.php";
require_once "models/tipo_documento.model.php";
require_once "models/resumen_documento_usuario.model.php";
require_once "models/documento_usuario.model.php";
require_once "models/documentos.model.php";

require_once "controllers/datosTabla.php";
require_once "controllers/tablaLogica.php";
require_once "controllers/persona.php";
require_once "controllers/tipo_documento.controller.php";
require_once "controllers/documentos.controller.php";
require_once "controllers/estadodocumento.controller.php";
require_once "controllers/resumen_documento_usuario.controller.php";
require_once "controllers/documento_usuario.controller.php";
require_once "controllers/documentos.controller.php";

require_once 'vendor/autoload.php';
require_once 'controllers/firma_electronica.controller.php';
require_once 'helpers/helper.php';

//require_once 'library/SetaPDF/Autoload.php';

// Template::baseUrl();
// Template::templateController();


// $clave = 'heyller3107';
// $name = Globales::encriptar($clave);
// echo 'clave firma: '.$name;
// echo '<br>';

// $pfx = 'hreyes';
// $file = Globales::encriptar($pfx);
// echo 'name file: '.$file;

// $firma = FirmaElectronica::firmar($pfx,$clave,'','');

// print_r($firma);

// echo $_SERVER['SERVER_NAME'];

// echo "<pre>";
// print_r($_SERVER);
// echo "</pre>";
// $table = 'resumen_documento_usuario';

// $where = array(
// 	'estado_old' => 0,
// 	'documento_id' => 26
// );

// $a = ResumenDocumentoUsuarioController::updateResumen($where);

// create a writer
$writer = new SetaPDF_Core_Writer_Http('png.pdf', true);
// get a document instance
$document = SetaPDF_Core_Document::loadByFilename(
    'test.pdf', $writer
);

// create a stamper instance
$stamper = new SetaPDF_Stamper($document);

// get an image instance
$image = SetaPDF_Core_Image::getByPath('../files-firma/qr.png');
// initiate the stamp
$stamp = new SetaPDF_Stamper_Stamp_Image($image);
// set height (and width until no setWidth is set the ratio will retain)
$stamp->setHeight(23);

// add stamp to stamper on position left top for all pages with a specific translation
$stamper->addStamp($stamp, array(
    'translateX' => 43,
    'translateY' => -38
));

// stamp the document
$stamper->stamp();

// save and send it to the client
$document->save()->finish();



exit();

$zip = new ZipArchive();
// Ruta absoluta
$nombreArchivoZip = date('d.m.Y.H.i.s').".zip";

if (!$zip->open($nombreArchivoZip, ZipArchive::CREATE | ZipArchive::OVERWRITE)) {
    exit("Error abriendo ZIP en $nombreArchivoZip");
}
// Si no hubo problemas, continuamos
// Agregamos el script.js
// Su ruta absoluta, como D:\documentos\codigo\script.js
$rutaAbsoluta = "test.pdf";
// Su nombre resumido, algo como "script.js"
$nombre = basename($rutaAbsoluta);
$zip->addFile($rutaAbsoluta, $nombre);

// No olvides cerrar el archivo
$resultado = $zip->close();
if ($resultado) {
    echo "Archivo creado";
} else {
    echo "Error creando archivo";
}

