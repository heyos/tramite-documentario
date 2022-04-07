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
                            <input type="text" class="input-sm form-control calendar" id="fecha_fin" name="fecha_fin" 
                            placeholder="Fecha fin" value="<?php echo date('d-m-Y');?>" autocpmplete="off">
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label class="control-label">
                            <i class="fa fa-license-card"></i> Tipo Documento
                        </label>
                        <select name="tipoDoc" id="tipoDoc" class="form-control" required>
                            <option value="0" >Todos</option>
                            <?php
                                $respuesta = TipoDocumentoController::allData();

                                if($respuesta['respuesta']){
                                    foreach ($respuesta['contenido'] as $key => $item) {
                                        
                                        echo '<option value="'.$item['id'].'" >'.$item['descripcion'].'</option>';
                                    }
                                    
                                }
                            ?>     
                        </select>
                    </div>
                </div>

                <!-- <div class="col-md-3 hide">
                    <div class="form-group">
                        <label class="control-label">
                            <i class="fa fa-license-card"></i> Estado Documento
                        </label>
                        <select name="estadoDoc" id="estadoDoc" class="form-control" required>
                                            
                        </select>
                    </div>
                </div> -->
                <div class="form-group col-md-2">
                    <label>&nbsp;&nbsp;</label>
                    <div class="input-group">                    
                        <button type="button" id="buscar_documento" class="btn btn-success"> <i class="fa fa-search"></i></button>
                    </div>                                    
                </div>

                <div class="col-md-3 ">
                    <div class="form-group pull-right">
                        <label>&nbsp;&nbsp;</label>
                        <div class="input-group">                       
                            <button type="button" id="descarga_lote" class="btn btn-primary btn-block">
                                <i class="fa fa-download"></i> Descargar por Lote
                            </button>
                        </div>  
                    </div>
                                                          
                </div>
                
                
            </div>
            <br>
            <div class="table-primary">
                <table class="table table-default table-condensed table-bordered table-striped tablaDocumento" width="100%">
                    <thead>
                         <tr>
                            <th>#</th>
                            <th>RUT Empresa</th>
                            <th>Nombre Empresa</th>
                            <th>N° Doc. Paciente</th>
                            <th>Nombre Paciente</th>
                            <th>Tipo de Documento</th>
                            <th>Estado</th>
                            <th>Fecha Creacion</th>
                            <th class="align-middle">Check 
                                
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