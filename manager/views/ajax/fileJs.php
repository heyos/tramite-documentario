<?php

require_once "../../controllers/globales.php";
require_once "../../controllers/filejs.php";
require_once "../../models/filejs.php";

class Ajax{

    public $idFile;
    public $file;
    public $oldFile;

    public function guardarFileJsAjax(){

        $datos = $this->file;

        $respuesta = File::guardarFileJsController($datos);

        echo $respuesta;
    }

    public function eliminarFileJsAjax(){

        $datos = $this->idFile;

        $respuesta = File::eliminarFileJsController($datos);

        echo $respuesta;
    }

    public function actualizarFileJsAjax(){

        $datos = array("file"=>$this->file,
                        "oldFile"=>$this->oldFile,
                        "id_file"=>$this->idFile);

        $respuesta = File::actualizarFileJsController($datos);

        echo $respuesta;
    }

    public function mostrarDataFileSelectAjax(){

        $respuesta = File::mostrarDataFileSelect();

        echo $respuesta;

    }

}

$g = new Globales();

if(isset($_POST["accion"])){

    $a = new Ajax();

    switch ($_POST["accion"]) {
        
        case 'add':
            
            $a -> file = $g->sanearData($_POST["fileJs"]);
            $a -> guardarFileJsAjax();

            break;

        case 'dataFileSelect':

            $a -> mostrarDataFileSelectAjax();

            break;

        case 'edit':

            $a -> idFile = $_POST["termFile"];
            $a -> file = $g->sanearData($_POST["fileJs"]);
            $a -> oldFile = $g->sanearData($_POST["oldFileJs"]);
            $a -> actualizarFileJsAjax();
            break;

        case 'delete':

            $a -> idFile = $_POST["termFile"];
            $a -> eliminarFileJsAjax();

            break;
        default:
            # code...
            break;
    }

}