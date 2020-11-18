<?php
$enlaces = new Enlaces();

include 'views/modules/start-main-wrapper.php';
include 'views/modules/main-menu.php';

$foto = new Empresa();
$datosEmpresa = new Empresa();

?>


<div id="content-wrapper">

    <div class="page-header">
        <h1 class="text-center text-left-sm">
            <i class="fa fa-building-o page-header-icon"></i> <?php $enlaces -> titlePageController(); ?>
        </h1>
    </div>

    <div class="panel panel-default">

        <div class="panel-body">
            
            <div class="row">
                <div class="col-sm-3">
                    <div id="img-empresa" class="text-center img-responsive">
                        <?php $foto->mostrarImagenEmpresaController();?>
                    </div>
                    <br>
                    
                </div>
                <div class="col-sm-5">
                    <form id="form-empresa" class="form-horizontal">
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Imagen:</label>
                            <div class="col-sm-8">
                                <input type="file" id="file-input" name="imagen">
                            </div>
                        </div>
                        <input type="hidden" name="imagenName" id="imagenName" value="<?php echo $datosEmpresa->datosEmpresaController('foto'); ?>">
                        <input type="hidden" name="oldImagenName" id="oldImagenName" value="<?php echo $datosEmpresa->datosEmpresaController('foto'); ?>">
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Nombre o Razon Social:</label>
                            <div class="col-sm-8">
                                <input name="nombreEmpresa" id="nombreEmpresa" class="form-control validarTextNum" type="text" maxlength="19" placeholder="maximo 19 caracteres" value="<?php echo $datosEmpresa->datosEmpresaController('nombre'); ?>" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Actividad Economica:</label>
                            <div class="col-sm-8">
                                <input name="actividad_economica" id="actividad_economica" class="form-control validar" type="text" value="<?php echo $datosEmpresa->datosEmpresaController('actividad_economica'); ?>" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Propietario:</label>
                            <div class="col-sm-8">
                                <input name="propietario" id="propietario" class="form-control validar" type="text" value="<?php echo $datosEmpresa->datosEmpresaController('propietario'); ?>" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Direccion:</label>
                            <div class="col-sm-8">
                                <input type="text" name="direccion" id="direccion" class="form-control validarTextNum" value="<?php echo $datosEmpresa->datosEmpresaController('direccion'); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Telefono:</label>
                            <div class="col-sm-8">
                                <input name="telefono" id="telefono" class="form-control validarNumero" type="text" value="<?php echo $datosEmpresa->datosEmpresaController('telefono'); ?>">
                            </div>
                        </div>

                        <div class="form-group text-center">
                            <button type="button" id="guardar" class="btn btn-primary">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>

    </div>

</div> <!-- / #content-wrapper -->


<?php

include 'views/modules/end-main-wrapper.php';

?>

