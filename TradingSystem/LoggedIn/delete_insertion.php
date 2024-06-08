<?php
    require_once '../config/db_config.php';

    if (session_status() !== PHP_SESSION_ACTIVE) session_start();
    if(!isset($_SESSION["is_logged_in"]) || !isset($_GET["ID"])){
        // Redirect a pagina di non autorizzazione
        header('Location: ../Authentication/unauthorized.php', 401);
        exit;
    }
    
    if ($_SERVER["REQUEST_METHOD"] == "GET") {

        $conn = db_setup_light();
        $query = "SELECT URL FROM foto WHERE Annuncio =?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('s',$_GET["ID"]);
        $searchResults = array();
        try {
            $stmt->execute();
            $result = $stmt->get_result();
            $rows = $result->fetch_all(MYSQLI_ASSOC);
        } catch (mysqli_sql_exception $e) {
            $stmt->close();
            $conn->close();
            $errorMessage = urlencode("Errore nell'identificazione delle foto. Riprovare più tardi");
            header("Location: ../LoggedIn/HomePage.php?error=" . $errorMessage);
            exit;
        }

        $query = "DELETE FROM annunci WHERE (ID = ? and Utente = ? and Visibile = 1);";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('ss',$_GET["ID"], $_SESSION["username"]);
        try {
            $stmt->execute();
            foreach ($rows as $row){
                if(file_exists("../" . $row["URL"])){
                    unlink("../" . $row["URL"]);
                }
            }
        } catch (mysqli_sql_exception $e) {
            $conn->close();
            $errorMessage = urlencode("Errore nell'eliminazione dell'annuncio. Riprovare più tardi");
            header("Location: ../LoggedIn/HomePage.php?error=" . $errorMessage);
            exit;
        }

        $query = "SELECT * FROM annunci WHERE Utente = ? and visibile = 1";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('s',$_SESSION["username"]);

        try {
            $stmt->execute();
            $result = $stmt->get_result();
            $rows = $result->fetch_all(MYSQLI_ASSOC);
            if(empty($rows)){
                $query = "DELETE FROM richiestetrattativa WHERE offerente = ?";
                $stmt = $conn->prepare($query);
                $stmt->bind_param('s',$_SESSION["username"]);
                try {
                    $stmt->execute();
                    $stmt->close();
                    $conn->close();
                } catch (mysqli_sql_exception $e) {
                    $stmt->close();
                    $conn->close();
                    $errorMessage = urlencode("Errore nell'aggiornamento delle richieste utente. Riprovare più tardi");
                    header("Location: ../LoggedIn/HomePage.php?error=" . $errorMessage);
                    exit;
                }
            }
        }
        catch (mysqli_sql_exception $e) {
            $stmt->close();
            $conn->close();
            $errorMessage = urlencode("Errore nell'aggiornamento delle richieste utente. Riprovare più tardi");
            header("Location: ../LoggedIn/HomePage.php?error=" . $errorMessage);
            exit;
        }
        $successMessage = urlencode("Annuncio rimosso con successo.");
        header("Location: ../LoggedIn/HomePage.php?success=" . $successMessage);
        exit;        

    }
?>
