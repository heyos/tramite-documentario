<?php

require_once "../../models/empresa.php";
require_once "../../controllers/empresa.php";
require_once "../../controllers/globales.php";

class AjaxEmpresa{

    public $imagenTemporal;
    public $imagenName;

    public function subirImagenEmpresaAjax(){

        $datos =  $this->imagenTemporal;

        $respuesta = Empresa::subirImagenController($datos);

        echo $respuesta;

    }

    public $nombre;
    public $oldImagenName;
    public $actividad_economica;
    public $propietario;
    public $direccion;
    public $telefono;

    public function guardarDatosEmpresaAjax(){

        $datos = array("nombre"=>$this->nombre,
                        "foto"=>$this->imagenName,
                        "oldfoto"=>$this->oldImagenName,
                        "telefono"=>$this->telefono,
                        "actividad_economica"=>$this->actividad_economica,
                        "propietario"=>$this->propietario,
                        "direccion"=>$this->direccion);

        $respuesta = Empresa::guardarDatosEmpresaController($datos);

        if($respuesta == "ok"){

            echo '
                <div class="alert alert-success alerta">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>Exito !</strong> Se guardo el registro exitosamente.
                                            
                </div>';

        }else{
            echo '
                <div class="alert alert-danger alerta">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>Error !</strong> Error inesperado al guardar el registro.
                                            
                </div>';
        }

        
    }
}

$g = new Globales();

if(isset($_FILES["imagen"]["tmp_name"])){

    $a = new AjaxEmpresa();
    $a -> imagenTemporal = $_FILES["imagen"]["tmp_name"];
    $a -> imagenName = $_FILES["imagen"]["name"];
    $a -> subirImagenEmpresaAjax();
}

if(isset($_POST["nombreEmpresa"])){

    $nombre = $g->sanearData($_POST["nombreEmpresa"]);
    $actividad_economica = $g->sanearData($_POST["actividad_economica"]);
    $propietario = $g->sanearData($_POST["propietario"]);
    $direccion = $g->sanearData($_POST["direccion"]);
    $telefono = $g->sanearData($_POST["telefono"]);

    $b = new AjaxEmpresa();
    $b -> nombre = $nombre;
    $b -> imagenName = $_POST["imagenName"];
    $b -> oldImagenName = $_POST["oldImagenName"];
    $b -> actividad_economica = $actividad_economica;
    $b -> propietario = $propietario;
    $b -> direccion = $direccion;
    $b -> telefono = $telefono;
    $b -> guardarDatosEmpresaAjax();

}