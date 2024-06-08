<?php
    require_once '../config/db_config.php';

    if (session_status() !== PHP_SESSION_ACTIVE) session_start();
    if(!isset($_SESSION["is_logged_in"]) || (!isset($_GET["ID"]) && !isset($_GET["personal_insertions"]))){
        // Redirect a pagina di non autorizzazione
        header('Location: ../Authentication/unauthorized.php', 401);
        exit;
    }

    if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["ID"])) {
        $conn = db_setup_light();
        $query = "SELECT URL FROM foto WHERE Annuncio = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('s',$_GET["ID"]);
        $imagesResults = array();
        try {
            $stmt->execute();
            $result = $stmt->get_result();
            $rows = $result->fetch_all(MYSQLI_ASSOC);
            if(empty($rows)) array_push($imagesResults, "../Photos/nophoto.jpg");
            else{
                foreach ($rows as $row) { 
                    array_push($imagesResults, "../" . $row["URL"]);
                }
            }
        }
        catch (mysqli_sql_exception $e) {
            $stmt->close();
            $conn->close();
            $errorMessage = urlencode("Errore nella raccolta delle foto. Riprovare più tardi");
            header("Location: ../LoggedIn/HomePage.php?error=" . $errorMessage);
            exit;
        }
        $query = "SELECT * FROM Annunci WHERE ID = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('s',$_GET["ID"]);
        try {
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows == 0){
                $stmt->close();
                $conn->close();
                $errorMessage = urlencode("L'annuncio non esiste. Riprovare più tardi");
                header("Location: ../LoggedIn/HomePage.php?error=" . $errorMessage);
                exit;
            }
            $row = $result->fetch_assoc();
            $_SESSION["insertion_ID"] = $_GET["ID"];
        }
        catch (mysqli_sql_exception $e) {
            print_r($e);
            $stmt->close();
            $conn->close();
            exit;
            $errorMessage = urlencode("Errore nell'ottenimento dell'annuncio. Riprovare più tardi");
            header("Location: ../LoggedIn/HomePage.php?error=" . $errorMessage);
            exit;
        }
        $query = "SELECT annuncio_richiesto FROM richiestetrattativa WHERE annuncio_richiesto = ? AND offerente = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('ss',$_GET["ID"], $_SESSION["username"]);
        try {
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows == 0){
                $isTradeRequestActive = false;
            }
            else $isTradeRequestActive = true;
        }
        catch (mysqli_sql_exception $e) {
            $stmt->close();
            $conn->close();
            $errorMessage = urlencode("Errore nel controllo dello stato annuncio. Riprovare più tardi");
            header("Location: ../LoggedIn/HomePage.php?error=" . $errorMessage);
            exit;
        }
        $stmt->close();
        $conn->close();
    }
?>