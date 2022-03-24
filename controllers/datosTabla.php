<?php

class DatosTabla{

    public static function mostrarDatosTablaController($datos){

        $salida = '';

        $xvalor1 = '';
        $xvalor2 = '';
        $nvalor1 = '';
        $nvalor2 = '';

        $contenido = "";

        $mantenimiento = $datos["mantenimiento"];
        $rowsPerPage = $datos['por_pag'];
        $buscar = $datos['buscar'];
        $pageNum = ($datos["numPaginador"] == '')? 1 : $datos["numPaginador"];
        

        //Ultimo registro mostrado por el numero de pagina anterior
        $offset = ($pageNum - 1) * $rowsPerPage;

        $where =sprintf(" WHERE tipo = '%s' AND cidtabla = '%s' GROUP BY xidelem ",$datos['tipo'],$datos['tabla']);

        if($buscar != ''){
            $where =" WHERE xvalor1 LIKE  '%".$buscar."%' AND tipo = 'V' AND cidtabla = '".$datos['tabla']."' GROUP BY xidelem ";
        }

        //cantidad de registros
        $cantidad = DatosTablaModel::mostrarDatosTablaModel($where,"tabla_logica");
        $totalReg = count($cantidad);

        $total_paginas = ceil($totalReg / $rowsPerPage);

        $datosModel =  array("where"=>$where,
                                "offset"=>$offset,
                                "rowsPerPage"=>$rowsPerPage);

        
        $respuesta = DatosTablaModel::mostrarDatosTablaFilterModel($datosModel,"tabla_logica");

        if(count($respuesta) > 0){
            $i = 0;
            $tablaName = "";

            foreach ($respuesta as $row => $valor) {

                $id = $valor["id_tbl"];
                $tablaName = $valor["cidtabla"];
                $tab_id = $valor['xidelem'];
                $i++;
                $x = 0;

                $contenido .= '
                    <tr>
                        <td>'.$i.'</td>
                ';

                //GENERAR EL CONTENIDO SEGUN LAS ETIQUETAS LABEL HABILITADAS
                $whereHead = sprintf(" WHERE cidtabla = '%s' AND tipo = 'T' AND nvalor1 = '1' ",$datos["tabla"]);
                $thead = TablaLogicaModel::obtenerDatosTablaModel($whereHead,"tabla_logica");

                foreach ($thead as $key => $value) {

                    if($value["xidelem"] != 'TAB_DESC'){

                        $like = " columnas LIKE '%@".$value["xidelem"]."%' ";
                        $whereVal = sprintf(" WHERE cidtabla = '%s' AND tipo = 'V' AND xidelem = '%s' AND %s ",$tablaName,$tab_id,$like);
                        $tVal = TablaLogicaModel::obtenerDatosTablaModel($whereVal,"tabla_logica");

                        if(count($tVal) > 0){
                            foreach ($tVal as $key => $campo) {

                                $contenido .='
                                    <td>'.$campo["xvalor1"].'</td>
                                ';
                            }

                        }else{

                            $contenido .='<td></td>';

                        }
                    }
                }

                $contenido .= '
                   
                        <td class="text-center">
                ';

                if($mantenimiento == "1"){
                    $contenido .='
                            <a href="'.$tablaName.'" data-cod="'.$tab_id.'" data-accion="editar"  class="btn btn-primary btn-xs btn-rounded"><i class="far fa-edit"></i></a>
                            <a href="'.$tablaName.'" data-cod="'.$tab_id.'" data-accion="delete" class="btn btn-danger btn-xs btn-rounded"><i class="far fa-trash-alt"></i></a>
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
                            <td>Sin registros que mostrar.</td>
                        </tr>
                ';
        }

        

        $datosPaginacion = array("total_paginas"=>$total_paginas,
                                    "pageNum"=>$pageNum,
                                    "rowsPerPage"=>$rowsPerPage,
                                    "totalReg"=>$totalReg);

        $paginacion = Globales::paginacion($datosPaginacion);

        //CABECERA DE LA TABLA
        $where = sprintf(" WHERE cidtabla = '%s' AND tipo = 'T' AND nvalor1 = '1' ",$datos["tabla"]);
        $thead = TablaLogicaModel::obtenerDatosTablaModel($where,"tabla_logica");

        if(count($thead)>0){

            $salida = '
                <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="">
                    <thead>
                        <tr>
                            <th>#</th>
            ';

            foreach ($thead as $key => $value) {

                if($value['xidelem']!='TAB_DESC'){

                    if($value['xvalor1']!=''){
                        $salida .= '<th>'.$value['xvalor1'].'</th>';
                    }

                }

            }

            $salida .= '
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="listadoOk">
                        '.$contenido.'
                    </tbody>

                </table>
            '.$paginacion;


        }else{

            $salida = '
                <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="">
                    <thead>
                        <tr>
                            <th>Sin Columnas que mostrar</th>
                        </tr>
                    </thead>
                    <tbody id="listadoOk">
                        '.$contenido.'
                    </tbody>

                </table>
            ';
        }

        return $salida;

    }

    public static function descargarExcelTablaController(){

        $contenido = '';
        $salida = '';

        if(isset($_GET['term'])){

            $name = $_GET['term'];
            $file = $name.'.xls';
            
            header('Expires: 0');
            header('Cache-control: private');
            header("Content-type: application/vnd.ms-excel"); // Archivo de Excel
            header("Cache-Control: cache, must-revalidate"); 
            header('Content-Description: File Transfer');
            header('Last-Modified: '.date('D, d M Y H:i:s'));
            header("Pragma: public"); 
            header('Content-Disposition:; filename="'.$file.'"');
            header("Content-Transfer-Encoding: binary");
            

            $where =sprintf(" WHERE tipo = 'V' AND cidtabla = '%s' GROUP BY xidelem ",$name);

            $respuesta = DatosTablaModel::mostrarDatosTablaModel($where,"tabla_logica");
            
            if(count($respuesta) > 0){
                $i = 0;
                $tablaName = "";

                foreach ($respuesta as $row => $valor) {

                    $id = $valor["id_tbl"];
                    $tablaName = $valor["cidtabla"];
                    $tab_id = $valor['xidelem'];
                    $i++;
                    $x = 0;

                    $contenido .= '
                        <tr>
                            <td style="border:1px solid #eee;">'.$i.'</td>
                    ';

                    //GENERAR EL CONTENIDO SEGUN LAS ETIQUETAS LABEL HABILITADAS
                    $whereHead = sprintf(" WHERE cidtabla = '%s' AND tipo = 'T' AND nvalor1 = '1' ",$name);
                    $thead = TablaLogicaModel::obtenerDatosTablaModel($whereHead,"tabla_logica");

                    foreach ($thead as $key => $value) {

                        if($value["xidelem"] != 'TAB_DESC'){

                            $like = " columnas LIKE '%@".$value["xidelem"]."%' ";
                            $whereVal = sprintf(" WHERE cidtabla = '%s' AND tipo = 'V' AND xidelem = '%s' AND %s ",$tablaName,$tab_id,$like);
                            $tVal = TablaLogicaModel::obtenerDatosTablaModel($whereVal,"tabla_logica");

                            if(count($tVal) > 0){
                                foreach ($tVal as $key => $campo) {

                                    $contenido .='
                                        <td style="border:1px solid #eee;">'.$campo["xvalor1"].'</td>
                                    ';
                                }

                            }else{

                                $contenido .='<td style="border:1px solid #eee;"></td>';

                            }
                        }
                    }

                    $contenido .='
                        </tr>
                    ';

                }

            }else{
                $contenido .= '
                            <tr>
                                <td>Sin registros que mostrar.</td>
                            </tr>
                    ';
            }

            //CABECERA DE LA TABLA
            $where = sprintf(" WHERE cidtabla = '%s' AND tipo = 'T' AND nvalor1 = '1' ",$name);
            $thead = TablaLogicaModel::obtenerDatosTablaModel($where,"tabla_logica");

            if(count($thead)>0){

                echo utf8_decode('
                    <table cellpadding="0" cellspacing="0" class="table table-striped table-bordered">
                        <caption>Tabla: '.$name.'</caption>
                        <thead>
                            <tr>
                                <th style="font-weight:bold; border:1px solid #eee;">#</th>
                ');

                foreach ($thead as $key => $value) {

                    if($value['xidelem']!='TAB_DESC'){

                        if($value['xvalor1']!=''){
                            echo utf8_decode('<th style="font-weight:bold; border:1px solid #eee;">'.$value['xvalor1'].'</th>');
                        }

                    }

                }

                echo utf8_decode('
                            </tr>
                        </thead>
                        <tbody id="listadoOk">
                            '.$contenido.'
                        </tbody>

                    </table>');

            }

            

        }
    }

    public static function guardarDatosTablaController($datos){

        $respuestaOk =  false;
        $mensajeError = "No se puede ejecutar la aplicacion.";
        $contenidoOk = "";

        $countVacio = 0;
        $error = 0;
        $errorSalida = '';

        $count_reg_validos = 0;
        $salida_reg_error = '';

        $xidelem = $datos['xidelem'];
        $tab_id = array_key_exists('TAB_ID', $xidelem) ? $xidelem['TAB_ID'] : uniqid(); //CODIGO
        $label = $datos['label'];
        $cidtabla = mb_strtoupper($datos['cidtabla'],'UTF-8');

        //VALIDAR CAMPOS
        $estructura = '';
        $cidtabla = $datos['cidtabla'];

        //VALIDAR CODIGO REGISTRO
        //if($xidelem["TAB_ID"] != ''){
        if($tab_id != ''){

            $value = $tab_id; //$xidelem["TAB_ID"];
            $value = mb_strtoupper($value,'UTF-8');
            $estructura = $value.'@TAB_ID@'.$cidtabla;

            $where = sprintf(" WHERE validar_campos = '%s' AND tipo = 'V' ",$estructura);

            $validar = TablaLogicaModel::obtenerDatosTablaModel($where,'tabla_logica');

            if(count($validar) > 0){

                $error++;
                $errorSalida .= '<strong>'.$label["TAB_ID"].': '.$value.'</strong><br>';
            }

        }

        //VALIDAR QUE NO VENGAN VACIOS
        foreach ( $xidelem as $key => $value) {

            if($value == ''){

                $countVacio++;
                
            }
            
        }

        
        if($countVacio == 0){

            if($error == 0){

                foreach ($xidelem as $key => $value) {

                    $value = ucwords($value);

                    $datos['xidelem_value'] = $tab_id;
                    $datos['nvalor1_value'] = 0;
                    $datos['nvalor2_value'] = 0;
                    $datos['xvalor1_value'] = $value;
                    $datos['xvalor2_value'] = '';
                    $datos['validar_campos'] = $value.'@'.$key.'@'.$datos['cidtabla'];
                    $datos['columnas'] = $label[$key].'@'.$key;

                    $respuesta = DatosTablaModel::guardarDatosTablaModel($datos,'tabla_logica');

                    if($respuesta == 'ok'){
                        $count_reg_validos++;
                    }else{
                        $salida_reg_error .= $value;
                    }
                }

                $respuestaOk = true;

                if($count_reg_validos > 0 && $salida_reg_error == ''){
                    $mensajeError = "Se guardo correctamente el registro.";
                }else{
                    $mensajeError = "Se guardo el registro, menos estos valores:<br>".$salida_reg_error.$salida_reg_error;
                }

            }else{
                $mensajeError = "Estos valores ya se encuentra registrados:<br>".$errorSalida;
            }

        }else{
            $mensajeError = "Los campos no pueden estar vacios.";
        }


        $salidaJson = array('respuesta'=>$respuestaOk,
                            'mensaje'=>$mensajeError,
                            'contenido'=>$contenidoOk);

        echo json_encode($salidaJson);

    }

    public static function cargarDatosTablaController($datos){

        $respuestaOk =  false;
        $mensajeError = "No se puede ejecutar la aplicacion.";
        $contenidoOk = "";

        $tab_id = $datos['codigo'];

        $columnas = array();
        $label = '';
        $xidelem = '';
        $campos = array();
        $valor = '';

        $like = '';

        $where = sprintf(" WHERE cidtabla = '%s' AND tipo = 'T' AND nvalor1 = '1' ",$datos['cidtabla']);
        $verificarLabel = TablaLogicaModel::obtenerDatosTablaModel($where,'tabla_logica');

        if(count($verificarLabel) > 0){

            foreach ($verificarLabel as $key => $value) {

                if($value['xidelem'] != 'TAB_DESC'){

                    $like = " columnas LIKE '%@".$value['xidelem']."%' AND ";
                    $where = sprintf(" WHERE xidelem = '%s' AND cidtabla = '%s' AND %s tipo = 'V' LIMIT 1",$tab_id,$datos['cidtabla'],$like);
                    $verificarCodigo = TablaLogicaModel::obtenerDatosTablaModel($where,'tabla_logica');

                    if(count($verificarCodigo) > 0){

                        foreach ($verificarCodigo as $key => $mostrar) {

                            $id = $mostrar['id_tbl'];

                            $rows = explode("@", $mostrar["columnas"]);
                            $label = $rows[0];
                            $xidelem = $rows[1];
                            
                            $label = ($label != $value['xvalor1'])?$value['xvalor1']:$label;

                            $campos = explode("@", $mostrar["validar_campos"]);
                            $valor = $campos[0];

                            $name = 'xidelem['.$xidelem.']';

                            $validar = ($value["validar_campos"]=="string")?'alphanum':'numeric';

                            $contenidoOk .= '
                                <div class="form-group">
                                    <input type="hidden" id="'.$xidelem.'_id" name="term_tbl['.$xidelem.']" class="form-control term_validar" value="'.$id.'" required>
                                    <label class="col-sm-4 control-label">
                                        '.$label.'
                                    </label>
                                    <div class="col-sm-7">
                                        <input type="text" id="'.$xidelem.'" name="'.$name.'" class="form-control '.$validar.'" value="'.$valor.'" required>
                                        <input type="hidden" id="'.$xidelem.'_label" name="label['.$xidelem.']" value="'.$label.'" class="form-control" required>
                                        <input type="hidden" id="'.$xidelem.'_tipo" name="tipoCampo['.$xidelem.']" value="'.$value['validar_campos'].'" class="form-control" required>
                                    </div>
                                    
                                </div>
                            ';

                        }
                        
                    }elseif($value['xvalor1']!=''){

                        $datos['xidelem_value'] = $tab_id;
                        $datos['nvalor1_value'] = 0;
                        $datos['nvalor2_value'] = 0;
                        $datos['xvalor1_value'] = '';
                        $datos['xvalor2_value'] = '';
                        $datos['validar_campos'] = '@'.$value['xidelem'].'@'.$datos['cidtabla'];
                        $datos['columnas'] = $value['xvalor1'].'@'.$value['xidelem'];

                        $respuesta = DatosTablaModel::guardarDatosTablaModel($datos,'tabla_logica');

                        $id = DatosTablaModel::ultimoIdRegistradoModel('id_tbl','tabla_logica');
                        $xidelem = $value['xidelem'];

                        $name = 'xidelem['.$xidelem.']';
                        $label = $value['xvalor1'];
                        $valor = '';

                        $contenidoOk .= '
                            <div class="form-group">
                                <input type="hidden" id="'.$xidelem.'_id" name="term_tbl['.$xidelem.']" class="form-control term_validar" value="'.$id.'" required>
                                <label class="col-sm-4 control-label">
                                    '.$label.'
                                </label>
                                <div class="col-sm-7">
                                    <input type="text" id="'.$xidelem.'" name="'.$name.'" class="form-control term_validar" value="'.$valor.'" required>
                                    <input type="hidden" id="'.$xidelem.'_label" name="label['.$xidelem.']" 
                                    value="'.$label.'" class="form-control" required>
                                </div>
                                
                            </div>
                        ';
                        
                    }
                
                }

            }

        }else{
            $mensajeError ="Sin registros";
        }

        $salidaJson = array('respuesta'=>$respuestaOk,
                            'mensaje'=>$mensajeError,
                            'contenido'=>$contenidoOk);

        echo json_encode($salidaJson);
    }

    public static function actualizarDatosTablaController($datos){

        $respuestaOk =  false;
        $mensajeError = "No se puede ejecutar la aplicacion.";
        $contenidoOk = "";

        $countVacio = 0;
        $error = 0;
        $errorSalida = '';

        $count_reg_validos = 0;
        $salida_reg_error = '';

        $id_tbl = $datos['id_tbl'];
        $xidelem = $datos['xidelem'];
        $tab_id = array_key_exists('TAB_ID', $xidelem) ? $xidelem['TAB_ID'] : '' ;
        $label = $datos['label'];
        $cidtabla = mb_strtoupper($datos['cidtabla'],'UTF-8');

        //print_r($id_tbl); exit();

        //VALIDAR CAMPOS
        $estructura = '';
        $old_estructura = '';

        //VALIDAR CODIGO REGISTRO
        if($xidelem["TAB_ID"] != ''){

            $value = $xidelem["TAB_ID"];

            $where_old = sprintf(" WHERE id_tbl = '%d' ",$id_tbl["TAB_ID"]);
            $old = TablaLogicaModel::obtenerDatosTablaModel($where_old,'tabla_logica');

            if(count($old) > 0){
                foreach ($old as $key2 => $old_value) {
                    $old_estructura = $old_value["validar_campos"];
                    $old_estructura = mb_strtoupper($old_estructura,'UTF-8');
                }
            }

            $value = mb_strtoupper($value,'UTF-8');
            $estructura = $value.'@TAB_ID@'.$cidtabla;

            if($old_estructura != $estructura){

                $where = sprintf(" WHERE validar_campos = '%s' AND tipo = 'V' ",$estructura);

                $validar = TablaLogicaModel::obtenerDatosTablaModel($where,'tabla_logica');

                if(count($validar) > 0){

                    $error++;
                    $errorSalida .= '<strong>'.$label["TAB_ID"].': '.$value.'</strong><br>';
                }

            }
        }

        //VALIDAR QUE NO TENGAN CAMPOS VACIOS
        foreach ( $xidelem as $key => $value) {

            if($value == ''){

                $countVacio++;

            }
            
        }
        
        if($countVacio == 0){
            
            if($error == 0){
                
                foreach ($xidelem as $key => $value) {

                    $value = ucwords($value);
                    
                    $datos['id'] = $id_tbl[$key];
                    $datos['xidelem_value'] = $tab_id;
                    $datos['nvalor1_value'] = 0;
                    $datos['nvalor2_value'] = 0;
                    $datos['xvalor1_value'] = $value;
                    $datos['xvalor2_value'] = '';
                    $datos['validar_campos'] = $value.'@'.$key.'@'.$datos['cidtabla'];
                    $datos['columnas'] = $label[$key].'@'.$key;

                    $respuesta = DatosTablaModel::actualizarDatosTablaModel($datos,'tabla_logica');

                    if($respuesta == 'ok'){
                        $count_reg_validos++;
                    }else{
                        $salida_reg_error .= $value;
                    }
                }

                $respuestaOk = true;

                if($count_reg_validos > 0 && $salida_reg_error == ''){
                    $mensajeError = "Se actualizo correctamente el registro.";
                }else{
                    $mensajeError = "Se actualizo el registro, menos estos valores:<br>".$salida_reg_error;
                }
                

            }else{
                $mensajeError = "Estos valores ya se encuentra registrados:<br>".$errorSalida;
            }
            

        }else{
            $mensajeError = "Los campos no pueden estar vacios.";
        }
        

        $salidaJson = array('respuesta'=>$respuestaOk,
                            'mensaje'=>$mensajeError,
                            'contenido'=>$contenidoOk);

        echo json_encode($salidaJson);
    }

    public static function eliminarDatosTablaController($datos){

        $respuestaOk =  false;
        $mensajeError = "No se puede ejecutar la aplicacion.";
        $contenidoOk = "";

        $respuesta = DatosTablaModel::eliminarDatosTablaModel($datos,'tabla_logica');

        if($respuesta == 'ok'){

            $mensajeError = "Se elimino el registro exitosamente.";
            $respuestaOk = true;

        }else{
            $mensajeError = "Error al eliminar el registro.";
        }

        $salidaJson = array('respuesta'=>$respuestaOk,
                            'mensaje'=>$mensajeError,
                            'contenido'=>$contenidoOk);

        echo json_encode($salidaJson);
    }

}