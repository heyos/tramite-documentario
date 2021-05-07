<?php

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

require_once "controllers/datosTabla.php";
require_once "controllers/tablaLogica.php";
require_once "controllers/persona.php";
require_once "controllers/tipo_documento.controller.php";
require_once "controllers/documentos.controller.php";
require_once "controllers/estadodocumento.controller.php";

require_once 'vendor/autoload.php';
require_once 'controllers/firma_electronica.controller.php';

$template = new Template();
$template -> templateController();

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


/*
require __DIR__ . '/vendor/autoload.php';

use Kunnu\Dropbox\Dropbox;
use Kunnu\Dropbox\DropboxApp;
use Kunnu\Dropbox\DropboxFile;

//enlace para utilizar
//https://stackoverflow.com/questions/56445545/upload-files-to-dropbox-with-php-dropbox-sdk-php

*/