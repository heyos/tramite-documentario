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
                <div class="col-sm-6">
                    <form id="formMenu" class="form-horizontal">
                        <div class="panel panel-primary" style="border-color:#428bca !important">
                            <div class="panel-heading">
                                <span class="panel-title" style="color:#fff">Menu</span>
                            </div>
                            <div class="panel-body">
                                
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Descripcion:</label>
                                    <div class="col-sm-6">
                                        <input name="nombreMenu" id="nombreMenu" class="form-control validarTextoMenu" type="text" placeholder="Nombre Menu" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Icono:</label>
                                    <div class="col-sm-6">
                                        <div class="input-group">
                                            <input name="icono" id="icono" class="form-control validarTextoIcono" type="text" placeholder="fa fa-user" required>
                                            <span class="input-group-btn">
                                                <a href="https://fontawesome.com/icons?d=gallery" target="_blank" class="btn btn-primary">Ver</a>
                                            </span>
                                        </div>
                                            
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Url:</label>
                                    <div class="col-sm-6">
                                        <input name="urlMenu" id="urlMenu" class="form-control urlMenu" type="text" placeholder="# o nombre_menu" required>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">Visible:</label>
                                    <div class="col-sm-3 checkbox">
                                        <input type="checkbox" id="visibleMenu" name="visibleMenu" value="1" data-class="switcher-primary">
                                    </div>
                                    <div id="info" class="col-sm-5 info">
                                        <button type="button" class="btn btn-rounded btn-primary" data-toggle="popover" data-placement="right" data-content="Esta opcion es para enlazar paginas que no se muestran en el menu de opciones y poderles dar los permisos de acceso y mantenimiento, ejemplo: al dar click en un boton y te abre una pagina que no figura en el menu de opciones pero contiene datos que necesitan mantenimiento. Visible On: Se visualizara en el menu" data-title="Info" data-original-title="" title=""><i class="fa fa-info"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="panel panel-primary" style="border-color:#428bca !important">
                            <div class="panel-heading">
                                <span class="panel-title" style="color:#fff">Menu - Level 1</span>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-sm-5">
                                        <div class="form-group no-margin-hr">
                                            <label class="control-label">Descripcion</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group no-margin-hr">
                                            <label class="control-label">Url</label>
                                        </div>
                                    </div>
                                    <div id="add" class="col-sm-1 add">
                                        <button id="add-submenu" class="btn btn-primary" type="button" data-toggle="tooltip" data-placement="right" title="" data-original-title="Agregar Menu Level 1"><i class="fa fa-plus"></i></button>
                                    </div>                            
                                </div>
                                <div id="divSubMenu">
                                    
                                </div>
                            </div>
                        </div>

                        <div class="form-group text-center">
                            <button type="button" id="guardarMenu" class="btn btn-primary">Guardar</button>
                        </div>

                    </form>
                    
                </div>

                <div class="col-sm-6">

                    <div class="panel panel-primary" style="border-color:#428bca !important">
                        <div class="panel-heading">
                            <span class="panel-title" style="color:#fff">Estructura Menu de Opciones</span>
                        </div>
                        <div id="divEstructuraMenu" class="panel-body">
                            <?php
                                $listaMenu = new Menu();
                                $listaMenu -> mostrarListaMenuController();
                            ?>
                        </div>
                    </div>
                    
                </div>
            </div>

        </div>

    </div>

</div> <!-- / #content-wrapper -->

<input type="hidden" id="nameUbiAccion" value="registrar_menu">

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
<div id="modalMenu" class="modal fade" tabindex="-1" role="dialog" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Actualizar Menu</h4>
            </div>
            <div class="modal-body">
                <div id="alert-info" style="display:none" class="alert alert-warning">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    Si actualiza su url por una diferente a #, sus sub menus se eliminaran.
                </div>
                <form id="formActualizarMenu" class="form-horizontal">
                    <input type="hidden" name="accionMenu" id="accionMenu" value="actualizarMenu" required>
                    <input name="termMenu" id="termMenu" class="form-control" type="hidden" value="0" required>
                    <input name="tieneSubMenu" id="tieneSubMenu" class="form-control" type="hidden" value="0" required>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Descripcion:</label>
                        <div class="col-sm-6">
                            <input name="actualizarNombreMenu" id="actualizarNombreMenu" class="form-control validarTextoMenu" type="text" placeholder="Nombre Menu" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Icono:</label>
                        <div class="col-sm-6">
                            <div class="input-group">
                                <input name="actualizarIcono" id="actualizarIcono" class="form-control validarTextoIcono" type="text" placeholder="fa fa-user" required>
                                <span class="input-group-btn">
                                    <a href="https://fontawesome.com/icons?d=gallery" target="_blank" class="btn btn-primary">Ver</a>
                                </span>
                            </div>
                                
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Url:</label>
                        <div class="col-sm-6">
                            <input name="actualizarUrlMenu" id="actualizarUrlMenu" class="form-control urlMenu" type="text" placeholder="# o index.php?action=nombre_menu" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Visible:</label>
                        <div class="col-sm-3 checkbox">
                            <input type="checkbox" id="actualizarVisibleMenu" name="actualizarVisibleMenu" value="1" data-class="switcher-primary">
                        </div>
                        <div id="info" class="col-sm-5 info">
                            <button type="button" class="btn btn-rounded btn-primary" data-toggle="popover" data-placement="right" data-content="Esta opcion es para enlazar paginas que no se muestran en el menu de opciones y poderles dar los permisos de acceso y mantenimiento, ejemplo: al dar click en un boton y te abre una pagina que no figura en el menu de opciones pero contiene datos que necesitan mantenimiento. Visible On: Se visualizara en el menu" data-title="Info" data-original-title="" title=""><i class="fa fa-info"></i></button>
                        </div>
                    </div>
                    
                </form>
            </div> <!-- / .modal-body -->
            <div class="modal-footer">
                <button data-accion="eliminarMenu" type="button" id="eliminarMenu" class="btn btn-danger button-accion" >Eliminar</button>
                <button data-accion="actualizarMenu" type="button" id="actualizarMenu" class="btn btn-primary button-accion">Actualizar</button>
            </div>
        </div> <!-- / .modal-content -->
    </div> <!-- / .modal-dialog -->
</div> <!-- /.modal -->

<!--modal agregar - actualizar submenu-->
<div id="modalSubMenu" class="modal fade" tabindex="-1" role="dialog" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="titleModalSubMenu">Agregar Menu - Level 1</h4>
            </div>
            <div class="modal-body">
                <form id="formActualizarSubMenu" class="form-horizontal">
                    <input type="hidden" id="accionSub" name="accionSub" value="add" required>
                    <input type="hidden" id="termMenu_sub" name="termMenu_sub" value="0" required>
                    <input type="hidden" id="termSubMenu" name="termSubMenu" value="0" required>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Descripcion:</label>
                        <div class="col-sm-6">
                            <input name="actualizarNombreSubMenu" id="actualizarNombreSubMenu" class="form-control validarTextoMenu" type="text" placeholder="Nombre SubMenu" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Url:</label>
                        <div class="col-sm-6">
                            <input name="actualizarUrlSubMenu" id="actualizarUrlSubMenu" class="form-control validarUrl" type="text" placeholder="index.php?action=nombre_submenu" readonly="readonly" required>
                        </div>
                    </div>
                    
                </form>
            </div> <!-- / .modal-body -->
            <div class="modal-footer">
                <button type="button" id="cancelarSubMenu" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="button" id="eliminarSubMenu" data-accion="eliminarSubMenu" class="btn btn-danger button-accion-sub" style="display:none;" >Eliminar</button>
                <button type="button" id="guardarSubMenu" data-accion="" class="btn btn-primary button-accion-sub">Guardar</button>
            </div>
        </div> <!-- / .modal-content -->
    </div> <!-- / .modal-dialog -->
</div> <!-- /.modal -->

<?php
include 'views/modules/end-main-wrapper.php';
?>