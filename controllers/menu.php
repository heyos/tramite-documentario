<?php

class Menu{

    //VISTAS MENU

    public static function listarMainMenuController(){

        $rol = $_SESSION["rol"];
        $datos = $rol;
        //$datos = 1;

        echo '
                <li><a href="index.php?action=inicio"><i class="menu-icon fas fa-tachometer-alt"></i> <span class="mm-text">Inicio</span></a></li>
           ';

        $respuesta = MenuModels::detallePermisosMenuModel($datos,"detalle_menu AS d, menu AS m");

        if(count($respuesta) > 0){

            foreach ($respuesta as $row => $item) {

                $idMenu = $item[0];

                $menu = $item[1];
                $icono = $item[2];
                $url = ($item[3]=='#')?$item[3]:'index.php?action='.$item[3];
                $visible = $item[4];

                $datosController =  array("id_menu" => $idMenu, "id_rol"=>$datos);

                $respuestaSub = MenuModels::detallePermisosSubMenuModel($datosController,"sub_menu AS s, detalle_sub_m AS d");

                if(count($respuestaSub) > 0 && $visible == "1"){

                    echo '
                        <li class="mm-dropdown">
                            <a href="'.$url.'"><i class="menu-icon '.$icono.'"></i> <span class="mm-text">'.$menu.'</span></a>
                            <ul>
                    ';

                    foreach ($respuestaSub as $row => $item) {

                        $sub = $item[1];
                        $url = 'index.php?action='.$item[2];
                        
                        echo '
                                <li>
                                    <a tabindex="-1" href="'.$url.'"><span class="mm-text">'.$sub.'</span></a>
                                </li>
                        ';
                    }


                    echo'
                            </ul>
                        </li>
                    ';

                }else if($visible == "1"){
                    echo '
                        <li><a href="'.$url.'"><i class="menu-icon '.$icono.'"></i> <span class="mm-text">'.$menu.'</span></a></li>
                   ';
                }

                
            }

        }else{
            
            echo '
                <li>
                    <a href="#"><i class="menu-icon far fa-eye-slash"></i><span class="mm-text">No hay elementos</span></a>
                </li>';
        }

    }

    public static function listarNavBarMenuController(){

        $rol = $_SESSION["rol"];
        $datos = $rol;
        $action = Globales::sanearData($_GET["action"]);
        
        $datosIdMenu = array("id_rol"=>$rol,"url"=>$action);
        $idMenuActive = self::returnActiveMenuController($datosIdMenu);
        $active = "";
        $activeExtra = 0;

        $contenido = '';
        $salida = '';
        $extra = '';
        $salidaExtra = '';

        $num = 0;

        $respuesta = MenuModels::detallePermisosMenuModel($datos,"detalle_menu AS d, menu AS m");

        if(count($respuesta) > 0){

            foreach ($respuesta as $row => $item) {

                $idMenu = $item[0];

                $menu = $item[1];
                $icono = $item[2];
                $url = ($item[3]=='#')?$item[3]:'index.php?action='.$item[3];
                $visible = $item[4];

                $active = ($idMenu == $idMenuActive)?"active":"";

                $datosController =  array("id_menu" => $idMenu, "id_rol"=>$datos);

                $respuestaSub = MenuModels::detallePermisosSubMenuModel($datosController,"sub_menu AS s, detalle_sub_m AS d");

                if(count($respuestaSub) > 0 && $visible == "1"){

                    if($num < 8){

                        $salida .= '
                            <li class="'.$active.'">
                                <a href="'.$url.'" class="dropdown-toggle" data-toggle="dropdown"><i class="'.$icono.'"></i> '.$menu.' <i class="fas fa-caret-down"></i></a>
                                <ul class="dropdown-menu multi-level">
                        ';

                        foreach ($respuestaSub as $row => $item) {

                            $sub = $item[1];
                            $url = 'index.php?action='.$item[2];
                            
                            $salida .= '
                                    <li>
                                        <a href="'.$url.'">'.$sub.'</a>
                                    </li>
                            ';
                        }

                        $salida.='
                                </ul>
                            </li>
                        ';

                    }else{

                        if($idMenu == $idMenuActive){
                            $activeExtra = 1;
                        }

                        $extra .= '
                            <li class="dropdown-submenu">
                                <a href="'.$url.'" class="dropdown-toggle" data-toggle="dropdown"><i class="'.$icono.'"></i> '.$menu.'</a>
                                <ul class="dropdown-menu">
                        ';

                        foreach ($respuestaSub as $row => $item) {

                            $sub = $item[1];
                            $url = 'index.php?action='.$item[2];
                            
                            $extra .= '
                                    <li>
                                        <a href="'.$url.'">'.$sub.'</a>
                                    </li>
                            ';
                        }


                        $extra.='
                                </ul>
                            </li>
                        ';
                    }

                        

                }else if($visible == "1"){

                    if($num < 8){
                        $salida.= '
                            <li class="'.$active.'"><a href="'.$url.'"><i class="'.$icono.'"></i><span class="mm-text"> '.$menu.'</span></a></li>
                       ';
                    }else{

                        if($idMenu == $idMenuActive){
                            $activeExtra = 1;
                        }

                        $extra.= '
                            <li><a href="'.$url.'"><i class="'.$icono.'"></i><span class="mm-text"> '.$menu.'</span></a></li>
                       ';
                    }    
                }

                $num++;
                
            }

            if($num > 7){

                $active = ($activeExtra==1)?"active":"";

                $salidaExtra = '
                    <li class="dropdown '.$active.'">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fas fa-plus"></i> Mas Opciones <i class="fas fa-caret-down"></i></a>
                        <ul class="dropdown-menu  multi-level">
                            '.$extra.'
                        </ul>
                    </li>
                    
                ';
            }



        }else{
            
            $salida = '
                <li>
                    <a href="#"><i class="far fa-eye-slash"></i> No hay elementos</a>
                </li>';
        }

        

        $contenido ='
            <ul class="nav navbar-nav">
                '.$salida.
                $salidaExtra.'
            </ul>
        ';

        echo $contenido;

    }

    public static function returnActiveMenuController($datos){

        $idMenu = 0;

        //validar acceso a menu que no tiene submenu
        $respuesta = EnlacesModels::enlaceMenuModel($datos,"detalle_menu AS d, menu AS m");

        if(!empty($respuesta[0])){
            $idMenu = $respuesta[0];
        }else{

            //acceso sub menu
            $respuesta = EnlacesModels::enlaceSubModel($datos,"sub_menu AS s, detalle_sub_m AS d");

            if(!empty($respuesta[0])){

                $idMenu = $respuesta[1];

            }
        }

        return $idMenu;

    }

    //VISUALIZAR DATOS MENU

    public static function mostrarSelectMenuController(){

        $contenido = '';

        $respuesta = MenuModels::mostrarRegistrosMenuModel("menu");

        if(count($respuesta) > 0){

            foreach ($respuesta as $row => $item) {

                $idMenu = $item["id_menu"];

                $verificarSub = MenuModels::mostrarRegistrosSubMenuModel($idMenu,"sub_menu");

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

    public static function mostrarSelectPermisosMenuController($datos){

        $contenidoOk = "";
        $respuestaOk =  true;

        $contenidoMenu = "";
        $contenidoSub = "";

        $contenidoMenu = '<option value="inicio">Inicio</option>';

        $respuesta = MenuModels::detallePermisosMenuModel($datos,"detalle_menu AS d, menu AS m");

        if(count($respuesta) > 0){

            foreach ($respuesta as $row => $item) {

                $idMenu = $item[0];
                $menu = $item[1];
                $url = $item[3];
                $visible = $item[4];

                $datosController =  array("id_menu" => $idMenu, "id_rol"=>$datos);

                $respuestaSub = MenuModels::detallePermisosSubMenuModel($datosController,"sub_menu AS s, detalle_sub_m AS d");

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

    //ORDENAR MENU SUB MENU
    public static function listaOrdenarMenuController(){

        $contenido = "";
        $reg = 0;
        $idMenu = 0;
        $padre = "";
        $icono = "";
        
        $reg = MenuModels::numRegistrosMenuModel("menu");

        $respuesta = MenuModels::mostrarRegistrosMenuModel("menu");

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
        
        $reg = MenuModels::numRegistrosMenuModel("menu");

        $respuesta = MenuModels::mostrarRegistrosMenuModel("menu");

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

                    $regSub = MenuModels::numRegistrosSubMenuModel($idMenu,"sub_menu");

                    if($regSub > 0){

                        $contenido.='<br><br>
                        ';

                        $respuestaSub = MenuModels::mostrarRegistrosSubMenuModel($idMenu,"sub_menu");

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

    public static function actualizarOrdenMenuController($datos){

        $respuesta = MenuModels::actualizarOrdenMenuModel($datos,"menu");

        echo $respuesta;

    }

    public static function actualizarOrdenSubMenuController($datos){

        $respuesta = MenuModels::actualizarOrdenSubMenuModel($datos,"sub_menu");

        echo $respuesta;

    }
    
    //PERMISOS MENU - SUBMENU
    public static function permisosMenuController(){

        $error = 0;

        if(isset($_GET["term"]) && !empty($_GET["term"])){

            $rol = Globales::sanearData($_GET["term"]);

            $where = sprintf(" id_rol = '%d' AND ",$rol);
            $verificar = RolUsuarioModel::datosRolModel($where,"rol_usuario");

            if(!empty($varificar["id_rol"])){

                $error = 0;

            }

        }else{

            $error = 1;
            
        }

        $contenido = "";
        $contenidoSub = "";
        $salida ="";
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

        $reg = MenuModels::numRegistrosMenuModel("menu");

        $respuesta = MenuModels::mostrarRegistrosMenuModel("menu");

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
                $permisoMenu = MenuModels::registroPermisoMenuModel($datosMenu,"detalle_menu");

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

                $respuestaSub = MenuModels::mostrarRegistrosSubMenuModel($idMenu,"sub_menu");

                if($respuestaSub != 0){

                    foreach ($respuestaSub as $row => $itemSub) {

                        $idSubM = $itemSub["id_sub_menu"];
                        $hijo = $itemSub["descripcion"];

                        $datos = array("id_sub_menu" => $idSubM,"id_rol"=>$rol);

                        $permiso = MenuModels::registroPermisoSubMenuModel($datos,"detalle_sub_m");

                        $siSub=0;
                        $noSub =1;

                        if(!empty($permiso["id_detalle_s"])){ //verificamos que tiene permiso de acceso

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

        $respuesta = MenuModels::registroPermisoMenuModel($datos,"detalle_menu");

        $si = 0;
        $no = 1;
        $classAcceso = array('0'=>'default','1'=>'primary');
        $classMante = array('0'=>'default','1'=>'success');

        if(!empty($respuesta["id_detalle_m"])){

            $idDetalleMenu = $respuesta["id_detalle_m"];

            $datos["id_detalle_m"] = $idDetalleMenu;

            if($datos["accion"] == "acceso"){

                //actualizar acceso

                $respuestaAcceso = MenuModels::actualizarPermisoAccesoMenuModel($datos,"detalle_menu");

                if($respuestaAcceso == "ok"){

                    $respuesta = MenuModels::registroPermisoMenuModel($datos,"detalle_menu");

                    if(!empty($respuesta["id_detalle_m"])){

                        if($respuesta["acceso"]==1){

                            $si = 1;
                            $no = 0;

                        }else{
                            //restringimos el acceso a todos los submenus cuando acceso=0
                            $respuestaSub = MenuModels::detallePermisosSubMenuModel($datos,"sub_menu AS s, detalle_sub_m AS d");

                            if(count($respuestaSub) > 0){

                                foreach ($respuestaSub as $row => $item) {
                                    
                                    $datos["id_detalle_s"] = $item[3];
                                    
                                    MenuModels::actualizarPermisoSubMenuModel($datos,"detalle_sub_m");

                                }

                            }

                        }

                        $contenido ='
                            <button type="button" onclick="clickPermiso('.$idMenu.',\'acceso\',1,0,'.$rol.')" class="btn btn-'.$classAcceso[$si].' btn-sm click">SI</button>
                            <button type="button" onclick="clickPermiso('.$idMenu.',\'acceso\',0,0,'.$rol.')" class="btn btn-'.$classAcceso[$no].' btn-sm click">NO</button>
                        ';

                        $bool = true;

                    }

                }

                //$contenido = $respuestaAcceso;

            }else{
                //actualizar mantenimiento
                $respuestaMantenimiento = MenuModels::actualizarPermisoMantenimientoModel($datos,"detalle_menu");

                if($respuestaMantenimiento == "ok"){

                    $respuesta = MenuModels::registroPermisoMenuModel($datos,"detalle_menu");

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

        }else{
            //registrar acceso para rol
            if($datos["accion"] == 'acceso'){

                $respuesta = MenuModels::darPermisoAccesoMenuModel($datos,"detalle_menu");

                if($respuesta == "ok"){
                    
                    $respuesta = MenuModels::registroPermisoMenuModel($datos,"detalle_menu");

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
                $respuesta = MenuModels::darPermisoMantenimientoModel($datos,"detalle_menu");
            
                if($respuesta == "ok"){
                    
                    $respuesta = MenuModels::registroPermisoMenuModel($datos,"detalle_menu");

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

        //echo $contenido;

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

        $respuesta = MenuModels::registroPermisoSubMenuModel($datos,"detalle_sub_m");

        if(!empty($respuesta["id_detalle_s"])){
            //actualizamos

            $datos["id_detalle_s"] = $respuesta["id_detalle_s"];
        
            $respuestaAcceso = MenuModels::actualizarPermisoSubMenuModel($datos,"detalle_sub_m");

            if($respuestaAcceso == "ok"){

                $permiso = MenuModels::registroPermisoSubMenuModel($datos,"detalle_sub_m");

                if(!empty($permiso["acceso"])){

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

            $respuestaAcceso = MenuModels::darPermisoSubMenuModel($datos,"detalle_sub_m");

            if($respuestaAcceso=="ok"){

                $permiso = MenuModels::registroPermisoSubMenuModel($datos,"detalle_sub_m");

                if(!empty($permiso["acceso"])){

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


    

    
}

