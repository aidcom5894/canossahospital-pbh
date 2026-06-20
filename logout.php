<?php

    // 1. Sabse pehle cache-control headers taaki logout ke baad 'Back' button se purana data na dikhe
    header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
    header("Pragma: no-cache"); // HTTP 1.0.
    header("Expires: 0"); // Proxies.
    
    include ('config.php');

    session_start();
    
    if (!isset($_SESSION['user'])) {
        header("Location: sign-in.php");
        exit();
    }


    unset($_SESSION['user']);
    session_unset();

    header("Location: sign-in.php");
    exit(); 
?>