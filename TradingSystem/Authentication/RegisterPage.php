<!DOCTYPE html>
<html lang="it">
<?php
	if (session_status() !== PHP_SESSION_ACTIVE) session_start();
?>
<head>
	<title>Registrati</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<script src="js/input_validator.js"></script>
	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</head>
<body>
	
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<form class="login100-form validate-form p-l-55 p-r-55 p-t-148" method="post" action="checkregistration.php">
					<span class="login100-form-title">
						Benvenuto alla piattaforma Scambi!
					</span>

					<div class="wrap-input100 validate-input m-b-16" data-validate="Inserisci Nome">
						<input class="input100" type="text" name="Nome" size="50" maxlength="30" placeholder="Nome" required onkeyup="checkEmail(true)">
						<span class="focus-input100"></span>
					</div>

                    <div class="wrap-input100 validate-input m-b-16" data-validate="Inserisci Cognome">
						<input class="input100" type="text" name="Cognome" size="50" maxlength="30" placeholder="Cognome" required onkeyup="checkEmail(true)">
						<span class="focus-input100"></span>
					</div>

                    <div class="wrap-input100 validate-input m-b-16" data-validate="Inserisci Email">
						<input class="input100" type="text" name="Email" id="email" size="50" maxlength="50" placeholder="Email" required onkeyup="checkEmail(false)">
						<span class="focus-input100"></span>
					</div>

					<div id="EmailAlertPlaceholder"></div>

                    <div class="wrap-input100 validate-input m-b-16" data-validate="Inserisci Username">
						<input class="input100" type="text" name="Username" id="username" size="50" maxlength="30" placeholder="Username" required onkeyup="checkUsername(false)">
						<span class="focus-input100"></span>
					</div>

					<div id="UsernameAlertPlaceholder"></div>

					<div class="wrap-input100 validate-input" data-validate = "Inserisci Password">
						<input class="input100" type="password" name="Password" id="password" size="50" maxlength="20" placeholder="Password" required onkeyup="checkValues()">
						<span class="focus-input100"></span>
					</div>

					<div id="PasswordAlertPlaceholder"></div>

					<div class="container-login100-form-btn">
						<button type="submit" id="submitButton" class="login100-form-btn" disabled>
							Registrati
						</button>
					</div>

					<div class="flex-col-c p-t-30 p-b-10">
						<span class="txt1 p-b-5">
							Hai già un account?
						</span>

						<a href="LoginPage.php" class="txt2">
							Fai il login!
						</a>
					</div>
				</form>
			</div>
		</div>
	</div>

	<?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show floating-alert" role="alert" style="position: fixed; bottom: 0; margin-left: 540px; margin-bottom: 60px; z-index: 1023; width: 30%">
            <strong>Attenzione:</strong>
            <?php echo htmlspecialchars(urldecode($_GET['error'])); ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

</body>
</html>