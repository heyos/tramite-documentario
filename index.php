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

$template = new Template();
$template -> templateController();


/*
// create a writer
$tempWriter = new SetaPDF_Core_Writer_String();
//$tempWriter = new SetaPDF_Core_Writer_Http('simple.pdf', true); //nombre como se guardara -- variable writer
// create a new document instance
$document = SetaPDF_Core_Document::loadByFilename(
    '../files-firma/test.pdf', $tempWriter
);

// create a signer instance
$signer = new SetaPDF_Signer($document);

// add a field with the name "Signature" to the top left of page 1
$signer->addSignatureField(
    'Signature',                    // Name of the signature field
    1,                              // put appearance on page 1
    SetaPDF_Signer_SignatureField::POSITION_RIGHT_TOP, //POSITION_RIGHT_TOP - POSITION_LEFT_TOP (original)
    array('x' => -160, 'y' => -150),   // Translate the position (x 50, y -80 -> 50 points right, 80 points down)
    180,                            // Width - 180 points
    50                              // Height - 50 points
);

// set some signature properties
$signer->setReason("Just for testing");
$signer->setLocation('setasign.com');

//$tmpDocument = $signer->preSign(new SetaPDF_Core_Writer_TempFile());

// read certificate and private key from the PFX file
$pkcs12 = array();
$pfxRead = openssl_pkcs12_read(
    file_get_contents('../files-firma/E-Certchile.pfx'),
    $pkcs12,
    'XjwPen6eErpQzj8'
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

//$document->save();
$signer->sign($module);
//exit();
//********************************************************************************
//SEGUNDA FIRMA
//********************************************************************************
$writer = new SetaPDF_Core_Writer_Http('several-signatures.pdf', true);

// create a new document instance based on the temporary result
$document2 = SetaPDF_Core_Document::loadByString($tempWriter, $writer);

// create a signer instance
$signer = new SetaPDF_Signer($document2);

// add a field with the name "Signature" to the top left of page 1
$signer->addSignatureField(
    'Signature 2',                    // Name of the signature field
    1,                              // put appearance on page 1
    SetaPDF_Signer_SignatureField::POSITION_LEFT_TOP, //POSITION_RIGHT_TOP - POSITION_LEFT_TOP (original)
    array('x' => 50, 'y' => -150),   // Translate the position (x 50, y -80 -> 50 points right, 80 points down)
    180,                            // Width - 180 points
    50                              // Height - 50 points
);
//$signer->setSignatureFieldName('Signature 2');
// set some signature properties
$signer->setReason("Just for testing");
$signer->setLocation('setasign.com');

//$tmpDocument = $signer->preSign(new SetaPDF_Core_Writer_TempFile());

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
$signatureXObject = $signatureDocument->getCatalog()->getPages()->getPage(1)->toXObject($document2);
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
*/


/*
require __DIR__ . '/vendor/autoload.php';

use Kunnu\Dropbox\Dropbox;
use Kunnu\Dropbox\DropboxApp;
use Kunnu\Dropbox\DropboxFile;

//enlace para utilizar
//https://stackoverflow.com/questions/56445545/upload-files-to-dropbox-with-php-dropbox-sdk-php

*/
