<?php
    if ($_SERVER["REQUEST_METHOD"] == "GET"){
        if (session_status() !== PHP_SESSION_ACTIVE) session_start();
        session_destroy();
        $_SESSION = [];
        header("Location: ../Authentication/LoginPage.php");
    }
?>