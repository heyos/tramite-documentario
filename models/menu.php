<?php

require_once "conexion.php";

class MenuModels{

    //Mostrar
    public static function numRegistrosMenuModel($tabla){

        $numRegistros = 0;

        $query = Conexion::conectar() ->prepare("SELECT id_menu,descripcion,icono
                                                    FROM $tabla
                                                    WHERE borrado = '0' ORDER BY orden ASC");
        $query -> execute();

        if($query -> rowCount() > 0){

            $numRegistros =  $query -> rowCount() ;
        }

        return $numRegistros;

        $query -> close();

    }

    public static function mostrarRegistrosMenuModel($tabla){

        $query = Conexion::conectar() ->prepare("SELECT id_menu,descripcion,icono,visible
                                                    FROM $tabla
                                                    WHERE borrado = '0' ORDER BY orden ASC");


        $query -> execute();

        if($query -> rowCount() > 0){

            return $query -> fetchAll() ;

        }else{
            return "error";
        }

        $query -> close();

    }

    public static function numRegistrosSubMenuModel($datos,$tabla){

        $numRegistros = 0;

        $query = Conexion::conectar() ->prepare("SELECT id_sub_menu,descripcion
                                                    FROM $tabla
                                                    WHERE borrado = '0' AND id_menu =:id_menu ORDER BY orden ASC");
        $query -> bindParam(":id_menu",$datos,PDO::PARAM_INT);
        $query -> execute();

        if($query -> rowCount() > 0){

            $numRegistros =  $query -> rowCount() ;
        }

        return $numRegistros;

        $query -> close();

    }

    public static function mostrarRegistrosSubMenuModel($datos,$tabla){

        $query = Conexion::conectar() ->prepare("SELECT id_sub_menu,descripcion
                                                    FROM $tabla
                                                    WHERE borrado = '0' AND id_menu =:id_menu ORDER BY orden ASC");
        $query -> bindParam(":id_menu",$datos,PDO::PARAM_INT);
        $query -> execute();

        if($query -> rowCount() > 0){

            return $query -> fetchAll() ;

        }else{
            return 0;
        }

        $query -> close();
    }

    //OBTENER DATOS

    public static function registroMenuModel($datos,$tabla){

        $query = Conexion::conectar() ->prepare("SELECT id_menu,descripcion,icono,url
                                                    FROM $tabla
                                                    WHERE borrado = '0' AND id_menu =:id_menu LIMIT 1");
        $query -> bindParam(":id_menu",$datos,PDO::PARAM_INT);


        $query -> execute();

        return $query -> fetch() ;

        $query -> close();

    }

    public static function registroSubMenuModel($datos,$tabla){

        $query = Conexion::conectar() ->prepare("SELECT id_sub_menu,descripcion
                                                    FROM $tabla
                                                    WHERE borrado = '0' AND id_sub_menu =:id_sub_menu LIMIT 1");
        $query -> bindParam(":id_sub_menu",$datos,PDO::PARAM_INT);
        $query -> execute();

        if($query -> rowCount() > 0){

            return $query -> fetch() ;

        }else{
            return "error";
        }

        $query -> close();
    }

    //actualizar orden
    public static function actualizarOrdenMenuModel($datos,$tabla){

        $query = Conexion::conectar() ->prepare("UPDATE $tabla
                                                SET orden = :orden
                                                WHERE borrado = '0' AND id_menu =:id_menu LIMIT 1");
        $query -> bindParam(":orden",$datos["orden"],PDO::PARAM_INT);
        $query -> bindParam(":id_menu",$datos["id_menu"],PDO::PARAM_INT);

        if($query -> execute()){
            return "ok";
        }else{
            return "error";
        }

        $query -> close();

    }

    public static function actualizarOrdenSubMenuModel($datos,$tabla){

        $query = Conexion::conectar() ->prepare("UPDATE $tabla
                                                SET orden = :orden
                                                WHERE borrado = '0' AND id_sub_menu =:id_sub_menu LIMIT 1");
        $query -> bindParam(":orden",$datos["orden"],PDO::PARAM_INT);
        $query -> bindParam(":id_sub_menu",$datos["id_sub_menu"],PDO::PARAM_INT);

        if($query -> execute()){
            return "ok";
        }else{
            return "error";
        }

        $query -> close();

    }


    //permisos
    public static function registroPermisoMenuModel($datos,$tabla){

        $query = Conexion::conectar() ->prepare("SELECT id_detalle_m,id_menu,acceso,mantenimiento
                                                    FROM $tabla
                                                    WHERE borrado = '0' AND id_menu =:id_menu AND id_rol =:id_rol LIMIT 1");
        $query -> bindParam(":id_menu",$datos["id_menu"],PDO::PARAM_INT);
        $query -> bindParam(":id_rol",$datos["id_rol"],PDO::PARAM_INT);
        
        $query -> execute();

        return $query -> fetch();

        $query -> close();

    }
    

    public static function detallePermisosMenuModel($datos,$tabla){

        //detalle_menu
        $query = Conexion::conectar() ->prepare("SELECT d.id_menu,m.descripcion,m.icono,m.url,m.visible
                                                    FROM $tabla
                                                    WHERE d.borrado = '0' AND m.borrado = '0' AND d.id_menu = m.id_menu 
                                                    AND d.id_rol =:id_rol AND d.acceso='1' AND m.visible ='1' ORDER BY m.orden ASC");
        $query -> bindParam(":id_rol",$datos,PDO::PARAM_INT);

        $query -> execute();

        return $query -> fetchAll() ;

        $query -> close();

    }

    public static function registroPermisoSubMenuModel($datos,$tabla){

        $query = Conexion::conectar() ->prepare("SELECT id_detalle_s,id_sub_menu,acceso
                                                    FROM $tabla
                                                    WHERE borrado = '0' AND id_sub_menu =:id_sub_menu AND id_rol =:id_rol LIMIT 1");
        
        $query -> bindParam(":id_sub_menu",$datos["id_sub_menu"],PDO::PARAM_INT);
        $query -> bindParam(":id_rol",$datos["id_rol"],PDO::PARAM_INT);
        $query -> execute();

        return $query -> fetch() ;

        $query -> close();

    }

    public static function detallePermisosSubMenuModel($datos,$tabla){

        //detalle_sub_menu
        $query = Conexion::conectar() ->prepare("SELECT d.id_sub_menu,s.descripcion,s.url,d.id_detalle_s
                                                    FROM $tabla
                                                    WHERE d.borrado = '0' AND s.borrado ='0' AND s.id_menu = :id_menu AND d.id_sub_menu = s.id_sub_menu 
                                                    AND d.id_rol =:id_rol AND d.acceso='1' ORDER BY s.orden ASC");
        $query -> bindParam(":id_menu",$datos["id_menu"],PDO::PARAM_INT);
        $query -> bindParam(":id_rol",$datos["id_rol"],PDO::PARAM_INT);

        $query -> execute();

        return $query -> fetchAll() ;

        $query -> close();

    }

    

    //PERMISO ACCESO MENU
    public static function darPermisoAccesoMenuModel($datos,$tabla){

        $query = Conexion::conectar() ->prepare("INSERT INTO $tabla (id_menu,acceso,id_rol) 
                                                    VALUES (:id_menu,:acceso,:id_rol) ");
        $query -> bindParam(":id_menu",$datos["id_menu"],PDO::PARAM_INT);
        $query -> bindParam(":acceso",$datos["value"],PDO::PARAM_STR);
        $query -> bindParam(":id_rol",$datos["id_rol"],PDO::PARAM_INT);
        
        if($query -> execute()){
            return "ok";
        }else{
            return "error";
        }

        $query -> close();

    }

    public static function actualizarPermisoAccesoMenuModel($datos,$tabla){

        $query = Conexion::conectar() ->prepare("UPDATE $tabla 
                                                    SET  acceso = :acceso
                                                    WHERE id_detalle_m = :id_detalle_m");
        $query -> bindParam(":acceso",$datos["value"],PDO::PARAM_STR);
        $query -> bindParam(":id_detalle_m",$datos["id_detalle_m"],PDO::PARAM_INT);

        if($query -> execute()){
            return "ok";
        }else{
            return "error";
        }

        $query -> close();

    }

    //PERMISO MANTENIMIENTO PARA REGISTROS
    public static function darPermisoMantenimientoModel($datos,$tabla){

        $query = Conexion::conectar() ->prepare("INSERT INTO $tabla (id_menu,mantenimiento,id_rol) 
                                                    VALUES (:id_menu,:mantenimiento,:id_rol) ");
        $query -> bindParam(":id_menu",$datos["id_menu"],PDO::PARAM_INT);
        $query -> bindParam(":mantenimiento",$datos["value"],PDO::PARAM_STR);
        $query -> bindParam(":id_rol",$datos["id_rol"],PDO::PARAM_INT);
        
        if($query -> execute()){
            return "ok";
        }else{
            return "error";
        }

        $query -> close();

    }

    public static function actualizarPermisoMantenimientoModel($datos,$tabla){

        $query = Conexion::conectar() ->prepare("UPDATE $tabla 
                                                    SET  mantenimiento = :mantenimiento
                                                    WHERE id_detalle_m = :id_detalle_m");
        $query -> bindParam(":mantenimiento",$datos["value"],PDO::PARAM_STR);
        $query -> bindParam(":id_detalle_m",$datos["id_detalle_m"],PDO::PARAM_INT);

        if($query -> execute()){
            return "ok";
        }else{
            return "error";
        }

        $query -> close();

    }

    //SUBMENU
    

    public static function darPermisoSubMenuModel($datos,$tabla){

        $query = Conexion::conectar() ->prepare("INSERT INTO $tabla (id_sub_menu,acceso,id_rol) 
                                                    VALUES (:id_sub_menu,:acceso,:id_rol) ");
        $query -> bindParam(":id_sub_menu",$datos["id_sub_menu"],PDO::PARAM_INT);
        $query -> bindParam(":acceso",$datos["value"],PDO::PARAM_STR);
        $query -> bindParam(":id_rol",$datos["id_rol"],PDO::PARAM_INT);
        
        if($query -> execute()){
            return "ok";
        }else{
            return "error";
        }

        $query -> close();

    }

    public static function actualizarPermisoSubMenuModel($datos,$tabla){

        $query = Conexion::conectar() ->prepare("UPDATE $tabla 
                                                    SET  acceso = :acceso
                                                    WHERE id_detalle_s = :id_detalle_s");
        $query -> bindParam(":acceso",$datos["value"],PDO::PARAM_STR);
        $query -> bindParam(":id_detalle_s",$datos["id_detalle_s"],PDO::PARAM_INT);

        if($query -> execute()){
            return "ok";
        }else{
            return "error";
        }

        $query -> close();

    }

}