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
                <button type="button" class="btn btn-primary">Firmar documentos por lote</button>
            </div>
            <br>
            <div class="table-primary">
                <table class="table table-default table-condensed table-bordered table-striped tablaDocumento" width="100%">
                    <thead>
                        <tr>
                            <th width="3%">#</th>
                            <th width="10%">RUT Empresa</th>
                            <th width="15%">Nombre Empresa</th>
                            <th width="10%">RUT Paciente</th>
                            <th width="17%">Nombre Paciente</th>
                            <th width="15%">Tipo de Documento</th>
                            <th width="12%">Estado</th>
                            <th width="7%" class="align-middle">Check 
                                
                                    <label class="px-single" >
                                        <input type="checkbox" name="" value="" class="px">
                                        <span class="lbl"></span>
                                    </label>
                                
                            </th>
                            <th width="10%"></th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>

        </div>

    </div>

</div> <!-- / #content-wrapper -->

<div id="modalFirma" class="modal fade" tabindex="-1" role="dialog" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close updateDatatables" data-dismiss="modal" data-keyboard="false" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">Firmar Documento Digitalmente</h4>
            </div>
            <div class="modal-body">
                
                <form id="form-firma" class="form-horizontal">
                    <input type="" id="id" name="id">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Clave</label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <input name="name" id="name" class="form-control" type="text" required="">
                                <div class="input-group-btn">
                                    <button type="button" id="firmar" class="btn btn-success">Firmar Digitalmente</button>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </form>

                <p>
                    <div class="form-group">
                        <div class="row vertical-align">
                            <div id="txt_response" class="col-sm-12 text-center" style="display: none;">
                                <img src="views/images/loader5.gif" width="100px">
                                <strong>Proceso de firma digital en marcha</strong>
                            </div>
                        </div>
                    </div>
                </p>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default updateDatatable" data-dismiss="modal">Cerrar</button>
                <button type="button" id="guardarPersona" class="btn btn-primary">Guardar</button>
            </div>

        </div>
    </div>
</div>

<?php
include 'views/modules/end-main-wrapper.php';
?>