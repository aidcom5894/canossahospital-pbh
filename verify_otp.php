<?php
    include('config.php');
    
    // error_reporting(E_ALL);
    // ini_set('display_errors',1);
    

    // SweetAlert variables initialization
    $showAlert = false;
    $alertTitle = "";
    $alertText = "";
    $alertIcon = "";
    $alertRedirect = "";
    $btnColor = "#3085d6"; 
    $btnText = "OK"; 
    
    
    $Email = isset($_GET['email']) ? $_GET['email'] : '';

    if(isset($_POST['verify'])) {
        $otp = mysqli_real_escape_string($conn, $_POST['otp']); 
        $check = mysqli_query($conn, "SELECT * FROM user_directory WHERE email='$Email' AND otp='$otp'");
        
        if(mysqli_num_rows($check) > 0) {
            // Success Block
            $showAlert = true;
            $alertTitle = "OTP Verified!";
            $alertText = "Set your new password";
            $alertIcon = "success";
            $alertRedirect = "reset_password.php?email=" . urlencode($Email); 
            $btnColor = "#4e73df";
            $btnText = "Continue";
        } else {
            // Error Block
            $showAlert = true;
            $alertTitle = "Invalid OTP!";
            $alertText = "Please enter correct 6-digit code";
            $alertIcon = "error";
            $alertRedirect = ""; // Khali taaki isi page par ruke
            $btnColor = "#d33";
            $btnText = "Try Again";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"> 
    <title>Cannosa Hospital OTP Verify</title>
    <link rel="icon" type="image/png" href="medera/images/cfavicon.png" sizes="16x16">
    <link rel="stylesheet" href="assets/css/lib/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
    
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

    <style>
        .auth-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f8f9fa;
            padding: 15px; 
        }
        .otp-card {
            max-width: 400px;
            width: 100%;
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            padding: 30px;
        }
        .form-control:focus {
            box-shadow: none;
            border-color: #4e73df;
        }
        @media (max-width: 576px) {
            .otp-card {
                padding: 20px;
            }
            h4 { font-size: 1.2rem; }
        }
    </style>
</head>
<body>

    <div class="auth-container">
        <div class="otp-card">
            <div class="text-center mb-4">
                <div class="mb-3">
                    <i class="ri-shield-check-line" style="font-size: 3rem; color: #4e73df;"></i>
                </div>
                <h4 class="fw-bold">Verify OTP</h4>
                <p class="text-muted small">Enter the 6-digit code sent to <br>
                    <span class="text-dark fw-bold"><?php echo htmlspecialchars($Email); ?></span>
                </p>
            </div>
            
            <form method="POST" autocomplete="off">
                <div class="mb-4">
                    <input type="text" 
                           name="otp" 
                           class="form-control h-56-px radius-12 text-center fs-4 fw-bold" 
                           placeholder="000000" 
                           required 
                           maxlength="6" 
                           inputmode="numeric" 
                           pattern="\d*">
                    <div class="text-center mt-2">
                        <small class="text-muted">Didn't receive code? <a href="forgot-password.php" class="text-primary text-decoration-none">Resend</a></small>
                    </div>
                </div>
                <button type="submit" name="verify" class="btn btn-primary w-100 radius-12 h-56-px fw-bold">
                    Verify & Continue
                </button>
                <div class="text-center mt-3">
                    <p id="timer" style="color:red; font-weight:bold; font-size:14px;"></p>
                </div>
            </form>
        </div>
    </div>

    <script>
        var timeLeft = 180;
        var timer = setInterval(function(){
            var minutes = Math.floor(timeLeft / 60);
            var seconds = timeLeft % 60;

            document.getElementById("timer").innerHTML =
            "OTP expires in: " + minutes + ":" + (seconds < 10 ? "0" : "") + seconds;

            if(timeLeft <= 0){
                clearInterval(timer);
                Swal.fire({
                    icon: "warning",
                    title: "Time Expired",
                    text: "OTP expired! Please send OTP again."
                }).then(function(){
                    window.location.href = "forgot-password.php";
                });
            }
            timeLeft--;
        }, 1000);
    </script>

    <?php if ($showAlert): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: '<?php echo $alertTitle; ?>',
                text: '<?php echo $alertText; ?>',
                icon: '<?php echo $alertIcon; ?>',
                confirmButtonColor: '<?php echo $btnColor; ?>',
                confirmButtonText: '<?php echo $btnText; ?>'
            }).then(() => {
                <?php if (!empty($alertRedirect)): ?>
                    window.location.href = '<?php echo $alertRedirect; ?>';
                <?php endif; ?>
            });
        });
    </script>
    <?php endif; ?>

</body>
</html>