<?php

require_once "conexion.php";

class RolUsuarioModel{

    public static function selectOptionRolModel($tabla){

        $query = Conexion::conectar()->prepare("SELECT id_rol,descripcion,mostrar_inicio
                                                FROM $tabla
                                                WHERE borrado = '0'");
        $query -> execute();

        return $query -> fetchAll();

        $query -> close();

    }

    public static function mostrarRolModel($datos,$tabla){

        $where = $datos["where"];
        $offset = $datos["offset"];
        $rowsPerPage = $datos["rowsPerPage"];

        $limit = sprintf(" LIMIT %d,%d ",$offset,$rowsPerPage);

        $query = Conexion::conectar()->prepare("SELECT id_rol,descripcion,mostrar_inicio,page_inicio
                                                FROM $tabla
                                                WHERE $where borrado = '0' $limit");
        $query -> execute();

        return $query -> fetchAll();

        $query -> close();

    }

    public static function mostrarRolModelGeneral($datos,$tabla){

        $query = Conexion::conectar()->prepare("SELECT id_rol,descripcion,mostrar_inicio
                                                FROM $tabla
                                                WHERE $datos borrado = '0'");
        $query -> execute();

        return $query -> fetchAll();

        $query -> close();
    }

    public static function datosRolModel($datos,$tabla){

        $query = Conexion::conectar()->prepare("SELECT id_rol,descripcion,mostrar_inicio,page_inicio
                                                FROM $tabla
                                                WHERE $datos borrado = '0' LIMIT 1 ");
        $query -> execute();

        return $query -> fetch();

        $query -> close();
    }

    public static function registrarRolModel($datos,$tabla){

        $query = Conexion::conectar()->prepare("INSERT INTO $tabla (descripcion,mostrar_inicio)
                                                VALUES (:descripcion,:mostrar_inicio) ");
        $query -> bindParam(":descripcion",$datos["descripcion"],PDO::PARAM_STR);
        $query -> bindParam(":mostrar_inicio",$datos["mostrar_inicio"],PDO::PARAM_STR);

        if($query->execute()){
            return "ok";
        }else{
            return "error";
        }

        $query -> close();

    }

    public static function actualizarRolModel($datos,$tabla){

        $query = Conexion::conectar()->prepare("UPDATE $tabla
                                                SET descripcion = :descripcion, mostrar_inicio =:mostrar_inicio
                                                WHERE id_rol = :id_rol ");
        $query -> bindParam(":descripcion",$datos["descripcion"],PDO::PARAM_STR);
        $query -> bindParam(":mostrar_inicio",$datos["mostrar_inicio"],PDO::PARAM_STR);
        $query -> bindParam(":id_rol",$datos["id_rol"],PDO::PARAM_INT);

        if($query->execute()){
            return "ok";
        }else{
            return "error";
        }

        $query -> close();

    }

    public static function guardarPaginaInicioRolModel($datos,$tabla){

        $query = Conexion::conectar()->prepare("UPDATE $tabla
                                                SET page_inicio = :page_inicio
                                                WHERE id_rol = :id_rol ");
        $query -> bindParam(":page_inicio",$datos["page_inicio"],PDO::PARAM_STR);
        $query -> bindParam(":id_rol",$datos["id_rol"],PDO::PARAM_INT);

        if($query->execute()){
            return "ok";
        }else{
            return "error";
        }

        $query -> close();

    }

    public static function eliminarRolModel($datos,$tabla){

        $query = Conexion::conectar()->prepare("UPDATE $tabla
                                                SET borrado = '1'
                                                WHERE id_rol = :id_rol ");
        $query -> bindParam(":id_rol",$datos,PDO::PARAM_INT);

        if($query->execute()){
            return "ok";
        }else{
            return "error";
        }

        $query -> close();

    }
}