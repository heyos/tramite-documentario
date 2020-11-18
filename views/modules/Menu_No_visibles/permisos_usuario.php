<?php

if(!$_SESSION["validar"]){

    header("location: index.php?action=ingreso");

    exit();

}

include 'views/modules/start-main-wrapper.php';
include 'views/modules/main-menu.php';

$enlaces =  new Enlaces();
$datosRol = new RolUsuario();
$respuesta = $datosRol -> datosRolController();
$nombreRol = ($respuesta !="error")?$respuesta["descripcion"]:$respuesta;

?>


<div id="content-wrapper">

    <div class="page-header">
        <h1 class="text-center text-left-sm">
            <?php $enlaces -> pageHeaderController(); echo ' / '.$nombreRol; ?>
        </h1>
    </div>

    <div class="panel panel-default">
        
        <div class="panel-body row">

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