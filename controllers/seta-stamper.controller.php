<?php

require_once "config.php";

class Stamper {

	public static function incrustarImg ($pathPdf,$pathImg) {

		$writer = new SetaPDF_Core_Writer_Http('png.pdf', true);
		$tempWriter = new SetaPDF_Core_Writer_TempFile();
		// get a document instance
		$document = SetaPDF_Core_Document::loadByFilename(
		    $pathPdf, $writer
		);

		// create a stamper instance
		$stamper = new SetaPDF_Stamper($document);

		// get an image instance
		$image = SetaPDF_Core_Image::getByPath($pathImg);
		// initiate the stamp
		$stamp = new SetaPDF_Stamper_Stamp_Image($image);
		// set height (and width until no setWidth is set the ratio will retain)
		$stamp->setHeight(75);

		// add stamp to stamper on position left top for all pages with a specific translation
		// $stamper->addStamp($stamp, array(
		//     'translateX' => 43,
		//     'translateY' => -38
		// ));

		$stamper->addStamp($stamp, array(
		    'position' => SetaPDF_Stamper::POSITION_RIGHT_BOTTOM,
		    'showOnPage' => SetaPDF_Stamper::PAGES_FIRST,
		    'translateX' => -20,
		    'translateY' => 20,
		));


		// stamp the document
		$stamper->stamp();

		//$document->getCatalog()->setPageLayout(SetaPDF_Core_Document_PageLayout::SINGLE_PAGE);

		// save and send it to the client
		$document->save()->finish();

	}

}