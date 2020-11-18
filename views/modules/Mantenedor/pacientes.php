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
                <button type="button" class="btn btn-primary btn-registrar">Registrar Paciente</button>
            </div>
            
            <div class="panel panel-primary head_table">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-sm-6">
                            <h4>Mantenedor de Pacientes</h4>
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
            
            <div id="contenidoTablas" class="table-primary table-responsive">
                
            </div>

            <p id="loading" class="text-center" style="display:none;">
                <img src="views/images/loader5.gif"> <strong>Cargando...</strong>
            </p>

        </div>

    </div>

</div>

<div id="modalTabla" class="modal fade" tabindex="-1" role="dialog" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title text-bold" id="myModalLabel">Registrar Tabla</h4>
            </div>
            <div class="modal-body">
                <form id="formPaciente" class="">
                    <input type="hidden" name="accion" id="accion" value="add">
                    <input type="hidden" name="id" id="id" value="0">
                    <input type="hidden" name="xTipoPer" id="xTipoPer" value="n">
                    <div class="form-group">
                        <label>RUT</label>
                        <input name="nRutPer" id="nRutPer" class="form-control alphanum" type="text" required>
                    </div>
                    <div class="form-group">
                        <label>Nombre</label>
                        <input name="xNombre" id="xNombre" class="form-control alpha" type="text" maxlength="40" required>
                    </div>

                    <div class="form-group">
                        <label>Apellido Paterno</label>
                        <input name="xApePat" id="xApePat" class="form-control alpha" type="text" maxlength="40" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Apellido Materno</label>
                        <input name="xApeMat" id="xApeMat" class="form-control alpha" type="text" maxlength="40" required>
                    </div>
                    
                    <div class="form-group">
                        <label>Tipo Cargo</label>
                        <select class="form-control select2" name="cTipCar" id="cTipCar" required="">
                            <?php echo Persona::listaSelectCtr('CARGO'); ?>
                        </select>
                    </div>
                                        
                    <div class="form-group">
                        <label>Sexo</label>
                        <select class="form-control" name="cSexo" id="cSexo">
                            <option value="">-Seleccionar-</option>
                            <option value="M">M</option>
                            <option value="F">F</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Fecha Nacimiento</label>
                        <div class="input-append date calendar input-group" data-date-end-date="0d">
                            <input name="dFecNac" id="dFecNac" class="form-control"  type="text" readonly>
                            <div class="input-group-btn">
                                <button type="button" data-type="calendar" class="btn btn-default datepicker-btn"><i class="fa fa-calendar"></i></button>
                            </div>
                            
                        </div>
                        
                    </div>
                </form>
            </div> <!-- / .modal-body -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="button" id="guardar" class="btn btn-primary">Guardar</button>
            </div>
        </div> <!-- / .modal-content -->
    </div> <!-- / .modal-dialog -->
</div>

<div id="modalTablaDetalle" class="modal fade" tabindex="-1" role="dialog" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title text-bold" id="myModalLabel">Registrar Direcciones</h4>
            </div>
            <div class="modal-body">

                <ul id="uidemo-tabs-default-demo" class="nav nav-tabs">
                    <li class="active">
                        <a href="#direcciones" data-toggle="tab">Direcciones </a>
                    </li>
                </ul>

                <div class="tab-content tab-content-bordered">
                    <div class="tab-pane fade active in" id="direcciones">

                        <div class="panel panel-default">
                            <div class="panel-body">
                                <form id="form-direccion" class="form-horizontal">
                                    <input type="hidden" name="id" id="id">
                                    <input type="hidden" name="nIdPersona" id="nIdPersona">
                                    <input type="hidden" name="accion"  value="adddireccion">
                                    <div class="row">
                                        <div class="col-xs-12 col-md-4">
                                            <div class="form-group no-margin-hr">
                                                <label>Nombre Faena</label>
                                                <input type="text" name="xNomFaena" id="xNomFaena" class="form-control" maxlength="40" required="">
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-md-4">
                                            <div class="form-group no-margin-hr">
                                                <label>Calle</label>
                                                <input type="text" name="cDirEnt" id="cDirEnt" class="form-control" maxlength="50" required="">
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-md-4">
                                            <div class="form-group no-margin-hr">
                                                <label>N° Dir.</label>
                                                <input type="text" name="xNumDir" id="xNumDir" class="form-control num" maxlength="15" required="">
                                            </div>
                                                
                                        </div>
                                        
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-md-4">
                                            <div class="form-group no-margin-hr">
                                                <label>Comunas</label>
                                                <select class="form-control select2" name="nIdComuna" id="nIdComuna" required="">
                                                    <?php echo Persona::listaSelectCtr('COMUNAS'); ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-md-4">
                                            <div class="form-group no-margin-hr">
                                                <label>Pais</label>
                                                <select class="form-control select2" name="cPais" id="cPais" required="">
                                                    <?php echo Persona::listaSelectCtr('PAIS'); ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-md-4">
                                            <div class="form-group no-margin-hr">
                                                <label>Email</label>
                                                <input type="email" name="xEmail" id="xEmail" maxlength="40" class="form-control">
                                            </div>
                                                
                                        </div>
                                        
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-md-4">
                                            <div class="form-group no-margin-hr">
                                                <label>Telefono 1</label>
                                                <input type="text" name="xTelEnt1" id="xTelEnt1" maxlength="9" class="form-control num">
                                            </div>
                                                
                                        </div>
                                        <div class="col-xs-12 col-md-4">
                                            <div class="form-group no-margin-hr">
                                                <label>Telefono 2</label>
                                                <input type="text" name="xTelEnt2" id="xTelEnt2" maxlength="9" class="form-control num">
                                            </div>
                                                
                                        </div>
                                        <div class="col-xs-12 col-md-4">
                                            <div class="form-group no-margin-hr">
                                                <label>Fax</label>
                                                <input type="text" name="xFaxEnt" id="xFaxEnt" maxlength="15" class="form-control num">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="text-center">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                            <button type="submit" class="btn btn-primary">Guardar</button>
                                            <button type="button" data-form="form-direccion" data-accion="adddireccion" class="btn btn-warning nuevoregistro" style="display: none;">Nuevo</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="panel panel-primary head_table">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <h4>Registro de Direcciones</h4>
                                    </div>
                                            
                                    <div class="col-sm-2">
                                        <h5 class="text-right">Por Pag.</h5>
                                    </div>

                                    <div class="col-sm-2">
                                        <select class="form-control por_pag">
                                            <option value="10" selected="selected">10</option>
                                            <option value="25">25</option>
                                            <option value="50">50</option>
                                            <option value="100">100</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-4">
                                        <input type="text" id="" class="form-control buscar_term" placeholder="Buscar ...">
                                        <input type="hidden" id="" class="mantenimiento" value="<?php echo $mantenimiento; ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div id="contenidoDirecciones" class="table-primary table-responsive">
                            
                        </div>

                        <p id="" class="text-center loading" style="display:none;">
                            <img src="views/images/loader5.gif"> <strong>Cargando...</strong>
                        </p>

                    </div> <!-- / .tab-pane -->
                </div> 

            </div>
            <div class="modal-footer">
                
            </div>
        </div> <!-- / .modal-content -->
    </div> <!-- / .modal-dialog -->
</div>


<?php
include 'views/modules/end-main-wrapper.php';
?>