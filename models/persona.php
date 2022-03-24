<?php

require_once "model.php";

class PersonaModel extends Model{

    public static function mostrarPersonaFilterModel($datos,$tabla){

        $where = $datos["where"];
        $offset = $datos["offset"];
        $rowsPerPage = $datos["rowsPerPage"];

        $limit = sprintf(" LIMIT %d,%d ",$offset,$rowsPerPage);

        $select = "*";
        $join = "";

        if($datos['tipo']=='j'){
            //$select = "p.*, t.xvalor1 AS pais";
            //$join =" JOIN tabla_logica t ON t.id_tbl = p.cPais ";
            $select = "p.*,p.cPais AS pais";
        }elseif($datos['tipo']=='n'){
            //$select = "p.*, t.xvalor1 AS cargo";
            //$join =" JOIN tabla_logica t ON t.id_tbl = p.cTipCar ";
            $select = "p.*,p.cTipCar AS cargo";
        }

        $sql = sprintf("SELECT %s FROM %s %s WHERE %s  %s",
                        $select,$tabla,$join,$where,$limit);

        $query = Conexion::conectar()->prepare($sql);

        $query -> execute();

        return $query -> fetchAll(PDO::FETCH_ASSOC);

        $query -> close();
    }

    public static function mostrarPersonaGeneralModel($datos,$tabla){

        $sql = "SELECT * FROM $tabla WHERE $datos ";

        //echo $sql;

        $query = Conexion::conectar()->prepare($sql);

        $query -> execute();

        return $query -> fetchAll();

        $query -> close();
    }


}
