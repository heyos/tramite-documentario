<?php

class Ingreso{

    public static function ingresoController($datos){

        $respuestaOk = false;
        $contenidoOk = "";
        $mensajeError = "No se puede ejecutar la aplicacion.";

        $respuesta = IngresoModels::ingresoModel($datos,"usuario");

        $maxIntentos = 2;
        
        $intentos = 0;
        $inicio = "";

        if(!empty($respuesta["username"])){

            $intentos = $respuesta["intentos"];
            $passwordDB = $respuesta["password"];
            $nombres = $respuesta["nombres"];
            $apellidos = $respuesta["apellidos"];
            $rol = $respuesta["id_rol"];
            $username = $datos["username"];
            //$sucursal = $respuesta["id_sucursal"];

            $where = sprintf(" id_rol = '%d' AND ",$rol);
            $datosRol = RolUsuarioModel::datosRolModel($where,'rol_usuario');
            $inicio = (!empty($datosRol["page_inicio"]))?$datosRol["page_inicio"]:"inicio";
            
            if($intentos < $maxIntentos){
                

                if(crypt($datos["password"],$passwordDB) == $passwordDB){
                                       
                    session_start();
                    $_SESSION["validar"] = true;
                    $_SESSION["fullname"] = $nombres." ".$apellidos;
                    $_SESSION["nombres"] = $nombres;
                    $_SESSION["rol"] = $rol;
                    
                    $intentos = 0;

                    $respuestaOk = true;
                    
                    $mensajeError = "Ingreso exitoso, se le redigira en unos segundos.";

                    $contenidoOk = $inicio;
                    

                }else{
                    $intentos++;
                    $mensajeError = "Usuario o contraseña incorrectos.";
                }
                
                
                $datosIntentos = array("intentos"=>$intentos,
                                        "usuarioActual"=>$datos["username"]);

                IngresoModels::actualizarIntentosModel($datosIntentos,"usuario");
                

            }else{
                $mensajeError = "Se completo el limite de intentos.";
            }
            

        }else{
            $mensajeError = "Usuario o contraseña incorrectos.";
        }
        
        

        $salidaJson =  array("respuesta"=>$respuestaOk,
                            "contenido"=>$contenidoOk,
                            "mensaje"=>$mensajeError);

        echo json_encode($salidaJson);
        
    }
}