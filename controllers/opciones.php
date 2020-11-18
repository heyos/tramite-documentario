<?php

class Configuracion{

    public static function datosConfiguracionController($accion){

        $nameTema = "theme-default";
        $view = "menu_lateral";

        $temas = array("theme-default"=>"",
                        "theme-silver"=>"",
                        "theme-white"=>"",
                        "theme-fresh"=>"",
                        "theme-frost"=>"",
                        "theme-purple-hills"=>"",
                        "theme-clean"=>"",
                        "theme-adminflare"=>"",
                        "theme-asphalt"=>"",
                        "theme-dust"=>"");

        $temasCheck = array("theme-default"=>"",
                        "theme-silver"=>"",
                        "theme-white"=>"",
                        "theme-fresh"=>"",
                        "theme-frost"=>"",
                        "theme-purple-hills"=>"",
                        "theme-clean"=>"",
                        "theme-adminflare"=>"",
                        "theme-asphalt"=>"",
                        "theme-dust"=>"");

        $vistaMenu = array("no-main-menu"=>"",
                            "menu_lateral"=>"");
        $vistaMenuCheck = array("no-main-menu"=>"",
                            "menu_lateral"=>"");

        $respuesta = ConfiguracionModel::datosConfiguracionModel("configuracion_sistema");

        if(!empty($respuesta["temas"])){

            $nameTema = $respuesta["temas"];
            $view = $respuesta["vista_menu"];

            $temas[$nameTema] = "checked";
            $temasCheck[$nameTema] = "panel-success";
            $vistaMenu[$view] = "checked";
            $vistaMenuCheck[$view] = "panel-success";

        }else{

            $nameTema = 'theme-default';
            $view = 'menu_lateral';

            $temas[$nameTema] = "checked";
            $temasCheck[$nameTema] = "panel-success";
            $vistaMenu[$view] = "checked";
            $vistaMenuCheck[$view] = "panel-success";
        }


        switch ($accion) {
            case 'tema':
                return $nameTema;
                break;
            case 'vista':
                return $view;
                break;
            case 'checkedTheme':
                return $temas;
                break;
            case 'checkedVista':
                return $vistaMenu;
                break;
            case 'opTheme':
                return $temasCheck;
                break;
            case 'opVista':
                return $vistaMenuCheck;
                break;
            default:
                # code...
                break;
        }

    }

    public static function actualizarConfiguracionController($datos){

        $mensajeError = "No se puede ejecutar la aplicacion.";
        $respuestaOk = false;
        $contenidoOk = "";

        $datosConfi = ConfiguracionModel::datosConfiguracionModel("configuracion_sistema");

        if(!empty($datosConfi["temas"])){

            $id = $datosConfi["id_configuracion"];

            $datos["id"]=$id;

            $respuesta = ConfiguracionModel::actualizarConfiguracionModel($datos,"configuracion_sistema");

        }else{

            $respuesta = ConfiguracionModel::guardarConfiguracionModel($datos,"configuracion_sistema");
        }

        if($respuesta == "ok"){
            $respuestaOk =  true;
            $mensajeError = 'Se guardo exitosamente la configuracion del sistema, se actualizara el navegador para ver los cambios.';
        }else{
            $mensajeError = 'Error al guardar la configuracion.';
        }


        $salidaJson =  array("respuesta"=>$respuestaOk,
                                "mensaje"=>$mensajeError,
                                "contenido"=>$contenidoOk);

        echo json_encode($salidaJson);

    }

}