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

          <div class="wizard ui-wizard-documento">
            <div class="wizard-wrapper">
              <ul class="wizard-steps">
                <li data-target="#datos" >
                  <span class="wizard-step-number">1</span>
                  <span class="wizard-step-caption">
                    Datos Principales
                    <span class="wizard-step-description">Ingresar datos del documento</span>
                  </span>
                </li
                ><li data-target="#firmantes"> <!-- ! Remove space between elements by dropping close angle -->
                  <span class="wizard-step-number">2</span>
                  <span class="wizard-step-caption">
                    Seleccionar Firmante
                    <span class="wizard-step-description">Seleccionar uno o mas firmantes</span>
                  </span>
                </li
                ><li data-target="#subirPdf"> <!-- ! Remove space between elements by dropping close angle -->
                  <span class="wizard-step-number">3</span>
                  <span class="wizard-step-caption">
                    Cargar Documento
                    <span class="wizard-step-description">Cargar documento en fomato PDF para ser firmado</span>
                  </span>
                </li
                ><li data-target="#wizard-example-step4"> <!-- ! Remove space between elements by dropping close angle -->
                  <span class="wizard-step-number">4</span>
                  <span class="wizard-step-caption">
                    Guardar Documento
                  </span>
                </li>
              </ul>
            </div>
            <form id="formDocumento" class="form-horizontal">
              <input type="" name="id" id="idDocumento" value="3">
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
                              style="display:none;" class="btn btn-success add add-paciente">
                              <i class="fas fa-user-plus"></i>
                            </button>
                          </span>
                        </div>
                        <input type="" name="paciente_id" id="paciente_id" value="0" required>
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
                          <input type="text" id="rut_cliente" class="form-control rut_cliente valid">
                          <span class="input-group-btn">
                            <button type="button" data-show="add-cliente" data-input="rut_cliente" data-type="cliente" data-display="xRazSoc"
                              data-displayId = "cliente_id" class="btn btn-primary search search-cliente">
                              <i class="fas fa-search"></i>
                            </button>
                            <button type="button" data-show="search-cliente" data-display="xRazSoc"
                              style="display:none;" class="btn btn-success add add-cliente">
                              <i class="fas fa-user-plus"></i>
                            </button>
                          </span>
                        </div>
                        <input type="" name="cliente_id" id="cliente_id" value="0" required>
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
                  <input type="" id="lista_aptos" name="lista_usuarios_firma" class="valid">
                  <input type="" id="rol_activo">
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

                      <div class="btn-group btn-group-justified">
                        <div class="btn-group" role="group">
                          <button class="btn btn-success" id="adjuntar">Adjuntar Documento</button>
                        </div>
                        <div class="btn-group" role="group" style="display: none;">
                          <button class="btn btn-primary" id="ver">Ver Documento</button>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-4"></div>
                  </div>
                  <br>
                  <div class="row">
                    <div class="col-md-4"></div>
                    <div class="col-sm-12 col-md-4">
                      <div class="alert alert-warning" id="error">
                        <p class="text-center">Documento aun no esta cargado</p>
                      </div>

                      <div class="alert alert-success" id="success" style="display: none;">
                        <p class="text-center">Documento almacenado correctamente</p>
                      </div>
                    </div>
                    <div class="col-md-4"></div>
                  </div>

                  <br><br>
                  <button type="button" class="btn wizard-prev-step-btn">Atras</button>
                  <button type="button" class="btn btn-primary wizard-next-step-btn"></button>
                </div>

                <div class="wizard-pane" id="wizard-example-step4" style="display: none;">
                  Verifique los datos antes de guardar el documento<br><br>
                  <button type="button" class="btn wizard-prev-step-btn">Atras</button>
                  <!-- <button class="btn btn-success wizard-go-to-step-btn">Go to Step 2</button> -->
                  <button type="button" id="guardarDocumento" class="btn btn-primary wizard-next-step-btn finish">Guardar Documento</button>
                </div>

              </div>
              <input type="" name="usuario" value="<?php echo $_SESSION['user'] ?>">
            </form>
          </div>

        </div>

    </div>

</div> <!-- / #content-wrapper -->



<?php
include 'views/modules/end-main-wrapper.php';
?>
