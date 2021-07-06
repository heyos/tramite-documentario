<?php

require_once 'controller.php';

class Persona extends Controller{

    public static function mostrarListaPersona($datos){

        $contenido = "";

        $mantenimiento = $datos["mantenimiento"];
        $rowsPerPage = $datos['por_pag'];
        $buscar = $datos['buscar'];
        $pageNum = ($datos["numPaginador"] == '')? 1 : $datos["numPaginador"];


        //Ultimo registro mostrado por el numero de pagina anterior
        $offset = ($pageNum - 1) * $rowsPerPage;

        $where ='';

        if($buscar != ''){
            if($datos['tipo']=='n'){
                $where ="  CONCAT(p.nRutPer,' ',p.xNombre,' ',p.xApePat,' ',p.xApeMat,' ',t.xvalor1) LIKE  '%".$buscar."%' AND ";
            }elseif ($datos['tipo']=='j') {

                $where ="  CONCAT(p.nRutPer,' ',p.xRazSoc,' ',t.xvalor1,' ',p.xActEco) LIKE  '%".$buscar."%' AND ";
            }

        }

        $where .= sprintf(" p.xTipoPer = '%s' AND p.deleted = '0' ",$datos['tipo']);

        //cantidad de registros
        $cantidad = PersonaModel::mostrarPersonaGeneralModel($where,$datos['tabla']);
        $totalReg = count($cantidad);

        $total_paginas = ceil($totalReg / $rowsPerPage);

        $datosModel =  array("where"=>$where,
                                "offset"=>$offset,
                                "rowsPerPage"=>$rowsPerPage,
                                'tipo'=>$datos['tipo']);

        $respuesta = PersonaModel::mostrarPersonaFilterModel($datosModel,$datos['tabla']);

        if(count($respuesta) > 0){
            $i = 0;

            foreach ($respuesta as $row => $valor) {

                $id = $valor['id'];
                $i++;
                $tipo = $datos['tipo'];
                $title = "";

                switch ($tipo) {
                    case 'n':
                        $title = "Direcciones";
                        $sexo = $valor['cSexo'] == 'F'?'Femenino':'Masculino';
                        $apellidos = $valor['xApePat'].' '.$valor['xApeMat'];
                        $fechaNac = $valor['dFecNac'] !=''?date('d-m-Y',strtotime($valor['dFecNac'])):'';

                        $cargo_id = $valor['cargo'] != '' ? $valor['cargo'] : 0 ;
                        $cargo_label = '';

                        if($cargo_id != 0){
                            $where = array(
                                'where' => array(
                                    ['id_tbl',$cargo_id]
                                ),
                                'useDeleted' => '0'
                            );
                            $cargo = DatosTablaModel::firstOrAll('tabla_logica',$where,'first');
                            $cargo_label = $cargo['xvalor1'];
                        }
                            

                        $contenido .= '
                            <tr>
                                <td>'.$i.'</td>
                                <td>'.$valor['nRutPer'].'</td>
                                <td>'.$valor['xNombre'].'</td>
                                <td>'.$apellidos.'</td>
                                <td>'.$cargo_label.'</td>
                                <td>'.$sexo.'</td>
                                <td>'.$fechaNac.'</td>
                                <td class="text-center">
                        ';

                        break;

                    case 'j':

                        $pais_id = $valor['pais'] != '' ? $valor['pais'] : 0;
                        $pais_label = '';
                        if($pais_id != 0){
                            $where = array(
                                'where' => array(
                                    ['id_tbl',$pais_id]
                                ),
                                'useDeleted' => '0'
                            );
                            $pais = DatosTablaModel::firstOrAll('tabla_logica',$where,'first');
                            $pais_label = $pais['xvalor1'];
                        }
                            

                        $title = "Contactos y Direcciones";
                        $contenido .= '
                            <tr>
                                <td>'.$i.'</td>
                                <td>'.$valor['nRutPer'].'</td>
                                <td>'.$valor['xRazSoc'].'</td>
                                <td>'.$valor['xActEco'].'</td>
                                <td>'.$pais_label.'</td>
                                <td class="text-center">
                        ';
                        break;
                }

                if($mantenimiento == "1"){
                    $contenido .='
                            <a href="'.$id.'" data-accion="editar" title="Editar" class="btn btn-primary btn-xs btn-rounded"><i class="far fa-edit"></i></a>
                            <a href="'.$id.'" data-accion="contactos" title="'.$title.'" class="btn btn-info btn-xs btn-rounded"><i class="far fa-address-book"></i></a>
                            <a href="'.$id.'" data-accion="delete" title="Eliminar" class="btn btn-danger btn-xs btn-rounded"><i class="far fa-trash-alt"></i></a>
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

        $thead = '';

        switch ($datos['tipo']) {
            case 'n':

                $thead .='
                        <th>#</th>
                        <th>Rut</th>
                        <th>Nombres</th>
                        <th>Apellidos</th>
                        <th>Tipo Cargo</th>
                        <th>Sexo</th>
                        <th>Fecha Nacimiento</th>
                        <th></th>
                ';

                break;

            case 'j':
                $thead .='
                        <th>#</th>
                        <th>Rut</th>
                        <th>Razon Social</th>
                        <th>Actividad Economica</th>
                        <th>Pais</th>
                        <th></th>
                ';
                break;
        }

        $salida = '
            <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="">
                <thead>
                    <tr>
                        '.$thead.'
                    </tr>
                </thead>
                <tbody id="listadoOk">
                    '.$contenido.'
                </tbody>

            </table>
        '.$paginacion;

        return $salida;
    }

    public static function mostrarDetalleInfoPersonaCtr($datos){

        $contenido = "";

        $mantenimiento = $datos["mantenimiento"];
        $rowsPerPage = $datos['por_pag'];
        $buscar = $datos['buscar'];
        $pageNum = ($datos["numPaginador"] == '')? 1 : $datos["numPaginador"];

        //Ultimo registro mostrado por el numero de pagina anterior
        $offset = ($pageNum - 1) * $rowsPerPage;

        $where ='';

        $id = $datos['id'];
        $persona_id = $id;

        if($datos['tipo']=='direccion'){
            $table = 'direccion';
            $term =  'd.nIdPersona';
        }elseif ($datos['tipo']=='contacto') {
            $table = 'contacto_persona_juridica';
            $term = 'c.nIdDireccion';
        }

        if($buscar != ''){
            if($datos['tipo']=='direccion'){
                $where ="  CONCAT(d.xNomFaena,' ',d.cDirEnt,' ',p.xvalor1,' ',d.xTelEnt1,' ',d.xTelEnt2,' ',d.xEmail,' ',t.xvalor1) LIKE  '%".$buscar."%' AND ";
            }elseif ($datos['tipo']=='contacto') {
                $where ="  CONCAT(p.xNombre,' ',p.xApePat,' ',p.xApeMat,' ',c.cCargo) LIKE  '%".$buscar."%' AND ";
            }
        }

        $where .= sprintf(" %s = '%s' ",$term,$id);

        //cantidad de registros
        $cantidad = TablaCustomModel::mostrarTablaGeneralModel($where,$table);
        $totalReg = count($cantidad);

        $total_paginas = ceil($totalReg / $rowsPerPage);

        $datosModel =  array("where"=>$where,
                                "offset"=>$offset,
                                "rowsPerPage"=>$rowsPerPage);

        $respuesta = TablaCustomModel::mostrarTablaFilterModel($datosModel,$table);

        if(count($respuesta) > 0){
            $i = 0;

            foreach ($respuesta as $row => $valor) {

                $id = $valor['id'];
                $i++;
                $tipo = $datos['tipo'];
                $extra = "";

                switch ($tipo) {
                    case 'direccion':
                        $datosPersona = Model::detalleDatosMdl('persona','id',$persona_id);
                        $tipopersona = $datosPersona[0]['xTipoPer'];

                        $telefono = $valor['xTelEnt1'].' / '.$valor['xTelEnt2'];

                        $contenido .= '
                            <tr>
                                <td>'.$i.'</td>
                                <td>'.$valor['xNomFaena'].'</td>
                                <td>'.$valor['cDirEnt'].'</td>
                                <td>'.$valor['xNumDir'].'</td>
                                <td>'.$valor['comuna'].'</td>
                                <td>'.$valor['pais'].'</td>
                                <td>'.$telefono.'</td>
                                <td>'.$valor['xEmail'].'</td>
                                <td class="text-center">
                        ';

                        if($tipopersona =='j'){
                            $extra = '<a href="'.$id.'" data-accion="contacto" data-faena="'.$valor['xNomFaena'].'" title="Contacto" class="btn btn-warning btn-xs btn-rounded"><i class="fa fa-book"></i></a>';
                        }

                        break;

                    case 'contacto':

                        $contenido .= '
                            <tr>
                                <td>'.$i.'</td>
                                <td>'.$valor['contacto'].'</td>
                                <td>'.$valor['cargo'].'</td>
                                <td class="text-center">
                        ';
                        break;
                }

                if($mantenimiento == "1"){
                    $contenido .='
                            <a href="'.$id.'" data-accion="editar" title="Editar" class="btn btn-primary btn-xs btn-rounded"><i class="far fa-edit"></i></a>
                            '.$extra.'
                            <a href="'.$id.'" data-accion="delete" title="Eliminar" class="btn btn-danger btn-xs btn-rounded"><i class="far fa-trash-alt"></i></a>
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

        $thead = '';

        switch ($datos['tipo']) {
            case 'direccion':

                $thead .='
                        <th>#</th>
                        <th>Faena</th>
                        <th>Direccion</th>
                        <th>N° Dir.</th>
                        <th>Comuna</th>
                        <th>Pais</th>
                        <th>Telefono(s)</th>
                        <th>Email</th>
                        <th></th>
                ';

                $identificador = "listadoOk2";

                break;

            case 'contacto':
                $identificador = "listadoOk3";
                $thead .='
                        <th>#</th>
                        <th>Contacto</th>
                        <th>Cargo</th>
                        <th></th>
                ';
                break;
        }

        $salida = '
            <table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="">
                <thead>
                    <tr>
                        '.$thead.'
                    </tr>
                </thead>
                <tbody class="'.$identificador.'">
                    '.$contenido.'
                </tbody>

            </table>
        '.$paginacion;

        return $salida;
    }

    public static function listaSelectCtr($table){

        $contenido = '<option value=""></option>';

        $data = TablaCustomModel::mostrarDatosTablaMdl($table);

        if(count($data) > 0){
            foreach ($data as $key => $value) {
                $contenido .= sprintf('<option value="%d">%s</option>',$value['id_tbl'],$value['xvalor1']) ;
            }
        }

        return $contenido;
    }

    public static function listaSelectContactosCtr(){

        $contenido = '<option value=""></option>';

        $data = Model::detalleDatosMdl('persona','xTipoPer','n');

        if(count($data) > 0){
            foreach ($data as $key => $value) {
                $contacto = $value['nRutPer'].' | '.$value['xNombre'].' '.$value['xApePat'].' '.$value['xApeMat'];
                $contenido .= sprintf('<option value="%d">%s</option>',$value['id'],$contacto) ;
            }
        }

        return $contenido;
    }

    public static function datosPersonaCtr($datos){

        $respuesta = false;
        $data = [];
        $message = '';

        if(is_array($datos)){

            $where = array 
                (
                    'where' => $datos,
                    'useDeleted' => '0'
                );
            $persona = DatosTablaModel::firstOrAll('persona',$where,'first');

            if(!empty($persona)){
                $respuesta = true;
                $data = $persona;
            }
        }else{
            $message = 'parametros tiene que ser un arreglo de datos';
        }

        return array(
            'response' => $respuesta,
            'data' => $data,
            'message' => $message
        );
    }

    
}
