<?php

require_once "../../controllers/tablaLogica.php";
require_once "../../controllers/globales.php";
require_once "../../models/tablaLogica.php";

class Ajax{

    public $id;
    public $old_cidtabla;
    public $estado;
    public $tipoRegistro;
    public $cidtabla;
    public $xvalor1;
    public $xvalor2;
    public $validar;
    public $mostrar;
    public $xidelem;
    public $labelForm;
    

    public function guardarDatosTablaAjax(){

        $datos = array("id_tbl"=>$this->id,
                        "tipo"=>$this->tipoRegistro,
                        "cidtabla"=>strtoupper($this->cidtabla),
                        "old_cidtabla"=>$this->old_cidtabla,
                        "xidelem"=>$this->xidelem,
                        "labelForm" => $this->labelForm,
                        "mostrar"=>$this->mostrar,
                        "validar"=>$this->validar,
                        "xvalor1"=>$this->xvalor1,
                        "xvalor2"=>$this->xvalor2);

        if($this->estado == '0'){
            //registramos
            $respuesta = TablaLogica::guardarTablaController($datos);

        }else{
            //actualizamos
            $respuesta = TablaLogica::actualizarTablaController($datos);

        }

        echo $respuesta;

    }

    public function obtenerDatosAjax(){

        $datos = array('cidtabla'=>$this->cidtabla);

        $respuesta = TablaLogica::obtenerDatosTablaController($datos);

        echo $respuesta;

    }

    public function eliminarTablaAjax(){

        $datos = array('cidtabla'=>$this->cidtabla);

        $respuesta = TablaLogica::eliminarTablaController($datos);

        echo $respuesta;

    }

}

if(isset($_POST["tipoRegistro"])){

    $a = new Ajax();

    switch ($_POST["tipoRegistro"]) {

        case 'tabla':

            $a -> id = (isset($_POST['term']))?$_POST['term']:0;
            $a -> estado = Globales::sanearData($_POST["estado"]);
            $a -> tipoRegistro = 'T';
            $a -> cidtabla = Globales::sanearData($_POST["cidtabla"]);
            $a -> old_cidtabla = Globales::sanearData($_POST["old_cidtabla"]);

            $a -> xvalor1 = $_POST["xvalor1"];
            $a -> xvalor2 = $_POST["xvalor2"];

            $a -> xidelem = $_POST["xidelem"];
            $a -> validar = $_POST["validar"];
            $a -> labelForm = $_POST["labelForm"];
            $a -> mostrar = (isset($_POST["mostrar"]))?$_POST["mostrar"]:0;            

            $a -> guardarDatosTablaAjax();
            
            break;

        case 'rows':

            $a -> cidtabla = Globales::sanearData($_POST["tabla"]);
            
            $a -> obtenerDatosAjax();

            break;

        case 'delete':
            
            $a -> cidtabla = (isset($_POST['term']))?$_POST['term']:'';
            $a -> eliminarTablaAjax();

            break;

        default:
            # code...
            break;
    }
}