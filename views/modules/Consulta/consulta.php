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
                                <form class="navbar-form pull-left">
                                    <input type="text" class="form-control" placeholder="Search">
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
                        <div class="col-md-4">
                            <h6 class="text-light-gray text-semibold text-xs">DOCUMENTO</h6>
                            <div class="input-group">
                                <input type="text" class="form-control">
                                <span class="input-group-btn">
                                    <button class="btn btn-primary" type="button"><i class="fa fa-search"></i></button>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <h1 class="note note-info">TIPO DOCUMENTO</h1>
                        </div>
                    </div>
                    <div class="row" style="margin-left: 20px;">
                        <div class="col-sm-12">
                            <h4 class="text-primary"><i class="fa fa-user-md"></i> <u> CLIENTE</u> </h4>
                            <em> <h4>76244460-7 ROBERTO SIERRA ROJAS</h4>  </em>
                            <h4 class="text-primary"><i class="fa fa-medkit"></i> <u> PACIENTE</u></h4>
                            <em> <h4>76244460-7 ROBERTO SIERRA ROJAS</h4>  </em>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="timeline">
                                <!-- Timeline header -->
                                <div class="tl-header now bg-primary">FIRMANTES</div>

                                <div class="tl-entry">
                                    <div class="tl-time">
                                        21/06/2021<br>11:45 am
                                    </div>
                                    <div class="tl-icon bg-success"><i class="fa fa-check"></i></div>
                                    <div class="panel tl-body">
                                        <h4 class="text-success"><b>DIRECTOR MEDICO</b></h4>
                                        CABALLERO ORTEGA, FRANCISCO JAVIER
                                    </div> <!-- / .tl-body -->
                                </div> <!-- / .tl-entry -->

                                <div class="tl-entry">
                                    <div class="tl-time">
                                        21/06/2021<br>11:45 pm
                                    </div>
                                    <div class="tl-icon bg-warning"><i class="fa fa-clock"></i></div>
                                    <div class="panel tl-body">
                                        <h4 class="text-warning"><b>DIRECTOR MEDICO</b></h4>
                                        CABALLERO ORTEGA, FRANCISCO JAVIER
                                    </div> <!-- / .tl-body -->
                                </div> <!-- / .tl-entry -->

                                <!-- Timeline header -->
                                <div class="tl-header">CREACION</div>

                                <div class="tl-entry">
                                    <div class="tl-time">
                                        21/06/2021<br>11:45 pm
                                    </div>
                                    <div class="tl-icon bg-info"><i class="fa fa-comment"></i></div>
                                    <div class="panel tl-body">
                                        <h4 class="text-info"><b>DIRECTOR MEDICO</b></h4>
                                        CABALLERO ORTEGA, FRANCISCO JAVIER
                                    </div> <!-- / .tl-body -->
                                </div> <!-- / .tl-entry -->                                

                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-7">
                            <embed src="../files-firma/test3.pdf" type="application/pdf" width="100%" height="600px" />
                            
                        </div>
                        <div class="col-sm-5 text-center">
                            <img src="../files-firma/qr.png" style="width: 60%">
                            <br><br>
                            <h4>Timbre A1800002042ABD4IN2</h4>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>

    </div>