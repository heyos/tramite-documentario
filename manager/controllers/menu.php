<?php

class Menu{

    public static function mostrarListaMenuController(){ //estructura de registro de menu en registrar_menu

        $contenido = "";
        $contenidoSub = "";

        $respuestaMenu = MenuModel::mostrarRegistrosMenuModel("menu");

        if(count($respuestaMenu) > 0){

            foreach ($respuestaMenu as $row => $item) {

                $urlMenu = $item["url"];

                $respuestaSub = MenuModel::mostrarRegistrosSubMenuModel($item["id_menu"],"sub_menu");

                $style = (count($respuestaSub) > 1)? '':'style="height: 80px;"';
                
                $contenidoSub = "";

                if(count($respuestaSub) > 0){

                    foreach ($respuestaSub as $rowSub => $itemSub) {

                        $contenidoSub .= '
                            <div id="divSub'.$itemSub["id_sub_menu"].'" class="stat-row">
                                
                                <a href="#" onclick="event.preventDefault();agregarSubMenu('.$item["id_menu"].','.$itemSub["id_sub_menu"].',\'update\')" class="stat-cell bg-info padding-sm valign-middle">
                                    '.$itemSub["descripcion"].'
                                </a>
                                
                            </div>
                        ';
                        
                    }

                    if($urlMenu == '#'){
                        $contenidoSub .='
                                <div class="stat-row after">
                        
                                    <a href="#" onclick="event.preventDefault(); agregarSubMenu('.$item["id_menu"].',0,\'add\')" class="stat-cell bg-info padding-sm valign-middle">
                                        <strong>Agregar Sub Menu <i class="fa fa-plus"></i></strong>
                                    </a>
                                    
                                </div>
                        ';
                    }

                }else{

                    if($urlMenu != '#'){
                        $contenidoSub ='
                                <div class="stat-row">
                        
                                    <a href="#" onclick="event.preventDefault();" class="stat-cell bg-info padding-sm valign-middle">
                                        Sin menu level 1
                                    </a>
                                    
                                </div>
                        ';
                    }else{
                        $contenidoSub ='
                                <div class="stat-row after">
                        
                                    <a href="#" onclick="event.preventDefault(); agregarSubMenu('.$item["id_menu"].',0,\'add\')" class="stat-cell bg-info padding-sm valign-middle">
                                        <strong>Agregar Sub Menu <i class="fa fa-plus"></i></strong>
                                    </a>
                                    
                                </div>
                        ';
                    }

                    
                }
                
                $contenido .= '
                            <div id="div'.$item['id_menu'].'" class="stat-panel" '.$style.'>
                                <a href="#" onclick="event.preventDefault();actualizarDatosMenu('.$item['id_menu'].')" class="stat-cell col-xs-7 bg-primary bordered no-border-vr no-border-l no-padding valign-middle text-center text-bg">
                                    <i class="'.$item["icono"].'"></i>&nbsp;&nbsp;<strong>'.$item["descripcion"].'</strong>
                                </a> 
                                <div class="stat-cell col-xs-5 no-padding valign-middle">
                                    <div id="stat_sub'.$item['id_menu'].'" class="stat-rows">
                                        '.$contenidoSub.'
                                    </div>
                                </div>
                            </div>
                ';


            }

        }

        echo $contenido;

    }

    public static function listarMainMenuRegistroController(){ //listar el menu de registro dinamico en menu_dinamico

        $contenido = "";
        $contenidoSub = '';

        echo '
                <li id="afterAdd"><a href="#" onclick="event.preventDefault();agregarMenu()">
                    <i class="menu-icon text-primary fas fa-plus"></i> <span class="mm-text text-primary"> <strong> Agregar Menu </strong></span>
                    </a>
                </li>
           ';

        $respuestaMenu = MenuModel::mostrarRegistrosMenuModel("menu");

        if(count($respuestaMenu) > 0){

            foreach ($respuestaMenu as $row => $item) {

                $contenidoSub = "";
                $visible = $item["visible"];
                $icono = $item["icono"];
                $menu = $item["descripcion"];
                $idMenu = $item["id_menu"];
                $urlMenu = $item["url"];

                $respuestaSub = MenuModel::mostrarRegistrosSubMenuModel($item["id_menu"],"sub_menu");
                

                if(count($respuestaSub) > 0){

                    echo '
                        <li id="li'.$idMenu.'" class="mm-dropdown">
                            <a href="#">
                                <i class="menu-icon '.$icono.'"></i> <span class="mm-text">'.$menu.'</span>
                                <span class="pull-right">
                                    <button type="button" class="btn btn-primary btn-xs" onclick="event.preventDefault();actualizarDatosMenu('.$idMenu.')">
                                    <i class="far fa-edit"></i></button>
                                </span>
                            </a>
                            <ul>
                    ';

                    foreach ($respuestaSub as $row => $itemSub) {

                        $sub = $itemSub["descripcion"];
                        $idSub = $itemSub["id_sub_menu"];
                        
                        
                        echo '
                                <li id="liSub'.$idSub.'">
                                    <a tabindex="-1" href="#" onclick="event.preventDefault();agregarSubMenu('.$idMenu.','.$idSub.',\'update\')"><span class="mm-text">'.$sub.'</span></a>
                                </li>
                        ';
                    }

                    echo'   
                                <li id="after'.$idMenu.'">
                                    <a tabindex="-1" href="#" onclick="event.preventDefault();agregarSubMenu('.$idMenu.',0,\'add\')">
                                        <span class="mm-text text-success"> <strong>Agregar Sub Menu <i class="fa fa-plus"></i></strong></span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    ';

                }else{

                    if($urlMenu == "#"){

                        echo '
                            <li id="li'.$idMenu.'" class="mm-dropdown">
                                <a href="#">
                                    <i class="menu-icon '.$icono.'"></i> <span class="mm-text">'.$menu.'</span>
                                    <span class="pull-right">
                                        <button type="button" class="btn btn-primary btn-xs" onclick="event.preventDefault();actualizarDatosMenu('.$idMenu.')">
                                        <i class="far fa-edit"></i></button>
                                    </span>
                                </a>
                                <ul>
                                    <li id="after'.$idMenu.'">
                                        <a tabindex="-1" href="#" onclick="event.preventDefault();agregarSubMenu('.$idMenu.',0,\'add\')">
                                            <span class="mm-text text-success"> <strong>Agregar Sub Menu <i class="fa fa-plus"></i></strong></span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                       ';

                    }else{
                        echo '
                            <li id="li'.$idMenu.'">
                                <a href="#">
                                    <i class="menu-icon '.$icono.'"></i> <span class="mm-text">'.$menu.'</span>
                                    <span class="pull-right">
                                        <button type="button" class="btn btn-primary btn-xs" onclick="event.preventDefault();actualizarDatosMenu('.$idMenu.')">
                                        <i class="far fa-edit"></i></button>
                                    </span>
                                </a>
                            </li>
                       ';
                    }

                }

            }

        }else{
            
            echo '
                <li>
                    <a href="#"><i class="menu-icon far fa-eye-slash"></i><span class="mm-text">No hay elementos</span></a>
                </li>';
        }

    }

    public static function mostrarSelectMenuController(){

        $contenido = '';

        $respuesta = MenuModel::mostrarRegistrosMenuModel("menu");

        if(count($respuesta) > 0){

            foreach ($respuesta as $row => $item) {

                $idMenu = $item["id_menu"];

                $verificarSub = MenuModel::mostrarRegistrosSubMenuModel($idMenu,"sub_menu");

                if(count($verificarSub) > 0){

                    $contenidoSub .='
                        <optgroup label="'.$item["descripcion"].'">
                    ';

                    foreach ($verificarSub as $row => $subMenu) {
                        
                        $contenidoSub .= '
                                <option data-type="s" value="'.$subMenu["id_sub_menu"].'">'.$subMenu["descripcion"].'</option>
                                    
                        ';
                    }

                    $contenidoSub .='
                        </optgroup>
                    ';

                }else{

                    $contenidoMenu .= '
                            
                                <option data-type="m" value="'.$idMenu.'">'.$item["descripcion"].'</option>
                              
                    ';
                }

            }

            $contenido = '
                <optgroup label="Menu">
                    '.$contenidoMenu.'
                </optgroup>'.
                $contenidoSub;

        }else{

            $contenido = '
                            <option value="0">Sin Registros</option>
                            
                ';

        }

        

        echo $contenido;

    }

    public static function guardarMenuController($datos){

        $respuestaOk = false;
        $mensajeError = "No se puede ejecutar la aplicacion.";
        $contenidoOk = "";

        $error = 0;
        $errorUrl = '';
        $errorEspacio = '';
        $numSub = 0;

        $guardarSub = 0;
        $errorGuardarSub = '';
        $contenidoSub = '';

        $dir = ""; //variable donde guardaremos las vistas de cada menu
        $carpeta = "";

        if($datos["urlMenu"] != '#' && $datos["descripcionSub"] != 0){

            $mensajeError = "No puede registrar Menu Level 1 porque cuenta con una url especifica en MENU.";

        }else{

            //VERIFICAR QUE LA URL NO TENGA ESPACIOS
            
            if($datos["urlMenu"] !='#'){

                if(strpos(" ",$datos["urlMenu"])==false ){

                
                    //VERIFICAR URL MENU
                    $where = sprintf("url = '%s' AND ",$datos["urlMenu"]);
                    
                    $respuestaVerificarUrlMenu = MenuModel::datosMenuModel($where,"menu");

                    if(!empty($respuestaVerificarUrlMenu["url"]) && $datos["urlMenu"] != '#'){

                        $mensajeError = "<strong>".$datos["urlMenu"]."</strong> <br>esta url ya se encuentra en uso.";
                        
                        $error ++;

                    }

                    $respuestaVerificarUrlSub = MenuModel::datosSubMenuModel($where,"sub_menu");

                    if(!empty($respuestaVerificarUrlSub["url"]) && $datos["urlMenu"] != '#'){

                        $mensajeError = "<strong>".$datos["urlMenu"]."</strong> <br>esta url ya se encuentra en uso.";
                        
                        $error ++;

                    }
                
                
                }else{
                    $error = 1;
                    $mensajeError = "<strong>".$datos["urlMenu"]."</strong> <br>contiene espacios.";
                }
            }

            //VERIFICAR URL SUB MENU
            
            if($datos["descripcionSub"] != 0 && $datos["urlSub"] != 0){

                foreach ($datos["urlSub"] as $url) {
                    
                    $where = sprintf("url = '%s' AND ",$url);

                    $resMenu = MenuModel::datosMenuModel($where,"menu");

                    if(!empty($resMenu["url"]) && $url != '#'){
                        $errorUrl .= "<strong>".$url."</strong><br>";
                        $error ++;
                    }

                    $res = MenuModel::datosSubMenuModel($where,"sub_menu");

                    if(!empty($res["url"])){
                        $errorUrl .= "<strong>".$url."</strong><br>";
                        $error ++;
                    }

                    if(strlen(stristr($url,' '))>0){
                        $errorEspacio .= "<strong>".$url."</strong><br>";
                        $error ++;
                    }
                }

                $numSub = 1;//si contiene registros submenu para guardar

                if($error > 0){
                    $mensajeError = $errorUrl."Esta(s) url ya se encuentran en uso.";
                }

                if($errorEspacio !=''){
                    $errorEspacio .= "Estas url contienen espacio.";

                    $mensajeError = ($errorUrl !='')? $errorUrl."Esta(s) url ya se encuentran en uso.<br>".$errorEspacio:$errorEspacio;
                }
            }
            

            if($error == 0){
               

                $respuesta = MenuModel::guardarMenuModel($datos,"menu");

                if($respuesta == "ok"){

                        
                    $respuestaOk = true;
                    $mensajeError = "Se guardo correctamente el menu.";;

                    $idMenu = MenuModel::ultimoIdRegistrado("id_menu","menu");  //devuelve el ultimo Id registrado
                
                    
                    $ruta = "../../../views/modules/plantilla.php";
                    
                    //creamos el directorio donde guardaremos las vistas
                    
                    $carpeta = str_replace(" ","_", $datos["descripcion"]);
                    $dir = "../../../views/modules/".$carpeta;
                    if(!file_exists($dir)){
                        mkdir($dir, 0777,true);
                    }
                    
                    if($numSub == 0){
                        //copiamos la plantilla en la ruta de desarrollo
                      
                        $rutaGeneral = $dir."/".$datos["urlMenu"].'.php';

                        if(!file_exists($rutaGeneral) && $datos["urlMenu"] != '#'){
                            copy($ruta,$rutaGeneral);
                        }
                        
                    }
                    
                    
                    if($numSub == 1){
                        //registrar sub menu
                        $descripcionSub = array_unique($datos["descripcionSub"]);
                        $urlSub = $datos["urlSub"];

                        foreach ($descripcionSub as $key => $subMenu) {

                            $datosController = array('descripcion'=>ucwords($subMenu),'urlSub'=>$urlSub[$key],"id_menu"=>$idMenu);

                            $respuestaSub = MenuModel::guardarSubMenuModel($datosController,"sub_menu");

                            if($respuestaSub == 'ok'){

                                $idSubMenu = MenuModel::ultimoIdRegistrado('id_sub_menu','sub_menu');

                                $guardarSub ++;
                                $contenidoSub .='
                                        <div id="divSub'.$idSubMenu.'" class="stat-row">
                                
                                            <a href="#" onclick="event.preventDefault();agregarSubMenu('.$idMenu.','.$idSubMenu.',\'update\')" class="stat-cell bg-info padding-sm valign-middle">
                                                '.$subMenu.'
                                            </a>
                                            
                                        </div>
                                ';
                            
                                $rutaGeneral = $dir."/".$urlSub[$key].'.php';

                                if(!file_exists($rutaGeneral)){
                                    copy($ruta,$rutaGeneral);
                                }
                            

                            }else{
                                $guardarSub = 0;
                                $errorGuardarSub .= "<strong>".$subMenu."</strong><br>";
                            }

                        }

                        if($datos["urlMenu"] == '#'){
                            $contenidoSub .='
                                    <div class="stat-row after">
                            
                                        <a href="#" onclick="event.preventDefault();agregarSubMenu('.$idMenu.',0,\'add\')" class="stat-cell bg-info padding-sm valign-middle">
                                            Agregar Sub Menu <i class="fa fa-plus"></i>
                                        </a>
                                        
                                    </div>
                            ';
                        }

                        if($guardarSub == 0){

                            $mensajeError = "Se guardo el menu, pero no estos sub menu <br>".$errorGuardarSub;

                        }

                    }else{

                        if($datos["urlMenu"] != '#'){

                            $contenidoSub ='
                                    <div class="stat-row">
                            
                                        <a href="#" onclick="event.preventDefault();" class="stat-cell bg-info padding-sm valign-middle">
                                            Sin menu level 1
                                        </a>
                                        
                                    </div>
                            ';

                        }else{
                            $contenidoSub ='
                                    <div class="stat-row after">
                            
                                        <a href="#" onclick="event.preventDefault();agregarSubMenu('.$idMenu.',0,\'add\')" class="stat-cell bg-info padding-sm valign-middle">
                                            Agregar Sub Menu <i class="fa fa-plus"></i>
                                        </a>
                                        
                                    </div>
                            ';
                        }

                    }
                

                    $style = ($guardarSub > 1)? '':'style="height: 80px;"';

                    
                    $contenidoOk = '
                            <div id="div'.$idMenu.'" class="stat-panel" '.$style.'>
                                <a href="#" onclick="event.preventDefault();actualizarDatosMenu('.$idMenu.')" class="stat-cell col-xs-7 bg-primary bordered no-border-vr no-border-l no-padding valign-middle text-center text-bg">
                                    <i class="'.$datos["icono"].'"></i>&nbsp;&nbsp;<strong>'.$datos["descripcion"].'</strong>
                                </a> 
                                <div class="stat-cell col-xs-5 no-padding valign-middle">
                                    <div id="stat_sub'.$idMenu.'" class="stat-rows">
                                        '.$contenidoSub.'
                                    </div>
                                </div>
                            </div>
                    ';

                    

                }else{
                    $mensajeError = "No se proceso correctamente la solicitud de registro.";
                }
            }
        

        }

        $salidaJson = array("respuesta"=>$respuestaOk,
                            "mensaje"=>$mensajeError,
                            "contenido"=>$contenidoOk);

        echo json_encode($salidaJson);

    }

    public static function agregarMenuController($datos){

        $respuestaOk = false;
        $mensajeError = "No se puede ejecutar la aplicacion.";
        $contenidoOk = "";

        $error = 0;
        $contenidoSub = '';

        $dir = ""; //variable donde guardaremos las vistas de cada menu
        $carpeta = "";
        $mm_dropdown = 'class="mm-dropdown"';

        //VERIFICAR QUE LA URL NO TENGA ESPACIOS
        
        if($datos["urlMenu"] !='#'){

            if(strpos(" ",$datos["urlMenu"])==false ){

                //VERIFICAR URL MENU
                $where = sprintf("url = '%s' AND ",$datos["urlMenu"]);
                
                $respuestaVerificarUrlMenu = MenuModel::datosMenuModel($where,"menu");

                if(!empty($respuestaVerificarUrlMenu["url"]) && $datos["urlMenu"] != '#'){

                    $mensajeError = "<strong>".$datos["urlMenu"]."</strong> <br>esta url ya se encuentra en uso.";
                    
                    $error ++;

                }

                $respuestaVerificarUrlSub = MenuModel::datosSubMenuModel($where,"sub_menu");

                if(!empty($respuestaVerificarUrlSub["url"]) && $datos["urlMenu"] != '#'){

                    $mensajeError = "<strong>".$datos["urlMenu"]."</strong> <br>esta url ya se encuentra en uso.";
                    
                    $error ++;

                }
            
            }else{
                $error = 1;
                $mensajeError = "<strong>".$datos["urlMenu"]."</strong> <br>contiene espacios.";
            }
        }

        if($error == 0){
           
            $respuesta = MenuModel::guardarMenuModel($datos,"menu");

            if($respuesta == "ok"){

                $respuestaOk = true;
                $mensajeError = "Se guardo correctamente el menu.";;

                $idMenu = MenuModel::ultimoIdRegistrado("id_menu","menu");  //devuelve el ultimo Id registrado
            
                $ruta = "../../../views/modules/plantilla.php";
                
                //creamos el directorio donde guardaremos las vistas
                
                $carpeta = str_replace(" ","_", $datos["descripcion"]);
                $dir = "../../../views/modules/".$carpeta;
                if(!file_exists($dir)){
                    mkdir($dir, 0777,true);
                }
                
                if($datos["urlMenu"] == '#'){

                    $contenidoSub ='
                            <ul>
                                <li id="after'.$idMenu.'">
                                    <a tabindex="-1" href="#" onclick="event.preventDefault();agregarSubMenu('.$idMenu.',0,\'add\')">
                                        <span class="mm-text text-success"> <strong>Agregar Sub Menu <i class="fa fa-plus"></i></strong></span>
                                    </a>
                                </li>
                            </ul>
                    ';

                }else{
                    //no tendra sub menus y creamos sus vista
                    //copiamos la plantilla en la ruta de desarrollo
                    $rutaGeneral = $dir."/".$datos["urlMenu"].'.php';

                    if(!file_exists($rutaGeneral) && $datos["urlMenu"] != '#'){
                        copy($ruta,$rutaGeneral);
                    }

                    $mm_dropdown = '';
                }

                $contenidoOk = '
                        <li id="li'.$idMenu.'" '.$mm_dropdown.'>
                            <a href="#">
                                <i class="menu-icon '.$datos["icono"].'"></i> <span class="mm-text">'.$datos["descripcion"].'</span>
                                <span class="pull-right">
                                    <button type="button" class="btn btn-primary btn-xs" onclick="event.preventDefault();actualizarDatosMenu('.$idMenu.')">
                                    <i class="far fa-edit"></i></button>
                                </span>
                            </a>
                            '.$contenidoSub.'
                        </li>
                        ';

            }else{
                $mensajeError = "No se proceso correctamente la solicitud de registro.";
            }

        }
        
        $salidaJson = array("respuesta"=>$respuestaOk,
                            "mensaje"=>$mensajeError,
                            "contenido"=>$contenidoOk);

        echo json_encode($salidaJson);

    }

    public static function datosMenuController($datos){

        $respuestaOk = false;
        $mensajeError = "No se puede ejecutar la aplicacion.";
        $contenidoOk = array();

        $where = sprintf(" id_menu = '%d' AND ",$datos);

        $respuesta = MenuModel::datosMenuModel($where,'menu');

        if(!empty($respuesta["descripcion"])){

            $respuestaOk = true;

            $registrosSubMenu = MenuModel::mostrarRegistrosSubMenuModel($datos,"sub_menu");

            $tieneRegistros = (count($registrosSubMenu)>0)? true:false;

            $contenidoOk = array("nombreMenu"=>$respuesta["descripcion"],
                                "icono"=>$respuesta["icono"],
                                "url"=>$respuesta["url"],
                                "visible"=>$respuesta["visible"],
                                "tieneSubMenu"=>$tieneRegistros);

        }else{
            $mensajeError = "Menu no identificado.";
        }


        $salidaJson = array("respuesta"=>$respuestaOk,
                            "mensaje"=>$mensajeError,
                            "contenido"=>$contenidoOk);

        echo json_encode($salidaJson);

    }

    public static function eliminarMenuController($datos){

        $respuestaOk = false;
        $mensajeError = "No se puede ejecutar la aplicacion.";
        $contenidoOk = "";

        $idMenu = $datos["id_menu"];

        $where = sprintf(" id_menu = '%d' AND ",$idMenu);

        $verificar = MenuModel::datosMenuModel($where,'menu');

        $sistema = "0";

        if(!empty($verificar["sistema"])){
            $sistema = $verificar["sistema"];
        }

        if($sistema == "1"){

            $mensajeError = "Menu del sistema, no se puede eliminar.";

        }else{

            $res = MenuModel::mostrarRegistrosSubMenuModel($idMenu,"sub_menu");
            $tieneSub = 0;

            if(count($res) > 0){

                $tieneSub = 1;

                $where = sprintf("id_menu = '%d'",$idMenu);

                $resSub = MenuModel::eliminarSubMenuModel($where,"sub_menu");

            }

            $respuesta = MenuModel::eliminarMenuModel($datos,"menu");

            if($respuesta == "ok"){

                $respuestaOk = true;
                $mensajeError = "se elimino el menu seleccionado correctamente.";

                if($tieneSub==1){
                    $mensajeError = "Se elimino el menu seleccionado y los submenus correctamente.";
                }

            }else{
                $mensajeError = "Error al intentar eliminar el menu.";
            }
        }

            

        $salidaJson = array("respuesta"=>$respuestaOk,
                            "mensaje"=>$mensajeError,
                            "contenido"=>$contenidoOk);

        echo json_encode($salidaJson);

    }

    public static function actualizarMenuController($datos){

        $respuestaOk = false;
        $mensajeError = "No se puede ejecutar la aplicacion.";
        $contenidoOk = "";

        //para concatenar y mostrar el contenido en menu_dinamico
        $contenidoDin = "";
        $contenidoSubDin = "";

        $idMenu = $datos["id_menu"];

        $where = sprintf("id_menu = '%d' AND ",$idMenu);
        $oldDatos = MenuModel::datosMenuModel($where,"menu");
        $sistema = $oldDatos["sistema"];
        $oldDescripcion = $oldDatos["descripcion"];

        $error = 0;

        $oldUrl = "";
        $modificoNombre = false;

        if($sistema == '1'){

            $mensajeError = "Menu del sistema, no se puede actualizar.";

        }else{

            if(!empty($oldDatos["id_menu"])){

                $oldUrl = $oldDatos["url"];

                if($datos["urlMenu"] != $oldUrl && $datos["urlMenu"] != '#'){

                    $where = sprintf("url = '%s' AND ",$datos["urlMenu"]);
                    $res = MenuModel::datosMenuModel($where,"menu");

                    if(!empty($res["url"])){

                        $error = 1;
                        $mensajeError = "Url existente, intente con otra.";
                    }

                    $verificarUrlSub = MenuModel::datosSubMenuModel($where,"sub_menu");

                    if(!empty($verificarUrlSub["url"])){

                        $mensajeError ="Url existente, intente con otra.";
                        $error ++;

                    }
                }

                if($datos["descripcion"] != $oldDescripcion){
                    $modificoNombre = true;
                }

            }

            $contenidoSub = "";

            if($error == 0){

                $respuesta = MenuModel::actualizarMenuModel($datos,"menu");

                if($respuesta == "ok"){

                    $respuestaOk = true;
                    $mensajeError = "se actualizo el menu seleccionado correctamente.";

                    //copiamos antiguo archivo
                    $oldDescripcion = str_replace(" ", "_", $oldDescripcion);
                    $ruta = "../../../views/modules/".$oldDescripcion."/".$oldUrl.".php";
                    
                    //copiamos la plantilla en la ruta de desarrollo
                    $carpeta = str_replace(" ","_", $datos["descripcion"]); //nueva carpeta a copiar los datos
                    $dir = "../../../views/modules/".$carpeta;
                    if(!file_exists($dir)){
                        mkdir($dir, 0777,true);
                    }

                    $rutaGeneral = $dir."/".$datos["urlMenu"].'.php';

                    if($oldUrl != "#" && $datos["urlMenu"] != "#"){
                        if(file_exists($ruta)){
                            if(!file_exists($rutaGeneral)){
                                copy($ruta,$rutaGeneral);
                            }
                        }
                        
                    }else if($datos["urlMenu"] != "#"){
                        $ruta = "../../../views/modules/plantilla.php";
                        if(!file_exists($rutaGeneral)){
                            copy($ruta,$rutaGeneral);
                        }
                    }

                    
                    $res = MenuModel::mostrarRegistrosSubMenuModel($idMenu,"sub_menu");

                    if(count($res) > 0 && $datos["urlMenu"] != '#' ){

                        $where = sprintf("id_menu = '%d'",$idMenu);

                        $resSub = MenuModel::eliminarSubMenuModel($where,"sub_menu");

                    }

                    $respuestaSub = MenuModel::mostrarRegistrosSubMenuModel($idMenu,"sub_menu");

                    if(count($respuestaSub) > 0 && $datos["urlMenu"] == '#'){

                        foreach ($respuestaSub as $row => $item) {

                            $contenidoSub .= '
                                        <div id="divSub'.$item["id_sub_menu"].'" class="stat-row">
                                
                                            <a href="#" onclick="event.preventDefault();agregarSubMenu('.$idMenu.','.$item["id_sub_menu"].',\'update\')" class="stat-cell bg-info padding-sm valign-middle">
                                                '.$item["descripcion"].'
                                            </a>
                                            
                                        </div>';

                            $contenidoSubDin .= '
                                        <li id="liSub'.$item["id_sub_menu"].'">
                                            <a tabindex="-1" href="#" onclick="event.preventDefault();agregarSubMenu('.$idMenu.','.$item["id_sub_menu"].',\'update\')">
                                                <span class="mm-text">'.$item["descripcion"].'</span>
                                            </a>
                                        </li>

                            ';
                            
                        }

                        $contenidoSub .= '
                                        <div class="stat-row after">
                                
                                            <a href="#" onclick="event.preventDefault();agregarSubMenu('.$idMenu.',0,\'add\')" class="stat-cell bg-info padding-sm valign-middle">
                                                <strong>Agregar Sub Menu <i class="fa fa-plus"></i></strong>
                                            </a>
                                            
                                        </div>';

                        $contenidoSubDin .='
                                        <ul>
                                            <li id="after'.$idMenu.'">
                                                <a tabindex="-1" href="#" onclick="event.preventDefault();agregarSubMenu('.$idMenu.',0,\'add\')">
                                                    <span class="mm-text text-success"> <strong>Agregar Sub Menu <i class="fa fa-plus"></i></strong></span>
                                                </a>
                                            </li>
                                        </ul>
                                    ';

                        //si tiene sub menus, copiamos todo el directorio
                        if($modificoNombre == true){

                            $oldRuta = "../../../views/modules/".$oldDescripcion;

                            Globales::full_copy($oldRuta,$oldDescripcion,$carpeta); //ful_copy(ruta_antigua,carpeta_origen,carpeta_destino)

                        }

                    }else{

                        if($datos["urlMenu"] == '#'){
                            
                            $contenidoSub = '
                                        <div class="stat-row after">
                                
                                            <a href="#" onclick="event.preventDefault();agregarSubMenu('.$idMenu.',0,\'add\')" class="stat-cell bg-info padding-sm valign-middle">
                                                <strong>Agregar Sub Menu <i class="fa fa-plus"></i></strong>
                                            </a>
                                            
                                        </div>';

                            $contenidoSubDin .='
                                        <ul>
                                            <li id="after'.$idMenu.'">
                                                <a tabindex="-1" href="#" onclick="event.preventDefault();agregarSubMenu('.$idMenu.',0,\'add\')">
                                                    <span class="mm-text text-success"> <strong>Agregar Sub Menu <i class="fa fa-plus"></i></strong></span>
                                                </a>
                                            </li>
                                        </ul>
                                    ';

                        }else{

                            $contenidoSub = '
                                        <div class="stat-row">
                                
                                            <a href="#" onclick="event.preventDefault();" class="stat-cell bg-info padding-sm valign-middle">
                                                Sin menu level 1
                                            </a>
                                            
                                        </div>';
                        }
                    }

                    //registrar_menu
                    $contenidoOk = '
                            
                                <a href="#" onclick="event.preventDefault();actualizarDatosMenu('.$idMenu.')" class="stat-cell col-xs-7 bg-primary bordered no-border-vr no-border-l no-padding valign-middle text-center text-bg">
                                    <i class="'.$datos["icono"].'"></i>&nbsp;&nbsp;<strong>'.$datos["descripcion"].'</strong>
                                </a> 
                                <div class="stat-cell col-xs-5 no-padding valign-middle">
                                    <div id="stat_sub'.$idMenu.'" class="stat-rows">
                                        '.$contenidoSub.'
                                    </div>
                                </div>
                            
                    ';

                    //menu_dinamico
                    $contenidoDin = '
                                <a href="#">
                                    <i class="menu-icon '.$datos["icono"].'"></i> <span class="mm-text">'.$datos["descripcion"].'</span>
                                    <span class="pull-right">
                                        <button type="button" class="btn btn-primary btn-xs" onclick="event.preventDefault();actualizarDatosMenu('.$idMenu.')">
                                        <i class="far fa-edit"></i></button>
                                    </span>
                                </a>
                                '.$contenidoSubDin
                    ;
             

                }else{
                    $mensajeError = "Error al intentar actualizar el menu.";
                }
            }

        }

            
    
        $salidaJson = array("respuesta"=>$respuestaOk,
                            "mensaje"=>$mensajeError,
                            "contenido"=>$contenidoOk,
                            "contenidoDin"=>$contenidoDin);

        echo json_encode($salidaJson);

    }

    public static function datosSubMenuController($datos){

        $respuestaOk = false;
        $mensajeError = "No se puede ejecutar la aplicacion.";
        $contenidoOk = "";

        $where = sprintf(" id_sub_menu = '%d' AND ",$datos);

        $respuesta = MenuModel::datosSubMenuModel($where,"sub_menu");

        if(!empty($respuesta["id_sub_menu"])){

            $respuestaOk = true;

            $contenidoOk = array("nombreSub"=>$respuesta["descripcion"],"url"=>$respuesta["url"]);
        }


        $salidaJson = array("respuesta"=>$respuestaOk,
                            "mensaje"=>$mensajeError,
                            "contenido"=>$contenidoOk);

        echo json_encode($salidaJson);

    }

    public static function agregarSubMenuController($datos){

        $respuestaOk = false;
        $mensajeError = "No se puede ejecutar la aplicacion.";
        $contenidoOk = "";  //para mostrar en registrar_menu
        $contenidoDin = ""; //para mostrar en menu_dinamico

        $error = 0;

        $url = $datos["urlSub"];

        $where = sprintf("url = '%s' AND ",$url);

        $verificarUrlMenu = MenuModel::datosMenuModel($where,"menu");

        if(!empty($verificarUrlMenu["url"]) && $url != '#'){
            
            $mensajeError ="<strong>".$url."</strong> esta url esta en uso.";
            $error ++;
        }

        $verificarUrlSub = MenuModel::datosSubMenuModel($where,"sub_menu");

        if(!empty($verificarUrlSub["url"]) > 0){

            $mensajeError ="<strong>".$url."</strong> esta url esta en uso.";
            $error ++;

        }

        if($error == 0){

            $respuesta = MenuModel::guardarSubMenuModel($datos,"sub_menu");

            if($respuesta == "ok"){

                $idSubMenu = MenuModel::ultimoIdRegistrado("id_sub_menu","sub_menu");
                $idMenu = $datos["id_menu"];
                
                $where = sprintf(" id_menu = '%d' AND ",$idMenu);
                $datosMenu = MenuModel::datosMenuModel($where,"menu");

                $menu = $datosMenu["descripcion"];
                $carpeta = str_replace(" ", "_", $menu);//nueva carpeta a copiar los datos
                $dir = "../../../views/modules/".$carpeta;
                if(!file_exists($dir)){
                    mkdir($dir, 0777,true);
                }

                $respuestaOk = true;

                $mensajeError = "Se guardo el sub menu correctamente.";

                $contenidoOk ='
                                <div id="divSub'.$idSubMenu.'" class="stat-row">
                            
                                    <a href="#" onclick="event.preventDefault();agregarSubMenu('.$idMenu.','.$idSubMenu.',\'update\')" class="stat-cell bg-info padding-sm valign-middle">
                                        '.$datos["descripcion"].'
                                    </a>
                                        
                                </div>';

                $contenidoDin = '
                                <li id="liSub'.$idSubMenu.'">
                                    <a tabindex="-1" href="#" onclick="event.preventDefault();agregarSubMenu('.$idMenu.','.$idSubMenu.',\'update\')">
                                        <span class="mm-text">'.$datos["descripcion"].'</span>
                                    </a>
                                </li>
                ';

                $ruta = "../../../views/modules/plantilla.php";
                //copiamos la plantilla en la ruta de desarrollo
                $rutaGeneral = $dir."/".$url.'.php';

                if(!file_exists($rutaGeneral)){
                    copy($ruta,$rutaGeneral);
                }
                

            }else{
                $mensajeError = "No se guardo el registro.";
            }

        }
    
        $salidaJson = array("respuesta"=>$respuestaOk,
                            "mensaje"=>$mensajeError,
                            "contenido"=>$contenidoOk,
                            "contenidoDin"=>$contenidoDin);

        echo json_encode($salidaJson);

    }

    public static function actualizarSubMenuController($datos){

        $respuestaOk = false;
        $mensajeError = "No se puede ejecutar la aplicacion.";
        $contenidoOk = "";  //para mostrar en registrar_menu
        $contenidoDin = ""; //para mostrar en menu_dinamico

        $error = 0;

        $idSubMenu = $datos["id_sub_menu"];
        $idMenu = $datos["id_menu"];

        $where = sprintf(" id_sub_menu = '%d' AND ",$idSubMenu);
        $verificar = MenuModel::datosSubMenuModel($where,"sub_menu");

        $sistema = "0";
        $oldUrl = "";

        if(!empty($verificar["sistema"])){
            $sistema = $verificar["sistema"];
        }

        if($sistema == '1'){
            $mensajeError = "Sub menu del sistema, no se puede actualizar.";
        }else{

            if($idSubMenu != 0){

                $where = sprintf(" id_sub_menu = '%d' AND ",$datos["id_sub_menu"]);
                $oldDatos = MenuModel::datosSubMenuModel($where,"sub_menu");

                if(!empty($oldDatos["url"])){

                    $oldUrl = $oldDatos["url"];

                    if($datos["urlSub"] != $oldUrl){

                        $where = sprintf(" url = '%s' AND ",$datos["urlSub"]);
                        $verificarUrlSub = MenuModel::datosSubMenuModel($where,"sub_menu");

                        if(!empty($verificarUrlSub["url"]) > 0){

                            $mensajeError ="<strong>".$datos["urlSub"]."</strong> esta url esta en uso.";
                            $error ++;

                        }

                        $res = MenuModel::datosMenuModel($where,"menu");

                        if(!empty($res["url"]) > 0){

                            $error ++;
                            $mensajeError = "<strong>".$datos["urlSub"]."</strong> esta url esta en uso.";
                        }

                    }
                }

                if($error == 0){

                    $respuesta = MenuModel::actualizarSubMenuModel($datos,"sub_menu");

                    if($respuesta == "ok"){

                        $respuestaOk = true;
                        $mensajeError = "Se actualizo correctamente el sub menu.";

                        $contenidoOk = '
                                <a href="#" onclick="event.preventDefault();agregarSubMenu('.$idMenu.','.$idSubMenu.',\'update\')" class="stat-cell bg-info padding-sm valign-middle">
                                    '.$datos["descripcion"].'
                                </a>
                        ';

                        $contenidoDin = '
                                
                                <a tabindex="-1" href="#" onclick="event.preventDefault();agregarSubMenu('.$idMenu.','.$idSubMenu.',\'update\')">
                                    <span class="mm-text">'.$datos["descripcion"].'</span>
                                </a>
                                
                        ';

                        $where = sprintf(" id_menu = '%d' AND ",$idMenu);
                        $datosMenu = MenuModel::datosMenuModel($where,"menu");

                        $menu = $datosMenu["descripcion"];
                        $carpeta = str_replace(" ", "_", $menu);//nueva carpeta a copiar los datos
                        $dir = "../../../views/modules/".$carpeta;
                        if(!file_exists($dir)){
                            mkdir($dir, 0777,true);
                        }

                        //copiamos antiguo archivo
                        $ruta = $dir."/".$oldUrl.".php";
                        //copiamos la plantilla en la ruta de desarrollo
                        $rutaGeneral = $dir."/".$datos["urlSub"].'.php';

                        if(file_exists($ruta)){
                            if(!file_exists($rutaGeneral)){
                                copy($ruta,$rutaGeneral);
                            }
                        }

                    }else{
                        $mensajeError = "Error al actualizar el sub menu.";
                    }

                }
                
            }else{
                $mensajeError = "No se reconoce como un sub menu registrado.";
            }

        }

            


        $salidaJson = array("respuesta"=>$respuestaOk,
                            "mensaje"=>$mensajeError,
                            "contenido"=>$contenidoOk,
                            "contenidoDin"=>$contenidoDin);

        echo json_encode($salidaJson);

    }

    public static function eliminarSubMenuController($datos){

        $respuestaOk = false;
        $mensajeError = "No se puede ejecutar la aplicacion.";
        $contenidoOk = "";

        $idSubMenu = $datos["id_sub_menu"];

        $where = sprintf(" id_sub_menu = '%d' AND ",$idSubMenu);
        $verificar = MenuModel::datosSubMenuModel($where,"sub_menu");

        $sistema = "0";
        

        if(!empty($verificar["sistema"])){
            $sistema = $verificar["sistema"];

        }

        if($sistema == '1'){

            $mensajeError = "Sub Menu del Sistema, no se puede eliminar.";

        }else{

            if($idSubMenu != 0){

                $where = sprintf(" id_sub_menu = '%d' LIMIT 1 ",$idSubMenu);
                $respuesta = MenuModel::eliminarSubMenuModel($where,"sub_menu");

                if($respuesta == "ok"){
                    $respuestaOk = true;
                    $mensajeError = "Se elimino correctamente el sub menu.";
                }else{
                    $mensajeError = "Error al eliminar el sub menu.";
                }

            }else{
                $mensajeError = "No se reconoce como un sub menu registrado.";
            }

        }

        $salidaJson = array("respuesta"=>$respuestaOk,
                            "mensaje"=>$mensajeError,
                            "contenido"=>$contenidoOk);

        echo json_encode($salidaJson);

    }

    public static function mostrarSelectPermisosMenuController($datos){

        $contenidoOk = "";
        $respuestaOk =  true;

        $contenidoMenu = "";
        $contenidoSub = "";

        $contenidoMenu = '<option value="inicio">Inicio</option>';

        $respuesta = MenuModel::detallePermisosMenuModel($datos,"detalle_menu AS d, menu AS m");

        if(count($respuesta) > 0){

            foreach ($respuesta as $row => $item) {

                $idMenu = $item[0];
                $menu = $item[1];
                $url = $item[3];
                $visible = $item[4];

                $datosController =  array("id_menu" => $idMenu, "id_rol"=>$datos);

                $respuestaSub = MenuModel::detallePermisosSubMenuModel($datosController,"sub_menu AS s, detalle_sub_m AS d");

                if(count($respuestaSub) > 0 && $visible == "1"){

                    $contenidoSub .='
                        <optgroup label="'.$menu.'">
                    ';

                    foreach ($respuestaSub as $row => $item) {

                        $sub = $item[1];
                        $url = $item[2];
                    
                        $contenidoSub .= '
                                <option value="'.$url.'">'.$sub.'</option>
                                    
                        ';
                    }


                    $contenidoSub .='
                        </optgroup>
                    ';

                }else if($visible == "1"){
                    $contenidoMenu.= '
                        <option value="'.$url.'">'.$menu.'</option>
                   ';
                }

                
            }

        }

        $contenidoOk = '
            <optgroup label="Menu">
                '.$contenidoMenu.'
            </optgroup>'.
            $contenidoSub;

        $salidaJson = array("respuesta"=>$respuestaOk,
                                "contenido"=>$contenidoOk);

        echo json_encode($salidaJson);

    }

    //PERMISOS
    public static function permisosMenuController(){

        $error = 0;
        $salida = "";

        if(isset($_GET["term"]) && !empty($_GET["term"])){

            $rol = Globales::sanearData($_GET["term"]);

            $where = sprintf(" id_rol = '%d' AND ",$rol);
            $respuesta = RolUsuarioModel::registroRolModel($where,"rol_usuario");

            if(!empty($respuesta["id_rol"]) == 0){

                $error = 1;

            }

        }else{

            $error = 1;
            
        }

        $contenido = "";
        $contenidoSub = "";
        $i = 0;
        $x = 0;
        $reg = 0;
        $idMenu = 0;
        $padre = "";
        $icono = "";
        $cabecera = "";

        //acesso
        $si = 0;
        $no = 0;
        $acceso = "";

        //mantenimiento
        $siM=0;
        $noM =0;
        $mantenimiento = "";

        //sub
        $siSub=0;
        $noSub =1;

        $reg = MenuModel::numRegistrosMenuModel("menu");

        $respuesta = MenuModel::mostrarRegistrosMenuModel("menu");

        $classAcceso = array('0'=>'default','1'=>'primary');
        $classMante = array('0'=>'default','1'=>'success');
        
        if($reg > 0 && $error == 0){

            foreach ($respuesta as $row => $item) {

                $i++;
                
                $cabecera = "";

                $idMenu = $item["id_menu"];
                $padre = $item["descripcion"];
                $icono = $item["icono"];

                $si = 0;
                $no = 1;

                $siM=0;
                $noM =1;

                $datosMenu = array("id_menu" => $idMenu,"id_rol"=>$rol);
                $permisoMenu = MenuModel::registroPermisoMenuModel($datosMenu,"detalle_menu");

                if(!empty($permisoMenu["id_detalle_m"])){

                    if($permisoMenu["acceso"] == 1){
                        $si = 1;
                        $no = 0;
                    }
                    
                }

                if(!empty($permisoMenu["id_detalle_m"])){

                    if($permisoMenu["mantenimiento"] == 1){
                        $siM=1;
                        $noM =0;
                    }
                }


                if($x<=1){
                    $cabecera ='
                        <div class="row text-center">
                            <div class="col-sm-offset-6 col-sm-3">Acceso</div>
                            <div class="col-sm-3">Mantenimiento</div>
                        </div>
                    ';
                }
            
                $contenido.= '

                    <div class="col-sm-6">
                        '.$cabecera.'<br>
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-sm-6 text-primary"><i class="'.$icono.'"></i> '.$padre.'</div>
                                    <div class="col-sm-3 text-center">
                                        <div id="padre_'.$idMenu.'" class="btn-group">
                                            <button type="button" onclick="clickPermiso('.$idMenu.',\'acceso\',1,0,'.$rol.')" class="btn btn-'.$classAcceso[$si].' btn-sm click">SI</button>
                                            <button type="button" onclick="clickPermiso('.$idMenu.',\'acceso\',0,0,'.$rol.')" class="btn btn-'.$classAcceso[$no].' btn-sm click">NO</button>
                                        </div>
                                    </div>
                                    <div class="col-sm-3 text-center">
                                        
                                    
                ';

                

                    $contenido .='
                                        <div id="mantenimiento_'.$idMenu.'" class="btn-group">
                                            <button type="button" onclick="clickPermiso('.$idMenu.',\'mantenimiento\',1,0,'.$rol.')" class="btn btn-'.$classMante[$siM].' btn-sm click">SI</button>
                                            <button type="button" onclick="clickPermiso('.$idMenu.',\'mantenimiento\',0,0,'.$rol.')" class="btn btn-'.$classMante[$noM].' btn-sm click">NO</button>
                                        </div>
                    ';
                

                $contenido .='
                                    </div>
                                </div>
                ';

                $respuestaSub = MenuModel::mostrarRegistrosSubMenuModel($idMenu,"sub_menu");

                if($respuestaSub != 0){

                    foreach ($respuestaSub as $row => $itemSub) {

                        $idSubM = $itemSub["id_sub_menu"];
                        $hijo = $itemSub["descripcion"];

                        $datos = array("id_sub_menu" => $idSubM,"id_rol"=>$rol);

                        $permiso = MenuModel::registroPermisoSubMenuModel($datos,"detalle_sub_m");

                        $siSub=0;
                        $noSub =1;

                        if(!empty($permiso["id_detalle_s"])){

                            if($permiso["acceso"]==1){
                                $siSub=1;
                                $noSub =0;
                            }
                            
                        }
                        
                        $contenido .= '

                                <br>
                                <div id="contenedor_hijo_'.$idSubM.'" class="col-sm-12">
                                    <div class="row">
                                        <div class=" col-sm-6"><span class="text-info">'.$hijo.'</span></div>
                                        <div class="col-sm-3 text-center">
                                            <div id="hijo_'.$idSubM.'" class="btn-group">
                                                <button type="button" onclick="clickPermiso('.$idMenu.',\'accesoSub\',1,'.$idSubM.','.$rol.')" class="btn btn-'.$classAcceso[$siSub].' btn-sm clicksub_si'.$idMenu.' click">SI</button>
                                                <button type="button" onclick="clickPermiso('.$idMenu.',\'accesoSub\',0,'.$idSubM.','.$rol.')" class="btn btn-'.$classAcceso[$noSub].' btn-sm clicksub_no'.$idMenu.' click">NO</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br>
                        ';
                    }
                }

                $contenido.= '
                            </div>
                        </div>
                    </div>
                ';

                if($i==2){

                    $salida .= '
                        <div class="row">
                            '.$contenido.'
                        </div>
                    ';

                    $contenido = "";
                    $i=0;

                }elseif($x==$reg){
                    $salida .= '
                        <div class="row">
                            '.$contenido.'
                        </div>
                    ';
                }

                $x++;
            
            }

        }else{

          $salida =  "No hay registros.";

        }

        echo $salida;

    }

    public static function darPermisoMenuController($datos){

        $bool = false;
        $contenido = "";
        $idMenu = $datos["id_menu"];
        $idDetalleMenu = 0;
        $rol = $datos["id_rol"];
        $prueba = "";

        $respuesta = MenuModel::registroPermisoMenuModel($datos,"detalle_menu");

        $si = 0;
        $no = 1;
        $classAcceso = array('0'=>'default','1'=>'primary');
        $classMante = array('0'=>'default','1'=>'success');

      
        if(!empty($respuesta["id_detalle_m"])){

            $idDetalleMenu = $respuesta["id_detalle_m"];

            $datos["id_detalle_m"] = $idDetalleMenu;

            if($datos["accion"] == "acceso"){
                
                //actualizar acceso

                $respuestaAcceso = MenuModel::actualizarPermisoAccesoMenuModel($datos,"detalle_menu");
            
                if($respuestaAcceso == "ok"){

                    $respuesta = MenuModel::registroPermisoMenuModel($datos,"detalle_menu");

                    if(!empty($respuesta["id_detalle_m"])){

                        if($respuesta["acceso"]==1){

                            $si = 1;
                            $no = 0;

                        }else{
                            //restringimos el acceso a todos los submenus cuando acceso=0
                            $respuestaSub = MenuModel::detallePermisosSubMenuModel($datos,"sub_menu AS s, detalle_sub_m AS d");

                            if(count($respuestaSub) > 0){

                                foreach ($respuestaSub as $row => $item) {
                                    
                                    $datos["id_detalle_s"] = $item[3];
                                    
                                    MenuModel::actualizarPermisoSubMenuModel($datos,"detalle_sub_m");

                                }

                            }else{
                                $prueba ="no hay";
                            }

                        }

                        $contenido ='
                            <button type="button" onclick="clickPermiso('.$idMenu.',\'acceso\',1,0,'.$rol.')" class="btn btn-'.$classAcceso[$si].' btn-sm click">SI</button>
                            <button type="button" onclick="clickPermiso('.$idMenu.',\'acceso\',0,0,'.$rol.')" class="btn btn-'.$classAcceso[$no].' btn-sm click">NO</button>
                        ';

                        $bool = true;

                    }

                }
                

            }else{
                
                //actualizar mantenimiento
                $respuestaMantenimiento = MenuModel::actualizarPermisoMantenimientoModel($datos,"detalle_menu");

                if($respuestaMantenimiento == "ok"){

                    $respuesta = MenuModel::registroPermisoMenuModel($datos,"detalle_menu");

                    if(!empty($respuesta["id_detalle_m"]) > 0){

                        if($respuesta["mantenimiento"]==1){
                            $si = 1;
                            $no = 0;
                        }

                        $contenido ='
                            <button type="button" onclick="clickPermiso('.$idMenu.',\'mantenimiento\',1,0,'.$rol.')" class="btn btn-'.$classMante[$si].' btn-sm click">SI</button>
                            <button type="button" onclick="clickPermiso('.$idMenu.',\'mantenimiento\',0,0,'.$rol.')" class="btn btn-'.$classMante[$no].' btn-sm click">NO</button>
                        ';

                        $bool = true;

                    }

                }
                

            }

        }else{
            //registrar acceso para rol
            if($datos["accion"] == 'acceso'){
               
                $respuesta = MenuModel::darPermisoAccesoMenuModel($datos,"detalle_menu");

                if($respuesta == "ok"){
                
                    $respuesta = MenuModel::registroPermisoMenuModel($datos,"detalle_menu");
                
                    if(!empty($respuesta["id_detalle_m"])){

                        if($respuesta["acceso"]==1){
                            $si = 1;
                            $no = 0;
                        }

                        $contenido ='
                            <button type="button" onclick="clickPermiso('.$idMenu.',\'acceso\',1,0,'.$rol.')" class="btn btn-'.$classAcceso[$si].' btn-sm click">SI</button>
                            <button type="button" onclick="clickPermiso('.$idMenu.',\'acceso\',0,0,'.$rol.')" class="btn btn-'.$classAcceso[$no].' btn-sm click">NO</button>
                        ';

                        $bool = true;

                    }
            
                }
            
                

            }else{
                
                //registramos mantenimiento
                $respuesta = MenuModel::darPermisoMantenimientoModel($datos,"detalle_menu");

                if($respuesta == "ok"){
                    
                    $respuesta = MenuModel::registroPermisoMenuModel($datos,"detalle_menu");

                    if(!empty($respuesta["id_detalle_m"])){

                        if($respuesta["mantenimiento"]==1){
                            $si = 1;
                            $no = 0;
                        }
                    
                        $contenido ='
                            <button type="button" onclick="clickPermiso('.$idMenu.',\'mantenimiento\',1,0,'.$rol.')" class="btn btn-'.$classMante[$si].' btn-sm click">SI</button>
                            <button type="button" onclick="clickPermiso('.$idMenu.',\'mantenimiento\',0,0,'.$rol.')" class="btn btn-'.$classMante[$no].' btn-sm click">NO</button>
                        ';

                        $bool = true;
                    

                    }

                }
                
            }
                   
        }
    
        $salidaJson = array("respuesta"=>$bool,
                        "contenido"=>$contenido);

        echo json_encode($salidaJson);

    }

    public static function darPermisoSubMenuController($datos){

        $bool = false;
        $contenido = "";

        $si = 0;
        $no = 1;
        $classAcceso = array('0'=>'default','1'=>'primary');

        $rol = $datos["id_rol"];
        $idMenu = $datos["id_menu"];
        $idSubM = $datos["id_sub_menu"];

        $respuesta = MenuModel::registroPermisoSubMenuModel($datos,"detalle_sub_m");

        if(!empty($respuesta["id_detalle_s"])){
            //actualizamos

            $datos["id_detalle_s"] = $respuesta["id_detalle_s"];
        
            $respuestaAcceso = MenuModel::actualizarPermisoSubMenuModel($datos,"detalle_sub_m");

            if($respuestaAcceso == "ok"){

                $permiso = MenuModel::registroPermisoSubMenuModel($datos,"detalle_sub_m");

                if(!empty($permiso["id_detalle_s"])){

                    if($permiso["acceso"] == 1){
                        $si = 1;
                        $no = 0;
                    }
                
                    $contenido = '
                        <button type="button" onclick="clickPermiso('.$idMenu.',\'accesoSub\',1,'.$idSubM.','.$rol.')" class="btn btn-'.$classAcceso[$si].' btn-sm clicksub_si'.$idMenu.' click">SI</button>
                        <button type="button" onclick="clickPermiso('.$idMenu.',\'accesoSub\',0,'.$idSubM.','.$rol.')" class="btn btn-'.$classAcceso[$no].' btn-sm clicksub_no'.$idMenu.' click">NO</button>
                    ';
                
                    $bool = true;
                }
                
            }else{
                $contenido ="aqui";
            }

        
        }else{
            //registramos

            $respuestaAcceso = MenuModel::darPermisoSubMenuModel($datos,"detalle_sub_m");

            if($respuestaAcceso=="ok"){

                $permiso = MenuModel::registroPermisoSubMenuModel($datos,"detalle_sub_m");

                if(!empty($permiso["id_detalle_s"]) > 0){

                    if($permiso["acceso"] == 1){
                        $si = 1;
                        $no = 0;
                    }
                
                    $contenido = '
                        <button type="button" onclick="clickPermiso('.$idMenu.',\'accesoSub\',1,'.$idSubM.','.$rol.')" class="btn btn-'.$classAcceso[$si].' btn-sm clicksub_si'.$idMenu.' click">SI</button>
                        <button type="button" onclick="clickPermiso('.$idMenu.',\'accesoSub\',0,'.$idSubM.','.$rol.')" class="btn btn-'.$classAcceso[$no].' btn-sm clicksub_no'.$idMenu.' click">NO</button>
                    ';
                
                    $bool = true;
                }

            }

        }

        $salidaJson = array("respuesta"=> $bool,
                            "contenido"=> $contenido);

        echo json_encode($salidaJson);

    }

    //ORDENAR
    public static function listaOrdenarMenuController(){

        $contenido = "";
        $reg = 0;
        $idMenu = 0;
        $padre = "";
        $icono = "";
        
        $reg = MenuModel::numRegistrosMenuModel("menu");

        $respuesta = MenuModel::mostrarRegistrosMenuModel("menu");

        if($reg > 0){

            foreach ($respuesta as $row => $item) {

                $idMenu = $item["id_menu"];
                $padre = $item["descripcion"];
                $icono = $item["icono"];
                $visible = $item["visible"];

                $contenido.='
                        <li id="'.$idMenu.'" class="bloque list-group-item bg-info">
                            <span class="handle"><i class="'.$icono.'"></i> '.$padre.'<span class="flecha" style="float:right;display:none"><i class="fas fa-arrows-alt"></i></span></span>
                        </li>
                    ';
                
 
            }

            $contenido = '
                <ul id="itemMenu" class="list-group">
                    '.$contenido.'
                </ul>
            ';

        }else{

          $contenido=  "No hay registros.";

        
        }

        echo $contenido;

    }

    public static function actualizarOrdenMenuController($datos){

        $respuesta = MenuModel::actualizarOrdenMenuModel($datos,"menu");

        echo $respuesta;

    }

    public static function listaOrdenarSubMenuController(){

        $contenido = "";
        $contenidoSub = '';
        $reg = 0;
        $regSub = 0;
        $idMenu = 0;
        $idSubMenu = 0;
        $padre = "";
        $hijo = "";
        $icono = "";
        $hide = 'style="display:none"';
        
        $reg = MenuModel::numRegistrosMenuModel("menu");

        $respuesta = MenuModel::mostrarRegistrosMenuModel("menu");

        if($reg > 0){

            foreach ($respuesta as $row => $item) {

                $idMenu = $item["id_menu"];
                $padre = $item["descripcion"];
                $icono = $item["icono"];
                $visible = $item["visible"];
                $contenidoSub ="";

                if($visible == 1){
                    $contenido.='
                        <li class="list-group-item bg-info">
                            <i class="'.$icono.'"></i> <span class="text-bold">'.$padre.'</span>
                    ';

                    //contenido submenu

                    $regSub = MenuModel::numRegistrosSubMenuModel($idMenu,"sub_menu");

                    if($regSub > 0){

                        $contenido.='<br><br>
                        ';

                        $respuestaSub = MenuModel::mostrarRegistrosSubMenuModel($idMenu,"sub_menu");

                        foreach ($respuestaSub as $row => $itemSub) {

                            $contenidoSub.='
                                <li id="sub'.$itemSub["id_sub_menu"].'" class="list-group-item bloqueSub'.$idMenu.'">
                                    <span class="handleSub'.$idMenu.' text-info">'.$itemSub["descripcion"].'<span class="flecha'.$idMenu.'" style="float:right;display:none"><i class="fas fa-arrows-alt"></i></span></span>
                                </li>
                            ';
                        }

                        $contenido .= '
                            <div class="row">
                                <ul id="itemSubMenu'.$idMenu.'" class="list-group col-sm-8">
                                    '.$contenidoSub.'
                                </ul>
                                <div class="col-sm-4">
                        
                        ';

                        if($regSub > 1){
                            $contenido .='
                                    <button type="button" data-menu="'.$idMenu.'" data-subMenu="'.$itemSub["id_sub_menu"].'" id="ordenarSub'.$idMenu.'" class="btn btn-warning ordenarSub">Ordenar Submenu</button>
                                    <button type="button" data-menu="'.$idMenu.'" id="guardarOrdenSub'.$idMenu.'" class="btn btn-primary guardarOrdenSub" style="display:none">Guardar Orden Submenu</button>
                            ';
                        }

                        $contenido .='
                                </div>
                            </div>
                        ';
                     }


                    $contenido .= '
                        </li>
                    ';
                }
 
            }

            $contenido = '
                <ul id="itemMenu" class="list-group">
                    '.$contenido.'
                </ul>
            ';

        }else{

          $contenido=  "No hay registros.";

        
        }

        echo $contenido;

    }


    public static function actualizarOrdenSubMenuController($datos){

        $respuesta = MenuModel::actualizarOrdenSubMenuModel($datos,"sub_menu");

        echo $respuesta;

    }

}