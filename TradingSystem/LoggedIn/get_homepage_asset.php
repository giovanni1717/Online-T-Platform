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
        $query = "SELECT Utente,ID,Titolo,Categoria FROM annunci WHERE utente != ? and visibile = 1 ORDER BY ID DESC LIMIT 4";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('s',$_SESSION["username"]);
        $searchResults = array();
        try {
            $stmt->execute();
            $result = $stmt->get_result();
            $rows = $result->fetch_all(MYSQLI_ASSOC);
            $performedsearch = true;
            foreach ($rows as $row) {
                $query = "SELECT * FROM Foto WHERE Annuncio = ? LIMIT 1";
                $stmt = $conn->prepare($query);
                $stmt->bind_param('s',$row["ID"]);
                $stmt->execute();
                $result = $stmt->get_result();
                $picture = $result->fetch_assoc();
                if(!isset($picture["URL"])) $picture["URL"] = "Photos/nophoto.jpg";
                $result = [$row["Titolo"], $picture["URL"], $row["ID"], $row["Categoria"]];
                array_push($searchResults, $result);
            }
            $stmt->close();
            $conn->close();
        } catch (mysqli_sql_exception $e) {
            $stmt->close();
            $conn->close();
            $errorMessage = urlencode("Errore nel caricamento della pagina iniziale. Riprovare più tardi");
            header("Location: ../LoggedIn/HomePage.php?error=" . $errorMessage);
            exit;
        }
    }
?>
