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

require_once "controllers/datosTabla.php";
require_once "controllers/tablaLogica.php";
require_once "controllers/persona.php";


$template = new Template();

$template -> templateController();

