<?php
    
    $theme2 = $config->datosConfiguracionController("tema");
    $theme2 = ($theme2 == '')?"theme-default":$theme2;
    $vistaMenu2 = $config->datosConfiguracionController("vista");
    $vistaMenu2 = ($vistaMenu2 =='')?"menu_lateral":$vistaMenu2;
?>

<div id="main-menu" role="navigation">
    <div id="main-menu-inner">
        <div class="menu-content top" id="menu-content-demo">

            <div>
                
                <div class="text-bg"><span class="text-slim">Hola,</span> <span class="text-semibold"><?php echo $_SESSION["nombres"]; ?></span></div>

                <img src="views/assets/demo/avatars/1.jpg" alt="" class="">
                <div class="btn-group">
                    <a href="#" class="btn btn-xs btn-primary btn-outline dark"><i class="fa fa-envelope"></i></a>
                    <a href="#" class="btn btn-xs btn-primary btn-outline dark"><i class="fa fa-user"></i></a>
                    <a href="#" class="btn btn-xs btn-primary btn-outline dark"><i class="fa fa-cog"></i></a>
                    <a href="#" class="btn btn-xs btn-danger btn-outline dark"><i class="fa fa-power-off"></i></a>
                </div>
                
            </div>
        </div>
    
        <ul class="navigation">
            <?php

                if($vistaMenu2 == "menu_lateral"){
                    $menu = new Menu();
                    $menu -> listarMainMenuController();
                }
                    
            ?>
        
        </ul> <!-- / .navigation -->
        
        
    </div> <!-- / #main-menu-inner -->
</div> <!-- / #main-menu -->