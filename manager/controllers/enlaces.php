<?php

class Enlaces{

    public static function enlaceController(){

        if(isset($_GET["action"])){

            $enlaces = $_GET["action"];
            $enlaces = Globales::sanearData($enlaces);
            
        }else{

            $enlaces = "index";
        
        }

        $respuesta = EnlacesModels::enlaceModel($enlaces);

        include $respuesta;

    }

    public static function titlePageController(){

        if(isset($_GET["action"])){

            $title = $_GET["action"];
            $title = Globales::sanearData($title);
            $title = str_replace("_", " ", $title);

        }else{

            $title = "Inicio";
        }

        echo ucwords($title);

    }


}