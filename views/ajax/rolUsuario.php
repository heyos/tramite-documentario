<?php

require_once "../../controllers/globales.php";
require_once "../../controllers/rolUsuario.php";
require_once "../../models/rolUsuario.php";

require_once "../../controllers/menu.php";
require_once "../../models/menu.php";


class Ajax{

    public $idRol;
    public $nombreRol;
    public $mostrarInicio;

    public function registrarRolAjax(){

        $datos = array("descripcion"=>$this->nombreRol,"mostrar_inicio"=>$this->mostrarInicio);

        $respuesta = RolUsuario::registrarRolController($datos);
        
        echo $respuesta;



    }

    public $oldNombreRol;

    public function actualizarRolAjax(){

        $datos = array("id_rol" => $this->idRol,
                        "descripcion"=> $this->nombreRol,
                        "oldNombreRol"=>$this->oldNombreRol,
                        "mostrar_inicio"=>$this->mostrarInicio);

        $respuesta = RolUsuario::actualizarRolController($datos);
        
        echo $respuesta;
        
    }

    public function eliminarRolAjax(){

        $datos = $this->idRol;

        $respuesta = RolUsuario::eliminarRolController($datos);

        echo $respuesta;

    }

    public function mostrarPaginaInicioRolAjax(){

        $datos = $this->idRol;

        $respuesta = Menu::mostrarSelectPermisosMenuController($datos);

        echo $respuesta;

    }

    public $pagInicio;
    public $namePage;

    public function guardarPaginaInicioRolAjax(){

        $datos = array("id_rol"=>$this->idRol,
                        "page_inicio"=>$this->pagInicio,
                        "namePage"=>$this->namePage);

        $respuesta = RolUsuario::guardarPaginaInicioRolController($datos);

        echo $respuesta;

    }
    
}

$g = new Globales();

if(isset($_POST["nombreRol"])){

    $a = new Ajax();
    $a -> idRol = $_POST["termRol"];
    $a -> nombreRol = $g->sanearData(ucfirst($_POST["nombreRol"]));
    $a -> oldNombreRol = $g->sanearData(ucfirst($_POST["oldNombreRol"]));
    $a -> mostrarInicio = isset($_POST["mostrar_inicio"]) ? $_POST["mostrar_inicio"] : "0";

    if($_POST["termRol"] == "0"){
        $a -> registrarRolAjax();
    }else{
        $a -> actualizarRolAjax();
    }
    
}

if(isset($_POST["id_rol"])){

    $b = new Ajax();
    $b -> idRol = $_POST["id_rol"];
    $b -> eliminarRolAjax();
}

if(isset($_POST["term"])){

    $c = new Ajax();
    $c -> idRol = $_POST["term"];
    $c -> pagInicio = $g->sanearData($_POST["inicio"]);
    $c -> mostrarPaginaInicioRolAjax();
}

if(isset($_POST["page"])){

    $d = new Ajax();
    $d -> idRol = $_POST["termRol"];
    $d -> pagInicio = $g->sanearData($_POST["page"]);
    $d -> namePage = $g->sanearData($_POST["namePage"]);
    $d -> guardarPaginaInicioRolAjax();
}