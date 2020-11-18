<?php

class EnlacesModels{

    public static function enlaceModel($enlaces){

        if($enlaces == "inicio" ||
            $enlaces == "configurar_empresa" ||
            $enlaces == "registrar_usuario" ||
            $enlaces == "rol_usuario" ||
            $enlaces == "registrar_menu"||
            $enlaces == "permisos_usuario"||
            $enlaces == "asociar_js" ||
            $enlaces == "registrar_file_js" ||
            $enlaces == "ordenar_menu" ||
            $enlaces == "ordenar_submenu"||
            $enlaces == "menu_dinamico"){

            $module = "views/modules/".$enlaces.".php";
        
        }else if($enlaces=="index"){
            $module = "views/modules/inicio.php";
        }else{
            $module = "views/modules/inicio.php";
        }

        return $module;

    }

}