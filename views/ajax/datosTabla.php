<?php

require_once "../../controllers/globales.php";
require_once "../../controllers/datosTabla.php";
require_once "../../controllers/tablaLogica.php";

require_once "../../models/datosTabla.php";
require_once "../../models/tablaLogica.php";

class Ajax{

    public $id_tbl;
    public $inputs;
    public $tabla;
    public $label;
    public $cidtabla;
    public $xidelem;

    public function mostrarInputsTablaAjax(){

        $datos = array('tabla'=>$this->tabla);

        $respuesta = TablaLogica::mostrarInputsTablaController($datos);

        echo $respuesta;

    }

    public function guardarDatosTablaAjax(){

        $datos = array('cidtabla'=>$this->cidtabla,
                        'xidelem'=>$this->xidelem,
                        'label'=>$this->label,
                        'tipo'=>'V');

        if($this -> id_tbl == 0){

            $respuesta = DatosTabla::guardarDatosTablaController($datos);

        }else{

            $datos['id_tbl'] = $this -> id_tbl;

            $respuesta = DatosTabla::actualizarDatosTablaController($datos);

        }

        echo $respuesta;
    }

    public function cargarDataFormulario(){

        $datos = array('cidtabla'=>$this->cidtabla,
                        'codigo'=>$this->xidelem,
                        'tipo'=>'V');

        $respuesta = DatosTabla::cargarDatosTablaController($datos);

        echo $respuesta;
    }

    public function eliminarRegistroTablaAjax(){

        $datos = array('cidtabla'=>$this->cidtabla,
                        'codigo'=>$this->xidelem,
                        'tipo'=>'V');

        $respuesta = DatosTabla::eliminarDatosTablaController($datos);

        echo $respuesta;
    }

}

if(isset($_POST['accion'])){

    $a = new Ajax();

    switch ($_POST['accion']) {
        case 'inputs':
            
            $a -> tabla = Globales::sanearData($_POST['tabla']);
            $a -> mostrarInputsTablaAjax();

            break;

        case 'add':

            $a -> id_tbl = (isset($_POST['term_tbl']))?$_POST['term_tbl']:0;
            $a -> cidtabla = Globales::sanearData($_POST['cidtabla']);
            $a -> xidelem = (isset($_POST['xidelem']))?$_POST['xidelem']:0;
            $a -> label = (isset($_POST['label']))?$_POST['label']:0;
            $a -> guardarDatosTablaAjax();
            
            break;

        case 'dataFormulario':
            $a -> cidtabla = Globales::sanearData($_POST['tabla']);
            $a -> xidelem = Globales::sanearData($_POST["codigo"]);
            $a -> cargarDataFormulario();
            break;

        case 'delete':
            $a -> cidtabla = Globales::sanearData($_POST['tabla']);
            $a -> xidelem = Globales::sanearData($_POST["term"]);
            $a -> eliminarRegistroTablaAjax();
            break;
        default:
            # code...
            break;
    }
}