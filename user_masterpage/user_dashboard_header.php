<?php 
  if (session_status() === PHP_SESSION_NONE) {
      session_start();
  }

  include('config.php'); 

  header("Cache-Control: no-cache, no-store, must-revalidate"); 

  // Agar user session mein nahi hai to sign-in par bhej do
  if (!isset($_SESSION['user'])) {
      header("Location: sign-in.php");
      exit();
  }

  // SweetAlert ke variables ko globally initialize kar rahe hain
  $showAlert = false;
  $alertTitle = "";
  $alertText = "";
  $alertIcon = "";
  $alertRedirect = "";
  $btnColor = "#3085d6"; // Default standard blue ya jo aap chahein
  $btnText = ""; // Default standard blue ya jo aap chahein
  
?>

<!-- meta tags and other links -->
<!DOCTYPE html>
<html lang="en" data-theme="light">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Canossa Hospital Partapgarh</title>
  <link rel="icon" type="image/png" href="img/canossalogo1.png" sizes="16x16">
  <link rel="icon" type="image/png" href="echo htmlspecialchars($favicon) ?>" sizes="16x16">
  <!-- remix icon font css  -->
  <link rel="stylesheet" href="assets/css/remixicon.css">
  <!-- BootStrap css -->
  <link rel="stylesheet" href="assets/css/lib/bootstrap.min.css">
  <!-- Apex Chart css -->
  <link rel="stylesheet" href="assets/css/lib/apexcharts.css">
  <!-- Data Table css -->
  <!-- <link rel="stylesheet" href="assets/css/lib/dataTables.min.css"> -->
  <!-- Text Editor css -->
  <link rel="stylesheet" href="assets/css/lib/editor-katex.min.css">
  <link rel="stylesheet" href="assets/css/lib/editor.atom-one-dark.min.css">
  <link rel="stylesheet" href="assets/css/lib/editor.quill.snow.css">
  <!-- Date picker css -->
  <link rel="stylesheet" href="assets/css/lib/flatpickr.min.css">
  <!-- Calendar css -->
  <link rel="stylesheet" href="assets/css/lib/full-calendar.css">
  <!-- Vector Map css -->
  <link rel="stylesheet" href="assets/css/lib/jquery-jvectormap-2.0.5.css">
  <!-- Popup css -->
  <link rel="stylesheet" href="assets/css/lib/magnific-popup.css">
  <!-- Slick Slider css -->
  <link rel="stylesheet" href="assets/css/lib/slick.css">
  <!-- prism css -->
  <link rel="stylesheet" href="assets/css/lib/prism.css">
  <!-- file upload css -->
  <link rel="stylesheet" href="assets/css/lib/file-upload.css">

  <link rel="stylesheet" href="assets/css/lib/audioplayer.css">
  <!-- main css -->
  <link rel="stylesheet" href="assets/css/style.css">

  
    <!-- ==================== DATA TABLES CDN ==================== -->
<link rel="stylesheet" href="https://cdn.datatables.net/2.3.5/css/dataTables.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/2.3.5/js/dataTables.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  
    <!-- SweetAlert2 Font and Size Customization Style -->
    <style>
          /* Poore popup ka global size control karne ke liye */
          .swal2-popup {
              font-family: 'Inter', sans-serif !important; /* Agar koi professional font use karna ho */
              padding: 1.5rem !important;
              border-radius: 16px !important;
          }
          /* Main Title ka font size chhota karne ke liye */
          .swal2-title {
              font-size: 20px !important; /* Default 28px-30px hota hai, isko chhota kiya */
              font-weight: 600 !important;
              color: #1e293b !important;
          }
          /* Niche waale Text description ka size chhota karne ke liye */
          .swal2-html-container {
              font-size: 14px !important; /* Default 18px hota hai */
              color: #64748b !important;
              margin: 8px 0 0 0 !important;
          }
          /* Confirm Button ka size chhota karne ke liye */
          .swal2-confirm {
              font-size: 13px !important;
              padding: 8px 20px !important;
              border-radius: 8px !important;
          }
          /* Icon ka size thoda normal karne ke liye */
          .swal2-icon {
              transform: scale(0.85); /* Icon ka scale thoda chhota kiya taaki font ke sath balance dikhe */
              margin-top: 10px !important;
          }

          /* Mobile view responsiveness fix */
          @media (max-width: 480px) {
              .swal2-popup {
                  width: 85% !important;
                  max-width: 85% !important;
                  margin: auto !important;
                  padding: 1.25rem !important;
              }
              .swal2-title {
                  font-size: 18px !important;
              }
              .swal2-html-container {
                  font-size: 13px !important;
              }
          }
    </style>
    
</head>

<body>

  <!-- Theme Customization Structure Start -->
<div class="body-overlay"></div>

