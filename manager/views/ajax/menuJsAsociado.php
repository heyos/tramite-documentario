<?php

require_once "../../controllers/globales.php";
require_once "../../controllers/menuJsAsociado.php";
require_once "../../models/menuJsAsociado.php";

class Ajax{

    public $id;
    public $file;
    public $oldFile;
    public $idJs;
    public $type;

    public function dataFileAsociadoAjax(){

        $datos = array("id"=>$this ->id,
                        "type"=>$this->type);

        $respuesta = MenuJs::mostrarDataJsController($datos);

        echo $respuesta;

    }

    public function guardarFileAsociadoAjax(){

        $datos = array("id"=>$this->id,
                        "files"=>$this->file,
                        "type"=>$this->type);

        $respuesta = MenuJs::guardarFileJsController($datos);

        echo $respuesta;

    }

    public function actualizarFileAsociadoAjax(){
        
        $datos = array("id_js"=>$this->idJs,
                        "file"=>$this->file,
                        "oldFile"=>$this->oldFile);

        $respuesta = MenuJs::actualizarFileJsController($datos);

        echo $respuesta;

        
    }

    public function eliminarFileAsociadoAjax(){

        $datos = $this ->idJs;

        $respuesta = MenuJs::eliminarFileJsController($datos);

        echo $respuesta;
    }


}

if(isset($_POST["accion"])){

    $a = new Ajax();

    switch($_POST["accion"]){

        case 'data':
            $a -> id = $_POST["term"];
            $a -> type = $_POST["typeMenu"];
            $a -> dataFileAsociadoAjax();
            break;

        case 'variable':
            # code...
            break;

        case 'add':

            $a -> id = $_POST["menuSelect"];
            $a -> file = $_POST["fileJs"];
            $a -> type = $_POST["typeMenu"];
            $a -> guardarFileAsociadoAjax();

            break;

        case 'update':
            $a -> idJs = $_POST["termFile"];
            $a -> file = $_POST["actualizarFileJs"];
            $a -> oldFile = $_POST["oldFileJs"];
            $a -> type = $_POST["typeMenu"];
            $a -> actualizarFileAsociadoAjax();
            break;

        case 'delete':
            $a -> idJs = $_POST["term"];
            $a -> eliminarFileAsociadoAjax();
            break;
    }

}

