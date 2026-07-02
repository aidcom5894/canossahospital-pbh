<?php
    session_start();
    include('config.php');

    // SweetAlert ke liye variables initialize kar rahe hain
    $showAlert = false;
    $alertTitle = "";
    $alertText = "";
    $alertIcon = "";
    $alertRedirect = "";
    $btnColor = "#d33"; // Default red

    if(isset($_POST['submit'])){

        $Email = mysqli_real_escape_string($conn, $_POST['email']);
        $User_Id = mysqli_real_escape_string($conn, $_POST['user_id']);
        $password = $_POST['password'];

        $checkEntry = mysqli_query($conn, "SELECT * FROM user_directory WHERE email = '$Email'");

        if(mysqli_num_rows($checkEntry) > 0) {
            $row = mysqli_fetch_assoc($checkEntry);
            $password_hash = $row['password'];

            if(password_verify($password, $password_hash)){
                $_SESSION['user'] = $Email;
                $_SESSION['user_id'] = $User_Id;

                // Success Variable Configuration
                $showAlert = true;
                $alertTitle = "Login Successful!";
                $alertText = "Welcome to Dashboard!";
                $alertIcon = "success";
                $alertRedirect = "user_dashboard";
                $btnColor = "#3085d6"; // Blue for success
            } else {
                // Invalid Password Configuration
                $showAlert = true;
                $alertTitle = "Invalid Password!";
                $alertText = "Please enter correct password!";
                $alertIcon = "error";
                $alertRedirect = "sign-in";
            }
        } else {
            // Invalid Email Configuration
            $showAlert = true;
            $alertTitle = "Invalid Email!";
            $alertText = "Email not found in system!";
            $alertIcon = "error";
            $alertRedirect = "sign-in";
        }
    }
?>
<!DOCTYPE html>
<html lang="en" data-theme="light">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"> 
  <title>Cannosa Hospital Sign-in Page</title>
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

  <link rel="stylesheet" href="assets/css/remixicon.css">

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

  <div class="body-overlay"></div>

    <button type="button"
        class="theme-customization__button w-48-px h-48-px bg-primary-600 text-white rounded-circle d-flex justify-content-center align-items-center position-fixed end-0 bottom-0 mb-40 me-40 text-2xxl bg-hover-primary-700">
        <i class="ri-settings-3-line animate-spin"></i>
    </button>
    <div class="theme-customization-sidebar w-100 bg-base h-100vh overflow-y-auto position-fixed end-0 top-0 shadow-lg">
        <div class="d-flex align-items-center gap-3 py-16 px-24 justify-content-between border-bottom">
            <div>
                <h6 class="text-sm dark:text-white">Theme Settings</h6>
                <p class="text-xs mb-0 text-neutral-500 dark:text-neutral-200">Customize and preview instantly</p>
            </div>
            <button data-slot="button"
                class="theme-customization-sidebar__close text-neutral-900 bg-transparent text-hover-primary-600 d-flex text-xl">
                <i class="ri-close-fill"></i>
            </button>
        </div>

        <div class="d-flex flex-column gap-48 p-24 overflow-y-auto flex-grow-1">

            <div class="theme-setting-item">
                <h6 class="fw-medium text-primary-light text-md mb-3">Theme Mode</h6>
                <div class="d-grid grid-cols-3 gap-3 dark-light-mode">
                    <button type="button"
                        class="theme-btn theme-setting-item__btn d-flex align-items-center justify-content-center h-64-px rounded-3 text-xl active"
                        data-theme="light">
                        <i class="ri-sun-line"></i>
                    </button>
                    <button type="button"
                        class="theme-btn theme-setting-item__btn d-flex align-items-center justify-content-center h-64-px rounded-3 text-xl"
                        data-theme="dark">
                        <i class="ri-moon-line"></i>
                    </button>
                    <button type="button"
                        class="theme-btn theme-setting-item__btn d-flex align-items-center justify-content-center h-64-px rounded-3 text-xl"
                        data-theme="system">
                        <i class="ri-computer-line"></i>
                    </button>
                </div>
            </div>

            <div class="theme-setting-item">
                <h6 class="fw-medium text-primary-light text-md mb-3">Page Direction</h6>
                <div class="d-grid grid-cols-2 gap-3">
                    <button type="button"
                        class="theme-setting-item__btn ltr-mode-btn d-flex align-items-center justify-content-center gap-2 h-56-px rounded-3 text-xl">
                        <span><i class="ri-align-item-left-line"></i></span>
                        <span class="h6 text-sm font-medium mb-0">LTR</span>
                    </button>

                    <button type="button"
                        class="theme-setting-item__btn rtl-mode-btn d-flex align-items-center justify-content-center gap-2 h-56-px rounded-3 text-xl">
                        <span class="h6 text-sm font-medium mb-0">RTL</span>
                        <span><i class="ri-align-item-right-line"></i></span>
                    </button>
                </div>
            </div>

            <div class="theme-setting-item">
                <h6 class="fw-medium text-primary-light text-md mb-3">Color Schema</h6>
                <div class="d-grid grid-cols-3 gap-3">
                    <button type="button"
                        class="color-picker-btn d-flex flex-column justify-content-center align-items-center"
                        data-color="blue">
                        <span class="color-picker-btn__box h-40-px w-100 rounded-3"
                            style="background-color: #2563eb;"></span>
                        <span class="fw-medium mt-1" style="color: #2563eb;">Blue</span>
                    </button>
                    <button type="button"
                        class="color-picker-btn d-flex flex-column justify-content-center align-items-center"
                        data-color="red">
                        <span class="color-picker-btn__box h-40-px w-100 rounded-3"
                            style="background-color: #dc2626;"></span>
                        <span class="fw-medium mt-1" style="color: #dc2626;">Red</span>
                    </button>
                    <button type="button"
                        class="color-picker-btn d-flex flex-column justify-content-center align-items-center"
                        data-color="green">
                        <span class="color-picker-btn__box h-40-px w-100 rounded-3"
                            style="background-color: #16a34a;"></span>
                        <span class="fw-medium mt-1" style="color: #16a34a;">Green</span>
                    </button>
                    <button type="button"
                        class="color-picker-btn d-flex flex-column justify-content-center align-items-center"
                        data-color="yellow">
                        <span class="color-picker-btn__box h-40-px w-100 rounded-3"
                            style="background-color: #ff9f29;"></span>
                        <span class="fw-medium mt-1" style="color: #ff9f29;">Yellow</span>
                    </button>
                    <button type="button"
                        class="color-picker-btn d-flex flex-column justify-content-center align-items-center"
                        data-color="cyan">
                        <span class="color-picker-btn__box h-40-px w-100 rounded-3"
                            style="background-color: #00b8f2;"></span>
                        <span class="fw-medium mt-1" style="color: #00b8f2;">Cyan</span>
                    </button>
                    <button type="button"
                        class="color-picker-btn d-flex flex-column justify-content-center align-items-center"
                        data-color="violet">
                        <span class="color-picker-btn__box h-40-px w-100 rounded-3"
                            style="background-color: #7c3aed;"></span>
                        <span class="fw-medium mt-1" style="color: #7c3aed;">Violet</span>
                    </button>
                </div>
            </div>

        </div>
    </div>
<section class="auth bg-base d-flex flex-wrap">  

    <div class="auth-left d-lg-block d-none">
        <div class="d-flex align-items-center flex-column h-100 justify-content-center">
            <img src="assets/images/auth/auth-img.png" alt="Image">
        </div>
    </div>
    <div class="auth-right py-32 px-24 d-flex flex-column justify-content-center">
        <div class="max-w-464-px mx-auto w-100">
            <div>
                <a href="sign-in" class="mb-40 max-w-290-px">
                    <img src="assets/images/logo.png" alt="Image">
                </a>
                <h4 class="mb-12">Sign In to your Account</h4>
                <p class="mb-32 text-secondary-light text-lg">Welcome back! please enter your detail</p>
            </div>

            <form method="POST" autocomplete="off">
                <div class="icon-field mb-16">
                    <span class="icon top-50 translate-middle-y">
                        <iconify-icon icon="mage:email"></iconify-icon>
                    </span>
                    <input type="email" name="email" class="form-control h-56-px bg-neutral-50 radius-12" placeholder="Email" required>
                </div>
                <div class="position-relative mb-20">
                    <div class="icon-field"> 
                        <input type="password" class="form-control h-56-px bg-neutral-50 radius-12" name="password" id="your-password" placeholder="Password" required>
                    </div>
                    <span class="toggle-password ri-eye-line cursor-pointer position-absolute end-0 top-50 translate-middle-y me-16 text-secondary-light" data-toggle="#your-password"></span>
                </div>
                <div class="">
                    <div class="d-flex justify-content-between gap-2">
                        <div class="form-check style-check d-flex align-items-center">
                            <input class="form-check-input border border-neutral-300" type="checkbox" value="" id="remeber" required>
                            <label class="form-check-label" for="remeber" >Remember me </label>
                        </div>
                        <a href="forgot-password" class="text-primary-600 fw-medium">Forgot Password?</a>
                    </div>
                </div>

                <button type="submit" name="submit" class="btn btn-primary text-sm btn-sm px-12 py-16 w-100 radius-12 mt-32"> Sign In</button>

                <div class="mt-32 text-center text-sm">
                    <p class="mb-0">Don’t have an account? <a href="sign-up" class="text-primary-600 fw-semibold">Sign Up</a></p>
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

<script>
    // ================== Password Show Hide Js Start ==========
    function initializePasswordToggle(toggleSelector) {
        $(toggleSelector).on('click', function() {
            $(this).toggleClass("ri-eye-off-line");
            var input = $($(this).attr("data-toggle"));
            if (input.attr("type") === "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }
        });
    }
    initializePasswordToggle('.toggle-password');
    // ========================= Password Show Hide Js End ===========================
</script>

<?php if ($showAlert): ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            title: '<?php echo $alertTitle; ?>',
            text: '<?php echo $alertText; ?>',
            icon: '<?php echo $alertIcon; ?>',
            confirmButtonColor: '<?php echo $btnColor; ?>'
        }).then(() => {
            window.location.href = '<?php echo $alertRedirect; ?>';
        });
    });
</script>
<?php endif; ?>

</body>
</html>