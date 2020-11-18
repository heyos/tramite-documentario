<?php

require_once "conexion.php";

class FileModel{

    public static function listarFilesModel($datos,$tabla){

        $query = Conexion::conectar() ->prepare("SELECT j.id_js,j.id_file, f.file
                                                    FROM $tabla
                                                    WHERE $datos j.borrado = '0' AND j.id_file = f.id_file ");
        $query -> execute();

        return $query->fetchAll();

        $query -> close();

    }

}