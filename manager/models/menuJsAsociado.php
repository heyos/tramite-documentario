<?php

require_once "conexion.php";

class MenuJsModel{

    //MOSTRAR

    public static function mostrarDataJsModel($datos,$tabla){

        $query = Conexion::conectar() ->prepare("SELECT j.id_js,j.id_file, f.file,f.sistema
                                                    FROM $tabla
                                                    WHERE $datos j.borrado = '0' AND j.id_file = f.id_file ");
        $query -> execute();

        return $query->fetchAll();

        $query -> close();

    }

    

    //GUARDAR
    public static function guardarFileJsMenuModel($datos,$tabla){

        $query = Conexion::conectar()->prepare("INSERT INTO $tabla (id_file,id_menu)
                                                VALUES (:id_file,:id_menu) ");
        $query -> bindParam(":id_file",$datos["id_file"],PDO::PARAM_INT);
        $query -> bindParam(":id_menu",$datos["id"],PDO::PARAM_INT);
        
        
        if($query->execute()){
            return "ok";
        }else{
            return "error";
        }

        $query -> close();

    }

    public static function guardarFileJsSubMenuModel($datos,$tabla){

        $query = Conexion::conectar()->prepare("INSERT INTO $tabla (id_file,id_sub_menu)
                                                VALUES (:id_file,:id_sub_menu) ");
        $query -> bindParam(":id_file",$datos["id_file"],PDO::PARAM_INT);
        $query -> bindParam(":id_sub_menu",$datos["id"],PDO::PARAM_INT);
        
        if($query->execute()){
            return "ok";
        }else{
            return "error";
        }

        $query -> close();

    }

    //ACTUALIZAR
    public static function actualizarFileJsModel($datos,$tabla){

        $query = Conexion::conectar()->prepare("UPDATE $tabla 
                                                SET file =:file
                                                WHERE id_js =:id_js ");
        $query -> bindParam(":file",$datos["file"],PDO::PARAM_STR);
        $query -> bindParam(":id_js",$datos["id_js"],PDO::PARAM_INT);
        
        if($query->execute()){
            return "ok";
        }else{
            return "error";
        }

        $query -> close();

    }

    //OBTENER DATOS
    public static function datosFileJsModel($datos,$tabla){

        $query = Conexion::conectar() ->prepare("SELECT id_js,id_file,id_menu,id_sub_menu
                                                    FROM $tabla
                                                    WHERE $datos borrado = '0' LIMIT 1 ");
        $query -> execute();

        return $query->fetch();

        $query -> close();
    }

    public static function registroFileJsModel($datos,$tabla){

        $query = Conexion::conectar() ->prepare("SELECT j.id_js,j.id_file, f.file
                                                    FROM $tabla
                                                    WHERE $datos j.borrado = '0' AND j.id_file = f.id_file ");
        $query -> execute();

        return $query->fetch();

        $query -> close();

    }

    public static function ultimoIdRegistrado($datos,$tabla){

        $query = Conexion::conectar() ->prepare("SELECT MAX($datos) AS ultimo_id
                                                    FROM $tabla
                                                    WHERE borrado = '0' LIMIT 1");
    
        $query -> execute();

        $respuesta = $query -> fetch() ;

        $id = 0;

        if(!empty($respuesta["ultimo_id"])){

            $id = $respuesta["ultimo_id"];
        }

        return $id;

        $query -> close();
    }

    //ELIMINAR

    public static function eliminarFileJsModel($datos,$tabla){

        $query = Conexion::conectar() ->prepare("DELETE FROM $tabla
                                                    WHERE id_js =:id ");
        $query -> bindParam(":id",$datos,PDO::PARAM_INT);
        

        if($query -> execute()){
            return "ok";
        }else{
            return "error";
        }

        $query -> close();

    }
}