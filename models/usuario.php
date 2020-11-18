<?php

require_once "conexion.php";

class UsuarioModel{

    public static function mostrarUsuarioFilterModel($datos,$tabla){

        $where = $datos["where"];
        $offset = $datos["offset"];
        $rowsPerPage = $datos["rowsPerPage"];

        $limit = sprintf(" LIMIT %d,%d ",$offset,$rowsPerPage);

        $query = Conexion::conectar()->prepare("SELECT u.id_usuario,u.dni,u.nombres,u.apellidos,u.num_tel,u.id_rol,r.descripcion,u.username
                                                    FROM $tabla
                                                    WHERE $where u.borrado = '0' AND u.id_rol = r.id_rol $limit");
        
        $query -> execute();

        return $query -> fetchAll();
        
        $query -> close();
    }

    public static function mostrarUsuarioGeneralModel($datos,$tabla){

        $query = Conexion::conectar()->prepare("SELECT u.id_usuario,u.dni,u.nombres,u.apellidos,u.num_tel,u.id_rol,r.descripcion,u.username
                                                    FROM $tabla
                                                    WHERE $datos u.borrado = '0' AND u.id_rol = r.id_rol");
        
        $query -> execute();

        return $query -> fetchAll();
        
        $query -> close();
    }

    public static function guardarUsuarioModel($datos,$tabla){

        $query = Conexion::conectar()->prepare("INSERT INTO $tabla (nombres,apellidos,dni,num_tel,id_rol,username,password)
                                                VALUES (:nombres,:apellidos,:dni,:num_tel,:id_rol,:username,:password)");
        $query -> bindParam(":nombres",$datos["nombres"],PDO::PARAM_STR);
        $query -> bindParam(":apellidos",$datos["apellidos"],PDO::PARAM_STR);
        $query -> bindParam(":dni",$datos["dni"],PDO::PARAM_STR);
        $query -> bindParam(":num_tel",$datos["num_tel"],PDO::PARAM_STR);
        $query -> bindParam(":id_rol",$datos["id_rol"],PDO::PARAM_INT);
        $query -> bindParam(":username",$datos["username"],PDO::PARAM_STR);
        $query -> bindParam(":password",$datos["password"],PDO::PARAM_STR);

        if($query -> execute()){
            return "ok";
        }else{
            return "error";
        }

        $query -> close();

    }

    public static function actualizarUsuarioModel($datos,$tabla){

        $query = Conexion::conectar()->prepare("UPDATE $tabla 
                                                SET nombres =:nombres,apellidos =:apellidos,
                                                dni =:dni,num_tel =:num_tel,
                                                id_rol =:id_rol,username =:username,password =:password
                                                WHERE id_usuario = :id_usuario ");
        $query -> bindParam(":nombres",$datos["nombres"],PDO::PARAM_STR);
        $query -> bindParam(":apellidos",$datos["apellidos"],PDO::PARAM_STR);
        $query -> bindParam(":dni",$datos["dni"],PDO::PARAM_STR);
        $query -> bindParam(":num_tel",$datos["num_tel"],PDO::PARAM_STR);
        $query -> bindParam(":id_rol",$datos["id_rol"],PDO::PARAM_INT);
        $query -> bindParam(":username",$datos["username"],PDO::PARAM_STR);
        $query -> bindParam(":password",$datos["password"],PDO::PARAM_STR);
        $query -> bindParam(":id_usuario",$datos["id_usuario"],PDO::PARAM_INT);

        if($query -> execute()){
            return "ok";
        }else{
            return "error";
        }

        $query -> close();

    }

    public static function verificarUsuarioModel($datos,$tabla){

        $query = Conexion::conectar()->prepare("SELECT id_usuario,dni,nombres,apellidos,num_tel,id_rol,username,CONCAT(nombres,' ',apellidos) AS fullname, password
                                                FROM $tabla
                                                    $datos AND borrado = '0'  ");
        $query -> execute();

        return $query -> fetch();
        
        $query -> close();
    }

    public static function datosUsuarioModel($datos,$tabla){

        $query = Conexion::conectar()->prepare("SELECT u.id_usuario,u.dni,u.nombres,u.apellidos,u.num_tel,u.id_rol,r.descripcion,u.username, u.password
                                                    FROM $tabla
                                                    WHERE $datos u.borrado = '0' AND u.id_rol = r.id_rol");
        $query -> execute();

        return $query -> fetch();
        
        $query -> close();
    }

    public static function eliminarUsuarioModel($datos,$tabla){

        $query = Conexion::conectar()->prepare("UPDATE $tabla 
                                                SET borrado = '1'
                                                WHERE id_usuario = :id_usuario ");
        $query -> bindParam(":id_usuario",$datos,PDO::PARAM_INT);

        if($query -> execute()){
            return "ok";
        }else{
            return "error";
        }

        $query -> close();
    }
    
}