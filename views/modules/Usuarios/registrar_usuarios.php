<?php

if(!$_SESSION["validar"]){

    header("location: index.php?action=ingreso");

    exit();

}

include 'views/modules/start-main-wrapper.php';
include 'views/modules/main-menu.php';

$enlaces = new Enlaces();

$nombres ='';
$apellidos = '';
$dni = '';
$telefono = '';
$datos = 0;
$usuario = '';
$required = "required";
$term = 0;

if(isset($_SESSION["termUsuario"])){

    $required = '';
    $term = GLOBALES::sanearData($_SESSION["termUsuario"]);

    $datosUsuario = new Usuario();
    $respuesta = $datosUsuario -> datosUsuarioController($term);

    $nombres = $respuesta["nombres"];
    $apellidos = $respuesta["apellidos"];
    $dni = $respuesta["dni"];
    $telefono = $respuesta["telefono"];
    $datos = $respuesta["rol"];
    $usuario = $respuesta["usuario"];
    

    unset($_SESSION["termUsuario"]);
}

?>


<div id="content-wrapper">
    
    <div class="page-header">
        <h1 class="text-center text-left-sm">
            <?php $enlaces -> pageHeaderController(); ?>
        </h1>
    </div>

    <!--<div style="position:fixed;top:70px;z-index:999998;right:0px;">
        <button type="button" class="btn btn-primary btn-redounded"><i class="fa fa-cogs"></i> Config</button>
    </div>-->
    
    <div class="panel panel-default">

        <div class="panel-body">

            <div class="row">
                <div class="col-sm-1"></div>
                <div class="col-sm-6">
                    <form id="formUsuario" class="form-horizontal">

                        <input name="term" id="term" class="form-control" type="hidden" value="<?php echo $term; ?>" required>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Nombres:</label>
                            <div class="col-sm-8">
                                <input name="nombre" id="nombre" class="form-control validarTexto" type="text" value="<?php echo $nombres; ?>" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Apellidos:</label>
                            <div class="col-sm-8">
                                <input name="apellidos" id="apellidos" class="form-control validarTexto" type="text" value="<?php echo $apellidos; ?>" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">DNI:</label>
                            <div class="col-sm-8">
                                <input name="dni" id="dni" class="form-control validarNum" minlength="8" maxlength="8" type="text" value="<?php echo $dni; ?>" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Telefono:</label>
                            <div class="col-sm-8">
                                <input name="telefono" id="telefono" class="form-control validarNum" value="<?php echo $telefono; ?>" type="text" >
                            </div>
                        </div>
                        <hr class="no-grid-gutter-h grid-gutter-margin-b no-margin-t">
                        
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Rol Usuario:</label>
                            <div class="col-sm-6">
                                <select id="rol_usuario" name="rol_usuario">
                                    <?php
                                        $rol = new RolUsuario();
                                        $rol -> selectOptionRolController($datos);
                                    ?>
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <button type="button" id="add_rol" class="btn btn-primary"><i class="fa fa-plus"></i></button>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Usuario:</label>
                            <div class="col-sm-8">
                                <input name="usuario" id="usuario" class="form-control validarTextoNum" type="text" autocomplete="off" value="<?php echo $usuario; ?>" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Contraseña:</label>
                            <div class="col-sm-8">
                                <input type="password" name="password" id="password" class="form-control validarTextoNum" autocomplete="off" <?php echo $required;?> >
                            </div>
                        </div>
                        <div class="form-group text-center">
                            <button type="button" id="guardar" class="btn btn-primary">Guardar</button>
                        </div>
                    </form>
                </div>
                <div class="col-sm-3"></div>
            </div>
            
                    

        </div>

    </div>

</div> <!-- / #content-wrapper -->

<div id="modalRol" class="modal fade" tabindex="-1" role="dialog" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel"></h4>
            </div>
            <div class="modal-body">
                <form id="formRol" class="form-horizontal">
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Rol Usuario</label>
                        <div class="col-sm-6">
                            <input name="nombreRol" id="nombreRol" class="form-control vacio validarTexto" type="text" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Mostrar Inicio</label>
                        <div id="checkbox" class="col-sm-6">
                            <input type="checkbox" id="mostrar_inicio" name="mostrar_inicio" value="1" data-class="switcher-success">
                        </div>
                    </div>
                    <input type="hidden" name="oldNombreRol" id="oldNombreRol" class="form-control" value="old" required>
                    <input type="hidden" name="termRol" id="termRol" class="form-control" value="0" required>
                </form>
            </div> <!-- / .modal-body -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="button" id="guardarRol" class="btn btn-primary">Guardar</button>
            </div>
        </div> <!-- / .modal-content -->
    </div> <!-- / .modal-dialog -->
</div> <!-- /.modal -->

<!--modal mensaje-->
<div id="modal-alert" class="modal modal-alert modal-success fade" style="display:none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <i id="icon-alert" class="fa fa-check-circle"></i>
            </div>
            <div id="alert-modal-title" class="modal-title">Some alert title</div>
            <div id="alert-modal-body" class="modal-body">Some alert text</div>
            <div class="modal-footer">
                <button id="btn-alert-modal" type="button" class="btn btn-success" data-dismiss="modal">OK</button>
            </div>
        </div> <!-- / .modal-content -->
    </div> <!-- / .modal-dialog -->
</div> <!-- / .modal -->

<?php
include 'views/modules/end-main-wrapper.php';
?>