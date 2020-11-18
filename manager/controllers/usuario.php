<?php

class Usuario{

    public static function mostrarUsuarioController(){

        $respuesta = UsuarioModel::mostrarUsuarioModel("usuario AS u,rol_usuario AS r");

        if(count($respuesta) > 0){

            foreach ($respuesta as $row => $valor) {

                $id = $valor[0];
                
                echo '
                    <tr id="tr'.$id.'">
                        <td id="tddni'.$id.'">'.$valor[1].'</td>
                        <td id="tdnom'.$id.'">'.$valor[2].'</td>
                        <td id="tdape'.$id.'">'.$valor[3].'</td>
                        <td id="tdnum'.$id.'">'.$valor[4].'</td>
                        <td id="tdrol'.$id.'" class="hide">'.$valor[5].'</td>
                        <td id="tdrolname'.$id.'">'.$valor[6].'</td>
                        <td id="tduser'.$id.'">'.$valor[7].'</td>
                        <td class="text-center">
                            <a href="#" onclick="event.preventDefault();cargarDataFormularioUsuario('.$id.')" class="btn btn-primary btn-xs btn-rounded"><i class="far fa-edit"></i></a>
                            <a href="#" onclick="event.preventDefault();eliminarUsuario('.$id.')" class="btn btn-danger btn-xs btn-rounded"><i class="far fa-trash-alt"></i></a>
                        </td>
                    </tr>
                ';

            }
        }
    }

    public static function guardarUsuarioController($datos){

        $mensajeError = "No se puede ejecutar la aplicacion.";
        $respuestaOk = false;
        $contenidoOk = "";
        $extra ="";

        $error = 0;

        $usuarios = UsuarioModel::mostrarUsuarioModel("usuario AS u,rol_usuario AS r");

        $cantidadUsuarios = count($usuarios) + 1;

        if($cantidadUsuarios < 3){

            $verificar = array("nombres"=>$datos["nombres"].' '.$datos["apellidos"],
                                "dni"=>$datos["dni"],
                                "num_tel"=>$datos["num_tel"],
                                "username"=>$datos["username"]);

            foreach ($verificar as $key => $value) {

                if($key == 'nombres'){
                    $where = sprintf("WHERE CONCAT(nombres,' ',apellidos) = '%s' ",$value);
                }else{
                    $where = sprintf("WHERE %s = '%s' ",$key,$value);
                }

                $r = UsuarioModel::verificarUsuarioModel($where,"usuario");

                if(!empty($r[$key]) && $r[$key] != ""){

                    $error++;

                    if($key == 'nombres'){
                        $mensajeError = $key." y apellidos existentes.";
                    }else{

                        $key = ($key=="num_tel")?"numero de telefono":$key;

                        $mensajeError = $key." existente.";
                    }

                    break;
                }
                
            }

            if($error == 0){

                $respuesta = UsuarioModel::guardarUsuarioModel($datos,"usuario");

                if($respuesta =="ok"){
                    $mensajeError = "Se registro el usuario correctamente.";
                    $respuestaOk = true;

                    $where = sprintf("WHERE u.dni = '%s' AND ",$datos["dni"]);
                    $q =  UsuarioModel::datosUsuarioModel($where,"usuario AS u, rol_usuario AS r");

                    if(!empty($q[1])){

                        $id = $q[0];

                        $contenidoOk = '
                            <tr id="tr'.$id.'">
                                <td id="tddni'.$id.'">'.$q[1].'</td>
                                <td id="tdnom'.$id.'">'.$q[2].'</td>
                                <td id="tdape'.$id.'">'.$q[3].'</td>
                                <td id="tdnum'.$id.'">'.$q[4].'</td>
                                <td id="tdrol'.$id.'" class="hide">'.$q[5].'</td>
                                <td id="tdrolname'.$id.'">'.$q[6].'</td>
                                <td id="tduser'.$id.'">'.$q[7].'</td>
                                <td class="text-center">
                                    <a href="#" onclick="event.preventDefault();cargarDataFormularioUsuario('.$id.')" class="btn btn-primary btn-xs btn-rounded"><i class="far fa-edit"></i></a>
                                    <a href="#" onclick="event.preventDefault();eliminarUsuario('.$id.')" class="btn btn-danger btn-xs btn-rounded"><i class="far fa-trash-alt"></i></a>
                                </td>
                            </tr>
                        ';
                    }

                        
                }
            }
        }else{
            $mensajeError = "No se permite registrar mas de 3 usuarios.";
        }

        $salidaJson = array("respuesta"=>$respuestaOk,
                            "contenido"=>$contenidoOk,
                            "mensaje"=>$mensajeError);

        echo json_encode($salidaJson);

    }

    public static function actualizarUsuarioController($datos){

        $mensajeError = "No se puede ejecutar la aplicacion.";
        $respuestaOk = false;
        $contenidoOk = "";
        
        $verificar = array("fullname"=>$datos["nombres"].' '.$datos["apellidos"],
                            "dni"=>$datos["dni"],
                            "num_tel"=>$datos["num_tel"],
                            "username"=>$datos["username"]);

        $where = sprintf("WHERE id_usuario = '%F' ",$datos["id_usuario"]);

        $res = UsuarioModel::verificarUsuarioModel($where,"usuario");

        $error = 0;

        if(!empty($res["nombres"])){

            foreach ($verificar as $key => $value) {

                $old = $res[$key];

                if($value != $old){

                    if($key == 'fullname'){
                        $where = sprintf("WHERE CONCAT(nombres,' ',apellidos) = '%s' ",$value);
                    }else{
                        $where = sprintf("WHERE %s = '%s' ",$key,$value);
                    }

                    $r = UsuarioModel::verificarUsuarioModel($where,"usuario");

                    if(!empty($r[$key])){
                        $error++;

                        if($key == 'fullname'){
                            $mensajeError = "Nombres y apellidos existentes.";
                        }else{
                            $key = ($key=="num_tel") ?"numero de telefono":$key;
                            $mensajeError = $key." existente.";
                        }

                        break;
                    }

                }
                
            }
        
        }

        if($error == 0){

            $respuesta = UsuarioModel::actualizarUsuarioModel($datos,"usuario");

            if($respuesta == "ok"){

                $mensajeError = "Se actualizo correctamente el registro.";
                $respuestaOk = true;

                $where = sprintf("WHERE id_usuario = '%d' AND ",$datos["id_usuario"]);
                $q = UsuarioModel::datosUsuarioModel($where,"usuario AS u, rol_usuario AS r");

                if(!empty($q[0])){

                    $id = $q[0];

                    $contenidoOk = '
                        
                            <td id="tddni'.$id.'">'.$q[1].'</td>
                            <td id="tdnom'.$id.'">'.$q[2].'</td>
                            <td id="tdape'.$id.'">'.$q[3].'</td>
                            <td id="tdnum'.$id.'">'.$q[4].'</td>
                            <td id="tdrol'.$id.'" class="hide">'.$q[5].'</td>
                            <td id="tdrolname'.$id.'">'.$q[6].'</td>
                            <td id="tduser'.$id.'">'.$q[7].'</td>
                            <td class="text-center">
                                <a href="#" onclick="event.preventDefault();cargarDataFormularioUsuario('.$id.')" class="btn btn-primary btn-xs btn-rounded"><i class="far fa-edit"></i></a>
                                <a href="#" onclick="event.preventDefault();eliminarUsuario('.$id.')" class="btn btn-danger btn-xs btn-rounded"><i class="far fa-trash-alt"></i></a>
                            </td>
                        
                    ';
                }
            }

        }

        $salidaJson = array("respuesta"=>$respuestaOk,
                            "contenido"=>$contenidoOk,
                            "mensaje"=>$mensajeError);

        echo json_encode($salidaJson);

    }

    public static function eliminarUsuarioController($datos){

        $mensajeError = "No se puede ejecutar la aplicacion.";
        $respuestaOk = false;
        $contenidoOk = "";

        $respuesta = UsuarioModel::eliminarUsuarioModel($datos,"usuario");

        if($respuesta == 'ok'){
            $respuestaOk = true;
            $mensajeError = "Se elimino correctamente el usuario.";
        }else{
            $mensajeError = "Hubo un error al eliminar el usuario.";
        }

        $salidaJson = array("respuesta"=>$respuestaOk,
                            "contenido"=>$contenidoOk,
                            "mensaje"=>$mensajeError);

        echo json_encode($salidaJson);
    }

}