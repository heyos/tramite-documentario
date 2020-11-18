<?php

class Globales{

    //crear una contraseña segura
    public static function crypt_blowfish($password,$digito = 7) {
        
        $password = self::unEspacio($password);

        $set_salt = './1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        $salt = sprintf('$2a$%02d$', $digito);

        for($i = 0; $i < 22; $i++){

            $salt .= $set_salt[mt_rand(0, 22)];
        }

        return crypt($password, $salt);
    }

    //limpiar informacion de los formularios en el servidor
    public static function sanearData($string){

        $string = trim($string);
        $string = self::unEspacio($string);
        $string = stripcslashes($string);
        $string = htmlspecialchars($string);

        $string = str_replace(
            array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
            array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
            $string
        );

        $string = str_replace(
            array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
            array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
            $string
        );

        $string = str_replace(
            array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
            array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
            $string
        );

        $string = str_replace(
            array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
            array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
            $string
        );

        $string = str_replace(
            array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
            array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
            $string
        );

        $string = str_replace(
            array('ñ', 'Ñ', 'ç', 'Ç'),
            array('n', 'N', 'c', 'C'),
            $string
        );

        //Esta parte se encarga de eliminar cualquier caracter extraño
        $string = str_replace(
            array("\\", "¨", "º", "~","'",
                 "#", "|", "!", "\"",
                 "·", "$", "%", "&",
                 "(", ")", "?", "'", "¡",
                 "¿", "[", "^", "`", "]",
                 "+", "}", "{", "¨", "´",
                 ">", "< ", ";", ",", ":","/","*"
                 ),
            '',
            $string
        );
        return $string;
    }

    public static function unEspacio($string){
        
        $array = explode(' ', $string);
        $newArray = array();
        $salida = '';

        foreach ($array as $key => $value) {

            if($value != ''){
                $newArray [] = $value;
            }
        }

        foreach ($newArray as $key => $value) {
            
            $salida .= $value.' ';
        }

        $salida = trim($salida);

        return $salida;
    }

    public static function paginacion($datos){

        $total_paginas = $datos["total_paginas"];
        $pageNum = $datos["pageNum"];
        $rowsPerPage = $datos["rowsPerPage"];
        $totalReg = $datos["totalReg"];

        $quitar = 0;
        
        $adjacents = 9;
        $salida = '
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
        ';

        $cantidadFilas = $pageNum * $rowsPerPage;

        $quitar = ($total_paginas == $pageNum) ? $cantidadFilas - $totalReg : 0;
        $cantidadFilas -= $quitar;

        $disabled = '';

        $adjacents = ($pageNum < 6) ? $adjacents - ($pageNum -1) : 4;
        $cantidadFilas = ($totalReg > 0) ? $cantidadFilas : 0;

        $salida .='
                    <div class="col-sm-4">
                        <h5>'.$cantidadFilas.' de '.$totalReg.' registros de '.$total_paginas.' pagina(s)</h5>
                    </div>
                    <div class="col-sm-8 text-right">
                        <ul id="pagi" class="pagination pagination-large pagi">
        ';

        if($pageNum == 1){
            $disabled = 'disabled';
        }

        $salida .='
                        <li class="'.$disabled.'"><a href="'.($pageNum - 1).'">&laquo;</a></li>
        ';

        //first label
        if($pageNum > ($adjacents+1)){

            $salida .='
                        <li><a href="1">1</a></li>
            ';
        }

        //interval
        if($pageNum > ($adjacents+2)){

            $salida .='
                        <li><a href="0">...</a></li>
            ';
        }

        //pages
        $pmin = ($pageNum>$adjacents) ? ($pageNum-$adjacents) : 1;
        $pmax = ($pageNum<($total_paginas-$adjacents)) ? ($pageNum+$adjacents) : $total_paginas;

        for($i=$pmin; $i<=$pmax; $i++) {
            if($i==$pageNum) {
                $salida.= "<li class='active'><a href='0'>$i</a></li>";
            }else if($i==1) {
                $salida.= "<li><a href='".$i."' >$i</a></li>";
            }else {
                $salida.= "<li><a href='".$i."'>$i</a></li>";
            }
        }

        // interval

        if($pageNum<($total_paginas-$adjacents-1)) {
            $salida.= "<li><a href='0'>...</a></li>";
        }

        //last
        if($pageNum < ($total_paginas-$adjacents)){
            $salida .='
                        <li><a href="'.$total_paginas.'">'.$total_paginas.'</a></li>
            ';
        }

        //next
        if($pageNum < $total_paginas){
            $disabled = '';
        }else{
            $disabled = 'disabled';
            $pageNum = -1;
        }

        $salida .='
                        <li class="'.$disabled.'"><a href="'.($pageNum+1).'">&rsaquo;&rsaquo;</a></li>
        ';

           

        $salida .= '
                        </ul>
                    </div>
                </div>
            </div>

        ';



        return $salida;
    }

    public static function full_copy($origen,$carpetaOrigen,$carpetaDestino){

        $files = glob($origen.'/*.php');

        $destino = "../../../views/modules/".$carpetaDestino;

        if(!file_exists($destino)){
            mkdir($destino,0777, true);
        }

        foreach ($files as $file) {

            $dest = str_replace($carpetaOrigen, $carpetaDestino, $file);
            copy($file, $dest);
        }

    }

}
