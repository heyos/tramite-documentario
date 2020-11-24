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
              <button type="button" class="btn btn-primary btn-registrar">Registrar Tipo Documento</button>
          </div>


          <table class="table primary-table table-default table-condensed dt-responsive table-bordered table-striped tablaTipoDocumento" style="width:100%">
            <thead>
              <tr>
                <th style="width:5% !important">#</th>
                <th style="width:70% !important">Descripcion</th>
                <th style="width:25% !important"></th>
              </tr>
            </thead>
            <tbody></tbody>
          </table>


        </div>

    </div>

</div> <!-- / #content-wrapper -->

<!-- MODAL AGREGAR TIPO DOCUMENTO -->
<div id="modalReg" class="modal fade" tabindex="-1" role="dialog" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel"></h4>
            </div>
            <div class="modal-body">
                <form id="formTipoDoc" class="form-horizontal">
                    <div class="form-group">
                        <label class="col-sm-4 control-label">Descripcion</label>
                        <div class="col-sm-6">
                            <input name="descripcion" id="descripcion" class="form-control alphanum" type="text" required>
                        </div>
                    </div>
                    <input type="hidden" name="id" id="id" class="form-control" value="0" required>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="button" id="guardar" class="btn btn-primary">Guardar</button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL AGREGA QUITAR ROL A TIPO DE DOCUMENTO -->
<div id="modalLista" class="modal fade" tabindex="-1" role="dialog" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel"></h4>
            </div>
            <div class="modal-body">
              <div class="row text-center">

                <div class="col-sm-6">
                  <div class="panel panel-primary">
                    <div class="panel-heading"><strong>Roles disponibles</strong></div>
                    <div class="panel-body slimScroll" style="height:200px">
                      <div class="list-group disponibles">

                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-sm-6">
                  <div class="panel panel-success">
                    <div class="panel-heading"><strong>Roles permitidos para firmar</strong></div>
                    <div class="panel-body slimScroll" style="height:200px">
                      <div class="list-group ocupados">

                      </div>
                    </div>
                  </div>
                </div>

              </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <!-- <button type="button" id="guardar" class="btn btn-primary">Guardar</button> -->
            </div>
        </div>
    </div>
</div>


<?php
include 'views/modules/end-main-wrapper.php';
?>
