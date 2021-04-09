<?php

class Conexion{

    public static function conectar(){
        
        $link = new PDO("mysql:host=localhost;dbname=tramite_db","root","");
        //$link = new PDO("mysql:host=localhost;dbname=hlevwvqa_tramite","hlevwvqa_heyos","heyller30/06");

        return $link;
    }
}