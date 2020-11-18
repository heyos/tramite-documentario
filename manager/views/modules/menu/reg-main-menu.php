<div id="main-menu" role="navigation">
    <div id="main-menu-inner">
        <div class="menu-content top" id="menu-content-demo">
            
            <div class="text-bg"><span class="text-slim">Bienvenido</span></div>

                <img src="views/assets/demo/avatars/1.jpg" alt="" class="">
                <div class="btn-group">
                    <a href="#" class="btn btn-xs btn-primary btn-outline dark"><i class="fa fa-envelope"></i></a>
                    <a href="#" class="btn btn-xs btn-primary btn-outline dark"><i class="fa fa-user"></i></a>
                    <a href="#" class="btn btn-xs btn-primary btn-outline dark"><i class="fa fa-cog"></i></a>
                    <a href="#" class="btn btn-xs btn-danger btn-outline dark"><i class="fa fa-power-off"></i></a>
                </div>
                
            
        </div>
    
        <ul class="navigation">
            <?php 
                $m = new Menu();
                $m -> listarMainMenuRegistroController();
            ?>
        </ul> <!-- / .navigation -->
        
        <div class="form-group text-center">
            <a href="#" onclick="event.preventDefault();verSitio()" class="btn btn-primary" target="_blank">Ver Sitio</a>
        </div>
        
        
        <div class=" menu-content text-center">

            <div class="text-bg"><span class="text-slim text-white" style="color:white">Contactanos</span></div>
            <div class="btn-group">
                <a href="https://api.whatsapp.com/send?phone=+51943494241" class="btn btn-rounded btn-lg btn-success"><i class="fab fa-whatsapp menu-icon"></i></a>
                <a href="https://m.me/hrsolucioneswebmovil" class="btn btn-rounded btn-lg btn-info"><i class="fab fa-facebook-messenger menu-icon"></i></a>
            </div>
        </div>
            
        
    </div> <!-- / #main-menu-inner -->
</div> <!-- / #main-menu -->