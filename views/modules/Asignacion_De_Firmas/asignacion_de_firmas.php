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

    <input type="hidden" class="mantenimiento" value="<?php echo $mantenimiento; ?>">
    
    <div class="panel panel-default">

        <div class="panel-body">
            
            <!-- <div class="form-group">
                <button type="button" class="btn btn-primary btn-registrar">Asignar Firma</button>
            </div> -->

            <div class="table-primary">
                <table class="table table-default table-condensed table-bordered table-striped tablaAsignacionFirma" width="100%">
                    <thead>
                        <tr>
                            <th style="width:5% !important">#</th>
                            <th style="width:35% !important">Nombres y Apellidos</th>
                            <th style="width:20% !important">Usuario</th>
                            <th style="width:10% !important">Rol</th>
                            <th style="width:10% !important">Firma</th>
                            <th style="width:10% !important">Certificado</th>
                            <th style="width:10% !important"></th>
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
                    <input type="" name="id_usuario" id="id_usuario" >
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label">Usuario</label>
                                        <input type="text" class="form-control" name="username" id="username" readonly>
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
                                        <label class="control-label">Imagen</label><br>
                                        <input id="digital" name="digital" type="file" style="display: none;">
                                        <div class="btn-group">
                                            <button type="button" open_click="digital" class="btn btn-success cargar">
                                                <i class="fas fa-file-upload"></i> Adjuntar
                                            </button>
                                            <button type="button" limpiar="digital" style="display: none;" class="btn btn-danger quitar">
                                                <i class="fas fa-window-close"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <img id="contenedor-img" class="img-responsive" width="80" height="80" src="views/images/firma-default.png">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="control-label">Certificado</label><br>
                                        <input id="ctr" name="ctr" type="file" style="display: none;">
                                        <div class="btn-group">
                                            <button type="button" open_click="ctr" class="btn btn-success cargar">
                                                <i class="fas fa-file-upload"></i> Adjuntar
                                            </button>
                                            <button type="button" limpiar="ctr" style="display: none;" class="btn btn-danger quitar">
                                                <i class="fas fa-window-close"></i>
                                            </button>
                                        </div>                                  
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