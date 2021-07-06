<?php

class File{

    public static function listarFilesController(){

        $enlaces = isset($_GET["action"]) ? $_GET["action"] : '';

        if(isset($_GET["action"]) && !empty($_GET["action"]) && isset($_SESSION['validar']) ){

            $type = "";

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
                    $str = 'views/mainJs/'.$item[2];
                    echo '<script src="'.assetsR($str).'"></script>';
                }

            }else if($enlaces == 'ingreso'){
                echo '<script src="'.assetsR('views/mainJs/mainJsIngreso.js').'"></script>';
            }else if($enlaces == 'inicio'){
                echo '<script src="'.assetsR('views/mainJs/mainJsIngreso.js').'"></script>';
                //luego poner script dashboard
            }else if($enlaces == 'consulta_externa'){
                echo '<script src="'.assetsR("views/mainJs/mainJsDescargarDocumentos.js").'"></script>';
            }else{
              echo '<script src="'.assetsR("views/mainJs/mainJsIngreso.js").'"></script>';
            }

        }else if($enlaces == 'consulta_externa'){
            echo '<script src="'.assetsR("views/mainJs/mainJsDescargarDocumentos.js").'"></script>';
        }else{
            echo '<script src="'.assetsR('views/mainJs/mainJsIngreso.js').'"></script>';
        }


    }


}
