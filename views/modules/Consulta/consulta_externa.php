<body class="theme-default main-menu-animated main-navbar-fixed main-menu-fixed no-main-menu">

    <div id="preloader">
        <div class="text-center " id="status">
            <img src="<?php assets('views/images/Preloader.gif'); ?>" alt="Preloader" class="img-responsive" style="margin: 0 auto">
        </div>
    </div>

    <input type="hidden" id="action" value="<?php echo $_GET['action'];?>">
    <input type="hidden" id="term" value="<?php echo $_GET['term'];?>" >

    <div id="main-wrapper">

        <div id="content-wrapper">

            <div class="page-header">
                <h1 class="text-center text-left-sm">
                    <?php

                        $args = array(
                            ['nRutPer',$_GET['term']],
                            ['xTipoPer','j']
                        );

                        $persona = Persona::datosPersonaCtr($args);

                        if($persona['response']){
                            echo '<b>'.$persona['data']['xRazSoc'].'</b>';
                        }

                    ?>
                </h1>
            </div>

            <div class="panel panel-default">

                <div class="panel-body">
                    
                    <div class="row mostrar">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">
                                    <i class="fa fa-calendar"></i>&nbsp;&nbsp; Rango de Fecha: 
                                </label>
                                <div class="input-daterange input-group" id="bs-datepicker-range">
                                    <input type="text" class="input-sm form-control calendar" id="fecha_inicio" name="fecha_inicio" placeholder="Fecha inicio" value="<?php echo date('d-m-Y');?>" autocpmplete="off">
                                    <span class="input-group-addon">hasta</span>
                                    <input type="text" class="input-sm form-control calendar" id="fecha_fin" name="fecha_fin" placeholder="Fecha fin" 
                                    value="<?php echo date('d-m-Y');?>" autocpmplete="off">
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

                        <!-- <div class="col-md-2">
                            <div class="form-group">
                                <label class="control-label">
                                    <i class="fa fa-license-card"></i> Estado Documento
                                </label>
                                <select name="estadoDoc" id="estadoDoc" class="form-control" required>
                                  <option value="4" >Todos</option>
                                    <?php
                                        $respuesta = EstadoDocumentoController::allData();

                                        if($respuesta['respuesta']){
                                            foreach ($respuesta['contenido'] as $item) {
                                                echo '<option value="'.$item['id'].'">'.$item['descripcion'].'</option>';
                                            }
                                            
                                        }

                                    ?>                  
                                </select>
                            </div>
                        </div> -->

                        <div class="form-group col-md-2">
                            <label>&nbsp;&nbsp;</label>
                            <div class="input-group">                    
                                <button type="button" id="buscar_documento" class="btn btn-success"> <i class="fa fa-search"></i></button>
                            </div>                                    
                        </div>
                        <div class="col-md-2"></div>
                        <div class="col-md-2">
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
                    <div class="table-responsive table-primary mostrar">
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

                    <div style="display: none;" class="messageError form-group text-center">
                        <span class="alert alert-danger" id="textError">
                            
                        </span>
                    </div>

                </div>

            </div>
           
            
        </div>

    </div>