<?php

require_once "../../controllers/globales.php";
require_once "../../controllers/menu.php";
require_once "../../models/menu.php";

class Ajax{

    //MENU
    public $idMenu;
    public $nombreMenu;
    public $icono;
    public $urlMenu;
    public $visible;
    public $nombreSub;
    public $urlSub;

    public function guardarMenuAjax(){

        $datos = array("descripcion"=>ucwords($this->nombreMenu),
                        "icono"=>$this->icono,
                        "urlMenu"=>str_replace(" ", "_", $this->urlMenu),
                        "visible"=>$this->visible,
                        "descripcionSub"=>$this->nombreSub,
                        "urlSub"=>$this->urlSub);

        $respuesta = Menu::guardarMenuController($datos);

        echo $respuesta;

    }

    
    public function obtenerDatosMenuAjax(){

        $datos = $this->idMenu;

        $respuesta = Menu::datosMenuController($datos);

        echo $respuesta;

    }
    

    //actualizar Menu
    public $accion;

    public function actualizarEliminarMenuAjax(){

        $datos = array("id_menu"=>$this->idMenu,
                        "descripcion"=>ucwords($this->nombreMenu),
                        "icono"=>$this->icono,
                        "urlMenu"=>str_replace(" ", "_", $this->urlMenu),
                        "visible"=>$this->visible);

        switch ($this->accion) {
            
            case 'addMenu':
                $respuesta = Menu::agregarMenuController($datos); //solo es valido cuando la peticion viene de menu_dinamico
                break;

            case 'actualizarMenu':
                $respuesta = Menu::actualizarMenuController($datos);
                break;
            case 'eliminarMenu':
                $respuesta = Menu::eliminarMenuController($datos);
                break;
            default:
                
                break;
        }

        echo $respuesta;

    }

    public $idSubMenu;

    public function obtenerDatosSubMenuAjax(){

        $datos = $this->idSubMenu;

        $respuesta = Menu::datosSubMenuController($datos);

        echo $respuesta;

    }

    public function actualizarEliminarSubMenuAjax(){

        $datos = array("id_menu"=>$this->idMenu,
                        "id_sub_menu"=>$this->idSubMenu,
                        "descripcion"=>ucwords($this->nombreSub),
                        "urlSub"=>$this->urlSub);

        switch ($this->accion) {

            case 'add':
                
                $respuesta = Menu::agregarSubMenuController($datos);

                break;

            case 'update':

                $respuesta = Menu::actualizarSubMenuController($datos);
                
                break;

            case 'eliminarSubMenu':
                
                $respuesta = Menu::eliminarSubMenuController($datos);

                break;

            default:
                $respuesta = $datos;
                break;
        }


        echo $respuesta;

    }

    //PERMISOS
    public $value;
    public $idRol;

    public function permisosMenuSubMenuAjax(){

        $datos = array("id_menu" => $this->idMenu,
                        "value" => $this->value,
                        "accion"=> $this->accion,
                        "id_sub_menu" => $this->idSubMenu,
                        "id_rol"=> $this->idRol);

        //echo json_encode($datos);
        
        if($this->accion == "acceso" || $this->accion == "mantenimiento"){

            $respuesta = Menu::darPermisoMenuController($datos);

        }else{

            $respuesta = Menu::darPermisoSubMenuController($datos);

        }
        
        echo $respuesta;

    }

    //ORDENAR
    //MENU
    public $ordenItem;

    public function actualizarOrdenMenu(){

        $datos = array("id_menu"=>$this->idMenu,
                        "orden"=>$this->ordenItem);

        $respuesta = Menu::actualizarOrdenMenuController($datos);

        echo $respuesta;
    
    }

    //SUBMENU
    public $ordenItemSub;

    public function actualizarOrdenSubMenu(){

        $datos = array("id_sub_menu"=>$this->idSubMenu,
                        "orden"=>$this->ordenItemSub);

        $respuesta = Menu::actualizarOrdenSubMenuController($datos);

        echo $respuesta;
        
    }

}

$g = new Globales();

if(isset($_POST["nombreMenu"])){

    $a = new Ajax();
    $a -> nombreMenu = $g->sanearData($_POST["nombreMenu"]);
    $a -> icono = $_POST["icono"];
    $a -> urlMenu = strtolower($_POST["urlMenu"]);
    $a -> visible =  (isset($_POST["visibleMenu"]))? $_POST["visibleMenu"]:"0";
    $a -> nombreSub = (isset($_POST["nombreSub"]))? $_POST["nombreSub"]:"0";
    $a -> urlSub = (isset($_POST["urlSub"]))? $_POST["urlSub"]:"0";
    $a -> guardarMenuAjax();
}

if (isset($_POST["menu"])) { 
    $b = new Ajax();
    $b -> idMenu = $_POST["menu"];
    $b -> obtenerDatosMenuAjax(); //retorna datos para mostrarlos en un modal para actualizar el menu
}

if(isset($_POST["accionMenu"])){ 

    $c = new Ajax();
    $c -> accion = $g->sanearData($_POST["accionMenu"]);
    $c -> idMenu = $_POST["termMenu"];
    $c -> nombreMenu = $g->sanearData($_POST["actualizarNombreMenu"]);
    $c -> icono = $_POST["actualizarIcono"];
    $c -> urlMenu = strtolower($_POST["actualizarUrlMenu"]);
    $c -> visible =  (isset($_POST["actualizarVisibleMenu"]))? $_POST["actualizarVisibleMenu"]:"0";
    $c -> actualizarEliminarMenuAjax(); //para actualizar y eliminar el menu
}

if(isset($_POST["subMenu"])){ 
    $d = new Ajax();
    $d -> idSubMenu = $_POST["subMenu"];
    $d -> obtenerDatosSubMenuAjax(); //retorna datos del submenu para mostrarlos en el modal
}

if(isset($_POST["accionSub"])){

    $e = new Ajax();
    $e -> accion = $g->sanearData($_POST["accionSub"]);
    $e -> idMenu = $_POST["termMenu_sub"];
    $e -> idSubMenu = $_POST["termSubMenu"];
    $e -> nombreSub = $g->sanearData($_POST["actualizarNombreSubMenu"]);
    $e -> urlSub = $_POST["actualizarUrlSubMenu"];
    $e -> actualizarEliminarSubMenuAjax();
}

//ACCIONES PARA ORDENAR MENU Y SUBMENU
if(isset($_POST["actualizarOrdenId"])){

    $a = new Ajax();
    $a -> idMenu = $_POST["actualizarOrdenId"];
    $a -> ordenItem = $_POST["actualizarOrdenItem"];
    $a -> actualizarOrdenMenu();
}

if(isset($_POST["actualizarOrdenIdSub"])){

    $b = new Ajax();
    $b -> idSubMenu = $_POST["actualizarOrdenIdSub"];
    $b -> ordenItemSub = $_POST["actualizarOrdenItemSub"];
    $b -> actualizarOrdenSubMenu();
}

//GENERAR PERMISOS SEGUN ELROL USUARIO
if(isset($_POST["accion"])){

    $f = new Ajax();
    $f -> idMenu = $_POST["idMenu"];
    $f -> accion = $_POST["accion"];
    $f -> value = $_POST["value"];
    $f -> idSubMenu = $_POST["idSub"];
    $f -> idRol = $_POST["rol"];
    $f -> permisosMenuSubMenuAjax();
}