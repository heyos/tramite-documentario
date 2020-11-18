<?php

class TablaLogica{

    //MOSTRAR
    public static function mostrarTablaLogicaController($datos){

        $contenido = "";

        $mantenimiento = $datos["mantenimiento"];
        $rowsPerPage = $datos['por_pag'];
        $buscar = $datos['buscar'];
        $pageNum = ($datos["numPaginador"] == '')? 1 : $datos["numPaginador"];
        

        //Ultimo registro mostrado por el numero de pagina anterior
        $offset = ($pageNum - 1) * $rowsPerPage;

        $where =sprintf(" WHERE tipo = '%s' ",$datos['tipo']);

        if($buscar != ''){
            $where =" WHERE cidtabla LIKE  '%".$buscar."%' AND tipo = 'T' ";
        }

        //cantidad de registros
        $cantidad = TablaLogicaModel::mostrarTablaLogicaModel($where,"tabla_logica");
        $totalReg = count($cantidad);

        $total_paginas = ceil($totalReg / $rowsPerPage);

        $datosModel =  array("where"=>$where,
                                "offset"=>$offset,
                                "rowsPerPage"=>$rowsPerPage);

        $respuesta = TablaLogicaModel::mostrarTablaLogicaFilterModel($datosModel,"tabla_logica");

        if(count($respuesta) > 0){
            $i = 0;
            $tablaName = "";
            $numRows = 0;

            foreach ($respuesta as $row => $valor) {

                $id = $valor["id_tbl"];
                $tablaName = $valor["cidtabla"];
                $i++;

                $contenido .= '
                    <tr>
                        <td>'.$i.'</td>
                        <td>'.$tablaName.'</td>
                        <td>'.$valor["columnas"].'</td>
                        <td class="text-center">
                ';
                

                if($mantenimiento == "1"){
                    $contenido .='
                            <a href="'.$tablaName.'" data-accion="editar"  class="btn btn-primary btn-xs btn-rounded"><i class="far fa-edit"></i></a>
                            <a href="'.$tablaName.'" data-accion="delete" class="btn btn-danger btn-xs btn-rounded"><i class="far fa-trash-alt"></i></a>
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

        $salida = '
            <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Tabla</th>
                        <th>Columnas</th>
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

    public static function mostrarSelectOptionTablaController(){

        $salida = '';

        $where = sprintf(" GROUP BY cidtabla");
        $respuesta = TablaLogicaModel::obtenerDatosTablaModel($where,'tabla_logica');

        if(count($respuesta) > 0){

            foreach ($respuesta as $key => $value) {
                
                $salida .= '
                    <option value="'.$value['cidtabla'].'">'.$value['cidtabla'].'</option>
                ';

            }
        }

        return $salida;
    }

    public static function mostrarInputsTablaController($datos){

        $respuestaOk =  false;
        $mensajeError = "No se puede ejecutar la aplicacion.";
        $contenidoOk = "";

        $where = sprintf(" WHERE cidtabla = '%s' AND tipo ='T' AND nvalor1 = '1' ",$datos['tabla']);
        $respuesta = TablaLogicaModel::obtenerDatosTablaModel($where,'tabla_logica');

        if(count($respuesta) > 0){

            $name = "";
            $validar = '';

            foreach ($respuesta as $key => $value) {

                if($value['xidelem']!='TAB_DESC'){

                    $name = 'xidelem['.$value['xidelem'].']';
                    $validar = ($value["validar_campos"]=="string")?'alphanum':'numeric';

                    if($value['xvalor1']!=''){
                        
                        $contenidoOk .= '
                            <div class="form-group">
                                <label class="col-sm-4 control-label">
                                    '.$value['xvalor1'].'
                                </label>
                                <div class="col-sm-7">
                                    <input type="text" id="'.$value['xidelem'].'" name="'.$name.'" class="form-control '.$validar.'" required>
                                    <input type="hidden" id="'.$value['xidelem'].'_label" name="label['.$value['xidelem'].']" value="'.$value['xvalor1'].'" class="form-control" required>
                                    <input type="hidden" id="'.$value['xidelem'].'_tipo" name="tipoCampo['.$value['xidelem'].']" value="'.$value['validar_campos'].'" class="form-control" required>
                                </div>
                                
                            </div>
                        ';
                    }

                }

            }

        }else{
            $mensajeError = "Tabla no contiene INPUTS de registros.";
        }

        $salidaJson = array('respuesta'=>$respuestaOk,
                            'mensaje'=>$mensajeError,
                            'contenido'=>$contenidoOk);

        echo json_encode($salidaJson);
    }

    //REGISTRAR TABLA
    public static function guardarTablaController($datos){

        $respuestaOk =  false;
        $mensajeError = "No se puede ejecutar la aplicacion.";
        $contenidoOk = "";

        $guardar = 0;
        $error = 0;
        $errorLabel = 0;
        $errorGuardar = '';
        $errorDesc = '';
        $tablaName = '';
        $rows = '';
        $rows_decripcion = '';
        $descripcion = '';
        
        $labelForm = $datos["labelForm"];
        $mostrar = $datos["mostrar"];
        $validar = $datos["validar"];
        $xvalor1 = $datos["xvalor1"];
        $xvalor2 = $datos["xvalor2"];
        $array_sin_vacios = array();

        $tab= array('TAB_DESC'=>'TAB_DESC','TAB_ID'=>'TAB_ID','TAB_X1'=>'TAB_X1','TAB_X2'=>'TAB_X2','TAB_N1'=>'TAB_N1','TAB_N2'=>'TAB_N2');
        $etiquetas = array('TAB_DESC'=>'','TAB_ID'=>'ID Tabla','TAB_X1'=>'Campo Caracter 1','TAB_X2'=>'Campo Caracter 2','TAB_N1'=>'Campo Numerico 1','TAB_N2'=>'Campo Numerico 2');

        //validar campos LLAVE
        foreach ($datos["xidelem"] as $key => $value) {
            
            if($value == ''){
                $error++;
            }
        }
        //--------------------------------------------

        //validar campos tipo
        foreach ($validar as $key => $value) {
            if($value == ''){
                $error++;
            }
        }
        //------------------------------

        //VALIDAR QUE CAMPOS LABEL NO VENGAN VACIOS SI SE ELIGE QUE SE MUESTRE
        if($mostrar != 0){

            foreach ($mostrar as $key => $value) {
                
                if($xvalor1[$key] == ''){
                    $errorLabel++;
                    $errorDesc .= $labelForm[$key].'<br>';
                }
            }

            if($error == 0 && $errorLabel == 0){

                $where = sprintf(" WHERE cidtabla = '%s' AND tipo = '%s' ",$datos['cidtabla'],$datos['tipo']);
                $verificar = TablaLogicaModel::datosTablaModel($where,'tabla_logica');

                if(!empty($verificar['cidtabla'])){

                    $mensajeError = "Esta tabla ya esta registrada.";

                }else{
                
                    $tablaName = $datos['cidtabla'];
                    $i = 0;

                    foreach ($datos["xidelem"] as $key => $value) {

                        $mostrar_val = 0;

                        if($mostrar != 0){
                            if(array_key_exists($key,$mostrar)){
                                $mostrar_val = Globales::sanearData($mostrar[$key]);
                            }
                        }

                        if($value == "TAB_DESC"){
                            $datos['xvalor1_value'] = $tablaName;
                        }else{

                            $i++;
                            
                            $datos['xvalor1_value'] = ($xvalor1[$key]!='')?Globales::sanearData($xvalor1[$key]):'';
                            $datos['xvalor1_value'] = ucwords($datos['xvalor1_value']);

                            if($xvalor1[$key]!='' && $mostrar_val == 1){
                                $array_sin_vacios = array_filter($xvalor1);
                                $band = count($array_sin_vacios);
                                $rows_decripcion .= ucwords($xvalor1[$key]);

                                $rows_decripcion .= ($i<$band)?' - ':'';
                            }
                            
                        }

                        $datos['xidelem_value'] = ($value != $tab[$key])?strtoupper($tab[$key]):$value;
                        $datos['xvalor2_value'] = ($xvalor2[$key]!='')?Globales::sanearData($xvalor2[$key]):'';
                        $datos['xvalor2_value'] = ucwords($datos['xvalor2_value']);
                        $datos['nvalor1_value'] = $mostrar_val;
                        $datos['nvalor2_value'] = 0;
                        $datos['validar'] = Globales::sanearData($validar[$key]);
                        
                        $respuesta = TablaLogicaModel::guardarTablaModel($datos,"tabla_logica");
                                                                                                
                        if($respuesta == 'ok'){
                            $guardar++;
                        }else{
                            $errorGuardar .= '<strong>'.$labelForm[$key].': </strong>'.$xvalor1[$key].'<br>';
                        }

                    }

                    if($guardar > 0){
                        $respuestaOk = true;
                        $mensajeError = "Se guardo correctamente el registro.";
                        
                        if($errorGuardar !=''){
                            $mensajeError = "Se guardaron correctamente los registros. Menos estos valores:<br>";
                        }

                        $where = sprintf(" WHERE cidtabla ='%s' AND tipo = 'T' ",$tablaName);
                        $verificarTabla = TablaLogicaModel::datosTablaModel($where,'tabla_logica');

                        if(!empty($verificarTabla["cidtabla"])){
                            $where = sprintf(" columnas = '%s' WHERE cidtabla = '%s' AND tipo = 'T' ",$rows_decripcion,$tablaName);
                            TablaLogicaModel::actualizarTablaModel($where,'tabla_logica');
                        }

                    }else{
                        $mensajeError = "Error al guardar los registros.";
                    }

                }

            }else{

                if($error > 0){
                   $mensajeError = "Los campos no pueden estar vacios. Cierre el formulario y vuelva abrirlo."; 
                }

                if($errorLabel > 0){
                    $mensajeError = "Los campos:<br> <strong>".$errorDesc."</strong> no pueden estar vacios."; 
                }

                if($errorLabel > 0 && $error >0){
                    $mensajeError = "Los campos no pueden estar vacios. Cierre el formulario y vuelva abrirlo
                                    <br><br>Los campos: <br><strong>".$errorDesc."</strong> no pueden estar vacios."; 
                }
            }


        }else{

            $mensajeError = "Almenos debe habilitar un nombre de etiqueta.";
        }

        
        $salidaJson = array('respuesta'=>$respuestaOk,
                            'mensaje'=>$mensajeError,
                            'contenido'=>$contenidoOk);

        echo json_encode($salidaJson);

    }

    //ACTUALIZAR TABLA
    public static function actualizarTablaController($datos){

        $respuestaOk =  false;
        $mensajeError = "No se puede ejecutar la aplicacion.";
        $contenidoOk = "";

        $guardar = 0;
        $error = 0;
        $errorLabel = 0;
        $errorGuardar = '';
        $errorDesc = '';
        $tablaName = '';
        $rows = '';
        $rows_decripcion = '';
        $descripcion = '';
        
        $id_tbl = $datos["id_tbl"];
        $labelForm = $datos["labelForm"];
        $mostrar = $datos["mostrar"];
        $validar = $datos["validar"];
        $xvalor1 = $datos["xvalor1"];
        $xvalor2 = $datos["xvalor2"];
        $array_sin_vacios = array();

        //variables values
        $xidelem_value = '';
        $xvalor1_value = '';
        $xvalor2_value = '';
        $nvalor1_value = 0;
        $nvalor2_value = 0;
        $validar_value = '';
        $mostrar_value = '';

        $tab= array('TAB_DESC'=>'TAB_DESC','TAB_ID'=>'TAB_ID','TAB_X1'=>'TAB_X1','TAB_X2'=>'TAB_X2','TAB_N1'=>'TAB_N1','TAB_N2'=>'TAB_N2');
        $etiquetas = array('TAB_DESC'=>'','TAB_ID'=>'ID Tabla','TAB_X1'=>'Campo Caracter 1','TAB_X2'=>'Campo Caracter 2','TAB_N1'=>'Campo Numerico 1','TAB_N2'=>'Campo Numerico 2');

        //validar campos LLAVE
        foreach ($datos["xidelem"] as $key => $value) {
            
            if($value == ''){
                $error++;
            }
        }
        //--------------------------------------------

        //validar campos tipo que no vengan vacios
        foreach ($validar as $key => $value) {

            if($value == ''){
                $error++;
            }

        }
        //------------------------------

        //VALIDAR QUE CAMPOS LABEL NO VENGAN VACIOS SI SE ELIGE QUE SE MUESTRE
        if($mostrar != 0){

            foreach ($mostrar as $key => $value) {
                
                if($xvalor1[$key] == ''){
                    $errorLabel++;
                    $errorDesc .= $labelForm[$key].'<br>';
                }
            }

            if($error == 0 && $errorLabel == 0){ //AQUI VERIFICAMOS QUE NO VENGAN VACIOS

                //verificar que tabla no se encuentre duplicada

                if(mb_strtoupper($datos["old_cidtabla"],'UTF-8') != mb_strtoupper($datos["cidtabla"],'UTF-8')){

                    $where = sprintf(" WHERE cidtabla = '%s' AND tipo = '%s' ",$datos['cidtabla'],$datos['tipo']);
                    $verificar = TablaLogicaModel::datosTablaModel($where,'tabla_logica');

                    if(!empty($verificar['cidtabla'])){
                        $error++;
                        $mensajeError = "Esta tabla ya se encuentra en uso.";
                    }
                }

                //VERIFICAR QUE CAMPOS NO SE ENCUENTREN DUPLICADOS
            /*  
                $where = sprintf(" WHERE cidtabla = '%s' AND tipo = 'T'  ",$datos['cidtabla']);
                $oldCampos = TablaLogicaModel::obtenerDatosTablaModel($where,"tabla_logica");

                if(count($oldCampos) > 0){

                    foreach ($oldCampos as $key => $value) {
                    
                        if($value['xidelem'] != 'TAB_DESC'){
                            
                            if(mb_strtoupper($value['xvalor1'],'UTF-8') != mb_strtoupper($xvalor1[$value['xidelem']],'UTF-8') && $xvalor1[$value['xidelem']] != '' ){
                                $where = sprintf(" WHERE cidtabla = '%s' AND tipo = 'T' AND xvalor1 = '%s' ",$datos['cidtabla'],$xvalor1[$value['xidelem']]);
                                $verificarCol = TablaLogicaModel::obtenerDatosTablaModel($where,'tabla_logica');

                                if(count($verificarCol) > 0){
                                    $errorLabel++;
                                    $errorDesc .= $etiquetas[$value['xidelem']].' : '.$xvalor1[$value['xidelem']].'<br>' ;
                                } 
                            }
                        }
                    }

                    if($errorLabel != 0){
                        $mensajeError = 'Estos valores ya estan en uso:<br><strong>'.$errorDesc.'</strong>';
                    }

                }
                
            */

                if($error == 0 && $errorLabel == 0){ //aqui verificamos que no tengan valores duplicados en la BD
                                    
                    $tablaName = $datos['cidtabla'];
                    $i = 0;
                    $band = 0;

                    foreach ($datos["xidelem"] as $key => $value) {

                        $mostrar_val = 0;

                        if($mostrar != 0){
                            if(array_key_exists($key,$mostrar)){
                                $mostrar_val = Globales::sanearData($mostrar[$key]);
                            }
                        }

                        if($value == "TAB_DESC"){
                            $xvalor1_value = $tablaName;
                        }else{

                            $i++;
                            
                            $xvalor1_value = ($xvalor1[$key]!='')?Globales::sanearData($xvalor1[$key]):'';
                            $xvalor1_value = ucwords($xvalor1_value);

                            if($xvalor1[$key]!='' && $mostrar_val == 1){
                                $array_sin_vacios = array_filter($xvalor1);
                                $band = count($array_sin_vacios);
                                $rows_decripcion .= ucwords($xvalor1[$key]);

                                $rows_decripcion .= ($i<$band-1)?' - ':'';
                            }
                            
                        }

                        $id = $id_tbl[$key];
                        $xidelem_value = ($value != $tab[$key])?strtoupper($tab[$key]):$value;
                        $xvalor2_value = ($xvalor2[$key]!='')?Globales::sanearData($xvalor2[$key]):'';
                        $xvalor2_value = ucwords($xvalor2_value);
                        $nvalor1_value = $mostrar_val;
                        $nvalor2_value = 0;
                        $validar_value = Globales::sanearData($validar[$key]);

                        $update = sprintf(" xidelem = '%s' , xvalor1 = '%s',
                                            xvalor2 = '%s' , nvalor1 = '%s', nvalor2 = '%s',
                                            validar_campos = '%s'
                                            WHERE id_tbl = '%d' ",
                                            $xidelem_value,$xvalor1_value,
                                            $xvalor2_value,$nvalor1_value,$nvalor2_value,
                                            $validar_value,$id);

                        $respuesta = TablaLogicaModel::actualizarTablaModel($update,"tabla_logica");
                                                                                                
                        if($respuesta == 'ok'){
                            $guardar++;
                        }else{
                            $errorGuardar .= '<strong>'.$labelForm[$key].': </strong>'.$xvalor1[$key].'<br>';
                        }

                    }

                    if($guardar > 0){

                        $respuestaOk = true;
                        $mensajeError = "Se guardo correctamente el registro.";
                        
                        if($errorGuardar !=''){
                            $mensajeError = "Se guardaron correctamente los registros. Menos estos valores:<br>";
                        }

                        $where = sprintf(" WHERE cidtabla ='%s' AND tipo = 'T' ",$datos["old_cidtabla"]);
                        $verificarTabla = TablaLogicaModel::datosTablaModel($where,'tabla_logica');

                        if(!empty($verificarTabla["cidtabla"])){
                            $where = sprintf(" columnas = '%s' WHERE cidtabla = '%s' AND tipo = 'T' ",$rows_decripcion,$datos["old_cidtabla"]);
                            TablaLogicaModel::actualizarTablaModel($where,'tabla_logica');
                        }
                        
                        //ACTUALIZAR NOMBRE DE TABLA
                        $whereOld = sprintf(" WHERE cidtabla ='%s' AND tipo = 'T' ",$datos["old_cidtabla"]);
                        $verificarOldTabla = TablaLogicaModel::datosTablaModel($whereOld,'tabla_logica');

                        if(!empty($verificarOldTabla["cidtabla"])){
                            $whereU = sprintf(" cidtabla = '%s' WHERE cidtabla = '%s' ",$tablaName,$datos["old_cidtabla"]);
                            TablaLogicaModel::actualizarTablaModel($whereU,'tabla_logica');

                        }

                    }else{
                        $mensajeError = "Error al guardar los registros.";
                    }
                    
                }

            }else{

                if($error > 0){
                   $mensajeError = "Los campos no pueden estar vacios. Cierre el formulario y vuelva abrirlo."; 
                }

                if($errorLabel > 0){
                    $mensajeError = "Los campos:<br> <strong>".$errorDesc."</strong> no pueden estar vacios."; 
                }

                if($errorLabel > 0 && $error >0){
                    $mensajeError = "Los campos no pueden estar vacios. Cierre el formulario y vuelva abrirlo
                                    <br><br>Los campos: <br><strong>".$errorDesc."</strong> no pueden estar vacios."; 
                }
            }


        }else{

            $mensajeError = "Almenos debe habilitar un nombre de etiqueta.";
        }

        
        $salidaJson = array('respuesta'=>$respuestaOk,
                            'mensaje'=>$mensajeError,
                            'contenido'=>$contenidoOk);

        echo json_encode($salidaJson);

    }

    //OBTENER DATOS TABLA
    public static function obtenerDatosTablaController($datos){

        $respuestaOk = false;
        $mensajeError = "No se puede ejecutar la aplicacion.";
        $contenidoOk = "";

        $id = 0;
        $xidelem = '';
        $xvalor1 = '';
        $xvalor2 = '';
        
        $checkMostrar = '';
        $display = '';

        $tab= array('TAB_DESC'=>'TAB_DESC','TAB_ID'=>'TAB_ID','TAB_X1'=>'TAB_X1','TAB_X2'=>'TAB_X2','TAB_N1'=>'TAB_N1','TAB_N2'=>'TAB_N2');
        $etiquetas = array('TAB_DESC'=>'','TAB_ID'=>'ID Tabla','TAB_X1'=>'Campo Caracter 1','TAB_X2'=>'Campo Caracter 2','TAB_N1'=>'Campo Numerico 1','TAB_N2'=>'Campo Numerico 2');
        
        $where = sprintf(" WHERE cidtabla ='%s' AND tipo = 'T' ",$datos["cidtabla"]);
        $respuesta = TablaLogicaModel::obtenerDatosTablaModel($where,'tabla_logica');

        if(count($respuesta) > 0){
            
            $i = 0;

            $respuestaOk = true;
            $string = '';
            $numerico = '';

            foreach ($respuesta as $key => $value) {

                $i++;

                $id = $value['id_tbl'];
                $xidelem = $value["xidelem"];
                $xvalor1 = $value["xvalor1"];
                $xvalor2 = $value["xvalor2"];
                $checkMostrar = ($value["nvalor1"] == 1)?'checked':'';
                $display = ($xidelem == "TAB_DESC")?'style="display:none;"':'';

                $string = 'selected';
                $numerico = '';

                if($value["validar_campos"] =='numerico'){
                    $string = '';
                    $numerico = 'selected';
                }

                $contenidoOk .= '
                                <div id="divInput_'.$i.'" '.$display.'>
                                  <div class="form-group label-head">
                                        <input type="hidden" id="term_'.$i.'" name="term['.$xidelem.']" value="'.$id.'" class="form-control">
                                        <input type="hidden" id="xidelem_'.$i.'" name="xidelem['.$xidelem.']" value="'.$xidelem.'" class="form-control">
                                        <input type="hidden" id="labelForm_'.$i.'" name="labelForm['.$xidelem.']" value="'.$etiquetas[$xidelem].'" class="form-control">
                                        <label class="col-sm-2 col-xs-12 control-label">'.$etiquetas[$xidelem].'</label>
                                        <div class="col-sm-6 text-center">
                                            <div class="row">
                                                <div class="col-xs-12 col-sm-7">
                                                    <input type="text" id="xvalor1_'.$i.'" name="xvalor1['.$xidelem.']" value="'.$xvalor1.'" class="form-control alphanum" >
                                                </div>
                                                <div class="col-xs-12 col-sm-5">
                                                    <input type="text" id="xvalor2_'.$i.'" name="xvalor2['.$xidelem.']" value="'.$xvalor2.'" class="form-control alphanum" >
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <select id="validar_'.$i.'" name="validar['.$xidelem.']"  class="form-control">
                                                <option value="string" '.$string.'>String</option>
                                                <option value="numerico" '.$numerico.'>Numerico</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-2 checkbox_val text-center">
                                            <input type="checkbox" id="mostrar_'.$i.'" name="mostrar['.$xidelem.']" value="1" class="switcher" '.$checkMostrar.' data-class="switcher-success">
                                        </div>
                                    </div>
                                </div>';
            
            }

        }else{
            $mensajeError = 'Error al procesar la informacion.';
        }

        $salidaJson = array('respuesta'=>$respuestaOk,
                            'mensaje'=>$mensajeError,
                            'contenido'=>$contenidoOk);

        echo json_encode($salidaJson);

    }

    //ELIMINAR TABLA Y VALORES DE TABLA
    public static function eliminarTablaController($datos){

        $respuestaOk = false;
        $mensajeError = "No se puede ejecutar la aplicacion.";
        $contenidoOk = '';

        $respuesta = TablaLogicaModel::eliminarTablaModel($datos,'tabla_logica');

        if($respuesta == 'ok'){
            $respuestaOk = true;
            $mensajeError = "Se elimino correctamente la tabla.";
        }else{
            $mensajeError = "No se completo la transaccion.";
        }

        $salidaJson = array('respuesta'=>$respuestaOk,
                            'mensaje'=>$mensajeError,
                            'contenido'=>$contenidoOk);

        echo json_encode($salidaJson);
    }

}