<body class="theme-default main-menu-animated main-navbar-fixed main-menu-fixed no-main-menu">

    <div id="main-wrapper">

        <div id="main-navbar" class="navbar navbar-inverse" role="navigation">
            <!-- Main menu toggle -->
            <button type="button" id="main-menu-toggle"><i class="navbar-icon fa fa-bars icon"></i><span class="hide-menu-text">HIDE MENU</span></button>

            <div class="navbar-inner">
                <!-- Main navbar header -->
                <div class="navbar-header">

                    <!-- Logo -->
                    <a href="./" class="navbar-brand">
                        <?php  
                            $e = new Empresa(); 
                            $imagen = $e -> datosEmpresaController("foto");

                            $ruta = 'views/images/empresa/'.$imagen;
                            if(!file_exists($ruta)){
                                $imagen = '';
                            }

                            $imagen = ($imagen=='')?'main-navbar-logo.png':$imagen;
                            $nombreEmpresa = $e -> datosEmpresaController("nombre");
                            $nombreEmpresa = ($nombreEmpresa == '')?'Empresa':$nombreEmpresa;
                        ?>
                        <div><img src="views/images/empresa/<?php echo $imagen;  ?>"></div>
                        
                        <?php 
                            
                            echo $nombreEmpresa;
                        ?>
                    </a>

                    <!-- Main navbar toggle -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#main-navbar-collapse"><i class="navbar-icon fa fa-bars"></i></button>

                </div> <!-- / .navbar-header -->

                <div id="main-navbar-collapse" class="collapse navbar-collapse main-navbar-collapse">
                    <!-- <div class="right clearfix"> -->
                        <ul class="nav navbar-nav pull-right right-navbar-nav">
                            <li>
                                <form id="form-consulta" class="navbar-form pull-left">
                                    <div class="form-group has-feedback">
                                        <i class="fa fa-search" style="position: absolute;padding: 10px;padding-top: 17px;pointer-events: none;color: #DDDDDD"></i>
                                        <input id="term" name="term"
                                        style="padding-left: 30px!important;width: 100%" type="text" class="form-control" 
                                        placeholder="Codigo + Enter">
                                    </div>
                                    
                                </form>
                            </li>
                        </ul>
                    <!-- </div> -->
                </div> <!-- / #main-navbar-collapse -->
            </div> <!-- / .navbar-inner -->
        </div> <!-- / #main-navbar -->

        <div id="content-wrapper">

            <!-- <div class="page-header">
                <h1 class="text-center text-left-sm">
                    <i class="fa fa-user page-header-icon"></i> CONSULTE EL ESTADO DEL DOCUMENTO
                </h1>
            </div> -->

            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <h1 class="note note-info" id="name_tipo_doc">TIPO DOCUMENTO</h1>
                        </div>
                    </div>
                    <div class="row" style="margin-left: 20px;">
                        <div class="col-sm-12">
                            <h4 class="text-primary"><i class="fa fa-user-md"></i> <u> CLIENTE</u> </h4>
                            <em> <h4 id="cliente_full">-</h4>  </em>
                            <h4 class="text-primary"><i class="fa fa-medkit"></i> <u> PACIENTE</u></h4>
                            <em> <h4 id="paciente_full">-</h4>  </em>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="timeline">
                                <!-- Timeline header -->
                                <div id="afterFirmantes" class="tl-header now bg-primary">FIRMANTES</div>

                                <div class="tl-entry default">
                                    <div class="tl-time">
                                    
                                    </div>
                                    <div class="tl-icon bg-default">-</div>
                                    <div class="tl-body">
                                        <h4 class="text-success"><b></b></h4>
                                        
                                    </div>
                                </div>
                                
                                <!-- Timeline header -->
                                <div id="afterCreacion" class="tl-header">CREACION</div>

                            </div>
                        </div>

                        <div class="col-sm-8">
                            <div class="row">
                                <div class="col-sm-7">
                                    <!-- <embed src="../files-firma/test3.pdf" type="application/pdf" width="100%" height="600px" /> -->
                                    
                                </div>
                                <div class="col-sm-5 text-center default">
                                    <img class="img-thumbnail" src="views/images/no_disponible.png" style="width: 60%">
                                    <br><br>
                                    <h4>Timbre ---</h4>
                                </div>

                                <div class="col-sm-5 text-center" style="display: none;" id="qr">
                                </div>
                            </div>
                        </div>
                    </div>

                11  </div>
            </div>
            
        </div>

    </div>