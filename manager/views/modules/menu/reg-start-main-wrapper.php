<body class="theme-default main-menu-animated main-navbar-fixed main-menu-fixed">

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
                    <div class="text-center text-xlg">
                    
                        
                        <strong>GESTIONA TU MENU DE NAVEGACION</strong>

                        
                    </div>
                </div> <!-- / #main-navbar-collapse -->
            </div> <!-- / .navbar-inner -->
        </div> <!-- / #main-navbar -->