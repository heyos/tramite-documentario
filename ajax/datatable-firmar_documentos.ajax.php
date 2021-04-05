<?php
require_once "../controllers/documentos.controller.php";
require_once "../models/documentos.model.php";


class DatatableTipoDocumento  {

  public $request;

  public function dataTipoDocumento(){

    session_start();
    $usuario_id = isset($_SESSION['usuario_id']) ? $_SESSION['usuario_id'] : 0 ;
    $user = isset($_SESSION['user']) ? $_SESSION['user'] : '';
    //
    /*
      SELECT d.id,
                d.cliente_id,
                d.paciente_id,
                d.tipoDocumento_id,
                d.name_documento,
                d.estado_firma,
                c.nRutPer,
                c.xRazSoc,
                p.nRutPer,
                CONCAT(p.xNombre,' ',p.xApePat,' ',p.xApeMat) as paciente,
                tp.descripcion
      FROM documento_usuario du
      JOIN documento d ON d.id = du.documento_id
      JOIN persona c ON c.id=d.cliente_id
      JOIN persona p ON p.id=d.paciente_id
      JOIN tipo_documento tp ON tp.id=d.tipoDocumento_id
      WHERE du.usuario_id = 4

    */

    $columns = "d.id,
                d.cliente_id,
                d.paciente_id,
                d.tipoDocumento_id,
                d.name_documento,
                d.estado_firma,
                c.nRutPer,
                c.xRazSoc,
                p.nRutPer,
                CONCAT(p.xNombre,' ',p.xApePat,' ',p.xApeMat) as paciente,
                tp.descripcion,
                du.firmado,
                d.usuario_modifica,
                d.orden_firmante,
                du.orden_firma,
                DATE(d.fecha_crea)
                "; //columnas

    $mantenimiento = isset($this->request['mantenimiento']) && !empty($this->request['mantenimiento']) ? $this->request['mantenimiento'] : 0;

    $idDocus = json_decode($this->request['idDocus'],true);

    $searchColumns = [
      'CONCAT(p.xNombre," ",p.xApePat," ",p.xApeMat)',
      'tp.descripcion',
      'c.xRazSoc',
      'c.nRutPer',
      'p.nRutPer'
    ]; //columnas donde generar la busqueda

    $orderColumns = [
      0 => 'd.id',
      1 => 'c.nRutPer',
      2 => 'c.xRazSoc',
      3 => 'p.nRutPer',
      4 => 'paciente',
      5 => 'tp.descripcion',
      6 => 'd.estado_firma'
    ]; //columnas para ordenar

    $inicio = !empty($this->request['inicio']) ? date('Y-m-d',strtotime($this->request['inicio'])) : date('Y-m-d');
    $fin = !empty($this->request['fin']) ? date('Y-m-d',strtotime($this->request['fin'])) : $inicio;

    $filtro_fecha = sprintf("date(d.fecha_crea) BETWEEN '%s' AND '%s'",$inicio,$fin);

    $where = array(
      ['du.usuario_id',$usuario_id],
      [$filtro_fecha]
    );

    $tipo = isset($this->request['tipoDoc']) ? $this->request['tipoDoc'] : '0';
    $filtro_tipo = $tipo != '0' ? array_push($where, ['d.tipoDocumento_id',$tipo]) : '' ;

    $estado = isset($this->request['estadoDoc']) ? $this->request['estadoDoc'] : '4';
    $filtro_estado = $estado != '4' ? array_push($where, ['d.estado_firma',$estado]) : '' ;

    $params = array(
      "table"=>"documento_usuario du",
      "columns"=>$columns,
      "searchColumns"=>$searchColumns,
      "orderColumns" => $orderColumns,
      "join" => array ( 
        ['documento d ','d.id','du.documento_id'],
        ['persona c','c.id','d.cliente_id'],
        ['persona p','p.id','d.paciente_id'],
        ['tipo_documento tp','tp.id','d.tipoDocumento_id']
      ),
      'where' => $where,
      'order' => 'd.fecha_crea',
      'dir' => 'DESC'
    );

    $options = DocumentoController::dataTable($this->request,$params,'options');
    $records = DocumentoController::dataTable($this->request,$params,'data');
    //$records = array();
    // $test = Controller::dataTable($this->request,$params,'');
    $data = [];

    //-------------------------------------------------

    if(count($records) > 0){

      $i =0;

      // procesando la data para mostrarla en el front
      $id = 0;
      $rutCliente = '' ;
      $nomCliente = '' ;
      $rutPaciente = '' ;
      $nomPaciente = '' ;
      $tipoDocumento_des = '';
      $descripcion = "";
      $estado = '';
      $usuario_modifica = '';
      $orden_firmante = '';
      $orden_firma = '';
      $check = '';
      $fechaCrea = '';

      foreach ($records as $row) {

        $i++;
        $id = $row[0];
        $estado = $row[5];
        $rutCliente = $row[6] ;
        $nomCliente = $row[7] ;
        $rutPaciente = $row[8] ;
        $nomPaciente = $row[9] ;
        $tipoDocumento_des = $row[10];
        $button = '';
        $name_docu = $row[4];
        $usuario_modifica = $row[12];
        $orden_firmante = $row[13];
        $orden_firma = $row[14];
        $fechaCrea = date('d/m/Y',strtotime($row[15]));

        $txt = "";
        $css = "";
        $check = "";

        
        $button .= "
          <div class='btn-group'>
        ";

        if($mantenimiento == '1'){
          /*
          $button .=  "
            <button title='Editar' class='btn btn-warning btnEditar btn-sm' id='".$id."'><i class='fas fa-edit'></i></button>
            <button title='Eliminar' class='btn btn-danger btnEliminar btn-sm' id='".$id."'><i class='fa fa-times'></i></button>
          ";
          */
        }

        switch ($estado) {
          case '0':
            $css = "label-warning";
            $txt = 'Pendiente';

            $button .=  "
              <button title='Subir documento' class='btn btn-success btn-sm btnUpload' 
                id='".$id."'
                rut_cliente='".$rutCliente."'
                nombre_paciente='".$nomPaciente."'
                tipo_doc_des='".$tipoDocumento_des."'
              >
                <i class='fas fa-file-upload'></i>
              </button>
              <input type='file' id='file_".$id."' style='display:none;'>
            ";

            break;
          case '1':
            $css = "label-info";
            $txt = 'En proceso de firma';

            $button .=  "
              <button title='Ver documento' name_docu = ".$name_docu." class='btn btn-primary btn-sm btnVer' id='".$id."'>
                <i class='fas fa-eye'></i>
              </button>
            ";

            if($orden_firmante == $orden_firma){
              $button .= "
                <button title='Firmar documento' class='btn btn-success btn-sm btnFirmar' 
                  id='".$id."'
                  rut_cliente='".$id."'
                  nombre_paciente='".$nomPaciente."'
                  tipo_doc_des='".$tipoDocumento_des."'
                >
                  <i class='fas fa-file-signature'></i>
                </button>
              ";
              //if idDocus
              $check = '
                <input type="checkbox" id="'.$id.'" class="check_firma" value="'.$id.'">
              ';

            }

            break;
          case '2':
            $css = "label-success";
            $txt = 'Firmado por todos';
            break;
          case '3':
            $css = "label-danger";
            $txt = 'Cancelado';
            break;
          default:
            
            break;
        }

        //verificamos si es el ultimo usuario en modificar para darle la accion de eliminar
        if($user == $usuario_modifica){
          $button .= "
            <button title='Eliminar' class='btn btn-danger btnEliminar btn-sm' id='".$id."'><i class='fa fa-times'></i></button>
          ";
        }

        $button .="
          </div>
        ";

        $labelEstado = '<span class="label '.$css.' ">'.$txt.'</span>';

        $data[] = array(
          "DT_RowIndex" => $i,
          "rutCliente" => $rutCliente,
          "nomCliente" => $nomCliente,
          "rutPaciente" => $rutPaciente,
          "nomPaciente" => $nomPaciente,
          "tipoDocumento" => $tipoDocumento_des,
          "estado" => $labelEstado,
          "fechaCrea" => $fechaCrea,
          "descargar" => $check,
          "action" => $button
        );

      }

    }else{
      // $var = '';

      // $data[] = array(
      //     "DT_RowIndex" => '',
      //     "codigo" => '',
      //     "proveedor_name" => $var,
      //     "total" =>'',
      //     "fecha_hora" => '',
      //     "action" => ''
      //   );
    }

    $options['data'] = $data;

    echo json_encode($options);

  }
}

if(isset($_GET)){
  $data = new DatatableTipoDocumento();
  $data -> request = $_GET;
  $data -> dataTipoDocumento();
}
