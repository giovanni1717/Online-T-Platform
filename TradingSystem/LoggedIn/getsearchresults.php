<?php
    require_once '../config/db_config.php';

    if (session_status() !== PHP_SESSION_ACTIVE) session_start();
    if(!isset($_SESSION["is_logged_in"]) || (!isset($_GET["searchInput"]) && !isset($_GET["personal_insertions"]))){
        // Redirect a pagina di non autorizzazione
        header('Location: ../Authentication/unauthorized.php', 401);
        exit;
    }
    
    if ($_SERVER["REQUEST_METHOD"] == "GET") {

        $conn = db_setup_light();
        $personalInsertions = false;
        if(!isset($_GET["personal_insertions"])){
            if($_GET["category"] !== "default"){
                $query = "SELECT Utente,ID,Titolo,Categoria,URL FROM annunci A left join foto F 
                on A.ID = F.Annuncio WHERE A.Titolo like ? and A.Categoria = ? and A.visibile = 1";
                $stmt = $conn->prepare($query);
                $searchInput = '%' . $_GET["searchInput"] . '%';
                $stmt->bind_param('ss',$searchInput,$_GET["category"]);
            } 
            else{
                $query = "SELECT Utente,ID,Titolo,Categoria,URL FROM annunci A left join foto F on A.ID = F.Annuncio 
                WHERE A.Titolo like ? and A.visibile = 1";
                $stmt = $conn->prepare($query);
                $searchInput = '%' . $_GET["searchInput"] . '%';
                $stmt->bind_param('s',$searchInput);
            } 
        }
        else{
            $query = "SELECT Utente,ID,Titolo,Categoria,URL FROM annunci A left join foto F on A.ID = F.Annuncio 
            WHERE A.Utente = ? and A.visibile = 1";
            $stmt = $conn->prepare($query);
            $stmt->bind_param('s',$_SESSION["username"]);
            $personalInsertions = true;
        }
        $searchResults = array();
        try {
            $stmt->execute();
            $result = $stmt->get_result();
            $rows = $result->fetch_all(MYSQLI_ASSOC);
            $lastID = -1;
            $performedsearch = true;
            foreach ($rows as $row) {
                if ($row["ID"] != $lastID) {
                    if($row["Utente"] !== $_SESSION["username"] || ($row["Utente"] === $_SESSION["username"] && isset($_GET["personal_insertions"]))){
                        if($row["URL"] === NULL) $row["URL"] = "Photos/nophoto.jpg";
                        $result = [$row["Titolo"], $row["URL"], $row["ID"], $row["Categoria"]];
                        array_push($searchResults, $result);
                        $lastID = $row["ID"];
                    }
                }
            }
            $stmt->close();
            $conn->close();
        } catch (mysqli_sql_exception $e) {
            $stmt->close();
            $conn->close();
            $errorMessage = urlencode("Errore nella ricerca degli annunci. Riprovare più tardi");
            header("Location: ../LoggedIn/HomePage.php?error=" . $errorMessage);
            exit;
        }
        

    }
?>
