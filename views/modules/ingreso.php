<body class="theme-default page-signin-alt">


    <div class="signin-header">
        <a href="#" onclick="event.preventDefault()" class="logo">
            <div class="demo-logo bg-primary">
			<img src="views/assets/demo/logo-medinort-nuevo1.png" width="180" alt="" style="margin-top: -4px;">
			</div>&nbsp;
            <!-- <strong>Medinort</strong> -->
        </a>

    </div>

    <h1 class="form-header">Ingrese a su cuenta de usuario</h1>
    
    <div class="row">
        <div class="col-sm-4 col-xs-hide">
            <img class="img-responsive pull-right" src="views/assets/demo/Logo Medinort.gif" alt=""
            style="height: 233.567px">
        </div>
        <div class="col-sm-4 col-xs-12">

            <form id="signin-form_id" class="panel" >
                <div class="form-group">
                    <input type="text" name="username" id="username_id" minlength="3" class="form-control input-lg validar" value="admin" placeholder="Username" required="">
                </div>

                <div class="form-group signin-password">
                    <input type="password" name="password" id="password_id" minlength="6" class="form-control input-lg validar" value="admin123456" placeholder="Password" required="">

                </div>

                <div id="divButton" class="form-actions">
                    <button type="button" id="btn-ingresar" class="btn btn-primary btn-block btn-lg" >Sign In</button>
                </div>
                <br>
                <div class="alerta"></div>
            </form>
        </div>
        <div class="col-sm-4 col-xs-hide"></div>
    </div>

    <!-- <form id="signin-form_id" class="panel" >
        <div class="form-group">
            <input type="text" name="username" id="username_id" minlength="3" class="form-control input-lg validar" value="admin" placeholder="Username" required="">
        </div>

        <div class="form-group signin-password">
            <input type="password" name="password" id="password_id" minlength="6" class="form-control input-lg validar" value="admin123456" placeholder="Password" required="">

        </div>

        <div id="divButton" class="form-actions">
            <button type="button" id="btn-ingresar" class="btn btn-primary btn-block btn-lg" >Sign In</button>
        </div>
        <br>
        <div class="alerta"></div>
    </form> -->

    <div class="signin-with">
		<div class="signin-header">
		<div class="demo-logo">
            <img src="views/assets/demo/Logo redondo.jpg" width="50" alt="" style="">
        </div>
			<a href="http://www.enterprisechile.cl"><strong>EnterpriseChile</strong></a>
        <br><br><p>Soluciones Tecnológicas</p>
		</div>
		<div class="btn-group">
            <a href="https://api.whatsapp.com/send?phone=+56994403763" class="btn btn-rounded  btn-success"><i class="fab fa-whatsapp menu-icon"></i></a>
            <a href="https://m.me/enterprisechile" class="btn btn-rounded  btn-info"><i class="fab fa-facebook-messenger menu-icon"></i></a>
        </div>

    </div>
