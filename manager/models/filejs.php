<?php

require_once "conexion.php";

class FileModel{

    //MOSTRAR

    public static function mostrarFileJsModel($datos,$tabla){

        $query = Conexion::conectar()->prepare("SELECT id_file,file,sistema
                                                FROM $tabla
                                                WHERE $datos borrado = '0'");
        $query -> execute();

        return $query -> fetchAll();

        $query -> close();

    }

    public static function mostrarFileJsFilterModel($datos,$tabla){

        $where = $datos["where"];
        $offset = $datos["offset"];
        $rowsPerPage = $datos["rowsPerPage"];

        $limit = sprintf(" LIMIT %d,%d ",$offset,$rowsPerPage);

        $query = Conexion::conectar()->prepare("SELECT id_file,file,sistema
                                                FROM $tabla
                                                WHERE $where borrado = '0' $limit");
        $query -> execute();

        return $query -> fetchAll();

        $query -> close();
    }

    //OBTENER DATOS

    public static function datosFileJsModel($datos,$tabla){

        $query = Conexion::conectar()->prepare("SELECT id_file,file,sistema
                                                FROM $tabla
                                                WHERE $datos borrado = '0'");
        $query -> execute();

        return $query -> fetch();

        $query -> close();
    }

    //GUARDAR
    public static function guardarFileJsModel($datos,$tabla){

        $query = Conexion::conectar()->prepare("INSERT INTO $tabla (file)
                                                VALUES (:file)");
        $query->bindParam(":file",$datos,PDO::PARAM_STR);
        
        if($query -> execute()){
            return "ok";
        }else{
            return 'error' ;
        }
        
        $query -> close();
    }

    //ACTUALIZAR
    public static function actualizarFileJsModel($datos,$tabla){

        $query = Conexion::conectar()->prepare("UPDATE $tabla
                                                SET file =:file
                                                WHERE id_file =:id_file ");
        $query->bindParam(":file",$datos["file"],PDO::PARAM_STR);
        $query->bindParam(":id_file",$datos["id_file"],PDO::PARAM_INT);
        
        if($query -> execute()){
            return "ok";
        }else{
            return 'error' ;
        }
        
        $query -> close();
    }

    //ELIMINAR
    public static function eliminarFileJsModel($datos,$tabla){

        $query = Conexion::conectar()->prepare("UPDATE $tabla
                                                SET borrado = '1'
                                                WHERE id_file =:id_file ");
        $query->bindParam(":id_file",$datos,PDO::PARAM_INT);
        
        if($query -> execute()){
            return "ok";
        }else{
            return 'error' ;
        }
        
        $query -> close();
        
    }
}