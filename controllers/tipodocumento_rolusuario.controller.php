<?php

require_once "controller.php";

class TipoDocumentoRolUsuarioController extends Controller {

  static public function listaTipoDocumentoRol($params){

    $rolesDisponibles = [];
    $rolesOcupados = [];

    $roles = RolUsuarioModel::mostrarRolModelGeneral('','rol_usuario');

    if(count($roles) > 0){

      foreach ($roles as $row) {

        $params['where'] = array(
          ['rolUsuario_id',$row['id_rol']],
          ['tipoDocumento_id',$params['tipoDocumento_id']]
        );

        $table = 'tipodocumento_rolusuario';
        $rolDisponible = TipoDocumentoRolUsuarioModel::firstOrAll($table,$params,'first');

        if(!empty($rolDisponible)){

          $rolesOcupados[$rolDisponible['id']] = array(
                                                      'rolUsuario_id' => $row['id_rol'],
                                                      'descripcion' => $row['descripcion']
                                                      );

        }else{

          $rolesDisponibles[$row['id_rol']] = $row['descripcion'];

        }
      }
    }

    $salida = array(
      'disponibles' =>$rolesDisponibles,
      'ocupados'=>$rolesOcupados
    );

    return $salida;
  }

}
