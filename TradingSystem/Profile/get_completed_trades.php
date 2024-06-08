<?php

    require_once '../config/db_config.php';

    if (session_status() !== PHP_SESSION_ACTIVE) session_start();
    if(!isset($_SESSION["is_logged_in"])){
        // Redirect a pagina di non autorizzazione
        header('Location: ../Authentication/unauthorized.php', 401);
        exit;
    }

    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        $conn = db_setup_light();
        $query = 'SELECT * FROM (scambi S join annunci A on S.annuncio_avvio = A.ID) WHERE A.utente = ?';
        $stmt = $conn->prepare($query);
        $stmt->bind_param('s',$_SESSION["username"]);
        $searchResults = array();
        try {
            $stmt->execute();
            $result = $stmt->get_result();
            $scambiAvviatidaAltroUtente = $result->fetch_all(MYSQLI_ASSOC);
            $query = 'SELECT * FROM (scambi S join annunci A on S.annuncio_completamento = A.ID) WHERE A.utente = ?';
            $stmt = $conn->prepare($query);
            $stmt->bind_param('s',$_SESSION["username"]);
            $stmt->execute();
            $result = $stmt->get_result();
            $scambiAvviatidaUtente = $result->fetch_all(MYSQLI_ASSOC);
            $searchResults = array_merge($scambiAvviatidaUtente,$scambiAvviatidaAltroUtente);
            $performedquery = true;
        } catch (mysqli_sql_exception $e) {
            $stmt->close();
            $conn->close();
            $errorMessage = urlencode("Errore nell'ottenimento delle informazioni sugli scambi completati. Riprovare più tardi");
            header("Location: ../LoggedIn/HomePage.php?error=" . $errorMessage);
            exit;
        }
        $annunci = array();
        foreach($searchResults as $row){
            $query = "SELECT Utente,email,ID,Titolo,Categoria,URL FROM (annunci A left join foto F on A.ID = F.Annuncio) join utenti U on A.Utente = U.username 
            WHERE A.ID = ? and A.visibile = 0";
            $stmt = $conn->prepare($query);
            $stmt->bind_param('s',$row["annuncio_avvio"]);

            try {
                $stmt->execute();
                $result = $stmt->get_result();
                $query_results = $result->fetch_all(MYSQLI_ASSOC);
                $first_result = $query_results[0];
                if($first_result["URL"] === NULL) $first_result["URL"] = "Photos/nophoto.jpg";
                $entry_avvio = [$first_result["Titolo"],$first_result["URL"],$first_result["ID"],$first_result["Categoria"],$first_result["Utente"],$first_result["email"]];
            }
            catch (mysqli_sql_exception $e) {
                $stmt->close();
                $conn->close();
                $errorMessage = urlencode("Errore nell'ottenimento delle informazioni degli annunci. Riprovare più tardi");
                header("Location: ../LoggedIn/HomePage.php?error=" . $errorMessage);
                exit;
            }

            $query = "SELECT Utente,email,ID,Titolo,Categoria,URL FROM (annunci A left join foto F on A.ID = F.Annuncio) join utenti U on A.Utente = U.username
            WHERE A.ID = ? and A.visibile = 0";
            $stmt = $conn->prepare($query);
            $stmt->bind_param('s',$row["annuncio_completamento"]);

            try {
                $stmt->execute();
                $result = $stmt->get_result();
                $query_results = $result->fetch_all(MYSQLI_ASSOC);
                $first_result = $query_results[0];
                if($first_result["URL"] === NULL) $first_result["URL"] = "Photos/nophoto.jpg";
                $entry_completamento = [$first_result["Titolo"],$first_result["URL"],$first_result["ID"],$first_result["Categoria"],$first_result["Utente"],$first_result["email"]];
            }
            catch (mysqli_sql_exception $e) {
                $stmt->close();
                $conn->close();
                $errorMessage = urlencode("Errore nell'ottenimento delle informazioni degli annunci. Riprovare più tardi");
                header("Location: ../LoggedIn/HomePage.php?error=" . $errorMessage);
                exit;
            }

            $query = "SELECT * FROM recensioni WHERE utente_scrivente = ? and annuncio_avvio_scambio = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param('ss',$_SESSION["username"],$row["annuncio_avvio"]);
            try {
                $stmt->execute();
                $result = $stmt->get_result();
                if ($result->num_rows > 0) $hasReviewed = true;
                else $hasReviewed = false;
            } catch (mysqli_sql_exception $e) {
                $stmt->close();
                $conn->close();
                $errorMessage = urlencode("Errore nell'ottenimento delle informazioni sulle recensioni. Riprovare più tardi");
                header("Location: ../LoggedIn/HomePage.php?error=" . $errorMessage);
                exit;
            }
            $entry = [$entry_avvio,$entry_completamento, $row["DataChiusuraScambio"],$hasReviewed];
            array_push($annunci,$entry);
        }
        $stmt->close();
        $conn->close();
        $_SESSION["review_lock"] = false;
        

    }

?>
