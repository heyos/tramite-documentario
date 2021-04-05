<?php

require_once "../../controllers/globales.php";
require_once "../../controllers/config.php";
require_once "../../models/usuario.php";
require_once "../../controllers/usuario.php";
require_once "../../controllers/firma_electronica.controller.php";
require_once "../../library/fpdf/fpdf.php";

class Ajax{

    public $id_usuario;
    public $nombres;
    public $apellidos;
    public $dni;
    public $num_tel;
    public $id_rol;
    public $username;
    public $password;
    public $file;
    public $params;

    public function guardarUsuarioAjax(){

        $datos = array("id_usuario"=>$this->id_usuario,
                        "nombres"=>ucwords($this->nombres),
                        "apellidos"=>ucwords($this->apellidos),
                        "dni"=>$this->dni,
                        "num_tel"=>$this->num_tel,
                        "id_rol"=>$this->id_rol,
                        "username"=>$this->username,
                        "password"=>$this->password);
    
        if($this->id_usuario == "0"){

            $respuesta = Usuario::guardarUsuarioController($datos);

        }else{
            $respuesta = Usuario::actualizarUsuarioController($datos);
        }

        echo $respuesta;
    
    }

    public function eliminarUsuarioAjax(){

        $datos = $this->id_usuario;

        $respuesta = Usuario::eliminarUsuarioController($datos);

        echo $respuesta;
    }

    public function guardarCredencialesAjax(){

        $params = $this->params;
        $files = $this->file;

        $params['file'] = array(
            'certificado' => isset($files['ctr']) ? $files['ctr'] : [] ,
            'firma' => isset($files['digital']) ? $files['digital'] : []
        );

        unset($params['accion']);

        $respuesta = Usuario::updateCredencialesUser($params);

        echo json_encode($respuesta);
    }

    public function quitarCredencialesAjax(){

        $params = $this->params;

        unset($params['accion']);

        $where = array(
            'logo'=>'0',
            'name_certificado' => '',
            'pass_certificado' => '',
            'tiene_certificado' => '0',
            'where' => array(
                ['id_usuario',$params['term']]
            ),
            'table'=>'usuario'
        );

        $update = Usuario::updateItem($where);

        if($update['respuesta']){
            $update['mensaje'] = "Se quitaron las credenciales exitosamente";
        }

        echo json_encode($update);
    }

}

if(isset($_POST["accion"])){

    $g = new Globales();

    $a = new Ajax();
    $a -> id_usuario = $g->sanearData($_POST["term"]);

    switch ($_POST["accion"]) {
        case 'guardar':
            $password = ($_POST["password"] == "")?"":$g->crypt_blowfish($_POST["password"]);
            $a -> nombres = $g->sanearData($_POST["nombre"]);
            $a -> apellidos = $g->sanearData($_POST["apellidos"]);
            $a -> dni = $g->sanearData($_POST["dni"]);
            $a -> num_tel = $g->sanearData($_POST["telefono"]);
            $a -> id_rol = $g->sanearData($_POST["rol_usuario"]);
            $a -> username = $g->sanearData($_POST["usuario"]);
            $a -> password = $password;
            $a -> guardarUsuarioAjax();
            
            break;

        case 'eliminar':
            $a -> eliminarUsuarioAjax();
            break;

        case 'editar':
            session_start();
            $_SESSION["termUsuario"] = $g->sanearData($_POST["term"]);
            $datos = array("respuesta"=>true,"session"=>$_SESSION["termUsuario"]);
            echo json_encode($datos);

            break;

        case 'credencial':
            $a -> file = isset($_FILES) ? $_FILES : [] ;
            $a -> params = $_POST;
            $a -> guardarCredencialesAjax();
            break;
        case 'quitar':
            $a -> params = $_POST;
            $a -> quitarCredencialesAjax();
            break;
        default:
            echo json_encode(array(
                'respuesta' => false,
                'message' => 'no se puede ejecutar la aplicacion',
                'mensaje' => 'no se puede ejecutar la aplicacion'
            ));

            break;
    }
}