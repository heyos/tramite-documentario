<?php

require_once "config.php";

class FirmaElectronica {

	private static function rutaCerfificado($name){

		$rootFolder = Config::rutas();
		$rutaCerfificado = $rootFolder['certificado'].'/'.$name;

		return $rutaCerfificado;
	}

	private static function rutaDocumento(){

		$rootFolder = Config::rutas();
		$rutaDocumento = $rootFolder['documento'].'/';

		return $rutaDocumento;
	}

	private static function verificarCertificado($name,$clave){

		try {

			$pkcs12 = array();
			$ruta = self::rutaCerfificado($name);
			$certificado = $ruta.'/'.$name.'.pfx';

			if(file_exists($certificado)){
				$pfxRead = openssl_pkcs12_read(
				    file_get_contents($certificado),
				    $pkcs12,
				    $clave
				);
			}		

			return $pkcs12;
			
		} catch (Exception $e) {
			return array();
		}

	}

	public static function firmar($name,$clave,$documento,$orden,$pathOut){
		
		try {

			$respuestaOk = false;
			$message = '';
			$data = array();

			$pkcs12 = self::verificarCertificado($name,$clave);
			$rutaDocumento = self::rutaDocumento();

			if(count($pkcs12) > 0){

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

				//ruta carpeta documentos
				$documento = $rutaDocumento.$documento;
				// create a temporary file writer
				$tempWriter = new SetaPDF_Core_Writer_TempFile();
				$document = SetaPDF_Core_Document::loadByFilename(
				    $documento, $tempWriter
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
				    '../library/fonts/dejavu-sans/DejaVuSans.ttf'
				);
				$visibleAppearance->setFont($font);

				// choose a document with a handwritten signature
				$ruta = self::rutaCerfificado($name);
				$rutaLogo = $ruta.'/'.$name.'.pdf';

				$rutasConfig = Config::rutas();
				$rutaLogoRoot = $rutasConfig['certificado'];
				$rutaLogoDefault = $rutaLogoRoot.'/logo_default.pdf';

				$logo = file_exists($rutaLogo) ? $rutaLogo : $rutaLogoDefault;
				$signatureDocument = SetaPDF_Core_Document::loadByFilename($logo);
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
								
				$pathFile = $rutaDocumento.$pathOut['path'];
				$nameFile = $pathOut['pdf'];

				if(!is_dir($pathFile)){
		          	mkdir($pathFile,0777,true);
		        }

				$saveDocument = $pathFile.'/'.$nameFile;
				copy($tempWriter->getPath(), $saveDocument);


				$respuestaOk = true;
				$message = "Se firmo digitalmente";
				$data = array(
					'out'=>'definir la nueva ruta del archivo firmado'
				);

			}else{
				$message = 'No se pudo verificar el certificado';
			}

			$return = array(
				'respuesta' => $respuestaOk,
				'message' => $message,
				'data' => $data
			);

			return $return;
			
		} catch (Exception $e) {
			return array('respuesta'=>false,'message'=>$e->getMessage());
		}
	}
}