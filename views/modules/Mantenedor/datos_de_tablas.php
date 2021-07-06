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
            <?php $enlaces -> pageHeaderController(); ?>
        </h1>
    </div>
    
    <div class="panel panel-default">

        <div class="panel-body">

            <div class="row">
                <label class="col-sm-3 text-center">Seleccionar Tabla</label>
                <div class="col-sm-3"></div>
            </div>
            <div class="row">
                <div class="col-sm-3 col-xs-12">
                    <select class="form-control" id="tbl">
                        <?php
                            echo TablaLogica::mostrarSelectOptionTablaController();
                        ?>                        
                    </select>
                </div>
                <div class="col-sm-3 col-xs-12">
                    <div class="btn-group text-center">
                        <button type="button" id="openModalTabla" class="btn btn-primary"> <i class="fa fa-plus"></i> Ingresar Registro</button>
                        <button type="button" id="exportarExcel" class="btn btn-success"> <i class="far fa-file-excel"></i> Exportar a Excel</button>
                    </div>
                    
                </div>
            </div>
            <br>
            
            <div class="panel panel-primary head_table">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-sm-6">
                            <h4>Lista de Registros</h4>
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
            
            <div id="contenidoDatosTabla" class="table-primary table-responsive">
                
            </div>

            <p id="loading" class="text-center" style="display:none;">
                <img src="views/images/loader5.gif"> <strong>Cargando...</strong>
            </p>

        </div>

    </div>

</div> <!-- / #content-wrapper -->

<div id="modalTabla" class="modal fade" tabindex="-1" role="dialog" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">Registrar Tabla</h4>
            </div>
            <div class="modal-body">
                <form id="formTabla" class="form-horizontal">
                    <div class="form-group">
                        <input name="cidtabla" id="cidtabla" class="form-control validarTexto" type="hidden">
                        <input name="accion" id="accion" class="form-control" type="hidden" value="add">
                    </div>
                    
                    <fieldset id="inputs"></fieldset>
                    
                </form>
            </div> <!-- / .modal-body -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="button" id="guardarTabla" class="btn btn-primary">Guardar</button>
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