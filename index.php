<!DOCTYPE html>
<html lang="en">

<head>
	<title>Link</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--===============================================================================================-->
	<link rel="icon" type="image/png" href="assets/img/kaiadmin/favicon.png" />
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="login/vendor/bootstrap/css/bootstrap.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="login/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="login/fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="login/vendor/animate/animate.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="login/vendor/css-hamburgers/hamburgers.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="login/vendor/animsition/css/animsition.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="login/vendor/select2/select2.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="login/vendor/daterangepicker/daterangepicker.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="login/css/util.css">
	<link rel="stylesheet" type="text/css" href="login/css/main.css">
	<!--===============================================================================================-->

	</style>
</head>

<body style="background-color: #ebeeef;">

	<div class="limiter">
		<nav style="text-align:center; background-color: #ebeeef;margin-top: 60px;">
			<img src="login/images/logo.png" id=logo alt="Newcoffee" width="20%" height="20%" />
		</nav>
		<div class="container-login100">
			<div class="wrap-login100">
				<div class="login100-form-title" style="background-image: url(login/images/login.jpg);">	
					<span class="login100-form-title-1">
						 .
					</span>
				</div>
				<form class="login100-form validate-form d-flex justify-content-center" action="login/Auth.php" method="post">
					<div class="wrap-input100 validate-input m-b-26 d-flex justify-content-center" data-validate="Username is required">
						<span class="label-input100">Utilizador</span>
						<input class="input100" type="text" name="username" placeholder="Insira o nome de utilizador">
						<span class="focus-input100"></span>
					</div>

					<div class="wrap-input100 validate-input m-b-18 d-flex justify-content-center" data-validate="Insira a sua password">
						<span class="label-input100">Password</span>
						<input class="input100" type="password" name="password" placeholder="Enter password">
						<span class="focus-input100"></span>
					</div>

					<div class="container-login100-form-btn d-flex justify-content-center" >
						<input class="login100-form-btn" style="background-color:rgb(120, 188, 255);" type="submit" value="Login" />
					</div>
				</form>
			</div>
			<!-- Move the footer outside of the wrap-login100 div -->
		</div>
		<footer style="background-color: #ebeeef; text-align: center;">
			<p>Author: D.S.I. 2025</p>	
		</footer>
	</div>

	<!--===============================================================================================-->
	<script src="login/vendor/jquery/jquery-3.2.1.min.js"></script>
	<!--===============================================================================================-->
	<script src="login/vendor/animsition/js/animsition.min.js"></script>
	<!--===============================================================================================-->
	<script src="login/vendor/bootstrap/js/popper.js"></script>
	<!--===============================================================================================-->
	<script src="login/vendor/bootstrap/js/bootstrap.min.js"></script>
	<!--===============================================================================================-->
	<script src="login/vendor/select2/select2.min.js"></script>
	<!--===============================================================================================-->
	<script src="login/vendor/daterangepicker/moment.min.js"></script>
	<!--===============================================================================================-->
	<script src="login/vendor/daterangepicker/daterangepicker.js"></script>
	<!--===============================================================================================-->
	<script src="login/vendor/countdowntime/countdowntime.js"></script>
	<!--===============================================================================================-->
	<script src="login/js/main.js"></script>

</body>

</html>