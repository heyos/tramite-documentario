<?php

require_once "../../controllers/datosTabla.php";
require_once "../../controllers/tablaLogica.php";
require_once "../../models/datosTabla.php";
require_once "../../models/tablaLogica.php";

$descargar = new DatosTabla();
$descargar -> descargarExcelTablaController();