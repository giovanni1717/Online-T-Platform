<?php
    require_once '../config/db_config.php';

    if (session_status() !== PHP_SESSION_ACTIVE) session_start();
    if(!isset($_SESSION["is_logged_in"]) || !isset($_GET["username_richiedente"]) || !isset($_GET["annuncio_richiesto"]) || $_SESSION["proposition_lock"]){
        // Redirect a pagina di non autorizzazione
        header('Location: ../Authentication/unauthorized.php', 401);
        exit;
    }

    if ($_SERVER["REQUEST_METHOD"] == "GET") {

        $conn = db_setup_light();
        $query = "SELECT Utente,ID,Titolo,Categoria,URL FROM annunci A left join foto F on A.ID = F.Annuncio 
            WHERE A.Utente = ? and A.visibile = 1";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('s',$_GET["username_richiedente"]);
        $searchResults = array();
        try {
            $stmt->execute();
            $result = $stmt->get_result();
            $rows = $result->fetch_all(MYSQLI_ASSOC);
            if(empty($rows)){
                $query = "DELETE FROM richiestetrattativa WHERE offerente = ?";
                $stmt = $conn->prepare($query);
                $stmt->bind_param('s',$_GET["username_richiedente"]);
                try {
                    $stmt->execute();
                    $stmt->close();
                    $conn->close();
                    $errorMessage = urlencode("Nessun annuncio disponibile.");
                    header("Location: ../LoggedIn/HomePage.php?error=" . $errorMessage);
                    exit;
                } catch (mysqli_sql_exception $e) {
                    $stmt->close();
                    $conn->close();
                    $errorMessage = urlencode("Errore nell'analisi richiesta utente. Riprovare più tardi");
                    header("Location: ../LoggedIn/HomePage.php?error=" . $errorMessage);
                    exit;
                }
            }
            $lastID = -1;
            $performedsearch = true;
            foreach ($rows as $row) {
                if ($row["ID"] != $lastID) {
                    if($row["URL"] === NULL) $row["URL"] = "Photos/nophoto.jpg";
                    $result = [$row["Titolo"], $row["URL"], $row["ID"], $row["Categoria"]];
                    array_push($searchResults, $result);
                    $lastID = $row["ID"];
                }
            }
            if(isset($_GET["annuncio_richiesto"]) && isset($_GET["username_richiedente"])){
                $_SESSION["annuncio_richiesto"] = $_GET["annuncio_richiesto"];
                $_SESSION["username_richiedente"] = $_GET["username_richiedente"];

            }
        }
        catch (mysqli_sql_exception $e) {
            $stmt->close();
            $conn->close();
            $errorMessage = urlencode("Errore nell'ottenimento degli annunci dell'utente. Riprovare più tardi");
            header("Location: ../LoggedIn/HomePage.php?error=" . $errorMessage);
            exit;
        }
        $stmt->close();
        $conn->close();
    }
?>