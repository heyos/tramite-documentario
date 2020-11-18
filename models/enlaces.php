<?php

require_once "conexion.php";

class EnlacesModels{

    public static function enlaceMenuModel($enlaces,$tabla){

        $query = Conexion::conectar()->prepare("SELECT d.id_menu,m.descripcion
                                                    FROM $tabla
                                                    WHERE d.borrado = '0' AND m.borrado = '0' AND d.id_menu = m.id_menu 
                                                    AND d.id_rol =:id_rol AND d.acceso='1' AND m.url = :url ");
        
        $query -> bindParam(":id_rol",$enlaces["id_rol"],PDO::PARAM_INT);
        $query -> bindParam(":url",$enlaces["url"],PDO::PARAM_STR);

        $query -> execute();

        return $query -> fetch();

        $query -> close();

    }

    public static function revisarEnlaceMenuModel($enlaces,$tabla){

        $query = Conexion::conectar()->prepare("SELECT d.id_menu,m.descripcion
                                                    FROM $tabla
                                                    WHERE d.borrado = '0' AND m.borrado = '0' AND d.id_menu = m.id_menu 
                                                    AND d.id_rol =:id_rol AND d.acceso='1' AND d.id_menu = :id_menu");
        
        $query -> bindParam(":id_rol",$enlaces["id_rol"],PDO::PARAM_INT);
        $query -> bindParam(":id_menu",$enlaces["id_menu"],PDO::PARAM_STR);

        $query -> execute();

        return $query -> fetch();

        $query -> close();

    }

    public static function enlaceSubModel($enlaces,$tabla){

        $query = Conexion::conectar()->prepare("SELECT d.id_sub_menu,s.id_menu
                                                    FROM $tabla
                                                    WHERE d.borrado = '0' AND s.borrado ='0' AND d.id_sub_menu = s.id_sub_menu 
                                                    AND d.id_rol =:id_rol AND d.acceso='1' AND s.url = :url");
        
        $query -> bindParam(":id_rol",$enlaces["id_rol"],PDO::PARAM_INT);
        $query -> bindParam(":url",$enlaces["url"],PDO::PARAM_STR);

        $query -> execute();

        return $query -> fetch();

        $query -> close();

    }

    //obtener datos
    public static function datosMenuModel($datos,$tabla){

        $query = Conexion::conectar()->prepare("SELECT id_menu,descripcion,icono,visible
                                                    FROM $tabla
                                                    WHERE $datos borrado = '0' ");
        
        $query -> execute();

        return $query -> fetch();

        $query -> close();

    }

    public static function datosSubMenuModel($datos,$tabla){

        $query = Conexion::conectar()->prepare("SELECT id_sub_menu,descripcion,id_menu
                                                    FROM $tabla
                                                    WHERE $datos borrado = '0' ");
        
        $query -> execute();

        return $query -> fetch();

        $query -> close();

    }

    public static function mantenimientoDatosModel($datos,$tabla){

        $query = Conexion::conectar() ->prepare("SELECT d.id_menu,d.mantenimiento
                                                    FROM $tabla
                                                    WHERE d.borrado = '0' AND m.borrado = '0' AND d.id_menu = m.id_menu 
                                                    AND d.id_menu =:id_menu AND d.id_rol = :id_rol AND d.mantenimiento='1' AND m.visible ='1' LIMIT 1");
        $query -> bindParam(":id_menu",$datos["id_menu"],PDO::PARAM_INT);
        $query -> bindParam(":id_rol",$datos["id_rol"],PDO::PARAM_INT);

        $query -> execute();

        return $query -> fetch() ;

        $query -> close();

    }


}