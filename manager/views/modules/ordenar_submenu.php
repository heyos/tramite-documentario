<?php


include 'views/modules/start-main-wrapper.php';
include 'views/modules/main-menu.php';

$enlaces = new Enlaces();

?>


<div id="content-wrapper">

    <div class="page-header">
        <h1 class="text-center text-left-sm">
            <i class="fa fa-sitemap page-header-icon"></i> <?php $enlaces -> titlePageController(); ?>
        </h1>
    </div>
    
    <div class="panel panel-default">

        <div class="panel-body row">

            <div class="col-sm-6">
                <?php
                    $ordenarSubMenu = new Menu();
                    $ordenarSubMenu -> listaOrdenarSubMenuController();
                ?>
            </div>
            

        </div>

    </div>

</div> <!-- / #content-wrapper -->



<?php
include 'views/modules/end-main-wrapper.php';
?>