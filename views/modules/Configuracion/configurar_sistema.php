<?php

if(!$_SESSION["validar"]){

    header("location: index.php?action=ingreso");

    exit();

}

include 'views/modules/start-main-wrapper.php';
include 'views/modules/main-menu.php';

$enlaces = new Enlaces();
$mantenimiento = $enlaces->mantenimientoDatosController();

$configSis = new Configuracion();

$checkedTheme = $config->datosConfiguracionController("checkedTheme");
$checkedVista = $config->datosConfiguracionController("checkedVista");
$opTheme = $config->datosConfiguracionController("opTheme");
$opVista = $config->datosConfiguracionController("opVista");

?>


<div id="content-wrapper">

    <div class="page-header">
        <h1 class="text-center text-left-sm">
            <?php $enlaces -> pageHeaderController(); ?>
        </h1>
    </div>
    
    <div class="panel panel-default">

        <div class="panel-body">

            <form id="formConfi">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="panel panel-primary panel-dark" style="border-color:#428bca !important">
                            <div class="panel-heading">
                                <span class="panel-title" style="color:#fff"><strong>Escoger tema del Sistema</strong></span>
                            </div>
                            <div class="panel-body">

                                <div class="row">
                                    <div class="col-sm-4">
                                        <div id="theme-default" class="panel <?php echo $opTheme['theme-default']; ?> colourable panel-theme panel-dark">
                                            <div class="panel-heading">
                                                <span class="panel-title"><b>Default</b></span>
                                                <div class="panel-heading-controls">
                                                    <input type="radio" name="theme" <?php echo $checkedTheme['theme-default']; ?> value="theme-default">
                                                </div> 
                                            </div>
                                            <div class="panel-body">
                                                <img class="img-responsive" src="views/images/themes/default.png">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div id="theme-dust" class="panel <?php echo $opTheme['theme-dust']; ?> colourable panel-theme panel-dark">
                                            <div class="panel-heading">
                                                <span class="panel-title"><b>Dust</b></span>
                                                <div class="panel-heading-controls">
                                                    <input type="radio" name="theme" <?php echo $checkedTheme['theme-dust']; ?>  value="theme-dust">
                                                </div> 
                                            </div>
                                            <div class="panel-body">
                                                <img class="img-responsive" src="views/images/themes/dust.png">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div id="theme-asphalt" class="panel <?php echo $opTheme['theme-asphalt']; ?> colourable panel-theme panel-dark">
                                            <div class="panel-heading">
                                                <span class="panel-title"><b>Asphalt</b></span>
                                                <div class="panel-heading-controls">
                                                    <input type="radio" name="theme" <?php echo $checkedTheme['theme-asphalt']; ?>  value="theme-asphalt">
                                                </div> 
                                            </div>
                                            <div class="panel-body">
                                                <img class="img-responsive" src="views/images/themes/asphalt.png">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    
                                    <div class="col-sm-4">
                                        <div id="theme-adminflare" class="panel <?php echo $opTheme['theme-adminflare']; ?> colourable panel-theme panel-dark">
                                            <div class="panel-heading">
                                                <span class="panel-title"><b>Adminflare</b></span>
                                                <div class="panel-heading-controls">
                                                    <input type="radio" name="theme" <?php echo $checkedTheme['theme-adminflare']; ?> value="theme-adminflare">
                                                </div> 
                                            </div>
                                            <div class="panel-body">
                                                <img class="img-responsive" src="views/images/themes/adminflare.png">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div id="theme-clean" class="panel <?php echo $opTheme['theme-clean']; ?> colourable panel-theme panel-dark">
                                            <div class="panel-heading">
                                                <span class="panel-title"><b>Clean</b></span>
                                                <div class="panel-heading-controls">
                                                    <input type="radio" name="theme" <?php echo $checkedTheme['theme-clean']; ?> value="theme-clean">
                                                </div> 
                                            </div>
                                            <div class="panel-body">
                                                <img class="img-responsive" src="views/images/themes/clean.png">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div id="theme-purple-hills" class="panel <?php echo $opTheme['theme-purple-hills']; ?> colourable panel-theme panel-dark">
                                            <div class="panel-heading">
                                                <span class="panel-title"><b>Purple Hills</b></span>
                                                <div class="panel-heading-controls">
                                                    <input type="radio" name="theme" <?php echo $checkedTheme['theme-purple-hills']; ?> value="theme-purple-hills">
                                                </div> 
                                            </div>
                                            <div class="panel-body">
                                                <img class="img-responsive" src="views/images/themes/purple-hills.png">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div id="theme-frost" class="panel <?php echo $opTheme['theme-frost']; ?> colourable panel-theme panel-dark">
                                            <div class="panel-heading">
                                                <span class="panel-title"><b>Frost</b></span>
                                                <div class="panel-heading-controls">
                                                    <input type="radio" name="theme" <?php echo $checkedTheme['theme-frost']; ?> value="theme-frost">
                                                </div> 
                                            </div>
                                            <div class="panel-body">
                                                <img class="img-responsive" src="views/images/themes/frost.png">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div id="theme-silver" class="panel <?php echo $opTheme['theme-silver']; ?> colourable panel-theme panel-dark">
                                            <div class="panel-heading">
                                                <span class="panel-title"><b>Silver</b></span>
                                                <div class="panel-heading-controls">
                                                    <input type="radio" name="theme" <?php echo $checkedTheme['theme-silver']; ?> value="theme-silver">
                                                </div> 
                                            </div>
                                            <div class="panel-body">
                                                <img class="img-responsive" src="views/images/themes/silver.png">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div id="theme-white" class="panel <?php echo $opTheme['theme-white']; ?> colourable panel-theme panel-dark">
                                            <div class="panel-heading">
                                                <span class="panel-title"><b>White</b></span>
                                                <div class="panel-heading-controls">
                                                    <input type="radio" name="theme" <?php echo $checkedTheme['theme-white']; ?> value="theme-white">
                                                </div> 
                                            </div>
                                            <div class="panel-body">
                                                <img class="img-responsive" src="views/images/themes/white.png">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div id="theme-fresh" class="panel <?php echo $opTheme['theme-fresh']; ?> colourable panel-theme panel-dark">
                                            <div class="panel-heading">
                                                <span class="panel-title"><b>Fresh</b></span>
                                                <div class="panel-heading-controls">
                                                    <input type="radio" name="theme" <?php echo $checkedTheme['theme-fresh']; ?> value="theme-fresh">
                                                </div> 
                                            </div>
                                            <div class="panel-body">
                                                <img class="img-responsive" class="img-responsive" src="views/images/themes/fresh.png">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div> 
                    </div>

                    <div class="col-sm-6">
                        <div class="panel panel-primary panel-dark" style="border-color:#428bca !important">
                            <div class="panel-heading">
                                <span class="panel-title" style="color:#fff"><strong>Escoger Vista de Menu de Opciones</strong></span>
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    
                                    <div class="col-sm-6">
                                        <div id="menu_lateral" class="panel panel-menu <?php echo $opVista['menu_lateral']; ?> colourable panel-dark">
                                            <div class="panel-heading">
                                                <span class="panel-title"><b>Menu Lateral</b></span>
                                                <div class="panel-heading-controls">
                                                    <input type="radio" name="viewMenu" <?php echo $checkedVista['menu_lateral']; ?> value="menu_lateral">
                                                </div> 
                                            </div>
                                            <div class="panel-body">
                                                <img class="img-responsive" src="views/images/views_menu/menu_izq.png">
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-sm-6">
                                        <div id="no-main-menu" class="panel panel-menu <?php echo $opVista['no-main-menu']; ?> colourable panel-dark">
                                            <div class="panel-heading">
                                                <span class="panel-title"><b>Menu Top</b></span>
                                                <div class="panel-heading-controls">
                                                    <input type="radio" name="viewMenu" <?php echo $checkedVista['no-main-menu']; ?> value="no-main-menu">
                                                </div> 
                                            </div>
                                            <div class="panel-body">
                                                <img class="img-responsive" src="views/images/views_menu/menu_top.png">
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="form-group text-center">
                                    <button type="button" id="saveConfig" class="btn btn-primary">Guardar Configuracion</button>
                                </div>
                                
                                

                            </div>
                        </div>

                        <div class="respuesta"></div>
                    </div>
                </div>
            </form>           
            
            

        </div>

    </div>

</div> <!-- / #content-wrapper -->



<?php
include 'views/modules/end-main-wrapper.php';
?>