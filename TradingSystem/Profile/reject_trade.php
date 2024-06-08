<?php

    require_once '../config/db_config.php';

    if (session_status() !== PHP_SESSION_ACTIVE) session_start();
    if(!isset($_SESSION["is_logged_in"]) || !isset($_GET["annuncio_richiesto"]) || !isset($_GET["annuncio_proposto"])){
        // Redirect a pagina di non autorizzazione
        header('Location: ../Authentication/unauthorized.php', 401);
        exit;
    }

    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        $conn = db_setup_light();
        $query = 'DELETE FROM propostedichiusuratrattativa WHERE annuncio_richiesto = ? and annuncio_proposto = ?'; 
        $stmt = $conn->prepare($query);
        $stmt->bind_param('ss',$_GET["annuncio_richiesto"],$_GET["annuncio_proposto"]);
        try {
            $stmt->execute();
        } catch (mysqli_sql_exception $e) {
            $stmt->close();
            $conn->close();
            $errorMessage = urlencode("Errore nel rifiuto della proposta. Riprovare più tardi");
            header("Location: ../LoggedIn/HomePage.php?error=" . $errorMessage);
            exit;
        }
        $stmt->close();
        $conn->close();
        $successMessage = urlencode("Scambio rifiutato con successo.");
        header("Location: ../LoggedIn/HomePage.php?success=" . $successMessage);
        exit;
    }

?>
