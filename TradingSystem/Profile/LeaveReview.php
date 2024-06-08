<?php

if (session_status() !== PHP_SESSION_ACTIVE) session_start();
    if(!isset($_SESSION["is_logged_in"]) || $_SESSION["review_lock"] || !isset($_GET["utente_scrivente"]) || !isset($_GET["utente_ricevente"]) || !isset($_GET["annuncio_avvio"]) || !isset($_GET["annuncio_completamento"])){
        // Redirect a pagina di non autorizzazione
        header('Location: ../Authentication/unauthorized.php', 401);
        exit;
    }
?>

<!DOCTYPE html>
<html lang="it">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
	<link href='css/reviewform.css' rel='stylesheet'>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
	<title>Lascia recensione</title>
	<script src="js/reviewform.js" defer></script>
</head>
<body>

	<div class="wrapper">
		<h3>Recensisci lo scambio con <?= $_GET["utente_ricevente"] ?></h3>
		<form action="SaveReview.php" method="post">
			<input type="hidden" name="utente_scrivente" value="<?= $_GET["utente_scrivente"] ?>">
			<input type="hidden" name="utente_ricevente" value="<?= $_GET["utente_ricevente"] ?>">
			<input type="hidden" name="annuncio_avvio" value="<?= $_GET["annuncio_avvio"] ?>">
			<input type="hidden" name="annuncio_completamento" value="<?= $_GET["annuncio_completamento"] ?>">
			<div class="rating">
				<input type="number" name="rating" hidden required>
				<i class='bx bx-star star' style="--i: 0;"></i>
				<i class='bx bx-star star' style="--i: 1;"></i>
				<i class='bx bx-star star' style="--i: 2;"></i>
				<i class='bx bx-star star' style="--i: 3;"></i>
				<i class='bx bx-star star' style="--i: 4;"></i>
			</div>
			<textarea name="testo" cols="30" rows="5" placeholder="La tua recensione..." onkeyup="countChar(this);"></textarea>
			<span id="charNum">300/300</span>
			<div class="btn-group">
				<button type="submit" class="btn submit">Invia</button>
				<button class="btn cancel"><a href="./view_completed_trades.php">Cancella</a></button>
			</div>
		</form>
	</div>


  
</body>
</html>