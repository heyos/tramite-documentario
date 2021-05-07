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
    <input type="hidden" class="mantenimiento" value="<?php echo $mantenimiento; ?>">
    <div class="page-header">
        <h1 class="text-center text-left-sm">
            <?php $enlaces -> pageHeaderController(); ?>
        </h1>
    </div>
    
    <div class="panel panel-default">

        <div class="panel-body">
            
            <div class="form-group">
              <a href="index.php?action=crear_documentos" class="btn btn-primary btn-registrar">Registrar Documento</a>
            </div>

            <div class="table-primary">
                <table class="table table-default table-condensed table-bordered table-striped tablaDocumento" width="100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Codigo</th>
                            <th>RUT Empresa</th>
                            <th>Nombre Empresa</th>
                            <th>RUT Paciente</th>
                            <th>Nombre Paciente</th>
                            <th>Tipo de Documento</th>
                            <th>Estado</th>
                            <th>Fecha Creacion</th>
                            <th width = "12%"></th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>

    </div>

</div> <!-- / #content-wrapper -->

<div id="modalUsuariosAsignados" class="modal fade" tabindex="-1" role="dialog" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close updateDatatable" data-dismiss="modal" data-keyboard="false" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">Lista de usuarios firmantes</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-5 text-center">
                        <label>Usuario</label>
                    </div>
                    <div class="col-sm-2 text-center">
                        <label>Firmado?</label>
                    </div>
                    <div class="col-sm-5 text-center">
                        <label>Fecha Firma</label>
                    </div>
                </div>
                <div id="contenido">
                    
                </div>
            </div>

            <div class="modal-footer">
                <!-- <button type="button" class="btn btn-default updateDatatable" data-dismiss="modal">Cerrar</button> -->
                <!-- <button type="button" id="guardarPersona" class="btn btn-primary">Guardar</button> -->
            </div>

        </div>
    </div>
</div>



<?php
include 'views/modules/end-main-wrapper.php';
?>