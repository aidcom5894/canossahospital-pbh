<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include('config.php'); 

// Agar admin session mein nahi hai to sign-in par bhej do
if (!isset($_SESSION['admin'])) {
    header("Location: admin_sign-in");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="medikit admin dashboard" />
    <meta name="keywords" content="medical dashboard, HTML UI KIT, medikit" />
    <title>Canossa Hospital Dashboard</title>
    <link rel="icon" type="image/png" href="medera/images/cfavicon.png" sizes="16x16">
    
    <link rel="stylesheet" href="medikit/css/swiper.css">
    <link rel="stylesheet" href="medikit/css/jquery.scrollbar.css">
    <link rel="stylesheet" href="medikit/css/daterangepicker.css">
    <link rel="stylesheet" href="medikit/css/select2.css">
    <link rel="stylesheet" href="medikit/css/ion.rangeSlider.min.css">
    <link rel="stylesheet" href="medikit/css/dashboard.min.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900" rel="stylesheet"> 
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
     
</head>
<body>

<div class="dashboard-wrap">
    <header class="sidebar-header">
        <h1 class="sidebar-header__logo">m<span>edi<strong>kit</strong></span></h1>
    </header>