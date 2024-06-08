<?php

    require_once '../config/db_config.php';

    if (session_status() !== PHP_SESSION_ACTIVE) session_start();
    if(!isset($_SESSION["is_logged_in"])){
        // Redirect a pagina di non autorizzazione
        header('Location: ../Authentication/unauthorized.php', 401);
        exit;
    }

    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        if (session_status() !== PHP_SESSION_ACTIVE) session_start();
        if(!isset($_SESSION["requested_username"])) $username = $_SESSION["username"];
        else $username = $_SESSION["requested_username"];
        $conn = db_setup_light(); 
        $query = "SELECT nome,cognome,email,username,ValutazioneMedia FROM utenti WHERE username = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('s',$username);
        try {
            $stmt->execute();
            $result = $stmt->get_result();
            $info = $result->fetch_assoc();
            $stmt->close();
            $conn->close();
        } catch (mysqli_sql_exception $e) {
            $stmt->close();
            $conn->close();
            $errorMessage = urlencode("Errore nell'ottenimento delle informazioni sul profilo utente. Riprovare più tardi");
            header("Location: ../LoggedIn/HomePage.php?error=" . $errorMessage);
            exit;
        }
    }
?>