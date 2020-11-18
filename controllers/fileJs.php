<?php

class File{

    public static function listarFilesController(){

        if(isset($_GET["action"]) && !empty($_GET["action"])){

            $type = "";

            $enlaces = $_GET["action"];
            $enlaces = Globales::sanearData($enlaces);
            $url = $enlaces;

            $where = sprintf(" url = '%s' AND ",$url);

            $verificarMenu = EnlacesModels::datosMenuModel($where,"menu");

            if(!empty($verificarMenu["id_menu"])){

                $type = "m";
                $id = $verificarMenu["id_menu"];

            }

            $verificarSub = EnlacesModels::datosSubMenuModel($where,"sub_menu");

            if(!empty($verificarSub["id_sub_menu"])){

                $type = "s";
                $id = $verificarSub["id_sub_menu"];
            }

            if($type=="m"){
                $where = sprintf(" j.id_menu = '%d' AND ",$id);
            }elseif ($type == "s"){
                $where = sprintf(" j.id_sub_menu = '%d' AND ",$id);
            }

            $respuesta = FileModel::listarFilesModel($where,"js_menu_asociado AS j, file_js AS f");

            if(count($respuesta) > 0){ //si cumple porque manda un array con los datos

                foreach ($respuesta as $row => $item) {
                    
                    echo '<script src="views/mainJs/'.$item[2].'"></script>';
                }

            }else if($enlaces == 'ingreso'){
                echo '<script src="views/mainJs/mainJsIngreso.js"></script>';
            }else{
                echo '<script src="views/mainJs/mainJsIngreso.js"></script>';
            }

        }else{
            echo '<script src="views/mainJs/mainJsIngreso.js"></script>';
        }


    }


}