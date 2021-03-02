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

require_once 'vendor/autoload.php';
require_once 'controllers/firma_electronica.controller.php';
//require_once 'library/SetaPDF/Autoload.php';

$template = new Template();
//$template -> templateController();

// $clave = 'heyller3107';
// $name = Globales::encriptar($clave);
// echo 'clave firma: '.$name;
// echo '<br>';

// $pfx = 'hreyes';
// $file = Globales::encriptar($pfx);
// echo 'name file: '.$file;

// $firma = FirmaElectronica::firmar($pfx,$clave,'','');

// print_r($firma);

//exit();

$file = 0 ;
$orden = $file+1;
$file = '../files-firma/test'.$file.'.pdf';

// read certificate and private key from the PFX file
$pkcs12 = array();
$pfxRead = openssl_pkcs12_read(
    file_get_contents('../files-firma/10464148022.pfx'),
    $pkcs12,
    'heyller3107'
);

// error handling
if (false === $pfxRead) {
    throw new Exception('The certificate could not be read.');
}

// create e.g. a PAdES module instance
$module = new SetaPDF_Signer_Signature_Module_Pades();
// pass the certificate ...
$module->setCertificate($pkcs12['cert']);
// ...and private key to the module
$module->setPrivateKey($pkcs12['pkey']);

// pass extra certificates if included in the PFX file
if (isset($pkcs12['extracerts']) && count($pkcs12['extracerts'])) {
    $module->setExtraCertificates($pkcs12['extracerts']);
}

//NEW
//--------------------------------------------
// create a reader
//$reader = new SetaPDF_Core_Reader_File($file);
// create a temporary file writer
$tempWriter = new SetaPDF_Core_Writer_TempFile();
//-----------------------------------------

// create a new document instance
$document = SetaPDF_Core_Document::loadByFilename(
    $file, $tempWriter
);

// create a signer instance
$signer = new SetaPDF_Signer($document);

$y = $orden*(-50)-(10*$orden);
$signature = 'Signature '.$orden;

// add a field with the name "Signature" to the top left of page 1
$signer->addSignatureField(
    $signature,                    // Name of the signature field
    1,                              // put appearance on page 1
    SetaPDF_Signer_SignatureField::POSITION_LEFT_TOP, //POSITION_RIGHT_TOP - POSITION_LEFT_TOP (original)
    array('x' => 30, 'y' => $y),   // Translate the position (x 50, y -80 -> 50 points right, 80 points down)
    160,                            // Width - 180 points
    50                              // Height - 50 points
);
$signer->setSignatureFieldName($signature);

// set some signature properties
$signer->setReason("Just for testing");
$signer->setLocation('setasign.com');


// create a Signature appearance
$visibleAppearance = new SetaPDF_Signer_Signature_Appearance_Dynamic($module);
// create a font instance for the signature appearance
$font = new SetaPDF_Core_Font_TrueType_Subset(
    $document,
    'library/fonts/dejavu-sans/DejaVuSans.ttf'
);
$visibleAppearance->setFont($font);

// choose a document with a handwritten signature
$signatureDocument = SetaPDF_Core_Document::loadByFilename('../files-firma/images/logo3.pdf');
$signatureXObject = $signatureDocument->getCatalog()->getPages()->getPage(1)->toXObject($document);
// set the signature xObject as graphic
$visibleAppearance->setGraphic($signatureXObject);

// disable the distinguished name
$visibleAppearance->setShow(
    SetaPDF_Signer_Signature_Appearance_Dynamic::CONFIG_DISTINGUISHED_NAME, false
);

// Translate the labels to german:
$visibleAppearance->setShowTpl(
    SetaPDF_Signer_Signature_Appearance_Dynamic::CONFIG_REASON, 'Razon: %s'
);

$visibleAppearance->setShowTpl(
    SetaPDF_Signer_Signature_Appearance_Dynamic::CONFIG_LOCATION, 'Firmado en: %s'
);

$visibleAppearance->setShowTpl(
    SetaPDF_Signer_Signature_Appearance_Dynamic::CONFIG_DATE, 'Fecha: %s'
);

$visibleAppearance->setShowTpl(
    SetaPDF_Signer_Signature_Appearance_Dynamic::CONFIG_NAME,
    'Firmado digitalmente por: %s'
);

// format the date
$visibleAppearance->setShowFormat(
    SetaPDF_Signer_Signature_Appearance_Dynamic::CONFIG_DATE, 'd.m.Y H:i:s'
);

// define the appearance
$signer->setAppearance($visibleAppearance);

// sign the document and send the final document to the initial writer
$signer->sign($module);

$file2 = '../files-firma/test'.$orden.'.pdf';
copy($tempWriter->getPath(), $file2);
echo "se firmo exitosamente el documento ".$file2;



/*
require __DIR__ . '/vendor/autoload.php';

use Kunnu\Dropbox\Dropbox;
use Kunnu\Dropbox\DropboxApp;
use Kunnu\Dropbox\DropboxFile;

//enlace para utilizar
//https://stackoverflow.com/questions/56445545/upload-files-to-dropbox-with-php-dropbox-sdk-php

*/