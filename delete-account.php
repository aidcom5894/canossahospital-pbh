<?php
// Session start aur database connection load karein
session_start();
include('config.php'); 

if (!isset($_SESSION['user'])) {
    header("Location: sign-in.php");
    exit;
}

$userEmail = $_SESSION['user']; 

if (isset($_GET['action']) && $_GET['action'] == 'confirm_delete') {
    
    $deleteQuery = mysqli_query($conn, "DELETE FROM user_directory WHERE email = '$userEmail'");

    if ($deleteQuery) {
        session_unset();
        session_destroy();
        
        // 🔥 FIX: Success alert ke sath Viewport aur Custom CSS bhi inject kar di taaki mobile glitch na aaye
        echo "
        <!DOCTYPE html>
        <html>
        <head>
            <meta name='viewport' content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no'>
            <style>
                @media (max-width: 600px) {
                    .swal2-popup {
                        width: 85% !important;
                        max-width: 85% !important;
                        margin: auto !important;
                    }
                }
            </style>
            <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        </head>
        <body>
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: 'Account Deleted!',
                text: 'Your account has been permanently removed.',
                icon: 'success',
                confirmButtonColor: '#d33'
            }).then(() => {
                window.location.href = 'sign-in.php'; 
            });
        });
        </script>
        </body>
        </html>";
        exit;
    } else {
        echo "Error: Account delete nahi ho paya.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Delete Account</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body {
            background-color: #f4f6f9; 
            font-family: sans-serif;
        }
        @media (max-width: 600px) {
            .swal2-popup {
                width: 85% !important;
                max-width: 85% !important;
                margin: auto !important;
            }
        }
    </style>
</head>
<body>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            title: 'Are you sure?',
            text: "Are you sure you want to delete your account? This action cannot be undone!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, Delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = 'delete-account.php?action=confirm_delete';
            } else {
                window.location.href = 'dashboard.php';
            }
        });
    });
    </script>

</body>
</html>