<?php

require_once "../../controllers/globales.php";
require_once "../../controllers/rolUsuario.php";
require_once "../../controllers/usuario.php";
require_once "../../controllers/datosTabla.php";
require_once "../../controllers/tablaLogica.php";
require_once "../../controllers/persona.php";

require_once "../../models/rolUsuario.php";
require_once "../../models/usuario.php";
require_once "../../models/datosTabla.php";
require_once "../../models/tablaLogica.php";
require_once "../../models/persona.php";
require_once "../../models/direccion_contacto.php";
require_once "../../models/model.php";

class Ajax{

    public $accion;
    public $idRol;
    public $page;
    public $mantenimiento;
    public $por_pag;
    public $buscar;
    public $numPaginador;
    public $tablaLogica;
    public $input;

    public function mostrarDataAjax(){

        $datos = array('id_rol'=>$this->idRol,
                        'mantenimiento'=>$this->mantenimiento,
                        'por_pag'=>$this->por_pag,
                        'buscar'=>$this->buscar,
                        'numPaginador'=>$this->numPaginador);

        switch ($this->accion) {
            case 'dataRol':
                $respuesta = RolUsuario::mostrarRolUsuarioController($datos);
                break;
            
            case 'dataUsuario':
                $respuesta = Usuario::mostrarUsuarioController($datos);
                break;

            case 'dataTablaLogica':
                $datos['tipo']='T';
                $respuesta = TablaLogica::mostrarTablaLogicaController($datos);
                break;

            case 'dataTabla':
                $datos["tipo"] = 'V';
                $datos["tabla"] = $this->tablaLogica;
                $respuesta = DatosTabla::mostrarDatosTablaController($datos);
                break;

            case 'dataPaciente':
                $datos['tabla'] = 'persona p';
                $datos['tipo'] = 'n';
                $respuesta = Persona::mostrarListaPersona($datos);
                break;
            case 'dataDirecciones':
                $valores = $this->input; 
                $datos['tipo'] = $valores['tipo'];
                $datos['id'] = $valores['id'];
                $respuesta = Persona::mostrarDetalleInfoPersonaCtr($datos);
                
                break;
            case 'dataCliente':
                $datos['tabla'] = 'persona p';
                $datos['tipo'] = 'j';
                $respuesta = Persona::mostrarListaPersona($datos);
                
                break;
            case 'dataContactos':
                $valores = $this->input; 
                $datos['tipo'] = $valores['tipo'];
                $datos['id'] = $valores['id'];
                $respuesta = Persona::mostrarDetalleInfoPersonaCtr($datos);
                break;
            default:
                $respuesta = "";
                break;
        }

        echo $respuesta;
    }

}


if(isset($_POST["accion"])){

    session_start();

    $a = new Ajax();
    $a -> tablaLogica = (isset($_POST['tabla']))?$_POST['tabla']:'';
    $a -> accion = $_POST["accion"];
    $a -> idRol = $_SESSION['rol'];
    $a -> page = $_POST["page"];
    $a -> por_pag = $_POST["por_pag"];
    $a -> buscar = $_POST["buscar"];
    $a -> numPaginador = $_POST["num"];
    $a -> mantenimiento = $_POST["mantenimiento"];
    $a -> input = $_POST;
    $a -> mostrarDataAjax();

}

