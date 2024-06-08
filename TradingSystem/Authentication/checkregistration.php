<?php

    require_once 'registration_check_utilities.php';
    require_once '../config/db_config.php';

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if(!isEmailValid($_POST["Email"]) || !isUsernameValid($_POST["Username"]) || !isPasswordValid($_POST["Password"])){
            header('Location: invalid_data.php', 302);
            exit; // Redirect
        }

        $conn = db_setup_light();
        $hashedpassword = md5($_POST["Password"]);                 
        $query = 'INSERT INTO utenti VALUES(?,?,?,?,?,NULL,0)';
        $stmt = $conn->prepare($query);
        $stmt->bind_param('sssss',$_POST["Nome"],$_POST["Cognome"],$_POST["Email"],strtolower($_POST["Username"]),$hashedpassword);
        try {
            $stmt->execute();
            if ($stmt->affected_rows > 0){
                $stmt->close();
                $conn->close();
                header('Location: RegistrationSuccess.php', 302);
                exit; 
            }
        } catch (mysqli_sql_exception $e) {
            if ($stmt->errno == 1062) {
                // Errore tupla duplicata
                $errorMessage = $stmt->error;
                $stmt->close();
                $conn->close();
                print_r($query);
                print_r($errorMessage);
                if (strpos($errorMessage, "PRIMARY") !== false){
                    $errorMessage = urlencode("Username già in uso. Riprovare.");
                    header("Location: ../Authentication/RegisterPage.php?error=" . $errorMessage);
                    exit;
                }
                elseif (strpos($errorMessage, "email") !== false){
                    $errorMessage = urlencode("Email già in uso. Riprovare.");
                    header("Location: ../Authentication/RegisterPage.php?error=" . $errorMessage);
                    exit;
                }
            }
            else{
                $stmt->close();
                $conn->close();
                $errorMessage = urlencode("Registrazione non riuscita. Riprovare più tardi.");
                header("Location: ../Authentication/RegisterPage.php?error=" . $errorMessage);
                exit; 
            }
        }
              
    }

?>