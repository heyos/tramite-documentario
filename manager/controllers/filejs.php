<?php

class File{

    public static function mostrarFileJsController($datos){

        $contenido = "";
        
        $rowsPerPage = $datos['por_pag'];
        $buscar = $datos['buscar'];
        $pageNum = ($datos["numPaginador"] == '')? 1 : $datos["numPaginador"];
        

        //Ultimo registro mostrado por el numero de pagina anterior
        $offset = ($pageNum - 1) * $rowsPerPage;

        $where ='';

        if($buscar != ''){
            $where ="  file LIKE  '%".$buscar."%' AND ";
        }

        //Cantidad total de registros
        $cantidad = FileModel::mostrarFileJsModel($where,"file_js");
        $totalReg = count($cantidad);

        $total_paginas = ceil($totalReg / $rowsPerPage);

        $datosModel =  array("where"=>$where,
                                "offset"=>$offset,
                                "rowsPerPage"=>$rowsPerPage);

        $respuesta = FileModel::mostrarFileJsFilterModel($datosModel,"file_js");

        if(count($respuesta) > 0){

            $i = 0;

            foreach ($respuesta as $row => $value) {

                $i++;

                $id = $value["id_file"];
                $sistema = $value["sistema"];
                
                $contenido .= '
                        <tr>
                            <td>'.$i.'</td>
                            <td id="tdFile'.$id.'">'.$value["file"].'</td>
                            <td>
                                
                        
                ';

                if($sistema == '1'){
                    $contenido .='
                                Archivos del sistema, no se puede eliminar o modificar.
                    ';
                }else{

                    $contenido .='
                                <a href="'.$id.'" data-accion="edit" class="btn btn-primary btn-xs btn-rounded"><i class="far fa-edit"></i></a>
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
                            <td colspan="3">Sin registros que mostrar.</td>
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
                        <th>File JS</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="listadoFileOk">
                    '.$contenido.'
                </tbody>

            </table>
        '.$paginacion;

        return $salida;


    }

    public static function mostrarDataFileSelect(){

        $respuestaOk = false;
        $mensajeError = "No se puede ejecutar la aplicacion";
        $contenidoOk = "";

        $respuesta = FileModel::mostrarFileJsModel("","file_js");

        $contenidoOk ='
                <select name="fileJs[]" class="form-control select2">
            ';

        if(count($respuesta)){

            foreach ($respuesta as $key => $item) {
                
                $contenidoOk .='
                    <option value="'.$item["id_file"].'">'.$item["file"].'</option>
                ';
            }

        }else{

            $contenidoOk = '<option>Sin registros</option>';
        }

        $contenidoOk .='
                </select>
            ';

        $salidaJson = array("respuesta"=>$respuestaOk,
                            "contenido"=>$contenidoOk,
                            "mensaje"=>$mensajeError);

        echo json_encode($salidaJson);

    }

    public static function guardarFileJsController($datos){

        $respuestaOk = false;
        $mensajeError = "No se puede ejecutar la aplicacion";
        $contenidoOk = "";

        $error = 0;

        if(strlen(stristr($datos,'.'))>0){

            $extension = explode(".", $datos);

            if($extension[1] != 'js'){
                $mensajeError = "Extension no permitida.";
                $error = 1;

            }else{

                $where = sprintf(" file = '%s' AND ",$datos);
                $verificar = FileModel::datosFileJsModel($where,"file_js");

                if(!empty($verificar["file"])){

                    $mensajeError = "Este registro ya se existe, registre uno nuevo.";

                }else{
                    //guardamos

                    $respuesta = FileModel::guardarFileJsModel($datos,"file_js");

                    if($respuesta == 'ok'){
                        $respuestaOk = true;
                        $mensajeError = "Se guardo exitosamente el registro.";

                        //copiamos la plantilla en la ruta de desarrollo
                        $ruta = "../../views/js/plantilla_js.js";
                        
                        $rutaGeneral = "../../../views/mainJs/".$datos;

                        if(!file_exists($rutaGeneral)){
                            copy($ruta,$rutaGeneral);
                        }

                    }else{
                        $mensajeError = "Error al guardar el registro.";
                    }

                }
            }

        }else{
            $mensajeError = "Debe ingresar un archivo valido de extension .js";
        }

        $salidaJson = array("respuesta"=>$respuestaOk,
                            "contenido"=>$contenidoOk,
                            "mensaje"=>$mensajeError);

        echo json_encode($salidaJson);

    }

    public static function actualizarFileJsController($datos){

        $respuestaOk = false;
        $mensajeError = "No se puede ejecutar la aplicacion";
        $contenidoOk = "";

        $error = 0;
    
        if(strlen(stristr($datos["file"],'.')) > 0){

            $extension = explode(".", $datos["file"]);

            if($extension[1] != 'js'){
                $mensajeError = "Extension no permitida.";      

            }else{
            
                if($datos["oldFile"] != $datos["file"]){

                    $where = sprintf(" file = '%s' AND ",$datos["file"]);
                    $verificar = FileModel::datosFileJsModel($where,"file_js");

                    if(!empty($verificar["file"])){

                        $mensajeError = "Este registro ya se existe, registre uno nuevo.";
                        $error = 1;

                    }

                }

                if($error==0){
                    //actualizamos

                    $respuesta = FileModel::actualizarFileJsModel($datos,"file_js");
                
                    if($respuesta == 'ok'){
                        $respuestaOk = true;
                        $mensajeError = "Se actualizo exitosamente el registro.";

                    
                        //copiamos el nuevo file
                        $ruta = "../../../views/mainJs/".$datos["oldFile"];
                        
                        $rutaGeneral = "../../../views/mainJs/".$datos["file"];
                    
                        
                        if($datos["oldFile"] != $datos["file"]){

                            if(!file_exists($rutaGeneral)){

                                copy($ruta,$rutaGeneral);

                            }
                            
                        }
                    
                    }else{
                        $mensajeError = "Error al actualizar el registro.";
                    }
                
                }
                
            }

        }else{
            $mensajeError = "Debe ingresar un archivo valido de extension .js";
        }
    
        $salidaJson = array("respuesta"=>$respuestaOk,
                            "contenido"=>$contenidoOk,
                            "mensaje"=>$mensajeError);

        echo json_encode($salidaJson);

    }

    public static function eliminarFileJsController($datos){

        $respuestaOk = false;
        $mensajeError = "No se puede ejecutar la aplicacion";
        $contenidoOk = "";
        
        $respuesta = FileModel::eliminarFileJsModel($datos,"file_js");

        if($respuesta == "ok"){
            $respuestaOk = true;
            $mensajeError = "Se elimino correctamente el registro.";
        }else{
            $mensajeError ="Error al eliminar el registro.";
        }
        
        $salidaJson = array("respuesta"=>$respuestaOk,
                            "contenido"=>$contenidoOk,
                            "mensaje"=>$mensajeError);

        echo json_encode($salidaJson);
    }
}