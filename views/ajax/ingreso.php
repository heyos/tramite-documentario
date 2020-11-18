<?php

require_once "../../models/ingreso.php";
require_once "../../models/rolUsuario.php";

require_once "../../controllers/globales.php";
require_once "../../controllers/ingreso.php";

class AjaxIngreso{

    public $username;
    public $password;

    public function ingresoAjax(){

        $datos = array("username"=>$this->username,
                        "password"=>$this->password);

        $respuesta = Ingreso::ingresoController($datos);

        echo $respuesta;

        
        
    }
}

if(isset($_POST["username"])){

    $g = new Globales();

    $usuario = $g->sanearData($_POST["username"]);
    $password = $g->sanearData($_POST["password"]);

    $a = new AjaxIngreso();
    $a -> username = $usuario;
    $a -> password = $password;
    $a -> ingresoAjax();
}