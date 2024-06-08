<?php
    require_once '../config/db_config.php';
    if (session_status() !== PHP_SESSION_ACTIVE) session_start();
    if(!isset($_SESSION["is_logged_in"]) || !isset($_SESSION["proposition_sent"]) || $_SESSION["proposition_lock"]){
        // Redirect a pagina di non autorizzazione
        header('Location: ../Authentication/unauthorized.php', 401);
        exit;
    }

    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        if(($_SESSION["last_requested_id"] === $_GET["annuncio_richiesto"]) && ($_SESSION["last_proposed_id"] === $_GET["annuncio_proposto"])){
            $errorMessage = urlencode("Invio proposta chiusura trattativa non consentita");
            header("Location: ../LoggedIn/HomePage.php?error=" . $errorMessage);
            exit;
        }

        $conn = db_setup_light();
        $transaction = "START TRANSACTION;
        INSERT INTO propostedichiusuratrattativa values (CURRENT_TIMESTAMP, " . $_GET["annuncio_richiesto"] . ", " . $_GET["annuncio_proposto"] . ");
        DELETE FROM richiestetrattativa WHERE offerente = '" . $_SESSION["username_richiedente"] . "' and annuncio_richiesto = " . $_GET["annuncio_richiesto"] . ";
        COMMIT;
        ";
        try {
            $conn->multi_query($transaction);
            do {
                if ($result = $conn->store_result()) {
                    $result->free();
                }
                if ($conn->more_results()) {
                    if (!$conn->next_result()) {
                        throw new Exception("Errore: " . $conn->error);
                    }
                }
            } while ($conn->more_results());
            unset($_SESSION["username_richiedente"]);
            $_SESSION["last_requested_id"] = $_GET["annuncio_richiesto"];
            $_SESSION["last_proposed_id"] = $_GET["annuncio_proposto"];
            $_SESSION["proposition_lock"] = true;         
        } catch (Exception $e) {
            $conn->close();
            $errorMessage = urlencode("Errore invio proposta di chiusura trattativa. Riprovare più tardi");
            header("Location: ../LoggedIn/HomePage.php?error=" . $errorMessage);
            exit;
        }
        $conn->close();
        $successMessage = urlencode("Proposta di chiusura trattativa inviata con successo.");
        header("Location: ../LoggedIn/HomePage.php?success=" . $successMessage);
        exit;
    }

?>