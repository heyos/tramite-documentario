<?php


include 'views/modules/start-main-wrapper.php';
include 'views/modules/main-menu.php';

?>


<div id="content-wrapper">

    <div class="panel panel-default">
        <div class="panel-body">
            
            <div class="row">
                
                <div class="col-sm-6">
                    <div class="timeline">
                        <div class="tl-header now bg-primary">Caracteristicas</div>
                        <div class="tl-entry">
                            <div class="tl-icon bg-warning"><i class="fas fa-shield-alt"></i></div>
                            <div class="panel tl-body">
                                Acceso seguro y sistema de restablecimiento de contraseña.
                            </div> <!-- / .tl-body -->
                        </div>
                        <div class="tl-entry">
                            <div class="tl-icon bg-warning"><i class="far fa-file"></i></div>
                            <div class="panel tl-body">
                                Potente herramienta para iniciar un nuevo proyecto.
                            </div> <!-- / .tl-body -->
                        </div>
                        <div class="tl-entry">
                            <div class="tl-icon bg-warning"><i class="fa fa-sitemap"></i></div>
                            <div class="panel tl-body">
                                Gestión de menú y submenú. Arrastra y suelta para ordenar el menú y el submenú.
                            </div> <!-- / .tl-body -->
                        </div>
                        <div class="tl-entry">
                            <div class="tl-icon bg-warning"><i class="fas fa-user-shield"></i></div>
                            <div class="panel tl-body">
                                Gestión de usuarios.<br>
                                Gestión de roles.<br>
                                Gestión de permisos.
                            </div> <!-- / .tl-body -->
                        </div>
                        <div class="tl-entry">
                            <div class="tl-icon bg-warning"><i class="fab fa-css3"></i></div>
                            <div class="panel tl-body">
                                Bootstrap 3 & Font Awesome ultima version y todas las caracteristicas de PixelAdmin.
                            </div> <!-- / .tl-body -->
                        </div>
                        <div class="tl-entry">
                            <div class="tl-icon bg-warning"><i class="fas fa-question-circle"></i></div>
                            <div class="panel tl-body">
                                Soporte por videollamada para su implementación y capacitación, previa coordinación.
                            </div> <!-- / .tl-body -->
                        </div>
                        <div class="tl-header now bg-primary">Requerimientos</div>
                        <div class="tl-entry">
                            <div class="tl-icon bg-warning"><i class="fas fa-question-circle"></i></div>
                            <div class="panel tl-body">
                                Mínimo PHP v5.6 & Mysql.
                            </div> <!-- / .tl-body -->
                        </div>
                        <div class="tl-header now bg-primary">Actualizaciones</div>
                        <div class="tl-entry">
                            <div class="tl-icon bg-dark-gray">v1.5</div>
                            <div class="panel tl-body">
                                - Esta version es compatible con PHP 7.2<br>
                                - Modificaciones en el codigo fuente para poder guardar de manera ordenada las vistas de los modulos.<br>
                                - Se agrego una opcion en <strong>Rol Usuario</strong> de poder elegir la pagina de inicio de cada rol de usuario despues de iniciar sesion en el sistema.<br>
                                <strong>Sistema</strong><br>
                                - Se agrego una opcion <strong>configurar sistema</strong>, permite elegir el tema y elegir que tipo de menu de navegacion se desea LATERAL o TOP.<br>
                                <strong>Panel Manager</strong><br>
                                - Se agrego una opcion <strong>Registrar Menu Dinamico</strong>, ayudara a visualizar como se vera el menu de navegacion mientras 
                                registran las opciones de menu.
                            </div> <!-- / .tl-body -->
                        </div>
                        <div class="tl-entry">
                            <div class="tl-icon bg-dark-gray">v1.3</div>
                            <div class="panel tl-body">
                                <strong>Sistema</strong><br>
                                - Se quito Inicio de la base de datos y se habilito mediante codigo a que sea la vista que 
                                cargara automaticamente al iniciar sesión en el sistema.<br>
                                <strong>Panel Manager</strong><br>
                                - Se agrego en <strong>Menu</strong> los items ordenar menú y ordenar submenú, para ordenarlos tambien desde el panel manager.
                            </div> <!-- / .tl-body -->
                        </div>
                        <div class="tl-entry">
                            <div class="tl-icon bg-dark-gray">v1.2</div>
                            <div class="panel tl-body">
                                - Se aumento la seguridad en el acceso a la información en todo el sistema.<br>
                                <strong>Panel Manager</strong><br>
                                - Se mejoró el registro de url en menú y submenú.
                            </div> <!-- / .tl-body -->
                        </div>
                        <div class="tl-entry">
                            <div class="tl-icon bg-dark-gray">v1.1</div>
                            <div class="panel tl-body">
                                <strong>Panel Manager</strong><br>
                                - Solución de algunos bugs de validación en formularios.
                            </div> <!-- / .tl-body -->
                        </div>
                        <div class="tl-entry">
                            <div class="tl-icon bg-dark-gray">v1.0</div>
                            <div class="panel tl-body">
                                - Lanzamiento de la aplicación.
                            </div> <!-- / .tl-body -->
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <p class="text-bg text-justify">
                        <span class="text-slim"><strong>MENU MANAGER</strong> es el panel de administración que se puede utilizar para iniciar un nuevo proyecto. 
                        Tiene todas las características principales que se requieren para comenzar cualquier proyecto que tengas en mente. 
                        Este panel de administración le permitira gestionar tu <strong>menu de opciones dinamicamente</strong>, asi como <strong>ordenar el orden de visualizacion</strong> 
                        de las opciones del menu y del submenu.
                        El código es muy práctico y fácil de leer. Tiene un <strong>inicio de sesión seguro</strong> que tiene la validación del lado del cliente (con js) 
                        y del lado del servidor (con php). <strong>La gestión de usuarios</strong>  es el requisito 
                        básico que necesita cada panel de administración, que ya está incluido junto con el <strong>sistema de roles y permisos</strong>. 
                        Por lo tanto, tiene la capacidad de crear<strong> menus y submenus, usuarios, roles y permisos </strong> sin límites desde el primer momento. 
                        La interfaz es muy fácil de usar y útil. <strong>MENU MANAGER</strong> usa PixelAdmin que ya tiene los complementos como DataTables, Pace, select2, Morris JS,
                        Jquery Flot Charts, etc.</span>
                    </p>
                    <p class="text-bg text-justify">
                        <strong>MENU MANAGER</strong>, esta desarrollado bajo el patron de arquitectura de software<strong> MVC</strong> con el lenguaje de programacion PHP, Mysql
                        como gestor de Base de datos y Ajax.
                    </p>
                    <br>
                    <p class="text-center">
                        <iframe width="100%" height="315" src="https://www.youtube.com/embed/t_ws8ng9zTc" frameborder="0" 
                        allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    </p>
                    <p>
                        <div class="note note-info">Para los que compraron el sistema, tendran actualizaciones gratis de por vida. Las actualizaciones se publicaran en 
                        nuestra pagina de Facebook, lo podran requerir dejando un mensaje en nuestra pagina con su correo de su cuenta de paypal para
                        la verificación correspondiente. Estar siempre atentos.</div>
                        
                    </p>
                </div>
                <div class="col-sm-6">
                    
                </div>
            </div>
        
        </div>
    </div>

</div> <!-- / #content-wrapper -->


<?php

include 'views/modules/end-main-wrapper.php';

?>

