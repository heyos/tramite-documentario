<?php
$origin = isset($_GET['origin']) && isset($_GET['term']) ? $_GET['origin'] : '';
$action = $origin;
$mostrar = $origin == 'externo' ? true : false;
$hide = $origin == 'externo' ? 'display:none;':'';

?>

<body class="theme-default main-menu-animated main-navbar-fixed main-menu-fixed no-main-menu">

    <input type="hidden" id="action" value="<?php echo $action; ?>">

    <div id="main-wrapper">

        <?php if(!$mostrar) { ?>
        <div id="main-navbar" class="navbar navbar-inverse" role="navigation">
            
            <button type="button" id="main-menu-toggle">
                <i class="navbar-icon fa fa-bars icon"></i><span class="hide-menu-text">HIDE MENU</span>
            </button>

            <div class="navbar-inner">
                
                <div class="navbar-header">

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
                                <?php
                                    
                                    $codigo = '';

                                    if(isset($_SESSION)){
                                        if(isset($_SESSION['codigoDocumento'])){
                                            $codigo = $_SESSION['codigoDocumento'];

                                            unset($_SESSION['codigoDocumento']);
                                        }
                                    }
                                ?>
                                <form id="form-consulta" class="navbar-form pull-left" onsubmit="event.preventDefault();">
                                    <div class="form-group has-feedback">
                                        <i class="fa fa-search" 
                                        style="position: absolute;padding: 10px;padding-top: 17px;pointer-events: none;color: #DDDDDD"></i>
                                        <input id="term" name="term"
                                        style="padding-left: 30px!important;width: 100%" type="text" class="form-control"
                                        value="<?php echo $codigo; ?>" 
                                        placeholder="Codigo + Enter">
                                    </div>
                                    
                                </form>
                            </li>
                        </ul>
                    <!-- </div> -->
                </div> <!-- / #main-navbar-collapse -->
            </div> <!-- / .navbar-inner -->
        </div>
        <?php } ?>

        <div id="content-wrapper">

            <!-- <div class="page-header">
                <h1 class="text-center text-left-sm">
                    <i class="fa fa-user page-header-icon"></i> CONSULTE EL ESTADO DEL DOCUMENTO
                </h1>
            </div> -->
            <?php if($mostrar) { ?>
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
            <?php } ?>

            <div class="panel panel-default">
                <div class="panel-body">

                    <?php if($mostrar) { ?>

                    <div class="row mostrar">
                        <div class="col-md-2"></div>
                        <div class="col-md-8 col-sm-12">
                            <div class="panel panel-info panel-dark">
                                <div class="panel-heading text-center">
                                    <span class="panel-title" style="font-size: 20px !important;">
                                        <strong>Ingrese codigo</strong>
                                    </span>
                                </div>
                                <div class="panel-body">
                                    <form id="form-consulta" class="search-form bg-primary" onsubmit="event.preventDefault();">
                                        <div class="input-group input-group-lg">
                                            <span class="input-group-addon no-background"><i class="fa fa-search"></i></span>
                                            <input type="text"
                                            id="term"
                                            class="form-control" placeholder="..."
                                            >
                                            <span class="input-group-btn">
                                                <button class="btn" id="btn-buscar" >Buscar</button>
                                            </span>
                                        </div>
                                    </form>
                                </div>
                                    
                            </div>
                        </div>
                        <div class="col-md-2"></div>
                    </div>

                    <?php } ?>
                    <!-- mostrar -->
                    <div id="principal" class="" style="<?php echo $hide; ?>">
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
                                        <img class="img-thumbnail" src="<?php assets('views/images/no_disponible.png'); ?>" style="width: 60%">
                                        <br><br>
                                        <h4>Timbre ---</h4>
                                    </div>

                                    <div class="col-sm-5 text-center" style="display: none;" id="qr">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <br>
                    <div style="display: none;" class="messageError form-group text-center">
                        <span class="alert alert-danger" id="textError">
                            
                        </span>
                    </div>

                </div>
            </div>
            
        </div>

    </div>