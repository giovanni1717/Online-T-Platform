<?php
    require_once '../config/db_config.php';

    if (session_status() !== PHP_SESSION_ACTIVE) session_start();
    if(!isset($_SESSION["is_logged_in"]) || !isset($_GET["username_richiedente"]) || !isset($_GET["annuncio_richiesto"])){
        // Redirect a pagina di non autorizzazione
        header('Location: ../Authentication/unauthorized.php', 401);
        exit;
    }

    if ($_SERVER["REQUEST_METHOD"] == "GET") {

        $conn = db_setup_light();
        $query = 'DELETE FROM richiestetrattativa WHERE offerente = ? AND annuncio_richiesto = ?';
        $stmt = $conn->prepare($query);
        $stmt->bind_param('ss',$_GET["username_richiedente"],$_GET["annuncio_richiesto"]);
        try {
            $stmt->execute();
            $stmt->close();
            $conn->close();
        }
        catch (mysqli_sql_exception $e) {
            $stmt->close();
            $conn->close();
            $errorMessage = urlencode("Errore rifiuto offerta. Riprovare più tardi");
            header("Location: ../LoggedIn/HomePage.php?error=" . $errorMessage);
            exit;
        }
        $successMessage = urlencode("Richiesta rifiutata con successo.");
        header("Location: ../LoggedIn/HomePage.php?success=" . $successMessage);
        exit;
    }