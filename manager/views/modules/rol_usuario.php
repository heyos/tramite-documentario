<?php


include 'views/modules/start-main-wrapper.php';
include 'views/modules/main-menu.php';

$enlaces = new Enlaces();



?>


<div id="content-wrapper">

    <div class="page-header">
        <h1 class="text-center text-left-sm">
            <i class="fa fa-user page-header-icon"></i> <?php $enlaces -> titlePageController(); ?>
        </h1>
    </div>

    <div class="panel panel-default">

        <div class="panel-body">
            
            <div class="row">
                <div class="col-sm-4">
                    <form id="formRolView" class="form-horizontal">
                        <input name="idRol" id="idRol" class="form-control" type="hidden" value="0" required>
                        <input type="hidden" name="oldNombreRol" id="oldNombreRol" class="form-control" value="old" required>

                        <div class="form-group">
                            <label class="col-sm-4 control-label">Nombre Rol</label>
                            <div class="col-sm-8">
                                <input name="nombreRol" id="nombreRol" class="form-control validarTexto" type="text" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Mostrar Inicio:</label>
                            <div id="checkbox" class="col-sm-8">
                                <input type="checkbox" id="mostrar_inicio" name="mostrar_inicio" value="1" data-class="switcher-success">
                            </div>
                        </div>
                        
                        <div class="form-group text-center">
                            <button type="button" id="guardarRolView" class="btn btn-primary">Guardar</button>
                        </div>
                    </form>
                </div>

                <div class="col-sm-8">
                    <div class="table-light">
                        <table class="table table-condensed table-bordered">
                            <thead>
                                <tr>
                                    <th>Nombre Rol</th>
                                    <th>Mostrar Inicio</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id="listadoRolOk">
                                <?php
                                    $rol = new RolUsuario();
                                    echo $rol -> mostrarRolUsuarioController();
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div> <!-- / #content-wrapper -->

<!--modal mensaje-->
<div id="modal-alert" class="modal modal-alert modal-success fade" style="display:none;">
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

<div id="modalInicio" class="modal fade" tabindex="-1" role="dialog" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Seleccionar Inicio de Pagina</h4>
            </div>
            <div class="modal-body">
                <form id="formRolView" class="form-horizontal">
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Rol Usuario</label>
                        <div class="col-sm-6">
                            <input name="rolInicio" id="rolInicio" class="form-control" type="text" readonly="readonly" required>
                        </div>
                    </div>
                    <div id="contenidoSelect" class="form-group">
                        <label class="col-sm-4 control-label">Pagina de Inicio</label>
                        <div class="col-sm-6">
                            <select class="form-control select2" id="pageInicio" name="pageInicio">
                                
                            </select>
                        </div>
                    </div>
                    <input type="hidden" name="termRolInicio" id="termRolInicio" class="form-control" value="0" required>
                </form>
            </div> <!-- / .modal-body -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div> <!-- / .modal-content -->
    </div> <!-- / .modal-dialog -->
</div> <!-- /.modal -->

<?php
include 'views/modules/end-main-wrapper.php';
?>