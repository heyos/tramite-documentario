<?php

$enlaces = new Enlaces();

?>

<!DOCTYPE html>
<!--[if IE 8]>         <html class="ie8"> <![endif]-->
<!--[if IE 9]>         <html class="ie9 gt-ie8"> <![endif]-->
<!--[if gt IE 9]><!--> <html class="gt-ie8 gt-ie9 not-ie"> <!--<![endif]-->
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>Menu Manager - <?php $enlaces -> titlePageController(); ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
	<meta name="description" content="sistema para gestionar las opciones de menu de tu sistema web, concede permisos segun el rol de usuario"/>
	<meta name="keywords" content="crear menu con php,menu manager, crear menu, sistema web, gestionar menu de sistema web, sistema para gestionar menu, menu manager para sistemas web,php mvc"/>
	<meta name="language" content="spanish" />
	<meta name="copyright" content="HR Developer Group">
	<meta name="author" content="HR Developer Group">
	<meta name="reply-to" content="heyller.ra@gmail.com">
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">

	<!-- Open Sans font from Google CDN -->
	<link href="http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,400,600,700,300&subset=latin" rel="stylesheet" type="text/css">

	<!-- Pixel Admin's stylesheets -->
	<link href="views/assets/stylesheets/bootstrap.min.css" rel="stylesheet" type="text/css">
	<link href="views/assets/stylesheets/pixel-admin.min.css" rel="stylesheet" type="text/css">
	<link href="views/assets/stylesheets/widgets.min.css" rel="stylesheet" type="text/css">
	<link href="views/assets/stylesheets/pages.min.css" rel="stylesheet" type="text/css">
	<link href="views/assets/stylesheets/rtl.min.css" rel="stylesheet" type="text/css">
	<link href="views/assets/stylesheets/themes.min.css" rel="stylesheet" type="text/css">
	<!--<link rel="stylesheet" type="text/css" href="views/css/font-awesome-4.7.0/css/font-awesome.min.css">-->
	<link rel="stylesheet" type="text/css" href="views/css/fontawesome-5.3.1/css/all.min.css">
	<link rel="stylesheet" type="text/css" href="views/css/custom.css">

	<!--[if lt IE 9]>
		<script src="views/assets/javascripts/ie.min.js"></script>
	<![endif]-->

</head>

<script>var init = [];</script>
<!-- Demo script --> <script src="views/assets/demo/demo.js"></script> <!-- / Demo script -->

	<?php 

	$enlaces -> enlaceController();

	?>
	
	<!-- Pixel Admin's javascripts -->
	<script src="views/js/jquery-2.0.3.min.js"></script>
	<script src="views/assets/javascripts/bootstrap.min.js"></script>
	<script src="views/assets/javascripts/pixel-admin.js"></script>
	<script src="views/js/jquery.alphanum.js"></script>
	
	
	<script src="views/js/default.js"></script>
	<script src="views/js/mainJsPermisosUsuario.js"></script>
	<script src="views/js/mainJsEmpresa.js"></script>
	<script src="views/js/mainJsUsuario.js"></script>
	<script src="views/js/mainJsRolUsuario.js"></script>
	<script src="views/js/mainJsMenu.js"></script>
	<script src="views/js/mainJsAsociados.js"></script>
	<script src="views/js/mainJsFile.js"></script>
	<script src="views/js/mainJsOrdenarMenu.js"></script>
	<script src="views/js/mainJsOrdenarSubmenu.js"></script>

	<script type="text/javascript">

		init.push(function () {
			
		});

		window.PixelAdmin.start(init);

	</script>

</body>
</html>