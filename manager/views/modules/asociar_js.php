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
            
            <div class="row">
                <div class="col-sm-4">
                    <form id="formFileJs" class="form-horizontal">
                        <div class="panel panel-primary" style="border-color:#428bca !important">
                            <div class="panel-heading">
                                <span class="panel-title" style="color:#fff">Menu</span>
                            </div>
                            <div class="panel-body">
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Descripcion:</label>
                                    <div class="col-sm-8">
                                        <select name="menuSelect" id="menuSelect" class="form-control" required>
                                            <?php
                                                $select = new Menu();
                                                $select -> mostrarSelectMenuController();
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                
                            </div>
                        </div>

                        <div class="panel panel-primary" style="border-color:#428bca !important">
                            <div class="panel-heading">
                                <span class="panel-title" style="color:#fff">Archivos JS Asociados</span>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-sm-7">
                                        <div class="form-group no-margin-hr">
                                            <label class="control-label">File</label>
                                        </div>
                                    </div>
                                    
                                    <div id="add" class="col-sm-1">
                                        <button id="add-js" class="btn btn-primary" type="button" ><i class="fa fa-plus"></i></button>
                                    </div>                            
                                </div>
                                <div id="divJs">
                                    
                                </div>
                            </div>
                        </div>

                        <div class="form-group text-center">
                            <button type="button" id="guardarMenuJs" class="btn btn-primary">Guardar</button>
                        </div>

                    </form>
                    
                </div>

                <div class="col-sm-8">

                    <div class="panel panel-primary" style="border-color:#428bca !important">
                        <div class="panel-heading">
                            <span class="panel-title" style="color:#fff">Estructura Files JS : <strong id="textMenu"></strong> </span>
                        </div>
                        <div id="divEstructuraMenuJs" class="panel-body">
                            <div class="table-primary table-responsive">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>File Js</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody id="listadoJsOk">
                                        
                                    </tbody>
                                </table>
                            </div>
                            
                        </div>
                    </div>
                    
                </div>
            </div>

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

<!--modal actualizar menu-->
<div id="modalFile" class="modal fade" tabindex="-1" role="dialog" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Actualizar File</h4>
            </div>
            <div class="modal-body">
                
                <form id="formActualizarFile" class="form-horizontal">
                    <input name="termFile" id="termFile" class="form-control" type="hidden" value="0" required>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Nombre File:</label>
                        <div class="col-sm-6">
                            <input name="actualizarFileJs" id="actualizarFileJs" class="form-control validarUrl" type="text" required>
                        </div>
                        <input name="oldFileJs" id="oldFileJs" class="form-control validarUrl" type="hidden" required>
                    </div>
                    
                </form>
            </div> <!-- / .modal-body -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="button" id="btn-actualizarFile" class="btn btn-primary">Actualizar</button>
            </div>
        </div> <!-- / .modal-content -->
    </div> <!-- / .modal-dialog -->
</div> <!-- /.modal -->


<?php
include 'views/modules/end-main-wrapper.php';
?>