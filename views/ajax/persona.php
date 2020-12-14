<?php

require_once "../../controllers/globales.php";
require_once "../../controllers/persona.php";

require_once "../../models/persona.php";
require_once "../../models/direccion_contacto.php";

class Ajax{

    public $input;

    public function accionPersonaAjax(){

        $datos = $this->input;
        $datos['tabla'] = 'persona';

        if(array_key_exists('accion',$datos)){

            switch ($datos['accion']) {
                case 'add':
                    $respuesta = Controller::nuevoRegistroCtr($datos);
                    break;
                case 'edit':
                    $respuesta = Controller::actualizarRegistroCtr($datos);
                    break;
                case 'delete':
                    $respuesta = Controller::deleteRegistroCtr($datos);
                    break;
                case 'datos':
                    $respuesta = Controller::detalleDatosCtr($datos);
                    break;
                case 'datosdireccion':
                    $datos['tabla'] = 'direccion';
                    $respuesta = Controller::detalleDatosCtr($datos);
                    break;
                case 'adddireccion':
                    $datos['tabla'] = 'direccion';
                    $respuesta = Controller::nuevoRegistroCtr($datos);
                    break;
                case 'editdireccion':
                    $datos['tabla'] = 'direccion';
                    $respuesta = Controller::actualizarRegistroCtr($datos);
                    break;
                case 'deletedireccion':
                    $datos['tabla'] = 'direccion';
                    $respuesta = Controller::deleteRegistroCtr($datos);
                    break;

                case 'addcontacto':
                    $datos['tabla'] = 'contacto_persona_juridica';
                    $respuesta = Controller::nuevoRegistroCtr($datos);
                    break;
                case 'editcontacto':
                    $datos['tabla'] = 'contacto_persona_juridica';
                    $respuesta = Controller::actualizarRegistroCtr($datos);
                    break;
                case 'datosContacto':
                    $datos['tabla'] = 'contacto_persona_juridica';
                    $respuesta = Controller::detalleDatosCtr($datos);
                    break;
                case 'deletecontacto':
                    $datos['tabla'] = 'contacto_persona_juridica';
                    $respuesta = Controller::deleteRegistroCtr($datos);
                    break;
                default:
                    $res = array('respuesta'=>false,'mensaje'=>'Accion no disponible');
                    $respuesta = json_encode($res);
                    break;
            }


        }else{
            $res = array('respuesta'=>false,'mensaje'=>'Accion no disponible');
            $respuesta = json_encode($res);
        }

        echo $respuesta;

    }


}

if(isset($_POST)){

    $a = new Ajax();

    $a -> input = $_POST;

    $a -> accionPersonaAjax();


}
