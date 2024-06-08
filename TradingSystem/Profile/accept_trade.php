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
        $transaction = "START TRANSACTION;
        INSERT INTO scambi values(CURRENT_TIMESTAMP()," . $_GET["annuncio_richiesto"] . "," . $_GET["annuncio_proposto"] . ");
        DELETE FROM propostedichiusuratrattativa WHERE annuncio_richiesto = " . $_GET["annuncio_richiesto"] . " or annuncio_richiesto = " . $_GET["annuncio_proposto"] . " or annuncio_proposto = " . $_GET["annuncio_proposto"] . " or annuncio_proposto = " . $_GET["annuncio_richiesto"] . ";
        DELETE FROM richiestetrattativa WHERE annuncio_richiesto = " . $_GET["annuncio_richiesto"] . " or annuncio_richiesto = " . $_GET["annuncio_proposto"] . ";
        UPDATE annunci SET Visibile = 0 WHERE ID = " . $_GET["annuncio_richiesto"] . " or ID = " . $_GET["annuncio_proposto"] . ";
        COMMIT;
        ";
        try {
            $was_everything_good = $conn->multi_query($transaction);
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
        } catch (Exception $e) {
            $conn->close();
            $errorMessage = urlencode("Errore nell'accettazione dello scambio. Riprovare più tardi");
            header("Location: ../LoggedIn/HomePage.php?error=" . $errorMessage);
            exit;
        }
        $conn->close();
        $successMessage = urlencode("Scambio accettato con successo.");
        header("Location: ../LoggedIn/HomePage.php?success=" . $successMessage);
        exit;
    }
?>
