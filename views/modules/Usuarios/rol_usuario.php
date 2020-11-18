<?php

if(!$_SESSION["validar"]){

    header("location: index.php?action=ingreso");

    exit();

}

include 'views/modules/start-main-wrapper.php';
include 'views/modules/main-menu.php';

$enlaces = new Enlaces();

$mantenimiento = $enlaces->mantenimientoDatosController();

?>


<div id="content-wrapper">

    <div class="page-header">
        <h1 class="text-center text-left-sm">
            <?php $enlaces -> pageHeaderController();  //echo basename($_SERVER['QUERY_STRING']);?>
        </h1>
    </div>
    
    <div class="panel panel-default">

        <div class="panel-body">
            <div class="form-group">
                <button type="button" id="registrarRol" class="btn btn-primary">Registrar Rol Usuario</button>
            </div>
            
            <div class="panel panel-primary head_table">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-sm-6">
                            <h4>Registros Rol Usuario</h4>
                        </div>
                                
                        <div class="col-sm-2">
                            <h5 class="text-right">Por Pag.</h5>
                        </div>

                        <div class="col-sm-1">
                            <select id="por_pag" class="form-control">
                                <option value="10" selected="selected">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                        </div>
                        <div class="col-sm-3">
                            <input type="text" id="buscar_term" class="form-control" placeholder="Buscar ...">
                            <input type="hidden" id="mantenimiento" value="<?php echo $mantenimiento; ?>">
                        </div>
                    </div>
                </div>
            </div>
            
            <div id="contenidoRol" class="table-primary table-responsive">
                
            </div>

            <p id="loading" class="text-center" style="display:none;">
                <img src="views/images/loader5.gif"> <strong>Cargando...</strong>
            </p>
        </div>
            
        

    </div>

</div> <!-- / #content-wrapper -->

<div id="modalRol" class="modal fade" tabindex="-1" role="dialog" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">Registrar Rol Usuario</h4>
            </div>
            <div class="modal-body">
                <form id="formRolView" class="form-horizontal">
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
                    <input type="hidden" name="termRol" id="termRol" class="form-control" value="0" required>
                    <input type="hidden" name="oldNombreRol" id="oldNombreRol" value="" class="form-control" value="0" required>
                </form>
            </div> <!-- / .modal-body -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="button" id="guardarRolView" class="btn btn-primary">Guardar</button>
            </div>
        </div> <!-- / .modal-content -->
    </div> <!-- / .modal-dialog -->
</div> <!-- /.modal -->

<div id="modalInicio" class="modal fade" tabindex="-1" role="dialog" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Seleccionar Inicio de Pagina</h4>
            </div>
            <div class="modal-body">
                <form id="formRolView" class="form-horizontal">
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Rol Usuario</label>
                        <div class="col-sm-6">
                            <input name="rolInicio" id="rolInicio" class="form-control" type="text" readonly="readonly" required>
                        </div>
                    </div>
                    <div id="contenidoSelect" class="form-group">
                        <label class="col-sm-4 control-label">Pagina de Inicio</label>
                        <div class="col-sm-6">
                            <select class="form-control" id="pageInicio" name="pageInicio">
                                
                            </select>
                        </div>
                    </div>
                    <input type="hidden" name="termRolInicio" id="termRolInicio" class="form-control" value="0" required>
                </form>
            </div> <!-- / .modal-body -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
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