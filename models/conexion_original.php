<?php

class Conexion{

    public static function conectar(){
        
        $link = new PDO("mysql:host=localhost;dbname=enterpri_menu15","enterpri_menu15","Medinort99");

        return $link;
    }
}