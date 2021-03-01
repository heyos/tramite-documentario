<?php

require_once "controller.php";

class TipoDocumentoRolUsuarioController extends Controller {

  static public function listaTipoDocumentoRol($params){

    $rolesDisponibles = [];
    $rolesOcupados = [];
    $tipoDocumento_id = $params['tipoDocumento_id'];

    $roles = RolUsuarioModel::mostrarRolModelGeneral('','rol_usuario');

    //DISPONIBLES
    if(count($roles) > 0){

      foreach ($roles as $row) {

        $params['where'] = array(
          ['rolUsuario_id',$row['id_rol']],
          ['tipoDocumento_id',$params['tipoDocumento_id']]
        );

        $table = 'tipodocumento_rolusuario';
        $rolDisponible = TipoDocumentoRolUsuarioModel::firstOrAll($table,$params,'first');

        if(empty($rolDisponible)){
          $rolesDisponibles[$row['id_rol']] = $row['descripcion'];

        }
      }
    }

    //OCUPADOS
    $rolesOcupados = self::listaRolesPermitidosFirma($tipoDocumento_id);

    $salida = array(
      'disponibles' =>$rolesDisponibles,
      'ocupados'=>$rolesOcupados
    );

    return $salida;
  }

  public static function listaRolesPermitidosFirma($tipoDocumento_id){

    $rolesFirma = [];

    $columns = '
      tpr.id AS id,
      tpr.rolUsuario_id AS id_rol,
      r.descripcion AS descripcion
    ';

    $params = array(
      'columns'=>$columns,
      'table'=>'tipodocumento_rolusuario tpr',
      'join' => array(
        ['rol_usuario r','r.id_rol','tpr.rolUsuario_id']
      ),
      'where' => array(
        ['tipoDocumento_id',$tipoDocumento_id]
      ),
      'order' => 'tpr.id',
      'dir' => 'ASC'
    );

    $rolFirma = TipoDocumentoRolUsuarioModel::all($params);

    if(count($rolFirma) > 0){
      foreach ($rolFirma as $row) {
        $rolesFirma[$row[0]] = array(
                                'rolUsuario_id' => $row[1],
                                'descripcion' => $row[2]
                                );
      }
    }

    return $rolesFirma;
  }

}
