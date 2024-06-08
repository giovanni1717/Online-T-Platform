<?php
    function isPasswordValid($password) {
        // Check if password length is between 8 and 20 characters
        $length = strlen($password);
        if ($length < 8 || $length > 20) {
            return false;
        }
        
        // Check if password contains at least one number
        if (!preg_match('/[0-9]/', $password)) {
            return false;
        }
        
        // Check if password contains at least one lowercase letter
        if (!preg_match('/[a-z]/', $password)){
            return false;
        }

        // Check if password contains at least one uppercase letter
        if (!preg_match('/[A-Z]/', $password)) {
            return false;
        }
    
        // Check if password contains at least one special symbol
        if (!preg_match('/[!?%_-]/', $password)) {
            return false;
        }
    
        // Password meets all requirements
        return true;
    }
    function isUsernameValid($username) {
        // Check if username length is between 8 and 20 characters
        $length = strlen($username);
        if ($length < 8 || $length > 30) {
            return false;
        }
        
        // Check if username contains only letters and numbers
        if (!preg_match('/^[a-zA-Z0-9]+$/', $username)) {
            return false;
        }
        
        // Username meets all requirements
        return true;
    }
    function isEmailValid($email) {
        // Check if email matches the specified regex pattern
        if (!preg_match('/^[a-zA-Z0-9._%+-]+@(gmail\.com|unicampania\.it|studenti\.unicampania\.it|libero\.it)$/', $email)) {
            return false;
        }
        
        // Email is valid
        return true;
    }
    
?>