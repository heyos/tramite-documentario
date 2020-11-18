<?php

class RolUsuario{

    public static function mostrarRolUsuarioController(){

        $salida = '';
        $pagInicio = '';

        $respuesta = RolUsuarioModel::selectOptionRolModel("rol_usuario");

        if(count($respuesta) > 0){

            foreach ($respuesta as $row => $value) {

                $id = $value["id_rol"];
                $mostrar_inicio = ($value["mostrar_inicio"]=="0")?"No":"Si";
                $pagInicio = $value["page_inicio"]; 

                $salida .= '
                    <tr id="trrol'.$id.'">
                        <td id="tdrol'.$id.'">'.$value["descripcion"].'</td>
                        <td class="hide" id="tdmostrar'.$id.'">'.$value["mostrar_inicio"].'</td>
                        <td id="tdvalue'.$id.'">'.$mostrar_inicio.'</td>
                        <td class="text-center">
                            <a href="#" onclick="event.preventDefault();cargarDataFormularioRolView('.$id.')" class="btn btn-primary btn-xs btn-rounded"><i class="far fa-edit"></i></a>
                            <a href="#" onclick="event.preventDefault();eliminarRol('.$id.')" class="btn btn-danger btn-xs btn-rounded"><i class="far fa-trash-alt"></i></a>
                            <a href="#" onclick="event.preventDefault();darPermisosRol('.$id.')" class="btn btn-success btn-xs btn-rounded"><i class="fas fa-lock-open"></i></a>
                            <a href="#" title="Escoger pagina de inicio" onclick="event.preventDefault();elegirInicioPagina('.$id.',\''.$pagInicio.'\',\''.$value["descripcion"].'\')" 
                            class="btn btn-info btn-xs btn-rounded"><i class="fas fa-play"></i></a>
                        </td>
                    </tr>
                ';

            }

        }

        return $salida;

    }

    public static function selectOptionRolController($datos){

        $salida = '';

        $respuesta = RolUsuarioModel::selectOptionRolModel("rol_usuario");

        if(count($respuesta) > 0){

            foreach ($respuesta as $row => $value) {

                if($datos == $value["descripcion"]){
                    $salida .= '<option value="'.$value["id_rol"].'" selected>'.$value["descripcion"].'</option>';
                }else{
                    $salida .= '<option value="'.$value["id_rol"].'">'.$value["descripcion"].'</option>';
                }

            }

        }else{
            $salida = '<option value="0"></option>';
        }

        echo $salida;

    }

    public static function datosRolController($row){

        $rol = 0;

        $salida = "error";

        if(isset($_GET["term"]) && !empty($_GET["term"])){

            $rol = Globales::sanearData($_GET["term"]);

        }

        $where = sprintf(" id_rol = '%d' AND ",$rol);
        $respuesta = RolUsuarioModel::registroRolModel($where,"rol_usuario");

        if(!empty($respuesta[$row])){

            $salida = $respuesta[$row];

        }

        return $salida;
    }

    public static function registrarRolController($datos){

        $mensajeError = "No se puede ejecutar la aplicacion.";
        $respuestaOk = false;
        $contenidoOk = "";
        $extra ="";
        $contenidoView = "";

    
        $verificar =  RolUsuarioModel::datosRolModel($datos["descripcion"],"rol_usuario");

        if(!empty($verificar["descripcion"])){

            $mensajeError = "Rol de usuario ya existe.";

        }else{
            
            $respuesta = RolUsuarioModel::registrarRolModel($datos,"rol_usuario");

            if($respuesta == "ok"){

                $respuestaDatos = RolUsuarioModel::datosRolModel($datos["descripcion"],"rol_usuario");

                $respuestaOk = true;

                $extra = '<option value="'.$respuestaDatos["id_rol"].'">'.$datos["descripcion"].'</option>';
                $contenidoOk = $respuestaDatos["id_rol"];

                //views/modules/rol_usuario
                $id = $respuestaDatos["id_rol"];
                $mostrar_inicio = ($datos["mostrar_inicio"] == "0")?"No":"Si";

                $where = sprintf(" id_rol = '%d' AND ",$id);
                $datosRol = RolUsuarioModel::registroRolModel($where,"rol_usuario");
                $pagInicio = (!empty($datosRol["page_inicio"]))?$datosRol["page_inicio"]:"inicio";

                $contenidoView = '
                    <tr id="trrol'.$id.'">
                        <td id="tdrol'.$id.'">'.$datos["descripcion"].'</td>
                        <td class="hide" id="tdmostrar'.$id.'">'.$datos["mostrar_inicio"].'</td>
                        <td id="tdvalue'.$id.'">'.$mostrar_inicio.'</td>
                        <td class="text-center">
                            <a href="#" onclick="event.preventDefault();cargarDataFormularioRolView('.$id.')" class="btn btn-primary btn-xs btn-rounded"><i class="far fa-edit"></i></a>
                            <a href="#" onclick="event.preventDefault();eliminarRol('.$id.')" class="btn btn-danger btn-xs btn-rounded"><i class="far fa-trash-alt"></i></a>
                            <a href="#" onclick="event.preventDefault();darPermisosRol('.$id.')" class="btn btn-success btn-xs btn-rounded"><i class="fas fa-lock-open"></i></a>
                            <a href="#" title="Escoger pagina de inicio" onclick="event.preventDefault();elegirInicioPagina('.$id.',\''.$pagInicio.'\',\''.$datos["descripcion"].'\')" 
                            class="btn btn-info btn-xs btn-rounded"><i class="fas fa-play"></i></a>
                        </td>
                    </tr>
                ';

                $mensajeError = "Se agrego correctamente el rol usuario.";

            }

        }
    

        $salidaJson =  array("respuesta"=>$respuestaOk,
                                "mensaje"=>$mensajeError,
                                "contenido"=>$contenidoOk,
                                "extra"=>$extra,
                                "contenidoView"=>$contenidoView);

        echo json_encode($salidaJson);
    }

    public static function actualizarRolController($datos){

        $mensajeError = "No se puede ejecutar la aplicacion.";
        $respuestaOk = false;
        $contenidoOk = "";

        $error = 0;
        
        if($datos["oldNombreRol"] != $datos["descripcion"]){

            $verificar =  RolUsuarioModel::datosRolModel($datos["descripcion"],"rol_usuario");

            if(!empty($verificar["descripcion"])){

                $mensajeError = "Rol de usuario ya existe.";
                $error = 1;

            }

        }

        if($error == 0){
            $respuesta = RolUsuarioModel::actualizarRolModel($datos,"rol_usuario");

            if($respuesta == "ok"){

                $respuestaDatos = RolUsuarioModel::datosRolModel($datos["descripcion"],"rol_usuario");

                $respuestaOk = true;
                $mensajeError = "Se actualizo correctamente el registro.";

                $id = $respuestaDatos["id_rol"];
                $mostrar_inicio = ($datos["mostrar_inicio"] == "0")?"No":"Si";

                $where = sprintf(" id_rol = '%d' AND ",$id);
                $datosRol = RolUsuarioModel::registroRolModel($where,"rol_usuario");
                $pagInicio = (!empty($datosRol["page_inicio"]))?$datosRol["page_inicio"]:"inicio";

                $contenidoOk = '
                        <td id="tdrol'.$id.'">'.$datos["descripcion"].'</td>
                        <td class="hide" id="tdmostrar'.$id.'">'.$datos["mostrar_inicio"].'</td>
                        <td id="tdvalue'.$id.'">'.$mostrar_inicio.'</td>
                        <td class="text-center">
                            <a href="#" onclick="event.preventDefault();cargarDataFormularioRolView('.$id.')" class="btn btn-primary btn-xs btn-rounded"><i class="far fa-edit"></i></a>
                            <a href="#" onclick="event.preventDefault();eliminarRol('.$id.')" class="btn btn-danger btn-xs btn-rounded"><i class="far fa-trash-alt"></i></a>
                            <a href="#" onclick="event.preventDefault();darPermisosRol('.$id.')" class="btn btn-success btn-xs btn-rounded"><i class="fas fa-lock-open"></i></a>
                            <a href="#" title="Escoger pagina de inicio" onclick="event.preventDefault();elegirInicioPagina('.$id.',\''.$pagInicio.'\',\''.$datos["descripcion"].'\')" 
                            class="btn btn-info btn-xs btn-rounded"><i class="fas fa-play"></i></a>
                        </td>
                ';
                
            }
        }

        $salidaJson =  array("respuesta"=>$respuestaOk,
                                "mensaje"=>$mensajeError,
                                "contenido"=>$contenidoOk);

        echo json_encode($salidaJson);

    }

    public static function guardarPaginaInicioRolController($datos){

        $mensajeError = "No se puede ejecutar la aplicacion.";
        $respuestaOk = false;
        $contenidoOk = "";

        $respuesta = RolUsuarioModel::guardarPaginaInicioRolModel($datos,"rol_usuario");

        if($respuesta == 'ok'){
            $respuestaOk =  true;
            $mensajeError = "La nueva pagina de inicio es: <strong>".$datos["namePage"]."</strong>";

            $contenidoOk = Self::mostrarRolUsuarioController();
        }

        $salidaJson =  array("respuesta"=>$respuestaOk,
                                "mensaje"=>$mensajeError,
                                "contenido"=>$contenidoOk);

        echo json_encode($salidaJson);
    }


    public static function eliminarRolController($datos){

        $mensajeError = "No se puede ejecutar la aplicacion.";
        $respuestaOk = false;
        $contenidoOk = "";

        $respuesta = RolUsuarioModel::eliminarRolModel($datos,"rol_usuario");

        if($respuesta == 'ok'){
            $respuestaOk = true;
            $mensajeError ="Se elimino el registro correctamente.";
        }else{
            $mensajeError = "Error al eliminar el registro.";
        }

        $salidaJson =  array("respuesta"=>$respuestaOk,
                                "mensaje"=>$mensajeError,
                                "contenido"=>$contenidoOk);

        echo json_encode($salidaJson);

    }

}