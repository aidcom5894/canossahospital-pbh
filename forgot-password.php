<?php
    include('config.php');

    // error_reporting(E_ALL);
    // ini_set('display_errors', 1);

    // Global SweetAlert variables initialize kar rahe hain
    $showAlert = false;
    $alertTitle = "";
    $alertText = "";
    $alertIcon = "";
    $alertRedirect = "";
    $btnColor = "#4e73df"; 

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require 'PHPMailer/src/PHPMailer.php';
    require 'PHPMailer/src/SMTP.php';
    require 'PHPMailer/src/Exception.php';

    if(isset($_POST['send_otp']))
    {
        $Email = mysqli_real_escape_string($conn, $_POST['email']);
        $check = mysqli_query($conn, "SELECT * FROM user_directory WHERE email='$Email'");

        if(mysqli_num_rows($check) > 0)
        {
            $user = mysqli_fetch_assoc($check);
            $current_time = date('Y-m-d H:i:s');
            
            // Limit Validation Logic
            if (!empty($user['last_otp_request']) && (strtotime($current_time) - strtotime($user['last_otp_request']) < 86400)) {
                if ($user['otp_count'] >= 3) {
                    $showAlert = true;
                    $alertTitle = "Limit Exceeded!";
                    $alertText = "Aap 24 ghante me 3 baar se zyada OTP request nahi kar sakte. Kripya baad me prayas karein.";
                    $alertIcon = "warning";
                    $btnColor = "#e67e22";
                }
            } else {
                // Agar 24 ghante beet chuke hain toh counter reset kar do
                mysqli_query($conn, "UPDATE user_directory SET otp_count = 0 WHERE email='$Email'");
                $user['otp_count'] = 0;
            }

            // Agar validation pass ho gayi toh hi mail bhejenge
            if (!$showAlert) {
                $otp = rand(100000, 999999);
                $new_count = $user['otp_count'] + 1;

                // OTP, request time aur updated count database me update karein
                mysqli_query($conn, "UPDATE user_directory SET otp='$otp', otp_count='$new_count', last_otp_request='$current_time' WHERE email='$Email'");

                $mail = new PHPMailer(true);

                try {
                    // Server settings  
                    $mail->isSMTP();
                    // Live production ke liye debug log off kiya hai, zaroorat padne par 2 karein
                    $mail->Host       = 'smtp.hostinger.com';
                    $mail->SMTPAuth   = true;
                    $mail->Username   = 'support@aidcombizcard.in';
                    $mail->Password   = 'FinTech@2026#@';   
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                    $mail->Port       = 465;

                    // Recipients
                    $mail->setFrom('support@aidcombizcard.in', 'Canossa Hospital');
                    $mail->addAddress($Email);

                    $mail->isHTML(true);
                    $mail->Subject = 'Password Reset OTP - Canossa Hospital';

                    $mail->Body = "
                    <div style='margin:0; padding:0; background:#f4f6f8; font-family:Arial, sans-serif;'>
                        <div style='max-width:600px; margin:30px auto; background:#ffffff; border-radius:10px; overflow:hidden; box-shadow:0 4px 12px rgba(0,0,0,0.08);'>
                            
                            <div style='background:#ffffff; padding:15px; text-align:center; border-bottom:1px solid #eee;'>
                                <h2 style='margin:0; color:#0d6efd; font-size:20px;'>Canossa Hospital</h2>
                            </div>

                            <div style='padding:30px; text-align:center; color:#333;'>
                                <h2 style='margin-top:0;'>Password Reset Request 🔐</h2>
                                <p style='font-size:15px; color:#555;'>
                                    We received a request to reset your password. Use the OTP below to proceed:
                                </p>

                                <div style='margin:25px 0;'>
                                    <span style='display:inline-block; font-size:32px; letter-spacing:6px; font-weight:bold; color:#0d6efd; background:#f1f5ff; padding:15px 25px; border-radius:8px;'>
                                        $otp
                                    </span>
                                </div>

                                <p style='font-size:14px; color:#777;'>
                                    This OTP is valid for a limited time. Please do not share it with anyone.
                                </p>
                            </div>

                            <div style='padding:0 30px; text-align:center;'>
                                <p style='font-size:14px; color:#555;'>
                                    If you have any questions or need assistance, feel free to contact our support team anytime.
                                </p>
                                <p style='margin-top:25px; font-size:14px; color:#333;'>
                                    Best Regards,<br><strong>Team Canossa Hospital</strong>
                                </p>
                            </div>

                            <div style='background:#f1f1f1; padding:15px; text-align:center; font-size:12px; color:#777; margin-top:20px;'>
                                © ".date('Y')." Canossa Hospital. All rights reserved.<br>
                            </div>
                        </div>
                    </div>";

                    if($mail->send()) {
                        $showAlert = true;
                        $alertTitle = "OTP Sent!";
                        $alertText = "Check your email for the verification code. (Attempt $new_count of 3)";
                        $alertIcon = "success";
                        $alertRedirect = "verify_otp?email=" . urlencode($Email);
                        $btnColor = "#4e73df";
                    }

                } catch (Exception $e) {
                    $showAlert = true;
                    $alertTitle = "Mailer Error!";
                    $alertText = "Mail could not be sent. Error: {$mail->ErrorInfo}";
                    $alertIcon = "error";
                    $btnColor = "#d33";
                }
            }
        }
        else
        {
            $showAlert = true;
            $alertTitle = "OTP Not Sent!";
            $alertText = "Email address not found in our records.";
            $alertIcon = "error";
            $btnColor = "#d33";
        }
    }
?>

<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <title>Forgot Password</title>
  <link rel="icon" type="image/png" href="medera/images/cfavicon.png" sizes="16x16">
  
  <link rel="stylesheet" href="assets/css/remixicon.css">
  <link rel="stylesheet" href="assets/css/lib/bootstrap.min.css">
  <link rel="stylesheet" href="assets/css/lib/apexcharts.css">
  <link rel="stylesheet" href="assets/css/lib/dataTables.min.css">
  <link rel="stylesheet" href="assets/css/lib/editor-katex.min.css">
  <link rel="stylesheet" href="assets/css/lib/editor.atom-one-dark.min.css">
  <link rel="stylesheet" href="assets/css/lib/editor.quill.snow.css">
  <link rel="stylesheet" href="assets/css/lib/flatpickr.min.css">
  <link rel="stylesheet" href="assets/css/lib/full-calendar.css">
  <link rel="stylesheet" href="assets/css/lib/jquery-jvectormap-2.0.5.css">
  <link rel="stylesheet" href="assets/css/lib/magnific-popup.css">
  <link rel="stylesheet" href="assets/css/lib/slick.css">
  <link rel="stylesheet" href="assets/css/lib/prism.css">
  <link rel="stylesheet" href="assets/css/lib/file-upload.css">
  <link rel="stylesheet" href="assets/css/lib/audioplayer.css">
  <link rel="stylesheet" href="assets/css/style.css">

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
        @media (max-width: 480px) {
            .swal2-popup {
                width: 85% !important;
                max-width: 85% !important;
                margin: auto !important;
            }
        }
  </style>
</head>

<body>

<div class="body-overlay"></div>

    <button type="button" class="theme-customization__button w-48-px h-48-px bg-primary-600 text-white rounded-circle d-flex justify-content-center align-items-center position-fixed end-0 bottom-0 mb-40 me-40 text-2xxl bg-hover-primary-700">
        <i class="ri-settings-3-line animate-spin"></i>
    </button>

    <div class="theme-customization-sidebar w-100 bg-base h-100vh overflow-y-auto position-fixed end-0 top-0 shadow-lg">
        <div class="d-flex align-items-center gap-3 py-16 px-24 justify-content-between border-bottom">
            <div>
                <h6 class="text-sm dark:text-white">Theme Settings</h6>
                <p class="text-xs mb-0 text-neutral-500 dark:text-neutral-200">Customize and preview instantly</p>
            </div>
            <button data-slot="button" class="theme-customization-sidebar__close text-neutral-900 bg-transparent text-hover-primary-600 d-flex text-xl">
                <i class="ri-close-fill"></i>
            </button>
        </div>

        <div class="d-flex flex-column gap-48 p-24 overflow-y-auto flex-grow-1">
            <div class="theme-setting-item">
                <h6 class="fw-medium text-primary-light text-md mb-3">Theme Mode</h6>
                <div class="d-grid grid-cols-3 gap-3 dark-light-mode">
                    <button type="button" class="theme-btn theme-setting-item__btn d-flex align-items-center justify-content-center h-64-px rounded-3 text-xl active" data-theme="light">
                        <i class="ri-sun-line"></i>
                    </button>
                    <button type="button" class="theme-btn theme-setting-item__btn d-flex align-items-center justify-content-center h-64-px rounded-3 text-xl" data-theme="dark">
                        <i class="ri-moon-line"></i>
                    </button>
                    <button type="button" class="theme-btn theme-setting-item__btn d-flex align-items-center justify-content-center h-64-px rounded-3 text-xl" data-theme="system">
                        <i class="ri-computer-line"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <section class="auth forgot-password-page bg-base d-flex flex-wrap">  
        <div class="auth-left d-lg-block d-none">
            <div class="d-flex align-items-center flex-column h-100 justify-content-center">
                <img src="assets/images/auth/forgot-pass-img.png" alt="Image">
            </div>
        </div>
        <div class="auth-right py-32 px-24 d-flex flex-column justify-content-center">
            <div class="max-w-464-px mx-auto w-100">
                <div>
                    <h4 class="mb-12">Forgot Password</h4>
                    <p class="mb-32 text-secondary-light text-lg">Enter the email address associated with your account and we will send you an OTP to reset your password.</p>
                </div>
                <form method="POST" autocomplete="off">
                    <div class="icon-field">
                        <span class="icon top-50 translate-middle-y">
                            <iconify-icon icon="mage:email"></iconify-icon>
                        </span>
                        <input type="email" class="form-control h-56-px bg-neutral-50 radius-12" placeholder="Enter Email" name="email" required>
                    </div>
                    <button type="submit" class="btn btn-primary text-sm btn-sm px-12 py-16 w-100 radius-12 mt-32" name="send_otp">Send OTP</button>

                    <div class="text-center">
                        <a href="sign-in" class="text-primary-600 fw-bold mt-24 d-inline-block">Back to Sign In</a>
                    </div>
                    
                    <div class="mt-120 text-center text-sm">
                        <p class="mb-0">Already have an account? <a href="sign-in" class="text-primary-600 fw-semibold">Sign In</a></p>
                    </div>
                </form>
            </div>
        </div>
    </section>

  <script src="assets/js/lib/jquery-3.7.1.min.js"></script>
  <script src="assets/js/lib/bootstrap.bundle.min.js"></script>
  <script src="assets/js/lib/apexcharts.min.js"></script>
  <script src="assets/js/lib/dataTables.min.js"></script>
  <script src="assets/js/lib/iconify-icon.min.js"></script>
  <script src="assets/js/lib/jquery-ui.min.js"></script>
  <script src="assets/js/lib/jquery-jvectormap-2.0.5.min.js"></script>
  <script src="assets/js/lib/jquery-jvectormap-world-mill-en.js"></script>
  <script src="assets/js/lib/magnifc-popup.min.js"></script>
  <script src="assets/js/lib/slick.min.js"></script>
  <script src="assets/js/lib/prism.js"></script>
  <script src="assets/js/lib/file-upload.js"></script>
  <script src="assets/js/lib/audioplayer.js"></script>
  <script src="assets/js/app.js"></script>

<?php if ($showAlert): ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            title: '<?php echo $alertTitle; ?>',
            text: '<?php echo $alertText; ?>',
            icon: '<?php echo $alertIcon; ?>',
            confirmButtonColor: '<?php echo $btnColor; ?>',
            confirmButtonText: 'Okay'
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