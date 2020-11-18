<?php

class Empresa{

    public static function mostrarImagenEmpresaController(){

        $respuesta = EmpresaModel::datosEmpresaModel("empresa");

        if(!empty($respuesta["foto"])){

            if($respuesta["foto"]!=""){

                echo '<img class="img-circle" src="views/images/empresa/'.$respuesta["foto"].'">';

            }else{
                echo '<img class="img-circle" src="views/images/5.jpg">';
            }

        }else{

            echo '<img class="img-circle" src="views/images/5.jpg">';

        }
    }

    public static function datosEmpresaController($row){

        $salida = "";

        $respuesta = EmpresaModel::datosEmpresaModel("empresa");

        if(!empty($respuesta[$row])){

            $salida = $respuesta[$row];
        }

        return $salida;

    }

    public static function guardarDatosEmpresaController($datos){

        $respuesta = EmpresaModel::datosEmpresaModel("empresa");
        $oldFoto = "";

        if(!empty($respuesta["nombre"])){

            $idEmpresa = $respuesta["id_empresa"];
            $oldFoto = $respuesta["foto"];

            $datos["id_empresa"] = $idEmpresa;

            $respuestaE = EmpresaModel::actualizarDatosEmpresaModel($datos,"empresa");

            if($respuestaE == "ok"){

                if($datos["foto"] != "" && $datos["foto"] != $oldFoto){
                    
                    $ruta = "../../views/images/empresa/".$oldFoto;

                    if(file_exists($ruta)){
                        unlink($ruta);
                    }
                    
                    $rutaGeneral = "../../../views/images/empresa/".$oldFoto;
                    if(file_exists($rutaGeneral)){
                        unlink($rutaGeneral);
                    }
                
                }
            }

        }else{

            $respuestaE = EmpresaModel::guardarDatosEmpresaModel($datos,"empresa");
        }

        //copiar de temporal a empresa
        if($datos["foto"] != "" && $datos["foto"] != $oldFoto && $respuestaE == "ok"){
            $ruta = "../../views/images/temp/".$datos["foto"];
            $nuevaRuta = "../../views/images/empresa/".$datos["foto"];

            $rutaGeneral = "../../../views/images/empresa/".$datos["foto"];

            copy($ruta,$nuevaRuta);
            copy($ruta,$rutaGeneral);
        }

        //borrar fotos temporales
        $borrar = glob("../../views/images/temp/*");

        foreach ($borrar as $file) {
            unlink($file);
        }

        return $respuestaE;
        
    }

    public static function subirImagenController($datos){

        list($ancho,$alto) = getimagesize($datos);

        $aleatorio = mt_rand(100,999);

        $imagenName = "empresa_".$aleatorio.".jpg";

        $ruta = "../../views/images/temp/".$imagenName;

        $nuevo_ancho = 160;
        $nuevo_alto = 160;

        $origen = imagecreatefromjpeg($datos);

        $destino = imagecreatetruecolor($nuevo_ancho, $nuevo_alto);

        imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevo_ancho, $nuevo_alto, $ancho, $alto);

        imagejpeg($destino,$ruta);

        $contenidoOk = '<img class="img-circle" src="views/images/temp/'.$imagenName.'">';

        $salidaJson =  array("imagenName" => $imagenName,
                                "contenido"=> $contenidoOk);

        echo json_encode($salidaJson);
    }

}
