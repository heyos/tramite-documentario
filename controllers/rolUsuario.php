<?php

class RolUsuario{

    public static function mostrarRolUsuarioController($datos){

        $contenido = "";

        $idMenu = 0;
        $mantenimiento = $datos["mantenimiento"];
        $rowsPerPage = $datos['por_pag'];
        $buscar = $datos['buscar'];
        $pageNum = ($datos["numPaginador"] == '')? 1 : $datos["numPaginador"];
        

        //Ultimo registro mostrado por el numero de pagina anterior
        $offset = ($pageNum - 1) * $rowsPerPage;

        $where ='';

        if($buscar != ''){
            $where ="  descripcion LIKE  '%".$buscar."%' AND ";
        }

        //Cantidad total de registros
        $cantidad = RolUsuarioModel::mostrarRolModelGeneral($where,"rol_usuario");
        $totalReg = count($cantidad);

        $total_paginas = ceil($totalReg / $rowsPerPage);

        $datosModel =  array("where"=>$where,
                                "offset"=>$offset,
                                "rowsPerPage"=>$rowsPerPage);

        $respuesta = RolUsuarioModel::mostrarRolModel($datosModel,"rol_usuario");

        if(count($respuesta) > 0){

            $i = 0;
            $pagInicio = "";

            foreach ($respuesta as $row => $value) {

                $i++;

                $id = $value["id_rol"];
                $mostrar_inicio = ($value["mostrar_inicio"]=="0")?"No":"Si";
                $pagInicio = $value["page_inicio"];

                $contenido .= '
                        <tr>
                            <td>'.$i.'</td>
                            <td id="tdRol'.$id.'">'.$value["descripcion"].'</td>
                            <td>'.$mostrar_inicio.'</td>
                            <td>
                ';

                if($mantenimiento == 1){ 
                    $contenido .='
                                <a href="#" onclick="event.preventDefault();cargarDataFormularioRol('.$id.','.$value["mostrar_inicio"].')" class="btn btn-primary btn-xs btn-rounded"><i class="far fa-edit"></i></a>
                                <a href="#" onclick="event.preventDefault();eliminarRol('.$id.')" class="btn btn-danger btn-xs btn-rounded"><i class="far fa-trash-alt"></i></a>
                                <a href="#" onclick="event.preventDefault();darPermisosRol('.$id.')" class="btn btn-success btn-xs btn-rounded"><i class="fas fa-lock-open"></i></a>
                                <a href="#" title="Escoger pagina de inicio" onclick="event.preventDefault();elegirInicioPagina('.$id.',\''.$pagInicio.'\',\''.$value["descripcion"].'\')" 
                                class="btn btn-info btn-xs btn-rounded"><i class="fas fa-play"></i></a>
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
                            <td colspan="4">Sin registros que mostrar.</td>
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
                        <th>N</th>
                        <th>Descripcion</th>
                        <th>Mostrar Inicio</th>
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

    public static function mostrarRolController($datos){

        $salida = '';

        $respuesta = RolUsuarioModel::mostrarRolModelGeneral("","rol_usuario");

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

    public static function datosRolController(){

        $rol = 0;

        if(isset($_GET["term"]) && !empty($_GET["term"])){

            $rol = Globales::sanearData($_GET["term"]);

        }

        $where = sprintf(" id_rol = '%d' AND ",$rol);
        $respuesta = RolUsuarioModel::datosRolModel($where,"rol_usuario");

        if(!empty($respuesta["descripcion"])){

            return $respuesta;

        }else{
            return "error";
        }

        
    }

    public static function mostrarInicioController(){

        $mostrar_inicio = "0";

        $idRol = $_SESSION["rol"];

        $where = sprintf(" id_rol = '%d' AND ",$idRol);
        $respuesta = RolUsuarioModel::datosRolModel($where,"rol_usuario");

        if(!empty($respuesta["mostrar_inicio"])){

            $mostrar_inicio = $respuesta["mostrar_inicio"];
        }

        return $mostrar_inicio;
    }

    public static function registrarRolController($datos){

        $mensajeError = "No se puede ejecutar la aplicacion.";
        $respuestaOk = false;
        $contenidoOk = "";
        $extra ="";
        $contenidoView = "";

        $where = sprintf(" descripcion = '%s' AND ",$datos["descripcion"]);
        $verificar =  RolUsuarioModel::datosRolModel($where,"rol_usuario");

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

                $contenidoView = '
                    <tr id="trrol'.$id.'">
                        <td id="tdrol'.$id.'">'.$datos["descripcion"].'</td>
                        <td class="hide" id="tdmostrar'.$id.'">'.$datos["mostrar_inicio"].'</td>
                        <td id="tdvalue'.$id.'">'.$mostrar_inicio.'</td>
                        <td class="text-center">
                            <a href="#" onclick="event.preventDefault();cargarDataFormularioRol('.$id.')" class="btn btn-primary btn-xs btn-rounded"><i class="fa fa-pencil"></i></a>
                            <a href="#" onclick="event.preventDefault();eliminarRol('.$id.')" class="btn btn-danger btn-xs btn-rounded"><i class="fa fa-trash-o"></i></a>
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

            $where = sprintf(" descripcion = '%s' AND ",$datos["descripcion"]);
            $verificar =  RolUsuarioModel::datosRolModel($where,"rol_usuario");

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

                $contenidoOk = '
                        <td id="tdrol'.$id.'">'.$datos["descripcion"].'</td>
                        <td class="hide" id="tdmostrar'.$id.'">'.$datos["mostrar_inicio"].'</td>
                        <td id="tdvalue'.$id.'">'.$mostrar_inicio.'</td>
                        <td class="text-center">
                            <a href="#" onclick="event.preventDefault();cargarDataFormularioRol('.$id.')" class="btn btn-primary btn-xs btn-rounded"><i class="fa fa-pencil"></i></a>
                            <a href="#" onclick="event.preventDefault();eliminarRol('.$id.')" class="btn btn-danger btn-xs btn-rounded"><i class="fa fa-trash-o"></i></a>
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