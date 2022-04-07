<?php

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

require_once "../controllers/documentos.controller.php";
require_once "../models/documentos.model.php";


class DatatableTipoDocumento  {

  public $request;

  public function dataTipoDocumento(){

    session_start();
    $usuario_id = isset($_SESSION['usuario_id']) ? $_SESSION['usuario_id'] : 0 ;
    $user = isset($_SESSION['user']) ? $_SESSION['user'] : '';
    $rutCliente = isset($this->request['rutCliente']) ? $this->request['rutCliente'] : '';
        
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
                DATE(d.fecha_crea),
                d.codigo,
                p.xPasaporte
                "; //columnas

    $mantenimiento = isset($this->request['mantenimiento']) && !empty($this->request['mantenimiento']) ? $this->request['mantenimiento'] : 0;

    $idDocus = json_decode($this->request['idDocus'],true);

    $searchColumns = [
      'CONCAT(p.xNombre," ",p.xApePat," ",p.xApeMat)',
      'tp.descripcion',
      'c.xRazSoc',
      'c.nRutPer',
      'p.nRutPer',
      'p.xPasaporte'
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
      [$filtro_fecha]
    );
    
    $general = isset($this->request['general']) ? $this->request['general'] : '';

    switch ($general){
      case 'consulta_externa':
        array_push($where,['c.nRutPer',$rutCliente]);
        break;
      case 'descargar_documentos':
      case 'consultar_documentos':
        break;
      default:
        array_push($where,['du.usuario_id',$usuario_id]);
        break;
    }

    $tipo = isset($this->request['tipoDoc']) ? $this->request['tipoDoc'] : '0';
    $filtro_tipo = $tipo != '0' ? array_push($where, ['d.tipoDocumento_id',$tipo]) : '' ;

    $estado = isset($this->request['estadoDoc']) ? $this->request['estadoDoc'] : '4';
    $view = isset($this->request['view']) ? $this->request['view'] : 'firma';
    $estado = $view == 'descargar' ? '2' : $estado ;

    if($general == 'consulta_externa' || $general == 'consultar_documentos'){
      $estado = $this->request['estadoDoc'];
    }

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

    if($general == 'consulta_externa' || $general == 'consultar_documentos' || $general == 'descargar_documentos'){
      $params['group'] = "du.documento_id";
    }

    if($general == 'consulta_externa'){
      $params['order'] = "paciente";
      $params['dir'] = "ASC";
    }

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
      $codigo = '';
      $xPasaporte = '';

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
        $codigo = $row[16];
        $xPasaporte = $row[17];

        $xDocumento = "";

        if($rutPaciente != ''){
          $xDocumento = 'Rut | '.$rutPaciente;
        }

        if($xPasaporte){
          $xDocumento = 'Pas. | '.$xPasaporte;
        }

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

        $acceso = array(
          'firma',
          'consulta',
          'descargar'
        );

        if($general != 'consulta_externa' && $estado != '3'){
          $button .=  "
            <button title='Ver usuarios firmantes' class='btn btn-warning btn-sm btnLista' id='".$id."'>
              <i class='fas fa-list-alt'></i>
            </button>
          ";
        }          

        switch ($estado) {
          case '0':
            $css = "label-warning";
            $txt = 'Pendiente';

            if($view == 'firma'){

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

            }

            break;
          case '1':
            $css = "label-info";
            $txt = 'En proceso de firma';

            if($general != 'consulta_externa'){
              $button .=  "
                <button title='Ver documento' name_docu = '".$name_docu."' codigo='".$codigo."' class='btn btn-primary btn-sm btnVer' id='".$id."'>
                  <i class='fas fa-eye'></i>
                </button>
              ";
            }

            if($orden_firmante == $orden_firma && $view == 'firma'){
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

           
            $button .=  "
              <button title='Ver documento' name_docu = '".$name_docu."' codigo='".$codigo."' class='btn btn-primary btn-sm btnVer' id='".$id."'>
                <i class='fas fa-eye'></i>
              </button>
            ";
                      

            if($view == 'descargar'){
              //
              $check = '
                <input type="checkbox" id="'.$id.'" class="check_download" value="'.$id.'">
              ';

              $button .= "
                <button title='Descargar documento' class='btn btn-success btn-sm btnDownload' 
                  id='".$id."'
                  name_docu = ".$name_docu."
                  codigo='".$codigo."'
                >
                  <i class='fa fa-download'></i>
                </button>
              ";

            }

            break;
          case '3':
            $css = "label-danger";
            $txt = 'Cancelado';
            break;
          default:
            
            break;
        }

        if($general != 'consulta_externa'){
          $button .= "
            <button title='Consultar' class='btn btn-info btnConsulta btn-sm' codigo='".$codigo."' id='".$id."'>
              <i class='fa fa-search'></i>
            </button>
          ";
        }

        //verificamos si es el ultimo usuario en modificar para darle la accion de eliminar
        if($user == $usuario_modifica && $view == 'firma' &&  $estado !='3'){
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
          "rutPaciente" => $xDocumento,//$rutPaciente,
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
