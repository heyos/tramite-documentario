<?php

require_once "conexion.php";

class DatosTablaModel{

    public static function mostrarDatosTablaModel($datos,$tabla){

        $query = Conexion::conectar()->prepare("SELECT id_tbl,xidelem, cidtabla, validar_campos,columnas
                                                FROM $tabla $datos ");

        $query -> execute();

        return $query -> fetchAll();

        $query -> close();

        $query = null;

    }

    public static function mostrarDatosTablaFilterModel($datos,$tabla){

        $where = $datos["where"];
        $offset = $datos["offset"];
        $rowsPerPage = $datos["rowsPerPage"];

        $limit = sprintf(" LIMIT %d,%d ",$offset,$rowsPerPage);

        $query = Conexion::conectar()->prepare("SELECT id_tbl,xidelem, cidtabla, validar_campos,columnas
                                                FROM $tabla
                                                $where $limit");

        $query -> execute();

        return $query -> fetchAll();

        $query -> close();

        $query = null;

    }

    public static function guardarDatosTablaModel($datos,$tabla){
        
        $query = Conexion::conectar()->prepare("INSERT INTO $tabla (cidtabla,xidelem,nvalor1,nvalor2,xvalor1,xvalor2,tipo,validar_campos,columnas)
                                                VALUES (:cidtabla,:xidelem,:nvalor1,:nvalor2,:xvalor1,:xvalor2,:tipo,:validar,:columnas) ");
        
        $query -> bindParam(':cidtabla',$datos['cidtabla'],PDO::PARAM_STR);
        $query -> bindParam(':xidelem',$datos['xidelem_value'],PDO::PARAM_STR);
        $query -> bindParam(':nvalor1',$datos['nvalor1_value'],PDO::PARAM_STR);
        $query -> bindParam(':nvalor2',$datos['nvalor2_value'],PDO::PARAM_STR);
        $query -> bindParam(':xvalor1',$datos['xvalor1_value'],PDO::PARAM_STR);
        $query -> bindParam(':xvalor2',$datos['xvalor2_value'],PDO::PARAM_STR);
        $query -> bindParam(':tipo',$datos['tipo'],PDO::PARAM_STR);
        $query -> bindParam(':validar',$datos['validar_campos'],PDO::PARAM_STR);
        $query -> bindParam(':columnas',$datos['columnas'],PDO::PARAM_STR);

        if($query->execute()){
            return "ok";
        }else{
            return "error";
        }

        $query -> close();
        $query = null;

    }

    public static function ultimoIdRegistradoModel($datos,$tabla){

        $id = 0;

        $query = Conexion::conectar()->prepare("SELECT MAX($datos) AS ultimo_id
                                                FROM $tabla LIMIT 1");

        $query->execute();

        $respuesta = $query->fetch();

        if(!empty($respuesta['ultimo_id'])){

            $id = $respuesta['ultimo_id'];
        }

        return $id;

        $query -> close();
        $query = null;

    }

    public static function actualizarDatosTablaModel($datos,$tabla){
        
        $query = Conexion::conectar()->prepare("UPDATE $tabla
                                                SET cidtabla =:cidtabla,xidelem =:xidelem,
                                                    nvalor1 =:nvalor1,nvalor2=:nvalor2,
                                                    xvalor1=:xvalor1,xvalor2=:xvalor2,
                                                    validar_campos=:validar,columnas=:columnas
                                                WHERE id_tbl =:id ");
        
        $query -> bindParam(':cidtabla',$datos['cidtabla'],PDO::PARAM_STR);
        $query -> bindParam(':xidelem',$datos['xidelem_value'],PDO::PARAM_STR);
        $query -> bindParam(':nvalor1',$datos['nvalor1_value'],PDO::PARAM_STR);
        $query -> bindParam(':nvalor2',$datos['nvalor2_value'],PDO::PARAM_STR);
        $query -> bindParam(':xvalor1',$datos['xvalor1_value'],PDO::PARAM_STR);
        $query -> bindParam(':xvalor2',$datos['xvalor2_value'],PDO::PARAM_STR);
        $query -> bindParam(':validar',$datos['validar_campos'],PDO::PARAM_STR);
        $query -> bindParam(':columnas',$datos['columnas'],PDO::PARAM_STR);
        $query -> bindParam(':id',$datos['id'],PDO::PARAM_INT);

        if($query->execute()){
            return "ok";
        }else{
            return "error";
        }

        $query -> close();
        $query = null;

    }

    public static function eliminarDatosTablaModel($datos,$tabla){
        
        $query = Conexion::conectar()->prepare("DELETE FROM $tabla
                                                WHERE xidelem =:codigo AND cidtabla = :tabla AND tipo =:tipo");
        
        $query -> bindParam(':codigo',$datos['codigo'],PDO::PARAM_STR);
        $query -> bindParam(':tabla',$datos['cidtabla'],PDO::PARAM_STR);
        $query -> bindParam(':tipo',$datos['tipo'],PDO::PARAM_STR);

        if($query->execute()){
            return "ok";
        }else{
            return "error";
        }

        $query -> close();
        $query = null;

    }
    
}