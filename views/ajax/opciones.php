<?php

require_once "../../controllers/globales.php";
require_once "../../controllers/opciones.php";
require_once "../../models/opciones.php";

class Ajax{

    public $tema;
    public $vistaMenu;

    public function guardarConfiguracionAjax(){

        $datos = array("tema"=>$this->tema,
                        "vista_menu"=>$this->vistaMenu);

        $respuesta = Configuracion::actualizarConfiguracionController($datos);

        echo $respuesta;

    }


}


if(isset($_POST["accion"])){

    $g = new Globales();
    $a = new Ajax();

    switch ($_POST["accion"]) {
        case 'config':

            $a -> tema = $g->sanearData($_POST["theme"]);
            $a -> vistaMenu = $g->sanearData($_POST["viewMenu"]);
            $a -> guardarConfiguracionAjax();
            
            break;
        
        default:
            # code...
            break;
    }
}