<?php

require_once "../../controllers/globales.php";
require_once "../../controllers/filejs.php";
require_once "../../models/filejs.php";

class Ajax{

    public $accion;
    public $page;
    public $por_pag;
    public $buscar;
    public $numPaginador;

    public function mostrarDataAjax(){

        $datos = array('page'=>$this->page,
                        'por_pag'=>$this->por_pag,
                        'buscar'=>$this->buscar,
                        'numPaginador'=>$this->numPaginador);

        switch ($this->accion) {
            case 'dataFile':
                $respuesta = File::mostrarFileJsController($datos);

                break;
            
            default:
                # code...
                break;
        }

        echo $respuesta;
    }

}


if(isset($_POST["accion"])){

    $a = new Ajax();
    $a -> accion = $_POST["accion"];
    $a -> page = $_POST["page"];
    $a -> por_pag = $_POST["por_pag"];
    $a -> buscar = $_POST["buscar"];
    $a -> numPaginador = $_POST["num"];
    $a -> mostrarDataAjax();

}
