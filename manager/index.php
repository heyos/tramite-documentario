<?php
ini_set("display_errors", 1);

require_once "models/enlaces.php" ;
require_once "models/empresa.php";
require_once "models/usuario.php";
require_once "models/rolUsuario.php";
require_once "models/menu.php";
require_once "models/menuJsAsociado.php";


require_once "controllers/template.php" ;
require_once "controllers/enlaces.php" ;
require_once "controllers/globales.php";
require_once "controllers/empresa.php";
require_once "controllers/usuario.php";
require_once "controllers/rolUsuario.php";
require_once "controllers/menu.php";
require_once "controllers/menuJsAsociado.php";



$template = new Template();

$template -> templateController();

