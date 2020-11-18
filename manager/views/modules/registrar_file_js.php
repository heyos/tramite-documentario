<?php


include 'views/modules/start-main-wrapper.php';
include 'views/modules/main-menu.php';

$enlaces = new Enlaces();

?>


<div id="content-wrapper">

    <div class="page-header">
        <h1 class="text-center text-left-sm">
            <i class="fa fa-sitemap page-header-icon"></i> <?php $enlaces -> titlePageController(); ?>
        </h1>
    </div>

    <div class="panel panel-default">

        <div class="panel-body">

            <button type="button" id="open-modalFile" class="btn btn-primary">Agregar FileJS</button>
            <hr>

            <div class="panel panel-primary head_table">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-sm-6">
                            <h4>Registros File JS</h4>
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
                            <input type="text" id="buscar_term" class="form-control validarTextoBus" placeholder="Buscar ...">
                        </div>
                    </div>
                </div>
            </div>
            
            <div id="contenidoFile" class="table-primary table-responsive">
                
            </div>

            <p id="loading" class="text-center" style="display:none;">
                <img src="views/images/loader5.gif"> <strong>Cargando...</strong>
            </p>

            
        </div>

    </div>

</div> <!-- / #content-wrapper -->

<!--modal mensaje-->
<div id="modal-alert" role="dialog" tabindex="-1" style="z-index:100000;" class="modal modal-alert modal-success fade" style="display:none;">
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

<!--modal registrar filejs-->
<div id="modalFile" class="modal fade" tabindex="-1" role="dialog" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="titleModal">Actualizar File</h4>
            </div>
            <div class="modal-body">
                
                <form id="formFile" class="form-horizontal">
                    <input name="accion" id="accion" class="form-control" type="hidden" value="0" required>
                    <input name="termFile" id="termFile" class="form-control" type="hidden" value="0" required>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Nombre File:</label>
                        <div class="col-sm-6">
                            <input name="fileJs" id="fileJs" class="form-control validarTextoBus" type="text" required>
                        </div>
                        <input name="oldFileJs" id="oldFileJs" class="form-control validarTextoBus" type="hidden" value="old.js" required>
                    </div>
                    
                </form>
            </div> <!-- / .modal-body -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="button" id="btn-saveFile" class="btn btn-primary">Guardar</button>
            </div>
        </div> <!-- / .modal-content -->
    </div> <!-- / .modal-dialog -->
</div> <!-- /.modal -->


<?php
include 'views/modules/end-main-wrapper.php';
?>