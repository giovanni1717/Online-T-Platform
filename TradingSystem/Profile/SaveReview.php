<?php

    require_once '../config/db_config.php';

    if (session_status() !== PHP_SESSION_ACTIVE) session_start();
        if(!isset($_SESSION["is_logged_in"]) || !isset($_POST["utente_scrivente"]) || !isset($_POST["utente_ricevente"]) || !isset($_POST["annuncio_avvio"]) || !isset($_POST["annuncio_completamento"])){
            // Redirect a pagina di non autorizzazione
            header('Location: ../Authentication/unauthorized.php', 401);
            exit;
        }


    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $conn = db_setup_light();
        $transaction = 'START TRANSACTION;
        INSERT INTO recensioni VALUES("' . $_POST["testo"] . '", ' . $_POST["rating"] . ', "' . $_POST["utente_scrivente"] . '", "' . $_POST["utente_ricevente"] . '", ' . $_POST["annuncio_avvio"] . ', ' . $_POST["annuncio_completamento"] . ', CURRENT_TIMESTAMP());
        UPDATE utenti
            SET ValutazioneMedia =
                CASE WHEN RecensioniRicevute = 0 THEN ' . $_POST["rating"] . '
                ELSE ((ValutazioneMedia * RecensioniRicevute) + ' . $_POST["rating"] . ')/(RecensioniRicevute + 1) 
                END,
            RecensioniRicevute = RecensioniRicevute + 1 
            WHERE username = "' . $_POST["utente_ricevente"] . '";
            COMMIT;';
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

                $conn->close();
                $_SESSION["review_lock"] = true;
            } catch (Exception $e) {
                $conn->close();
                $errorMessage = urlencode("Errore nell'inserimento della recensione. Riprovare più tardi");
                header("Location: ../LoggedIn/HomePage.php?error=" . $errorMessage);
                exit;
            }
            $successMessage = urlencode("Recensione inviata con successo.");
            header("Location: ../LoggedIn/HomePage.php?success=" . $successMessage);
            exit;
    }

?>