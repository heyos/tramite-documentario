<?php

$usuario_id = $_SESSION['usuario_id'];
$resumen = ResumenDocumentoUsuarioController::detalleResumen($usuario_id);

$pendientes = !empty($resumen) ? $resumen['pendientes'] : 0;
$proceso_de_firma = !empty($resumen) ? $resumen['proceso_de_firma'] : 0;
$firmado_todos = !empty($resumen) ? $resumen['firmado_todos'] : 0;
$rechazados = !empty($resumen) ? $resumen['rechazados'] : 0;

?>

<div class="row">
    <div class="col-md-12">
        <!-- DASHBOARD -->
        <div class="text-primary">
            Mis Documentos
        </div>
        <hr>
        <div class="stat-panel" style="margin-top: 30px;margin-bottom:0px;">
            <div class="stat-row">
                <div data-estado="0" class="col-sm-3 text-center estado" style="color: #555555;cursor: pointer;">
                    <i class="fa fa-exclamation-circle fa-2x text-warning"></i> 
                    <span style="font-size: 26px;">
                        <?php echo $pendientes; ?>
                    </span>
                    <p>Pendientes</p>
                </div>
                <div data-estado="1" class="col-sm-3 text-center estado" style="color: #555555;cursor: pointer;">
                    <i class="fa  fa-clock-o fa-2x text-primary" ></i> 
                    <span style="font-size: 26px;">
                        <?php echo $proceso_de_firma; ?>
                    </span>
                    <p>En Proceso <br> de Firma</p>
                </div>
                <div data-estado="2" class="col-sm-3 text-center estado" style="color: #555555;cursor: pointer;">
                    <i class="fa fa-check-circle fa-2x text-success"></i> 
                    <span style="font-size: 26px;">
                        <?php echo $firmado_todos; ?>
                    </span>
                    <p>Firmado por <br> Todos</p>
                </div>
                <div data-estado="3" class="col-sm-3 text-center estado" style="color: #555555;cursor: pointer;">
                    <i class="fa fa-times-circle fa-2x text-danger"></i> 
                    <span style="font-size: 26px;">
                        <?php echo $rechazados; ?>
                    </span>
                    <p>Rechazados</p>
                </div>
            </div>
        </div>
    </div>
</div>

