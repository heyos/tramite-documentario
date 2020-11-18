<?php

require_once "conexion.php";

class IngresoModels{

    public static function ingresoModel($datos,$tabla){

        $query = Conexion::conectar()->prepare("SELECT id_usuario,nombres,apellidos,username,password,id_rol,intentos
                                                    FROM $tabla
                                                    WHERE username = :username AND borrado ='0' ");
        $query -> bindParam(":username",$datos["username"],PDO::PARAM_STR);
        $query -> execute();

        return $query -> fetch();

        $query -> close();


    }

    public static function actualizarIntentosModel($datos,$tabla){

        $query = Conexion::conectar() -> prepare("UPDATE $tabla 
                                                SET intentos = :intentos
                                                WHERE usuario = :usuario");
        $query -> bindParam(":intentos",$datos["intentos"],PDO::PARAM_INT);
        $query -> bindParam(":usuario",$datos["usuarioActual"],PDO::PARAM_STR);

        if($query -> execute()){
            return "ok";
        }else{
            return "error";
        }

        $query -> close();
    }


}