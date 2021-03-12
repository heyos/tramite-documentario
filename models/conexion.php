<?php

class Conexion{

    public static function conectar(){
        
        $link = new PDO("mysql:host=localhost;dbname=tramite_db","root","admin1702");

        return $link;
    }
}