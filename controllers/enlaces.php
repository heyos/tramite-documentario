<?php

class Enlaces{

    public static function enlaceController(){

        $rol = (isset($_SESSION["rol"]))?$_SESSION["rol"]:0;

        if(isset($_GET["action"])){

            $enlaces = $_GET["action"];
            $enlaces = Globales::sanearData($enlaces);
            $url = $enlaces;

        }else{

            $enlaces = "";
            $url = "";

        }

        $datosController = array("id_rol"=>$rol,"url"=>$url);

        $dir = '';

        //validar acceso a menu que no tiene submenu
        $respuesta = EnlacesModels::enlaceMenuModel($datosController,"detalle_menu AS d, menu AS m");

        if(!empty($respuesta[0])){

            $dir = $respuesta[1];
            $dir = str_replace(" ", "_", $dir);
            $module = "views/modules/".$dir."/".$enlaces.".php";

        }else{
          
            //acceso sub menu
            $respuesta = EnlacesModels::enlaceSubModel($datosController,"sub_menu AS s, detalle_sub_m AS d");

            if(!empty($respuesta[0])){

                $idMenu = $respuesta[1];

                $datosController["id_menu"] = $idMenu;

                //validar que tenga acceso al menu padre para recien poder ingresar al submenu
                $respuesta = EnlacesModels::revisarEnlaceMenuModel($datosController,"detalle_menu AS d, menu AS m");

                if(!empty($respuesta[0])){

                    $dir = $respuesta[1];
                    $dir = str_replace(" ", "_", $dir);
                    $module = "views/modules/".$dir."/".$enlaces.".php";

                }else{
                    $module = "views/modules/ingreso.php";

                }

            }else if(isset($_GET["action"]) && !empty($_GET["action"]) && $_GET["action"]=="salir"){

                $module = "views/modules/salir.php";

            }else if(isset($_GET["action"]) && !empty($_GET["action"]) && $_GET["action"]=="inicio"){

                $module = "views/modules/inicio.php";

            }else if(isset($_GET["action"]) && !empty($_GET["action"]) && $_GET["action"]=="consulta"){

                $module = "views/modules/Consulta/consulta.php";

            }else if(isset($_GET["action"]) && !empty($_GET["action"]) && $_GET["action"]=="ver"){
                
                $module = "views/modules/Consulta/visualizar.php";
            }else if(isset($_GET["action"]) && !empty($_GET["action"]) && $_GET["action"]=="consulta_externa"){
                $module = "views/modules/Consulta/consulta_externa.php";
            }else{
                $module = "views/modules/ingreso.php";
            }

        }

        include $module;

    }

    public static function titlePageController(){

        if(isset($_GET["action"])){

            $title = $_GET["action"];
            $title = Globales::sanearData($title);
            $title = str_replace("_", " ", $title);

        }else{

            $title = "signin";
        }

        echo ucwords($title);

    }

    public static function mantenimientoDatosController(){

        $rol = (isset($_SESSION["rol"]))?$_SESSION["rol"]:0;

        if(isset($_GET["action"])){

            $enlaces = $_GET["action"];
            $enlaces = Globales::sanearData($enlaces);
            $url = $enlaces;

        }else{

            $enlaces = "";
            $url = "";

        }

        $datos = array('id_rol'=>$rol,
                        'url'=>$url);

        $verificarMenu = EnlacesModels::enlaceMenuModel($datos,"detalle_menu AS d, menu AS m");

        if(!empty($verificarMenu[0])){

            $idMenu = $verificarMenu[0];
        }

        $verificarSubMenu = EnlacesModels::enlaceSubModel($datos,"sub_menu AS s, detalle_sub_m AS d");

        if(!empty($verificarSubMenu[1])){
            $idMenu = $verificarSubMenu[1];
        }

        $datos["id_menu"] = $idMenu;

        $respuesta = EnlacesModels::mantenimientoDatosModel($datos,"detalle_menu AS d, menu AS m");
        $mantenimiento = false;

        if(!empty($respuesta[1])){
            $mantenimiento = true;
        }

        return $mantenimiento;

    }

    public static function pageHeaderController(){

        $enlaces = "";
        $url = "";

        $contenido = "";


        if(isset($_GET["action"])){

            $enlaces = $_GET["action"];
            $enlaces = Globales::sanearData($enlaces);
            $url = $enlaces;

        }

        $where = sprintf(" url ='%s' AND ",$url);

        $menuDatos = EnlacesModels::datosMenuModel($where,"menu");

        if(!empty($menuDatos["descripcion"])){

            if($menuDatos["visible"] == '1'){
                $contenido = '<i class="'.$menuDatos["icono"].' page-header-icon"></i> '.$menuDatos["descripcion"];
            }
        }

        if($enlaces == 'inicio'){
            $contenido = '<i class="fas fa-tachometer-alt page-header-icon"></i> Inicio';
        }


        $subMenu = EnlacesModels::datosSubMenuModel($where,"sub_menu");

        if(!empty($subMenu["descripcion"])){

            $idMenu = $subMenu["id_menu"];

            $where = sprintf(" id_menu = '%d' AND ",$idMenu);
            $menu = EnlacesModels::datosMenuModel($where,"menu");

            if(!empty($menu["descripcion"])){

                if($menu["visible"] == '1'){
                    $contenido = '<span class="text-light-gray"><i class="'.$menu["icono"].' page-header-icon"></i> '.$menu["descripcion"].' / </span>'.$subMenu["descripcion"];
                }else{
                    $contenido = $subMenu["descripcion"];
                }

            }

        }


        echo $contenido;

    }

    public static function mostrarContenidoInicioController($datos){

        // if($datos == '1'){

        //     include 'views/modules/inicio/admin.php';

        // }else{
        //     include 'views/modules/inicio/user.php';
        // }

        include 'views/modules/inicio/admin.php';
    }

}
