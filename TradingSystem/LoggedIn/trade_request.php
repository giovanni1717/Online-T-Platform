<?php
    require_once '../config/db_config.php';
    if (session_status() !== PHP_SESSION_ACTIVE) session_start();
    if(!isset($_SESSION["is_logged_in"]) || !isset($_SESSION["insertion_ID"])){
        // Redirect a pagina di non autorizzazione
        header('Location: ../Authentication/unauthorized.php', 401);
        exit;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $conn = db_setup_light();
        $query = "SELECT * FROM annunci WHERE Utente = ? and visibile = 1";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('s',$_SESSION["username"]);
        try {
            $stmt->execute();
            $result = $stmt->get_result();
            if($result->num_rows == 0){
                $stmt->close();
                $conn->close();
                $errorMessage = urlencode("Errore invio richiesta trattativa. Non hai nessun annuncio pubblicato!");
                header("Location: ../LoggedIn/HomePage.php?error=" . $errorMessage);
                exit;
            }
            
            
        } catch (mysqli_sql_exception $e) {
            $stmt->close();
            $conn->close();
            $errorMessage = urlencode("Errore invio richiesta trattativa. Riprovare più tardi");
            header("Location: ../LoggedIn/HomePage.php?error=" . $errorMessage);
            exit;
        }
        $query = "INSERT INTO richiestetrattativa values (CURRENT_TIMESTAMP, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('ss',$_SESSION["username"],$_SESSION["insertion_ID"]);
        try {
            $stmt->execute();
            $stmt->close();
            $conn->close();            
        } catch (mysqli_sql_exception $e) {
            $stmt->close();
            $conn->close();
            $errorMessage = urlencode("Errore invio richiesta trattativa. Riprovare più tardi");
            header("Location: ../LoggedIn/HomePage.php?error=" . $errorMessage);
            exit;
        }
        $successMessage = urlencode("Richiesta di trattativa inviata con successo.");
        header("Location: ../LoggedIn/HomePage.php?success=" . $successMessage);
        exit;
    }

?>