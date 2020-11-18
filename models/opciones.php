<?php
require_once "conexion.php";

class ConfiguracionModel{

    public static function datosConfiguracionModel($tabla){

        $query = Conexion::conectar()->prepare("SELECT id_configuracion,temas,vista_menu FROM $tabla LIMIT 1");

        $query -> execute();

        return $query -> fetch() ;

        $query -> close();
    }

    public static function guardarConfiguracionModel($datos,$tabla){

        $query = Conexion::conectar()->prepare("INSERT INTO $tabla (temas,vista_menu)
                                                VALUES (:tema,:vista_menu)");
        
        $query -> bindParam(":tema",$datos["tema"],PDO::PARAM_STR);
        $query -> bindParam(":vista_menu",$datos["vista_menu"],PDO::PARAM_STR);
        

        if($query -> execute()){
            return "ok";
        }else{
            return "error";
        }

        $query -> close();
    }

    public static function actualizarConfiguracionModel($datos,$tabla){

        $query = Conexion::conectar()->prepare("UPDATE $tabla
                                                SET temas =:tema,vista_menu=:vista_menu 
                                                WHERE id_configuracion=:id LIMIT 1");
        $query -> bindParam(":tema",$datos["tema"],PDO::PARAM_STR);
        $query -> bindParam(":vista_menu",$datos["vista_menu"],PDO::PARAM_STR);
        $query -> bindParam(":id",$datos["id"],PDO::PARAM_INT);

        if($query -> execute()){
            return "ok";
        }else{
            return "error";
        }

        $query -> close();
    }

}