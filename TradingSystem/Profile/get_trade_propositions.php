<?php

    require_once '../config/db_config.php';

    if (session_status() !== PHP_SESSION_ACTIVE) session_start();
    if(!isset($_SESSION["is_logged_in"]) || !isset($_GET["is_it_a_sent_request"])){
        // Redirect a pagina di non autorizzazione
        header('Location: ../Authentication/unauthorized.php', 401);
        exit;
    }

    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        $conn = db_setup_light();
        if($_GET["is_it_a_sent_request"] === "true") $query = 'SELECT * FROM (propostedichiusuratrattativa as P join annunci as A on P.annuncio_richiesto = A.ID) WHERE A.Utente =?'; 
        else $query = 'SELECT * FROM (propostedichiusuratrattativa as P join annunci as A on P.annuncio_proposto = A.ID) WHERE A.Utente =?'; 
        $stmt = $conn->prepare($query);
        $stmt->bind_param('s',$_SESSION["username"]);
        $searchResults = array();
        try {
            $stmt->execute();
            $result = $stmt->get_result();
            $rows = $result->fetch_all(MYSQLI_ASSOC);
            $performedquery = true;
        } catch (mysqli_sql_exception $e) {
            $stmt->close();
            $conn->close();
            $errorMessage = urlencode("Errore nell'ottenimento delle proposte di chiusura trattativa. Riprovare più tardi");
            header("Location: ../LoggedIn/HomePage.php?error=" . $errorMessage);
            exit;
        }
        $annunci = array();
        foreach($rows as $row){
            $query = "SELECT Utente,ID,Titolo,Categoria,URL FROM annunci A left join foto F on A.ID = F.Annuncio 
            WHERE A.ID = ? and A.visibile = 1";
            $stmt = $conn->prepare($query);
            $stmt->bind_param('s',$row["annuncio_richiesto"]);

            try {
                $stmt->execute();
                $result = $stmt->get_result();
                $query_results = $result->fetch_all(MYSQLI_ASSOC);
                $first_result = $query_results[0];
                if($first_result["URL"] === NULL) $first_result["URL"] = "Photos/nophoto.jpg";
                $entry_richiesta = [$first_result["Titolo"],$first_result["URL"],$first_result["ID"],$first_result["Categoria"],$first_result["Utente"]];
            }
            catch (mysqli_sql_exception $e) {
                $stmt->close();
                $conn->close();
                $errorMessage = urlencode("Errore nell'ottenimento delle informazioni degli annunci. Riprovare più tardi");
                header("Location: ../LoggedIn/HomePage.php?error=" . $errorMessage);
                exit;
            }

            $query = "SELECT Utente,ID,Titolo,Categoria,URL FROM annunci A left join foto F on A.ID = F.Annuncio 
            WHERE A.ID = ? and A.visibile = 1";
            $stmt = $conn->prepare($query);
            $stmt->bind_param('s',$row["annuncio_proposto"]);

            try {
                $stmt->execute();
                $result = $stmt->get_result();
                $query_results = $result->fetch_all(MYSQLI_ASSOC);
                $first_result = $query_results[0];
                if($first_result["URL"] === NULL) $first_result["URL"] = "Photos/nophoto.jpg";
                $entry_proposta = [$first_result["Titolo"],$first_result["URL"],$first_result["ID"],$first_result["Categoria"],$first_result["Utente"]];
            }
            catch (mysqli_sql_exception $e) {
                print_r($e);
                $stmt->close();
                $conn->close();
    
                $errorMessage = urlencode("Errore nell'ottenimento delle informazioni degli annunci. Riprovare più tardi");
                header("Location: ../LoggedIn/HomePage.php?error=" . $errorMessage);
                exit;
            }
            $entry = [$entry_richiesta,$entry_proposta, $row["DataEmissioneProposta"]];
            array_push($annunci,$entry);
        }
        $_SESSION["block_go_back"] = false;
        $stmt->close();
        $conn->close();

    }
?>
