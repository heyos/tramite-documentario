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
            
            <div class="form-group">
                <button type="button" class="btn btn-primary btn-registrar">Asignar Firma</button>
            </div>

            <div class="table-primary">
                <table class="table table-default table-condensed table-bordered table-striped tablaAsignacionFirma" width="100%">
                    <thead>
                        <tr>
                            <th style="width:5% !important">#</th>
                            <th style="width:30% !important">Usuario</th>
                            <th style="width:20% !important">Logo</th>
                            <th style="width:20% !important">Certificado</th>
                            <th style="width:25% !important"></th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>

        </div>

    </div>

</div> <!-- / #content-wrapper -->

<!-- MODAL ASIGNAR FIRMA -->
<div id="modalReg" class="modal fade" tabindex="-1" role="dialog" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel"></h4>
            </div>
            <div class="modal-body">
                <form id="formAsigFirma" class="form">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label">Usuarios</label>
                                        <select name="usuario" id="usuario" class="form-control" required>
                                            
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label">Clave</label>
                                        <input type="text" name="clave" value="clave" class="form-control" placeholder="Ingrese la clave">                                    
                                    </div>
                                </div>
                            </div>
                             <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label">Imagen</label>
                                        <input id="imagen" name="imagen" type="file" multiple="" />
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label">Certificado</label>
                                        <input id="certificado" name="certificado" type="file" multiple="" />                                  
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    
                    <input type="hidden" name="id" id="id" class="form-control" value="0" required>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="button" id="guardar" class="btn btn-primary">Guardar</button>
            </div>
        </div>
    </div>
</div>


<?php
include 'views/modules/end-main-wrapper.php';
?>