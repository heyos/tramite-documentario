<?php

class MenuJs{

    public static function mostrarDataJsController($datos){

        $mensajeError = "No se puede ejecutar la aplicacion.";
        $respuestaOk = false;
        $contenidoOk = '';

        if($datos["type"]=="m"){
            $where = sprintf(" j.id_menu = '%d' AND ",$datos["id"]);
        }else{
            $where = sprintf(" j.id_sub_menu = '%d' AND ",$datos["id"]);
        }

        $respuesta = MenuJsModel::mostrarDataJsModel($where,"js_menu_asociado AS j, file_js AS f");

        if(count($respuesta)>0){

            foreach ($respuesta as $row => $item) {

                $id = $item[0];
                $sistema = $item[3];

                $contenidoOk .='
                    <tr id="trFile'.$id.'">
                        <td id="tdFile'.$id.'">'.$item[2].'</td>
                        <td>
                        
                ';

                if($sistema == '1'){
                    $contenidoOk .='
                            Archivo del sistema, no se puede eliminar o modificar.
                    ';
                }else{
                    $contenidoOk .='
                            <a data-accion="delete" href="'.$id.'" class="btn btn-danger btn-xs btn-rounded"><i class="far fa-trash-alt"></i></a>
                    ';
                }

                $contenidoOk .='
                        </td>
                    </tr>
                ';


            }

        }else{
            $contenidoOk = '
                <tr id="trFileEmpty">
                        <td colspan="2">Sin registros</td>
                 </tr>
            ';

        }


        $salidaJson = array("respuesta"=>$respuestaOk,
                            "mensaje"=>$mensajeError,
                            "contenido"=>$contenidoOk);

        echo json_encode($salidaJson);
    }

    public static function guardarFileJsController($datos){

        $mensajeError = "No se puede ejecutar la aplicacion.";
        $respuestaOk = false;
        $contenidoOk = '';

        $error = 0;
        $logError="";

        $logErrorFile = "";

        $guardar = 0;

        $new_array =  array();

        $new_array = array_unique($datos["files"]);

        if(count($new_array) > 0){
            

            foreach ($new_array as $file) { //validamos que no se encuentren registrado

                if($datos["type"]=='m'){
                    $extra = sprintf("id_menu = '%d' AND",$datos["id"]);
                }else{
                    $extra = sprintf("id_sub_menu = '%d' AND",$datos["id"]);
                }

                $where = sprintf(" id_file = '%d' AND %s ",$file,$extra);
                $validar = MenuJsModel::datosFileJsModel($where,"js_menu_asociado");

                if(!empty($validar["id_js"])){
                    $error++;

                    $id_js = $validar["id_js"];
                    $where = sprintf(" j.id_js = '%d' AND ",$id_js);
                    $datos = MenuJsModel::registroFileJsModel($where,"js_menu_asociado AS j, file_js AS f");
                    $fileName = $datos[2];

                    $logError .= '<strong>'.$fileName.'</strong><br>';
                }
              
            }

            if($error == 0){
                

                foreach ($new_array as $file) {

                    $datosController = array("id_file"=>$file,"id"=>$datos["id"]);

                    if($datos["type"]=='m'){
                        $respuesta = MenuJsModel::guardarFileJsMenuModel($datosController,"js_menu_asociado");
                    }else{
                        $respuesta = MenuJsModel::guardarFileJsSubMenuModel($datosController,"js_menu_asociado");
                    }
                
                    if($respuesta == "ok"){
                        $guardar++;

                        $id = MenuJsModel::ultimoIdRegistrado("id_js","js_menu_asociado");
                        
                        $where = sprintf(" j.id_js = '%d' AND ",$id);
                        $datosFile = MenuJsModel::registroFileJsModel($where,"js_menu_asociado AS j, file_js AS f");
                        $fileName = $datosFile[2];

                        $contenidoOk .='
                            <tr id="trFile'.$id.'">
                                <td id="tdFile'.$id.'">'.$fileName.'</td>
                                <td>
                                    <a data-accion="delete" href="'.$id.'" class="btn btn-danger btn-xs btn-rounded"><i class="far fa-trash-alt"></i></a>
                                </td>
                            </tr>
                        ';

                    }else{
                        $guardar=0;
                        
                    }
                

                }
                

                if($guardar !=0){

                    $respuestaOk = true;
                    $mensajeError = "Se guardaron satisfactoriamente los files asociados al menu.";

                }else{
                    $mensajeError = "No se guardaron los registros.";
                }

            }else{

                $mensajeError = ($error == 1)? "Este File:<br>".$logError." ya se encuentra asociado." : "Estos Files:<br>".$logError." ya se encuentran asociados.";
            
            }
            

        }else{
            $mensajeError = "Debe agregar almenos un registro";
        }

        

        $salidaJson = array("respuesta"=>$respuestaOk,
                            "mensaje"=>$mensajeError,
                            "contenido"=>$contenidoOk);

        echo json_encode($salidaJson);
    }

    public static function actualizarFileJsController($datos){

        $mensajeError = "No se puede ejecutar la aplicacion.";
        $respuestaOk = false;
        $contenidoOk = '';

        $error = 0;
        $logError="";

        $errorFile = 0;
        $logErrorFile = "";

        if($datos["oldFile"] != $datos["file"]){

            if(strlen(stristr($datos["file"],'.'))>0) {
                    
                $extension = explode(".", $datos["file"]);

                if($extension[1] == "js"){ //validamos la extension correcta

                    $where = sprintf(" file = '%s' AND ",$datos["file"]);
                    $validar = MenuJsModel::datosFileJsModel($where,"js_menu_asociado");

                    if(!empty($validar["file"])){
                        $error++;

                        $logError .= '<strong>'.$datos["file"].'</strong><br>';
                    }

                }else{
                    $errorFile ++;
                    $logErrorFile .= '<strong>'.$datos["file"].'</strong><br>';
                }

            }else{
                $errorFile ++;
                $logErrorFile .= '<strong>'.$datos["file"].'</strong><br>';
            }

        }


        if($error == 0 && $errorFile == 0){
            
            $respuesta = MenuJsModel::actualizarFileJsModel($datos,"js_menu_asociado");

            if($respuesta == "ok"){

                $respuestaOk = true;
                $mensajeError = "Se actualizo correctamente el file.";

                $ruta = "../../../views/mainJs/".$datos["oldFile"];
                $rutaGeneral = "../../../views/mainJs/".$datos["file"];

                if($datos["oldFile"] != $datos["file"]){

                    if(!file_exists($rutaGeneral)){

                        copy($ruta,$rutaGeneral);

                    }
                    
                }

            }else{
                $mensajeError = "No se actualizo el registro.";
            }
        
        }else{

            if($error > 0){
                $mensajeError = "Este File:<br>".$logError." ya se encuentra asociado.";
            }
            
            if($errorFile > 0){
                $mensajeError = ($errorFile > 0)? "<br>File(s):<br>".$logErrorFile." no contienen extension valida.":"";
            }
        }

        $salidaJson = array("respuesta"=>$respuestaOk,
                            "mensaje"=>$mensajeError,
                            "contenido"=>$contenidoOk);

        echo json_encode($salidaJson);

    }

    public static function eliminarFileJsController($datos){

        $mensajeError = "No se puede ejecutar la aplicacion.";
        $respuestaOk = false;
        $contenidoOk = '';

        $respuesta = MenuJsModel::eliminarFileJsModel($datos,"js_menu_asociado");

        if($respuesta == "ok"){

            $mensajeError = "Se elimino correctamente el FILE.";
            $respuestaOk = true;
        }

        $salidaJson = array("respuesta"=>$respuestaOk,
                            "mensaje"=>$mensajeError,
                            "contenido"=>$contenidoOk);

        echo json_encode($salidaJson);

    }
}