<?php
    function db_setup(){
        $servername = "localhost";
        $username = "root";
        $password = "";
        $database = "piattaformascambi";
        mysqli_report(MYSQLI_REPORT_STRICT | MYSQLI_REPORT_ALL); // Per gestione eccezione
        $conn = new mysqli($servername, $username, $password, $database);


        if ($conn->connect_error){
            die("Connessione fallita: " . $conn->connect_error);
            header("Location: TradingSystem/Authorization/database_error.php");
            exit;
        }

        return $conn;
    }

    function db_setup_light(){
        $servername = "localhost";
        $username = "root";
        $password = "";
        $database = "piattaformascambi";
        mysqli_report(MYSQLI_REPORT_STRICT | MYSQLI_REPORT_ERROR); // Per gestione eccezione
        $conn = new mysqli($servername, $username, $password, $database);


        if ($conn->connect_error){
            die("Connessione fallita: " . $conn->connect_error);
            header("Location: TradingSystem/Authorization/database_error.php");
            exit;
        }

        return $conn;
    }
?>
