<?php

    require_once '../config/db_config.php';

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $conn = db_setup_light();
        $username = $_POST["username"];
        $hashedpassword = md5($_POST["password"]);

        $query = 'SELECT hashedpassword,nome FROM utenti WHERE username=?';
        $stmt = $conn->prepare($query);
        $stmt->bind_param('s', $username);
        try {
            $stmt->execute();
            $result = $stmt->get_result();
            $stmt->close();
            $conn->close();
            if ($result->num_rows > 0){
                $row = $result->fetch_assoc();
                if($row["hashedpassword"] == $hashedpassword){
                    if (session_status() !== PHP_SESSION_ACTIVE) session_start(); // Avvio sessione
                    $_SESSION["nome"] = $row["nome"];
                    $_SESSION["username"] = strtolower($_POST["username"]);
                    $_SESSION["is_logged_in"] = true;
                    header('Location: ../LoggedIn/HomePage.php', 302);
                    exit; // Redirect
                }
                else{
                    redirect('LoginPage.php','password_error_message','Errore: password scorretta');
                }
            }
            else{
                redirect('LoginPage.php','username_error_message','Errore: username non trovato');
            }
        } catch (mysqli_sql_exception $e){
            $stmt->close();
            $conn->close();
            redirect('LoginPage.php','error_message','Errore esecuzione query');
        }
    }

    function redirect($url, $session_variable_name, $session_variable_value){
        if (session_status() !== PHP_SESSION_ACTIVE) session_start(); 
        $_SESSION[$session_variable_name] = $session_variable_value; 
        header('Location: ' . $url, 302);
        exit; 
    }
?>