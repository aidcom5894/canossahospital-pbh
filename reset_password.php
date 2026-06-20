<?php
    include('config.php');

    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    // SweetAlert variables globally initialize kar rahe hain
    $showAlert = false;
    $alertTitle = "";
    $alertText = "";
    $alertIcon = "";
    $alertRedirect = "";
    $btnColor = "#4e73df"; 

    // FIXED: Form submit hone ke baad bhi email GET ya POST dono me se jahan mile, safe rahe
    $Email = isset($_REQUEST['email']) ? $_REQUEST['email'] : '';

    if(isset($_POST['reset'])) {
        if (!empty($Email)) {
            $newpass = password_hash($_POST['password'], PASSWORD_DEFAULT);

            // Password update aur OTP clear karne ki query
            $update = mysqli_query($conn, "UPDATE user_directory SET password='$newpass', otp='' WHERE email='$Email'");
            
            if($update && mysqli_affected_rows($conn) > 0) {
                $showAlert = true;
                $alertTitle = "Password Updated!";
                $alertText = "Now Login with your new password!";
                $alertIcon = "success";
                $alertRedirect = "sign-in.php"; 
                $btnColor = "#4e73df";
            } else {
                $showAlert = true;
                $alertTitle = "No Changes Made!";
                $alertText = "This email might not exist or password is unchanged.";
                $alertIcon = "warning";
                $alertRedirect = ""; 
                $btnColor = "#e67e22";
            }
        } else {
            $showAlert = true;
            $alertTitle = "Error!";
            $alertText = "Invalid or expired session. Please request password reset again.";
            $alertIcon = "error";
            $alertRedirect = "forgot_password.php"; 
            $btnColor = "#d33";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"> 
  <title>Cannosa Hospital Reset Password</title>
  <link rel="icon" type="image/png" href="medera/images/cfavicon.png" sizes="16x16">
  
  <link rel="stylesheet" href="assets/css/remixicon.css">
  <link rel="stylesheet" href="assets/css/lib/bootstrap.min.css">
  <link rel="stylesheet" href="assets/css/lib/apexcharts.css">
  <link rel="stylesheet" href="assets/css/lib/dataTables.min.css">
  <link rel="stylesheet" href="assets/css/lib/flatpickr.min.css">
  <link class="main-css" rel="stylesheet" href="assets/css/style.css">

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <style>
        .swal2-popup {
            font-family: 'Inter', sans-serif !important; 
            padding: 1.5rem !important;
            border-radius: 16px !important;
        }
        .swal2-title {
            font-size: 20px !important; 
            font-weight: 600 !important;
            color: #1e293b !important;
        }
        .swal2-html-container {
            font-size: 14px !important; 
            color: #64748b !important;
            margin: 8px 0 0 0 !important;
        }
        .swal2-confirm {
            font-size: 13px !important;
            padding: 8px 20px !important;
            border-radius: 8px !important;
        }
        .swal2-icon {
            transform: scale(0.85); 
            margin-top: 10px !important;
        }

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

    <section class="auth py-32 px-24 d-flex flex-column justify-content-center align-items-center" style="height: 100vh;">
        <div class="max-w-464-px w-100 bg-white p-24 radius-12 shadow-sm">
            <h4 class="mb-12">Create New Password</h4>
            <p class="mb-32 text-secondary-light">Please enter a strong password for your account.</p>
            
            <form method="POST" action="reset_password.php?email=<?php echo urlencode($Email); ?>" autocomplete="off">
                <div class="position-relative mb-16">
                    <div class="icon-field"> 
                        <input type="password" name="password" class="form-control h-56-px radius-12" placeholder="Set new Password" minlength="8" id="your-password" autocomplete="new-password" required>
                    </div>
                    <span class="toggle-password ri-eye-line cursor-pointer position-absolute end-0 top-50 translate-middle-y me-16 text-secondary-light" data-toggle="#your-password"></span>
                </div>
                <button type="submit" name="reset" class="btn btn-primary w-100 radius-12 h-56-px">Reset Password</button>
            </form>
        </div>
    </section>

  <script src="assets/js/lib/jquery-3.7.1.min.js"></script>
  <script src="assets/js/lib/bootstrap.bundle.min.js"></script>
  <script src="assets/js/app.js"></script>

<script>
      // ================== Password Show Hide Js Start ==========
      function initializePasswordToggle(toggleSelector) {
        $(toggleSelector).on('click', function() {
            $(this).toggleClass("ri-eye-line ri-eye-off-line");
            var input = $($(this).attr("data-toggle"));
            if (input.attr("type") === "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }
        });
    }
    initializePasswordToggle('.toggle-password');
</script>

<?php if ($showAlert): ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            title: '<?php echo $alertTitle; ?>',
            text: '<?php echo $alertText; ?>',
            icon: '<?php echo $alertIcon; ?>',
            confirmButtonColor: '<?php echo $btnColor; ?>',
            confirmButtonText: 'Continue'
        }).then(() => {
            <?php if (!empty($alertRedirect)): ?>
                window.location.href = '<?php echo $alertRedirect; ?>';
            <?php endif; ?>
        });
    }); // 👈 FIXED: Yahan original code me }); missing tha jiski wajah se JS break ho rahi thi
</script>
<?php endif; ?>

</body>
</html>