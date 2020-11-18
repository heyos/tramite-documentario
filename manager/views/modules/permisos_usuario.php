<?php


include 'views/modules/start-main-wrapper.php';
include 'views/modules/main-menu.php';

$enlaces = new Enlaces();

$rol = new RolUsuario();

$nombreRol = $rol -> datosRolController("descripcion");

?>


<div id="content-wrapper">

    <div class="page-header">
        <h1 class="text-center text-left-sm">
            <i class="fa fa-user page-header-icon"></i> <?php $enlaces->titlePageController(); echo ' / '.$nombreRol; ?>
        </h1>
    </div>
    
    <div class="panel panel-default">

        <div class="panel-body">
            
            <?php

                $permisos = new Menu();
                $permisos -> permisosMenuController();

            ?>

        </div>

    </div>

</div> <!-- / #content-wrapper -->



<?php
include 'views/modules/end-main-wrapper.php';
?>