<?php

require_once "conexion.php";

class EmpresaModel{

    public static function guardarDatosEmpresaModel($datos,$tabla){

        $query = Conexion::conectar()->prepare("INSERT INTO $tabla (nombre,telefono,actividad_economica,propietario,foto,direccion)
                                                    VALUES (:nombre,:telefono,:actividad_economica,:propietario,:foto,:direccion) ");
        $query -> bindParam(":nombre",$datos["nombre"],PDO::PARAM_STR);
        $query -> bindParam(":telefono",$datos["telefono"],PDO::PARAM_STR);
        $query -> bindParam(":actividad_economica",$datos["actividad_economica"],PDO::PARAM_STR);
        $query -> bindParam(":propietario",$datos["propietario"],PDO::PARAM_STR);
        $query -> bindParam(":foto",$datos["foto"],PDO::PARAM_STR);
        $query -> bindParam(":direccion",$datos["direccion"],PDO::PARAM_STR);

        if($query->execute()){

            return "ok";

        }else{

            return "error";
            
        }

        $query -> close();

    }
    
    public static function actualizarDatosEmpresaModel($datos,$tabla){

        $query = Conexion::conectar()->prepare("UPDATE $tabla
                                                SET nombre = :nombre, telefono =:telefono, actividad_economica =:actividad_economica,
                                                propietario =:propietario, foto =:foto, direccion =:direccion
                                                WHERE id_empresa =:id_empresa LIMIT 1 ");
        $query -> bindParam(":nombre",$datos["nombre"],PDO::PARAM_STR);
        $query -> bindParam(":telefono",$datos["telefono"],PDO::PARAM_STR);
        $query -> bindParam(":actividad_economica",$datos["actividad_economica"],PDO::PARAM_STR);
        $query -> bindParam(":propietario",$datos["propietario"],PDO::PARAM_STR);
        $query -> bindParam(":foto",$datos["foto"],PDO::PARAM_STR);
        $query -> bindParam(":direccion",$datos["direccion"],PDO::PARAM_STR);
        $query -> bindParam(":id_empresa",$datos["id_empresa"],PDO::PARAM_INT);

        if($query->execute()){

            return "ok";

        }else{

            return "error";
            
        }

        $query -> close();

    }

    public static function datosEmpresaModel($tabla){

        $query = Conexion::conectar()->prepare("SELECT id_empresa,nombre,telefono,actividad_economica,propietario,foto,direccion
                                                FROM $tabla");
        $query -> execute();

        return $query -> fetch();

        $query -> close();

    }
}