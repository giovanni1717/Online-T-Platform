<?php

    require_once '../config/db_config.php';

    if (session_status() !== PHP_SESSION_ACTIVE) session_start();
    if(!isset($_SESSION["is_logged_in"]) || !isset($_GET["username"])){
        // Redirect a pagina di non autorizzazione
        header('Location: ../Authentication/unauthorized.php', 401);
        exit;
    }

    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        $conn = db_setup_light();
        $query = 'SELECT Testo,Rating,Data,utente_scrivente FROM recensioni WHERE utente_ricevente = ?';
        $stmt = $conn->prepare($query);
        $stmt->bind_param('s',$_GET["username"]);
        try {
            $stmt->execute();
            $result = $stmt->get_result();
            $reviews = $result->fetch_all(MYSQLI_ASSOC);
            $performedquery = true;
        } catch (mysqli_sql_exception $e) {
            $stmt->close();
            $conn->close();
            $errorMessage = urlencode("Errore nell'ottenimento delle informazioni sulle recensioni. Riprovare più tardi");
            header("Location: ../LoggedIn/HomePage.php?error=" . $errorMessage);
            exit;
        }
        $stmt->close();
        $conn->close();
    }

?>
