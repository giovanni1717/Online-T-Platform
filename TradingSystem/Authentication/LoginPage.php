<!DOCTYPE html>
<html lang="it">
<?php
	if (session_status() !== PHP_SESSION_ACTIVE) session_start();
?>
<head>
	<title>Login</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<form class="login100-form validate-form p-l-55 p-r-55 p-t-178" method="post" action="checklogin.php">
					<span class="login100-form-title">
						Benvenuto alla piattaforma Scambi!
					</span>

					<div class="wrap-input100 validate-input m-b-16" data-validate="Inserisci Username">
						<input class="input100" type="text" name="username" placeholder="Username" required>
						<span class="focus-input100"></span>
					</div>

					<?php
						if(isset($_SESSION["username_error_message"])){ ?>
							<div class="alert alert-danger" role="alert" style="margin-top: 15px; border-radius: 17px;">
								<?php echo $_SESSION["username_error_message"];
									unset($_SESSION["username_error_message"]);
								?>
							</div>
					<?php 
						}
					?>

					<div class="wrap-input100 validate-input" data-validate = "Inserisci Password">
						<input class="input100" type="password" name="password" placeholder="Password" required>
						<span class="focus-input100"></span>
					</div>

					<?php

						if(isset($_SESSION["password_error_message"]) && !isset($_SESSION["username_error_message"])){ ?>
							<div class="alert alert-danger" role="alert" style="margin-top: 15px; border-radius: 17px;">
								<?php echo $_SESSION["password_error_message"];
									unset($_SESSION["password_error_message"]);
								?>
							</div>
					<?php 
						}
					?>

					<div class="container-login100-form-btn">
						<button type="submit" class="login100-form-btn">
							Sign in
						</button>
					</div>

					<div class="flex-col-c p-t-170 p-b-40">
						<span class="txt1 p-b-9">
							Non hai un account?
						</span>

						<a href="RegisterPage.php" class="txt2">
							Registrati!
						</a>
					</div>
				</form>
			</div>
		</div>
	</div>

</body>
</html>