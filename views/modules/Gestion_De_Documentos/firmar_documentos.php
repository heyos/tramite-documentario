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
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label">
                            <i class="fa fa-calendar"></i>&nbsp;&nbsp; Rango de Fechas: 
                        </label>
                        <div class="input-daterange input-group" id="bs-datepicker-range">
                            <input type="text" class="input-sm form-control calendar" id="fecha_inicio" name="fecha_inicio" placeholder="Fecha inicio" value="<?php echo date('d-m-Y');?>" autocpmplete="off">
                            <span class="input-group-addon">hasta</span>
                            <input type="text" class="input-sm form-control calendar" id="fecha_fin" name="fecha_fin" 
                            placeholder="Fecha fin" value="<?php echo date('d-m-Y');?>" autocpmplete="off">
                        </div>
                    </div>
                </div>

                <div class="col-md-2">
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

                <div class="col-md-2">
                    <div class="form-group">
                        <label class="control-label">
                            <i class="fa fa-license-card"></i> Estado Documento
                        </label>
                        <select name="estadoDoc" id="estadoDoc" class="form-control" required>
                            <option value="4" >Todos</option>
                            <?php
                                $estado = isset($_SESSION['estadoDocumento']) ? $_SESSION['estadoDocumento'] : '';
                                $selected = '';

                                $respuesta = EstadoDocumentoController::allData();

                                if($respuesta['respuesta']){
                                    foreach ($respuesta['contenido'] as $item) {
                                        $selected = $item['id'] == $estado ? 'selected' : '';
                                        echo '<option value="'.$item['id'].'" '.$selected.' >'.$item['descripcion'].'</option>';
                                    }
                                    
                                }

                                unset($_SESSION['estadoDocumento']);
                            ?>
                        </select>
                    </div>
                </div>

                <div class="form-group col-md-2">
                    <label>&nbsp;&nbsp;</label>
                    <div class="input-group">                    
                        <button type="button" id="buscar_documento" class="btn btn-success"> <i class="fa fa-search"></i></button>
                    </div>                                    
                </div>

                <div class="form-group col-md-2">
                    
                    <div class="form-group pull-right">
                        <label>&nbsp;&nbsp;</label>
                        <div class="input-group">                       
                            <button type="button" id="firma_lote" class="btn btn-primary">Firmar documentos lote</button>
                        </div>  
                    </div>                               
                </div>
            </div>
            <br>
            <div class="table-primary">
                <table class="table table-default table-condensed table-bordered table-striped tablaDocumento" width="100%">
                    <thead>
                        <!-- <tr>
                            <th width="3%">#</th>
                            <th width="9%">RUT Empresa</th>
                            <th width="15%">Nombre Empresa</th>
                            <th width="9%">RUT Paciente</th>
                            <th width="15%">Nombre Paciente</th>
                            <th width="12%">Tipo de Documento</th>
                            <th width="10%">Estado</th>
                            <th width="9%">Fecha Creacion</th>
                            <th width="7%" class="align-middle">Check 
                                
                                <label class="px-single" >
                                    <input type="checkbox" name="" value="" class="px">
                                    <span class="lbl"></span>
                                </label>
                                
                            </th>
                            <th width="10%"></th>
                        </tr> -->
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
                            <th width="12%"></th>
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
                <button type="button" class="close updateDatatable" data-dismiss="modal" data-keyboard="false" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">Confirmar</h4>
            </div>
            <div class="modal-body">
                
                <form id="form-firma" class="form-horizontal">
                    <input type="hidden" id="id" name="id" required>
                    <!-- <div class="form-group">
                        <label class="col-sm-2 control-label">Clave</label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <input name="name" id="name" class="form-control" type="text" required="">
                                <div class="input-group-btn">
                                    <button type="button" id="firmar" class="btn btn-success">Firmar Digitalmente</button>
                                </div>
                            </div>
                            
                        </div>
                    </div> -->
                    <div class="text-center">
                        <strong>Desea firmar digitalmente el(los) documento(s) ?</strong>
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

            <div class="modal-footer text-center">
                <button type="button" class="btn btn-default updateDatatable" data-dismiss="modal">Cerrar</button>
                <button type="button" id="firmar" class="btn btn-primary">Firmar</button>
            </div>

        </div>
    </div>
</div>

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