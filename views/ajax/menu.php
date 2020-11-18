<?php

require_once "../../controllers/menu.php";
require_once "../../models/menu.php";

class Ajax{

    //MENU
    public $idMenu;
    public $ordenItem;

    public function actualizarOrdenMenu(){

        $datos = array("id_menu"=>$this->idMenu,
                        "orden"=>$this->ordenItem);

        $respuesta = Menu::actualizarOrdenMenuController($datos);

        echo $respuesta;
    
    }

    //SUBMENU
    public $idSubMenu;
    public $ordenItemSub;

    public function actualizarOrdenSubMenu(){

        $datos = array("id_sub_menu"=>$this->idSubMenu,
                        "orden"=>$this->ordenItemSub);

        $respuesta = Menu::actualizarOrdenSubMenuController($datos);

        echo $respuesta;
        
    }

    //PERMISOS
    public $accion;
    public $value;
    public $idRol;

    public function permisosMenuSubMenuAjax(){

        $datos = array("id_menu" => $this->idMenu,
                        "value" => $this->value,
                        "accion"=> $this->accion,
                        "id_sub_menu" => $this->idSubMenu,
                        "id_rol"=> $this->idRol);

        if($this->accion == "acceso" || $this->accion == "mantenimiento"){

            $respuesta = Menu::darPermisoMenuController($datos);

        }else{

            $respuesta = Menu::darPermisoSubMenuController($datos);

        }

        echo $respuesta;

    }


}

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

if(isset($_POST["accion"])){

    $c = new Ajax();
    $c -> idMenu = $_POST["idMenu"];
    $c -> accion = $_POST["accion"];
    $c -> value = $_POST["value"];
    $c -> idSubMenu = $_POST["idSub"];
    $c -> idRol = $_POST["rol"];
    $c -> permisosMenuSubMenuAjax();
}