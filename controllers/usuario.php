<?php

class Usuario{

    public static function mostrarUsuarioController($datos){

        $contenido = "";

        $mantenimiento = $datos["mantenimiento"];
        $rowsPerPage = $datos['por_pag'];
        $buscar = $datos['buscar'];
        $pageNum = ($datos["numPaginador"] == '')? 1 : $datos["numPaginador"];
        

        //Ultimo registro mostrado por el numero de pagina anterior
        $offset = ($pageNum - 1) * $rowsPerPage;

        $where ='';

        if($buscar != ''){
            $where ="  CONCAT(u.dni,' ',u.nombres,' ',u.apellidos,' ',r.descripcion,' ',u.username) LIKE  '%".$buscar."%' AND ";
        }

        //cantidad de registros
        $cantidad = UsuarioModel::mostrarUsuarioGeneralModel($where,"usuario AS u,rol_usuario AS r");
        $totalReg = count($cantidad);

        $total_paginas = ceil($totalReg / $rowsPerPage);

        $datosModel =  array("where"=>$where,
                                "offset"=>$offset,
                                "rowsPerPage"=>$rowsPerPage);

        $respuesta = UsuarioModel::mostrarUsuarioFilterModel($datosModel,"usuario AS u,rol_usuario AS r");

        if(count($respuesta) > 0){
            $i = 0;

            foreach ($respuesta as $row => $valor) {

                $id = $valor[0];
                $i++;
                
                $contenido .= '
                    <tr>
                        <td>'.$i.'</td>
                        <td>'.$valor[1].'</td>
                        <td>'.$valor[2].'</td>
                        <td>'.$valor[3].'</td>
                        <td>'.$valor[4].'</td>
                        <td>'.$valor[6].'</td>
                        <td>'.$valor[7].'</td>
                        <td class="text-center">
                ';

                if($mantenimiento == "1"){
                    $contenido .='
                            <a href="'.$id.'" data-accion="editar"  class="btn btn-primary btn-xs btn-rounded"><i class="far fa-edit"></i></a>
                            <a href="'.$id.'" data-accion="delete" class="btn btn-danger btn-xs btn-rounded"><i class="far fa-trash-alt"></i></a>
                    ';
                }

                $contenido .='
                        </td>
                    </tr>
                ';

            }

        }else{
            $contenido .= '
                        <tr>
                            <td colspan="8">Sin registros que mostrar.</td>
                        </tr>
                ';
        }

        $datosPaginacion = array("total_paginas"=>$total_paginas,
                                    "pageNum"=>$pageNum,
                                    "rowsPerPage"=>$rowsPerPage,
                                    "totalReg"=>$totalReg);

        $paginacion = Globales::paginacion($datosPaginacion);

        $salida = '
            <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>DNI</th>
                        <th>Nombres</th>
                        <th>Apellidos</th>
                        <th>Telefono</th>
                        <th>Rol</th>
                        <th>Usuario</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="listadoOk">
                    '.$contenido.'
                </tbody>

            </table>
        '.$paginacion;

        return $salida;
        
    }

    public static function guardarUsuarioController($datos){

        $mensajeError = "No se puede ejecutar la aplicacion.";
        $respuestaOk = false;
        $contenidoOk = "";
        $extra ="";

        $error = 0;

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

                $where = sprintf(" u.dni = '%s' AND ",$datos["dni"]);
                $q =  UsuarioModel::datosUsuarioModel($where,"usuario AS u, rol_usuario AS r");

                
            }
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

            $pass = $res["password"];

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

            if($datos["password"]==""){
                $datos["password"] = $pass;
            }

            $respuesta = UsuarioModel::actualizarUsuarioModel($datos,"usuario");

            if($respuesta == "ok"){

                $mensajeError = "Se actualizo correctamente el registro.";
                $respuestaOk = true;

                $where = sprintf(" id_usuario = '%d' AND ",$datos["id_usuario"]);
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

    public static function datosUsuarioController($datos){

        $nombres = '';
        $apellidos = '';
        $dni = '';
        $telefono = '';
        $rol = 0;
        $usuario = '';

        $where = sprintf(" u.id_usuario = '%d' AND ",$datos);
        $respuesta = UsuarioModel::datosUsuarioModel($where,"usuario AS u,rol_usuario AS r");

        if(!empty($respuesta[0])){

            $nombres = $respuesta[2];
            $apellidos = $respuesta[3];
            $dni = $respuesta[1];
            $telefono = $respuesta[4];
            $rol = $respuesta[5];
            $usuario = $respuesta[7];

        }


        $salida = array("nombres"=>$nombres,
                        "apellidos"=>$apellidos,
                        "dni"=>$dni,
                        "telefono"=>$telefono,
                        "rol"=>$rol,
                        "usuario"=>$usuario);

        return $salida;
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