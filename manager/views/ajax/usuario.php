<?php

require_once "../../controllers/globales.php";
require_once "../../models/usuario.php";
require_once "../../controllers/usuario.php";

class Ajax{

    public $id_usuario;
    public $nombres;
    public $apellidos;
    public $dni;
    public $num_tel;
    public $id_rol;
    public $username;
    public $password;

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

        //echo json_encode($datos);

    }

    public function eliminarUsuarioAjax(){

        $datos = $this->id_usuario;

        $respuesta = Usuario::eliminarUsuarioController($datos);

        echo $respuesta;
    }
}

$g = new Globales();

if(isset($_POST["nombre"])){

    $password = $g->sanearData($_POST["password"]);

    $a = new Ajax();
    $a -> id_usuario = $g->sanearData($_POST["term"]);
    $a -> nombres = $g->sanearData($_POST["nombre"]);
    $a -> apellidos = $g->sanearData($_POST["apellidos"]);
    $a -> dni = $g->sanearData($_POST["dni"]);
    $a -> num_tel = $g->sanearData($_POST["telefono"]);
    $a -> id_rol = $g->sanearData($_POST["rol_usuario"]);
    $a -> username = $g->sanearData($_POST["usuario"]);
    $a -> password = $g->crypt_blowfish($password);
    $a -> guardarUsuarioAjax();
}

if(isset($_POST["id_usuario"])){

    $b = new Ajax();
    $b -> id_usuario = $_POST["id_usuario"];
    $b -> eliminarUsuarioAjax();
}
