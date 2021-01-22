<?php
ob_start();
session_start();

$enlaces = new Enlaces();

?>

<!DOCTYPE html>
<!--[if IE 8]>         <html class="ie8"> <![endif]-->
<!--[if IE 9]>         <html class="ie9 gt-ie8"> <![endif]-->
<!--[if gt IE 9]><!--> <html class="gt-ie8 gt-ie9 not-ie"> <!--<![endif]-->
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title><?php $enlaces -> titlePageController(); ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">

	<meta name="description" content="sistema Medinort"/>
	<meta name="keywords" content="Medinort"/>
	<meta name="language" content="spanish" />
	<meta name="copyright" content="EnterpriseChile">
	<meta name="author" content="EnterpriseChile">
	<meta name="reply-to" content="contacto@enterprisechile.cl">
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">

	<!-- Open Sans font from Google CDN -->
	<link href="http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,400,600,700,300&subset=latin" rel="stylesheet" type="text/css">

	<!-- Pixel Admin's stylesheets -->
	<!-- <link href="views/css/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" type="text/css"> -->
	<link href="views/assets/stylesheets/bootstrap.min.css" rel="stylesheet" type="text/css">
	<link href="views/assets/stylesheets/pixel-admin.min.css" rel="stylesheet" type="text/css">
	<link href="views/assets/stylesheets/widgets.min.css" rel="stylesheet" type="text/css">
	<link href="views/assets/stylesheets/pages.min.css" rel="stylesheet" type="text/css">
	<link href="views/assets/stylesheets/rtl.min.css" rel="stylesheet" type="text/css">
	<link href="views/assets/stylesheets/themes.min.css" rel="stylesheet" type="text/css">
	<!--<link rel="stylesheet" type="text/css" href="views/css/font-awesome-4.7.0/css/font-awesome.min.css">-->
	<link rel="stylesheet" type="text/css" href="views/css/fontawesome-5.3.1/css/all.min.css">
	<link rel="stylesheet" type="text/css" href="views/css/select2.min.css">
	<link rel="stylesheet" type="text/css" href="views/css/custom.css">
	<link rel="stylesheet" type="text/css" href="views/css/sweetalert.css">
	<!-- <link rel="stylesheet" type="text/css" href="views/css/datatables.net-bs/css/dataTables.bootstrap.min.css"> -->
	<!-- <link rel="stylesheet" type="text/css" href="views/css/datatables.net-bs/css/responsive.bootstrap.min.css"> -->
	<link rel="stylesheet" href="views/css/styles.css">

	<!-- Pixel Admin's javascripts -->
	<script src="views/js/jquery-2.0.3.min.js"></script>
	<!-- <script src="views/assets/javascripts/jquery-ui-extras.min.js"></script> -->
	<script src="views/assets/javascripts/bootstrap.min.js"></script>
	<script src="views/js/select2.min.js"></script>
	<script src="views/assets/javascripts/pixel-admin.min.js"></script>
	<!-- <script src="views/js/jquery.dataTables.js"></script> -->
	<!-- <script src="views/js/datatables.net/js/jquery.dataTables.min.js"></script> -->
  <!-- <script src="views/js/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
  <script src="views/js/datatables.net-bs/js/dataTables.responsive.min.js"></script>
  <script src="views/js/datatables.net-bs/js/responsive.bootstrap.min.js"></script> -->
	<script src="views/js/jquery.alphanum.js"></script>
	<script src="views/js/sweetalert.min.js"></script>
	<script src="views/js/jquery_Rut_min.js"></script>
	<script src="views/js/jquery.blockUI.js"></script>
	<script src="https://mozilla.github.io/pdf.js/build/pdf.js"></script>

	<!--[if lt IE 9]>
		<script src="views/assets/javascripts/ie.min.js"></script>
	<![endif]-->

</head>

<script>var init = [];</script>
<!-- Demo script -->
<script src="views/assets/demo/demo.js"></script>
<!-- / Demo script -->

	<?php

		$enlaces -> enlaceController();



	?>
	<!-- PRELOADER -->


	<script src="views/mainJs/default.js"></script>

	<?php

		$script = new File();
		$script -> listarFilesController();
	?>

	<script type="text/javascript">

		init.push(function () {
			//aqui poner codigo javascript
		});

		window.PixelAdmin.start(init);

	</script>

</body>
</html>

<?php ob_end_flush();?>
