<?php

require_once "conexion.php";

class TablaLogicaModel{

    public static function mostrarTablaLogicaModel($datos,$tabla){

        $query = Conexion::conectar()->prepare("SELECT id_tbl, cidtabla, validar_campos,columnas
                                                FROM $tabla $datos GROUP BY cidtabla");

        $query -> execute();

        return $query -> fetchAll();

        $query -> close();

        $query = null;

    }


    public static function mostrarTablaLogicaFilterModel($datos,$tabla){

        $where = $datos["where"];
        $offset = $datos["offset"];
        $rowsPerPage = $datos["rowsPerPage"];

        $limit = sprintf(" LIMIT %d,%d ",$offset,$rowsPerPage);

        $query = Conexion::conectar()->prepare("SELECT id_tbl, cidtabla, validar_campos,columnas
                                                FROM $tabla
                                                $where GROUP BY cidtabla $limit");

        $query -> execute();

        return $query -> fetchAll();

        $query -> close();

        $query = null;

    }

    public static function datosTablaModel($datos,$tabla){

        $query = Conexion::conectar()->prepare("SELECT id_tbl, cidtabla, validar_campos,columnas
                                                FROM $tabla $datos GROUP BY cidtabla");

        $query -> execute();

        return $query -> fetch();

        $query -> close();

        $query = null;

    }

    public static function obtenerDatosTablaModel($datos,$tabla){

        $query = Conexion::conectar()->prepare("SELECT id_tbl, cidtabla,xidelem,nvalor1,nvalor2,xvalor1,xvalor2, validar_campos,columnas
                                                FROM $tabla $datos");

        $query -> execute();

        return $query -> fetchAll();

        $query -> close();

        $query = null;
    }

    public static function guardarTablaModel($datos,$tabla){
        
        $query = Conexion::conectar()->prepare("INSERT INTO $tabla (cidtabla,xidelem,nvalor1,nvalor2,xvalor1,xvalor2,tipo,validar_campos,columnas)
                                                VALUES (:cidtabla,:xidelem,:nvalor1,:nvalor2,:xvalor1,:xvalor2,:tipo,:validar,:columnas) ");
        
        $query -> bindParam(':cidtabla',$datos['cidtabla'],PDO::PARAM_STR);
        $query -> bindParam(':xidelem',$datos['xidelem_value'],PDO::PARAM_STR);
        $query -> bindParam(':nvalor1',$datos['nvalor1_value'],PDO::PARAM_STR);
        $query -> bindParam(':nvalor2',$datos['nvalor2_value'],PDO::PARAM_STR);
        $query -> bindParam(':xvalor1',$datos['xvalor1_value'],PDO::PARAM_STR);
        $query -> bindParam(':xvalor2',$datos['xvalor2_value'],PDO::PARAM_STR);
        $query -> bindParam(':tipo',$datos['tipo'],PDO::PARAM_STR);
        $query -> bindParam(':validar',$datos['validar'],PDO::PARAM_STR);
        $query -> bindParam(':columnas',$datos['columnas'],PDO::PARAM_STR);

        if($query->execute()){
            return "ok";
        }else{
            return "error";
        }

        $query -> close();
        $query = null;

    }

    public static function actualizarTablaModel($datos,$tabla){

        $query = Conexion::conectar()->prepare("UPDATE $tabla
                                                SET $datos ");

        if($query->execute()){
            return "ok";
        }else{
            return "error" ;
        }

        $query -> close();
        $query = null;

    }

    public static function eliminarTablaModel($datos,$tabla){

        $query = Conexion::conectar()->prepare("DELETE FROM $tabla
                                                WHERE cidtabla = :cidtabla ");

        $query -> bindParam(':cidtabla',$datos['cidtabla'],PDO::PARAM_STR);

        if($query->execute()){
            return "ok";
        }else{
            return "error" ;
        }

        $query -> close();
        $query = null;

    }

}