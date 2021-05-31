<?php

$config = new Configuracion();

$theme = $config->datosConfiguracionController("tema");
$theme = ($theme == '')?"theme-default":$theme;
$vistaMenu = $config->datosConfiguracionController("vista");
$vistaMenu = ($vistaMenu =='')?"menu_lateral":$vistaMenu;

?>

<body class="<?php echo $theme; ?> main-menu-animated main-navbar-fixed main-menu-fixed <?php echo $vistaMenu; ?>">

  <div id="preloader">
    <div class="text-center " id="status">
        <img src="views/images/Preloader.gif" alt="Preloader" class="img-responsive" style="margin: 0 auto">
    </div>
  </div>

    <div id="main-wrapper">

        <div id="main-navbar" class="navbar navbar-inverse" role="navigation">
            <!-- Main menu toggle -->
            <button type="button" id="main-menu-toggle"><i class="navbar-icon fa fa-bars icon"></i><span class="hide-menu-text">HIDE MENU</span></button>

            <div class="navbar-inner">
                <!-- Main navbar header -->
                <div class="navbar-header">

                    <a href="index.php?action=inicio" class="navbar-brand">
                        <?php
                            $e = new Empresa();
                            $imagen = $e -> datosEmpresaController("foto");

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
                    <div>

                        <?php

                            if($vistaMenu == "no-main-menu"){
                                $navbar = new Menu();
                                $navbar-> listarNavBarMenuController();
                            }

                        ?>

                        <div class="right clearfix">
                            <ul class="nav navbar-nav pull-right right-navbar-nav">
                                <?php
                                    $usuario_id = $_SESSION['usuario_id'];
                                    $resumen = ResumenDocumentoUsuarioController::detalleResumen($usuario_id);

                                    $proceso_de_firma = !empty($resumen) ? $resumen['proceso_de_firma'] : 0;
                                    $displaySec = $proceso_de_firma == 0 ?  '' : 'display: none;' ;
                                    $displayPrin = $proceso_de_firma > 0 ? '' : 'display: none;' ;
                                    
                                ?>

                                <li class="nav-icon-btn nav-icon-btn-danger dropdown">
                                    <a href="#notifications" class="dropdown-toggle" data-toggle="dropdown">
                                        <span class="label"><?php echo $proceso_de_firma; ?></span>
                                        <i class="nav-icon fa fa-bullhorn"></i>
                                        <span class="small-screen-text">Notifications</span>
                                    </a>

                                    <!-- NOTIFICATIONS -->
                                    <div class="dropdown-menu widget-notifications no-padding" style="width: 300px;height: 60px !important;">

                                        <div class="notifications-list" id="main-navbar-notifications">

                                            <div class="notification" style="<?php echo $displaySec; ?>" >
                                                <div class="notification-title text-default">TIENE 0 DOCUMENTO PENDIENTES DE FIRMA</div>
                                            </div>

                                            <div data-estado="1" class="notification estado" style="<?php  echo $displayPrin;  ?> cursor: pointer;" >
                                                <div class="notification-title text-info">EN PROCESO DE FIRMA</div>
                                                <div class="notification-description">
                                                    Tiene <strong>"<?php echo $proceso_de_firma ?> documento(s)"</strong> en proceso de firma.
                                                </div>
                                                <div class="notification-icon fa fa-clock-o bg-info"></div>
                                            </div>

                                            
                                        </div>
                                    </div>
                                </li>

                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle user-menu" data-toggle="dropdown">
                                        <!-- <img src="views/assets/demo/avatars/1.jpg" alt=""> -->
                                        <span><?php echo $_SESSION["fullname"]; ?></span>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a href="index.php?action=salir"><i class="dropdown-icon fa fa-power-off"></i>&nbsp;&nbsp;Log Out</a></li>
                                    </ul>
                                </li>
                            </ul> <!-- / .navbar-nav -->
                        </div> <!-- / .right -->
                    </div>
                </div> <!-- / #main-navbar-collapse -->
            </div> <!-- / .navbar-inner -->
        </div> <!-- / #main-navbar -->
