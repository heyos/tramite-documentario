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
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label">
                            <i class="fa fa-calendar"></i>&nbsp;&nbsp; Rango de Fecha: 
                        </label>
                        <div class="input-daterange input-group" id="bs-datepicker-range">
                            <input type="text" class="input-sm form-control calendar" id="fecha_inicio" name="fecha_inicio" placeholder="Fecha inicio" value="<?php echo date('d-m-Y');?>" autocpmplete="off">
                            <span class="input-group-addon">hasta</span>
                            <input type="text" class="input-sm form-control calendar" id="fecha_fin" name="fecha_fin" placeholder="Fecha fin" autocpmplete="off">
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label class="control-label">
                            <i class="fa fa-license-card"></i> Tipo Documento
                        </label>
                        <select name="tipoDoc" id="tipoDoc" class="form-control" required>
                                            
                        </select>
                    </div>
                </div>

                <div class="col-md-3 hide">
                    <div class="form-group">
                        <label class="control-label">
                            <i class="fa fa-license-card"></i> Estado Documento
                        </label>
                        <select name="estadoDoc" id="estadoDoc" class="form-control" required>
                                            
                        </select>
                    </div>
                </div>

                <div class="form-group col-sm-offset-3 col-md-2 ">
                    <label>&nbsp;&nbsp;</label>
                    <div class="input-group">                       
                        <button type="button" id="firma_lote" class="btn btn-primary"><i class="fa fa-download"></i> Descargar por Lote</button>
                    </div>                                    
                </div>
                
                
            </div>
            <br>
            <div class="table-primary">
                <table class="table table-default table-condensed table-bordered table-striped tablaDocumento" width="100%">
                    <thead>
                        <tr>
                            <th width="5%"> 
                                
                                    <label class="px-single" >
                                        <input type="checkbox" name="" value="" class="px">
                                        <span class="lbl"></span>
                                    </label>
                                
                            </th>
                            <th width="3%">#</th>
                            <th width="10%">RUT Empresa</th>
                            <th width="15%">Nombre Empresa</th>
                            <th width="10%">RUT Paciente</th>
                            <th width="17%">Nombre Paciente</th>
                            <th width="15%">Tipo de Documento</th>
                            <th width="12%">Estado</th>
                            
                            <th width="10%"></th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>

        </div>

    </div>

</div> <!-- / #content-wrapper -->



<?php
include 'views/modules/end-main-wrapper.php';
?>