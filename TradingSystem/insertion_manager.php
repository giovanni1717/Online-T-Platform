<?php

    require_once 'config/db_config.php';

    if (session_status() !== PHP_SESSION_ACTIVE) session_start();

    if (!isset($_SESSION['is_logged_in']) || !isset($_POST["titolo"]) || !isset($_POST["categoria"]) || !isset($_POST["condizioni"]) || !isset($_POST["posizione"])) {
        // Redirect alla pagina di non autorizzato
        header('Location: Authentication\unauthorized.php', 401);
        exit;
    }

    if($_SERVER["REQUEST_METHOD"] == "POST"){

        if(!isset($_POST["descrizione"])) $descrizione = "";
        else $descrizione = $_POST["descrizione"];
        $results = uploadImages("Photos");
        
        $conn = db_setup();

        $query = 'INSERT INTO annunci (Titolo,Descrizione,Categoria,Condizioni,Luogo,Data,Utente,Visibile) VALUES
        (?,?,?,?,?,CURRENT_TIMESTAMP(),?,TRUE)';

        $stmt = $conn->prepare($query);
        $stmt->bind_param('ssssss',$_POST["titolo"],$descrizione,$_POST["categoria"],$_POST["condizioni"],$_POST["posizione"],$_SESSION["username"]);
        try {
            $stmt->execute();
        }
        catch (mysqli_sql_exception $e) {
            $stmt->close();
            $conn->close();
            $errorMessage = urlencode("Errore inserimento annuncio. Riprovare più tardi");
            header("Location: LoggedIn/HomePage.php?error=" . $errorMessage);
            exit;
        }
        $Id = mysqli_insert_id($conn);

        foreach($results as $photo){
            $query = 'INSERT INTO foto VALUES("' . $photo . '","' . $Id . '")';
            try {
                $stmt = $conn->prepare($query);
                $stmt->execute();
            } catch (mysqli_sql_exception $e) {
                unlink($photo);
                $stmt->close();
                $conn->close();
                $errorMessage = urlencode("Errore caricamento foto al database. Riprovare più tardi");
                header("Location: LoggedIn/HomePage.php?error=" . $errorMessage);
                exit;
            }
        }
        $stmt->close();
        $conn->close();
        $successMessage = urlencode("Annuncio caricato con successo");
        header("Location: LoggedIn/HomePage.php?success=" . $successMessage);
        exit; 
    }
    
?>



<?php
    function uploadImages($uploadDir) {
        $uploadedImages = array();
    
        // Check if the form was submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_FILES['immagini']['tmp_name'])) {
            // Loop through each file in the uploaded files array
            foreach ($_FILES['immagini']['tmp_name'] as $key => $tmp_name) {
                // Check if file is uploaded successfully
                if ($_FILES['immagini']['error'][$key] === UPLOAD_ERR_OK) {
                    $tmp_name = $_FILES['immagini']['tmp_name'][$key];
                    $name = basename($_FILES['immagini']['name'][$key]);
    
                    // Generate a unique filename
                    $uniqueName = generateUniqueFilename($uploadDir, $name);
    
                    $destination = $uploadDir . '/' . $uniqueName;
                    // Move the uploaded file to your desired directory
                    if (move_uploaded_file($tmp_name, $destination)) {
                        $uploadedImages[] = $destination; // Save the file path
                    } else {
                        $errorMessage = urlencode("Errore spostamento file. Riprovare più tardi");
                        header("Location: LoggedIn/HomePage.php?error=" . $errorMessage);
                        exit;
                    }
                }
            }
        }
        return $uploadedImages;
    }

    function generateUniqueFilename($uploadDir, $filename) {
        $uniqueFilename = $filename;
        $i = 1;
        while (file_exists($uploadDir . '/' . $uniqueFilename)) {
            $uniqueFilename = pathinfo($filename, PATHINFO_FILENAME) . '_' . $i . '.' . pathinfo($filename, PATHINFO_EXTENSION);
            $i++;
        }
        return $uniqueFilename;
    }
?>

