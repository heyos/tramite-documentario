<?php

if(!$_SESSION["validar"]){

    header("location: index.php?action=ingreso");

    exit();

}

$id = isset($_SESSION['idDocumento']) ? $_SESSION['idDocumento'] : 0;
//$id = 2;

if(isset($_SESSION['idDocumento'])){
  unset($_SESSION['idDocumento']);
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

          <div class="wizard ui-wizard-documento">
            <div class="wizard-wrapper">
              <ul class="wizard-steps">
                <li data-target="#datos" >
                  <span class="wizard-step-number">1</span>
                  <span class="wizard-step-caption">
                    Datos Principales
                    <span class="wizard-step-description">Ingresar datos del documento</span>
                  </span>
                </li>
                <li data-target="#firmantes"> <!-- ! Remove space between elements by dropping close angle -->
                  <span class="wizard-step-number">2</span>
                  <span class="wizard-step-caption">
                    Seleccionar Firmante
                    <span class="wizard-step-description">Seleccionar uno o mas firmantes</span>
                  </span>
                </li>
                <li data-target="#subirPdf"> <!-- ! Remove space between elements by dropping close angle -->
                  <span class="wizard-step-number">3</span>
                  <span class="wizard-step-caption">
                    Cargar Documento y Guardar
                    <span class="wizard-step-description">Cargar documento en fomato PDF para ser firmado</span>
                  </span>
                </li>
                <!-- <li data-target="#wizard-example-step4">
                  <span class="wizard-step-number">4</span>
                  <span class="wizard-step-caption">
                    Guardar Documento
                  </span>
                </li> -->
              </ul>
            </div>
            <form id="formDocumento" class="form-horizontal">

              <input type="hidden" name="id" id="idDocumento" value="<?php echo $id; ?>">
              <input type="hidden" id="codigo" >
              <input type="hidden" id="google_id" name="google_id" >

              <div class="wizard-content panel">
                <div class="wizard-pane" id="datos">
                  <div class="row">

                    <div class="col-sm-3">
      								<div class="form-group no-margin-hr">
                        <label class="control-label">RUT Paciente</label>
      									<div class="input-group">
                          <input type="text" id="rut_paciente" class="form-control rut_paciente valid">
                          <span class="input-group-btn">
                            <button type="button" data-show="add-paciente" data-input="rut_paciente" data-type="paciente" data-display="xNombrePaciente"
                              data-displayId = "paciente_id"
                              class="btn btn-primary search search-paciente">
                              <i class="fas fa-search"></i>
                            </button>
                            <button type="button" data-show="search-paciente" data-display="xNombrePaciente" data-displayId = "paciente_id"
                              data-input="rut_paciente" data-type="paciente" style="display:none;" class="btn btn-success add-persona add add-paciente">
                              <i class="fas fa-user-plus"></i>
                            </button>
                          </span>
                        </div>
                        <input type="hidden" name="paciente_id" id="paciente_id" value="0" required>
                      </div>
      							</div>

      							<div class="col-sm-3">
      								<div class="form-group no-margin-hr">
      									<label class="control-label">Nombre Paciente</label>
      									<input type="text" id="xNombrePaciente" class="form-control valid" required readonly>
      								</div>
      							</div>

                    <div class="col-sm-3">
      								<div class="form-group no-margin-hr">
      									<label class="control-label">RUT Cliente</label>
      									<div class="input-group">
                          <input type="text" id="rut_cliente" name="rut_cliente" class="form-control rut_cliente valid">
                          <span class="input-group-btn">
                            <button type="button" data-show="add-cliente" data-input="rut_cliente" data-type="cliente" data-display="xRazSoc"
                              data-displayId = "cliente_id" class="btn btn-primary search search-cliente">
                              <i class="fas fa-search"></i>
                            </button>
                            <button type="button" data-show="search-cliente" data-display="xRazSoc" data-input="rut_cliente" data-type="cliente"
                              style="display:none;" class="btn btn-success add-persona add add-cliente">
                              <i class="fas fa-user-plus"></i>
                            </button>
                          </span>
                        </div>
                        <input type="hidden" name="cliente_id" id="cliente_id" value="0" required>
      								</div>
      							</div>

      							<div class="col-sm-3">
      								<div class="form-group no-margin-hr">
      									<label class="control-label">Nombre Cliente</label>
      									<input type="text" id="xRazSoc" class="form-control valid" required readonly>
      								</div>
      							</div>

      						</div>

                  <br><br>
                  <button type="button" data-div="datos" class="btn btn-primary wizard-next-step-btn">Sig.</button>
                </div>

                <div class="wizard-pane" id="firmantes" style="display: none;">
                  <div class="row">
                    <div class="col-sm-4"></div>
                    <div class="col-sm-4">
                      <div class="form-group no-margin-hr">
      									<label class="control-label">Tipo de documento</label>
      									<select class="form-control valid" name="tipoDocumento_id" id="tipoDocumento_id" required>
                          <option value="">-Seleccionar-</option>
                          <?php
                            $tipos = TipoDocumentoController::allData();
                            if($tipos['respuesta']){
                              foreach ($tipos['contenido'] as $row) {
                                echo sprintf('<option value="%d">%s</option>',$row['id'],$row['descripcion']) ;
                              }
                            }
                          ?>
                        <select>
                        <input type="hidden" id="name_tipo_doc">
      								</div>
                    </div>
                    <div class="col-sm-4"></div>
                  </div>

                  <div class="row">
                    <div class="col-sm-4">
                      <div class="panel panel-primary">
                        <div class="panel-heading"><strong>Roles permitidos para firmar</strong></div>
                        <div class="panel-body slimScroll" style="height:200px">
                          <div class="list-group disponibles">

                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="col-sm-4">
                      <div class="panel panel-primary">
                        <div class="panel-heading"><strong>Usuarios disponibles para firmar</strong></div>
                        <div class="panel-body slimScroll" style="height:200px">
                          <div class="list-group users-disponibles">

                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="col-sm-4">
                      <div class="panel panel-primary">
                        <div class="panel-heading"><strong>Usuarios aptos para firmar</strong></div>
                        <div class="panel-body slimScroll" style="height:200px">
                          <div class="list-group users-aptos">

                          </div>
                        </div>
                      </div>
                    </div>

                  </div>
                  <input type="hidden" id="lista_aptos" name="lista_usuarios_firma" class="valid">
                  <input type="hidden" id="rol_activo">
                  <input type="hidden" id="detalle_rol_activo">
                  <input type="hidden" id="lista_roles_aptos">
                  <br><br>
                  <button type="button" class="btn wizard-prev-step-btn">Atras</button>
                  <button type="button" data-div="firmantes" class="btn btn-primary wizard-next-step-btn">Next</button>
                </div>

                <div class="wizard-pane" id="subirPdf" style="display: none;">
                  <div class="row">
                    <div class="col-md-4"></div>
                    <div class="col-sm-12 col-md-4">

                      <input type="file" id="file" style="display: none;">
                      <input type="hidden" id="name_documento" name="name_documento" class="name_documento">
                      <!-- <input type="hidden" id="google_id" name="google_id" class="google_id"> -->

                      <div class="btn-group btn-group-justified">
                        <div class="btn-group" role="group">
                          <button type="button" class="btn btn-success" id="adjuntar">Adjuntar Documento</button>
                        </div>
                        <div class="btn-group tieneDocumento" role="group" style="display: none;">
                          <button type="button" class="btn btn-primary" id="ver">Ver Documento</button>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-4"></div>
                  </div>
                  <br>
                  <div class="row">
                    <div class="col-md-4"></div>
                    <div class="col-sm-12 col-md-4">
                      <div class="alert alert-warning noTieneDocumento" id="error">
                        <p class="text-center">Documento aun no esta cargado</p>
                      </div>

                      <div class="alert alert-success tieneDocumento" id="success" style="display: none;">
                        <p class="text-center">Documento almacenado correctamente</p>
                      </div>
                    </div>
                    <div class="col-md-4"></div>
                  </div>

                  <br><br>
                  <button type="button" class="btn wizard-prev-step-btn">Atras</button>
                  <!-- <button type="button" class="btn btn-primary wizard-next-step-btn"></button> -->
                  <button type="button" id="guardarDocumento" class="btn btn-primary wizard-next-step-btn finish">Guardar Documento</button>
                </div>

                <!-- <div class="wizard-pane" id="wizard-example-step4" style="display: none;">
                  Verifique los datos antes de guardar el documento<br><br>
                  <button type="button" class="btn wizard-prev-step-btn">Atras</button>
                  <button type="button" id="guardarDocumento" class="btn btn-primary wizard-next-step-btn finish">Guardar Documento</button>
                </div> -->

              </div>
              <input type="hidden" name="usuario" value="<?php echo $_SESSION['user'] ?>">
            </form>
          </div>

        </div>

    </div>

</div> <!-- / #content-wrapper -->

<!-- CREAR PACIENTE - CLIENTE -->
<div id="modalReg" class="modal fade" tabindex="-1" role="dialog" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel"></h4>
            </div>
            <div class="modal-body">
              <form id="formPersona" class="form-horizontal">
                <input type="hidden" name="xTipoPer" id="xTipoPer" class="form-control" required>
                <div class="form-group">
                  <label class="col-sm-4 control-label">RUT</label>
                  <div class="col-sm-6">
                      <input name="nRutPer" id="nRutPer" class="form-control rut_persona" type="text" required>
                  </div>
                </div>

                <!-- JURIDICA -->
                <div class="form-group juridica" style="display:none;">
                  <label class="col-sm-4 control-label">Razon Social</label>
                  <div class="col-sm-6">
                      <input name="xRazSoc" id="xRazSoc" class="form-control alphanum limpiar" type="text">
                  </div>
                </div>

                <!-- NATURAL -->
                <div class="form-group natural" style="display:none;">
                  <label class="col-sm-4 control-label">Nombres</label>
                  <div class="col-sm-6">
                      <input name="xNombre" id="xNombre" class="form-control alpha limpiar" type="text">
                  </div>
                </div>
                <div class="form-group natural" style="display:none;">
                  <label class="col-sm-4 control-label">Apellido Paterno</label>
                  <div class="col-sm-6">
                      <input name="xApePat" id="xApePat" class="form-control alpha limpiar" type="text">
                  </div>
                </div>
                <div class="form-group natural" style="display:none;">
                  <label class="col-sm-4 control-label">Apellido Materno</label>
                  <div class="col-sm-6">
                      <input name="xApeMat" id="xApeMat" class="form-control alpha limpiar" type="text">
                  </div>
                </div>
                
              </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                <button type="button" id="guardarPersona" class="btn btn-primary">Guardar</button>
            </div>
        </div>
    </div>
</div>



<?php
include 'views/modules/end-main-wrapper.php';
?>
