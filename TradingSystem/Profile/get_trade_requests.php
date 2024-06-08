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
        if($_GET["is_it_a_sent_request"] === "true") $query = 'SELECT annuncio_richiesto,Titolo,Categoria,URL,A.Utente FROM (richiestetrattativa R join annunci A on R.annuncio_richiesto = A.ID) 
        left join foto F on A.ID = F.Annuncio WHERE offerente = ?';
        else $query = 'SELECT annuncio_richiesto,Titolo,Categoria,URL,offerente FROM (richiestetrattativa R join annunci A on R.annuncio_richiesto = A.ID) 
        left join foto F on A.ID = F.Annuncio WHERE A.utente = ?';
        $stmt = $conn->prepare($query);
        $stmt->bind_param('s',$_SESSION["username"]);
        $searchResults = array();
        try {
            $stmt->execute();
            $result = $stmt->get_result();
            $rows = $result->fetch_all(MYSQLI_ASSOC);
            $lastID = -1;
            $lastofferente = "";
            $performedquery = true;
            foreach ($rows as $row) {
                if ($row["annuncio_richiesto"] != $lastID || ($_GET["is_it_a_sent_request"] === "false" && $row["offerente"] != $lastofferente)) {
                    if($row["URL"] === NULL) $row["URL"] = "photos/nophoto.jpg";
                    if($_GET["is_it_a_sent_request"] === "true") $result = [$row["Titolo"], $row["URL"], $row["annuncio_richiesto"], $row["Categoria"],$row["Utente"]];
                    else $result = [$row["Titolo"], $row["URL"], $row["annuncio_richiesto"], $row["offerente"], $row["Categoria"]];
                    array_push($searchResults, $result);
                    $lastID = $row["annuncio_richiesto"];
                    if($_GET["is_it_a_sent_request"] === "false") $lastofferente = $row["offerente"];
                }
            }
            $stmt->close();
            $conn->close();
            $_SESSION["is_it_a_sent_request"] = $_GET["is_it_a_sent_request"];
            $_SESSION["proposition_lock"] = false;
        } catch (mysqli_sql_exception $e) {
            print_r($e);
            $stmt->close();
            $conn->close();
            $errorMessage = urlencode("Errore nell'ottenimento delle richieste di scambio. Riprovare più tardi");
            header("Location: ../LoggedIn/HomePage.php?error=" . $errorMessage);
            exit;
        }
        

    }
?>
