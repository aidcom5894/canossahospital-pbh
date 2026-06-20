<?php
    header("Cache-Control: no-cache, no-store, must-revalidate"); 

    include('admin_masterpage/admin_header.php');
    include('admin_masterpage/admin_sidebar.php');
    include('admin_masterpage/admin_navbar.php');

?>

<?php 
  $userEmail = $_SESSION['admin']; // logged user
    $fetch = mysqli_query($conn, "SELECT * FROM admin_directory WHERE email='$userEmail'");
    $row = mysqli_fetch_assoc($fetch);

?>

<?php
    
    // Fetch user Data
    $userId = $_SESSION['admin'];
    $fetch = mysqli_query($conn, "SELECT * FROM admin_directory WHERE email='$userEmail'");
    $row = mysqli_fetch_assoc($fetch);


    /* ---------------- UPDATE FORM ---------------- */
    if(isset($_POST['update'])){

        $name        = mysqli_real_escape_string($conn, $_POST['name']);
        $Dob         = mysqli_real_escape_string($conn, $_POST['dob']);

        $Department         = mysqli_real_escape_string($conn, $_POST['department']);
        $Gender  = mysqli_real_escape_string($conn, $_POST['gender']);
        $Designation = mysqli_real_escape_string($conn, $_POST['designation']);
        $Language    = mysqli_real_escape_string($conn, $_POST['language']);
        $Address     = mysqli_real_escape_string($conn, $_POST['address']);

        // Default image = old image
        $oldImage = $row['avatar'];
        $Avatar = $oldImage;

        /* -------- IMAGE UPLOAD -------- */
        if(isset($_FILES['image']) && $_FILES['image']['error'] === 0){

            $file_name = $_FILES['image']['name'];
            $file_tmp = $_FILES['image']['tmp_name'];

            $targetDir = __DIR__ . "/pImages/";
            $uniqueName = time() . "_" . basename($file_name);
            $targetFile = $targetDir . $uniqueName;

            $dbPath = $base_url . "/pImages/" .$uniqueName;

            if(move_uploaded_file($file_tmp, $targetFile)){
                $Avatar = $dbPath;  // correct variable used
            }
        }

        $update = mysqli_query($conn,"
            UPDATE admin_directory SET  
                name        = '$name',
                gender      =' $Gender',
                dob         ='$Dob',
                department  = '$Department',
                designation = '$Designation',
                language    = '$Language',
                address     = '$Address',
                avatar      = '$Avatar'
                WHERE email ='$userId'
            ");

        if($update){
            // 🔥 FIX: Animate.css aur SweetAlert2 ko yahan load karke Pro-Level layout trigger kiya hai
            echo "
  
            <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: 'Updated Successfull!',
                    html: 'Profile data updated Successfully.',
                    icon: 'success',
                    width: '550px',
                    confirmButtonText: 'Great, Thanks!',
                    confirmButtonColor: '#3085d6',
                    customClass: {
                        popup: 'pro-swal-popup',
                        title: 'pro-swal-title',
                        htmlContainer: 'pro-swal-html',
                        confirmButton: 'pro-swal-confirm'
                    },
                    showClass: {
                        popup: 'animate__animated animate__fadeInUp animate__faster'
                    },
                    hideClass: {
                        popup: 'animate__animated animate__fadeOutDown animate__faster'
                    }
                }).then(() => {
                    window.location.href = 'admin_profile.php';
                });
            });
            </script>";
            exit;
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
  <!-- remix icon font css  -->
  <link rel="stylesheet" href="assets/css/remixicon.css">
  <!-- BootStrap css -->
  <link rel="stylesheet" href="assets/css/lib/bootstrap.min.css">
  <!-- Apex Chart css -->
  <link rel="stylesheet" href="assets/css/lib/apexcharts.css">
  <!-- Data Table css -->
  <link rel="stylesheet" href="assets/css/lib/dataTables.min.css">
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

  <!-- password icon cdn -->
    <link rel="stylesheet" href="assets/css/remixicon.css">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body{
            font-style: sans-serif !important;
        }
        .user-grid-card ul li span{
            font-size:16px !important;
        }

        .user-grid-card ul li{
            font-size:16px !important;
        }

        .user-grid-card h6{
            font-size:20px !important;
        }

        .tab-content h6{
            font-size: 20px !important;
        }

        .tab-content input, textarea, select{
            font-size: 14px !important;
            font-style: sans-serif;
        }
        .tab-content label{
            font-size: 14px !important;
        }
        .tab-content button{
            font-size: 16px !important;
        }

    </style>
</head>

<body >

    <div class="dashboard-main-body">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
          <h6 class="fw-semibold mb-0" style="font-size: 22px !important;">View Profile</h6>
          <ul class="d-flex align-items-center gap-2">
            <li style="font-size: 18px !important;">Edit</li>   
            <li class="fw-medium" style="font-size: 18px !important;">Your Profile</li>
          </ul>
        </div>

        <div class="row gy-4">
            <div class="col-lg-4">
                <div class="user-grid-card position-relative border radius-16 overflow-hidden bg-base h-100">
                    <img src="assets/images/pro.png" alt="Image" class="w-100 object-fit-cover">
                    <div class="pb-24 ms-16 mb-24 me-16  mt--100">
                        <div class="text-center border border-top-0 border-start-0 border-end-0">
                            <img src="<?php echo $row['avatar'];?>" alt="Image" class="border br-white border-width-2-px w-200-px h-200-px rounded-circle object-fit-cover">
                            <h6 class="mt-16" style="margin-bottom: -17px;"><?php echo $row['name'];?></h6>
                            <span class="text-secondary-light mb-16" style="font-size:12px;"><?php echo $row['email'];?></span>
                        </div>
                        <div class="mt-24">
                            <h6 class="mb-16">Personal Info</h6>
                            <ul>
                                <li class="d-flex align-items-center gap-1 mb-12">
                                    <span class="w-30 text-md fw-semibold text-primary-light ">Full Name</span>
                                    <span class="w-70 text-secondary-light fw-medium">: <?php echo $row['name'];?></span>
                                </li>
                                <li class="d-flex align-items-center gap-1 mb-12">
                                    <span class="w-30 text-md fw-semibold text-primary-light"> Email</span>
                                    <span class="w-70 text-secondary-light fw-medium">: <?php echo $row['email'];?></span>
                                </li>
                                <li class="d-flex align-items-center gap-1 mb-12">
                                    <span class="w-30 text-md fw-semibold text-primary-light">Contact</span>
                                    <span class="w-70 text-secondary-light fw-medium">: <?php echo $row['contact'];?></span>
                                </li>
                                <li class="d-flex align-items-center gap-1 mb-12">
                                    <span class="w-30 text-md fw-semibold text-primary-light">Gender</span>
                                    <span class="w-70 text-secondary-light fw-medium">: <?php echo $row['gender'];?></span>
                                </li>
                                <li class="d-flex align-items-center gap-1 mb-12">
                                    <span class="w-30 text-md fw-semibold text-primary-light">Date of Birth</span>
                                    <span class="w-70 text-secondary-light fw-medium">: <?php echo $row['dob'];?></span>
                                </li>


                                <li class="d-flex align-items-center gap-1 mb-12">
                                    <span class="w-30 text-md fw-semibold text-primary-light"> Department</span>
                                    <span class="w-70 text-secondary-light fw-medium">: <?php echo $row['department'];?></span>
                                </li>
                                <li class="d-flex align-items-center gap-1 mb-12">
                                    <span class="w-30 text-md fw-semibold text-primary-light"> Designation</span>
                                    <span class="w-70 text-secondary-light fw-medium">: <?php echo $row['designation'];?></span>
                                </li>
                                <li class="d-flex align-items-center gap-1 mb-12">
                                    <span class="w-30 text-md fw-semibold text-primary-light"> Languages</span>
                                    <span class="w-70 text-secondary-light fw-medium">: <?php echo $row['language'];?></span>
                                </li>
                                <li class="d-flex align-items-center gap-1 mb-12">
                                    <span class="w-30 text-md fw-semibold text-primary-light"> Address</span>
                                    <span class="w-70 text-secondary-light fw-medium">: <?php echo $row['address'];?></span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="card h-100">
                    <div class="card-body p-24">


                        <div class="tab-content" id="pills-tabContent">   
                            <div class="tab-pane fade show active" id="pills-edit-profile" role="tabpanel" aria-labelledby="pills-edit-profile-tab" tabindex="0">
                                <h6 class="text-md text-primary-lght mb-16">Profile Image</h6>

                                <form method="POST" enctype="multipart/form-data">
                                                                    <!-- Upload Image Start -->
                                <div class="mb-24 mt-16">
                                    <div class="avatar-upload">
                                            <div class="avatar-edit position-absolute bottom-0 end-0 me-24 mt-16 z-1 cursor-pointer">
                                                <input type='file' id="imageUpload" accept=".png, .jpg, .jpeg" name="image" style="font-size:18px !important;" hidden>
                                                <label for="imageUpload" class="w-32-px h-32-px d-flex justify-content-center align-items-center bg-primary-50 text-primary-600 border border-primary-600 bg-hover-primary-100 text-lg rounded-circle" style="height:35px !important; width: 35px !important;">
                                                    <iconify-icon icon="solar:camera-outline" class="icon" style="font-size:20px !important;"></iconify-icon>
                                                </label>
                                            </div>
                                            <div class="avatar-preview">
                                                <div id="imagePreview" style="font-size:16px !important;">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Upload Image End -->

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="mb-20">
                                                <label for="name" class="form-label fw-semibold text-primary-light text-sm mb-8">Full Name <span class="text-danger-600">*</span></label>
                                                <input type="text" class="form-control form-control-sm radius-8" placeholder="Enter your Full Name" name="name" value="<?php echo $row['name'];?>">
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="mb-20">
                                                <label for="email" class="form-label fw-semibold text-primary-light text-sm mb-8">Email <span class="text-danger-600">*</span></label>
                                                <input type="email" class="form-control form-control-sm radius-8" placeholder="Enter your email address"value="<?php echo $row['email'];?>" readonly>
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="mb-20">
                                                <label for="number" class="form-label fw-semibold text-primary-light text-sm mb-8">Phone</label>
                                                <input type="text" class="form-control form-control-sm radius-8" placeholder="Enter your phone number" value="<?php echo $row['contact'];?>" required>
                                            </div>
                                        </div>


                                        <div class="col mb-sm-6">
                                            <label for="Language" class="form-label fw-semibold text-primary-light text-sm mb-8">Gender <span class="text-danger-600">*</span> </label>
                                            <select class="form-control form-control-sm radius-8 form-select" name="gender" required>
                                                <option disabled>Choose a Gender</option>
                                                <option value="Male"<?php if($row['gender'] == 'Male') echo 'selected'; ?>>
                                                    Male
                                                </option>

                                                <option value="Female" <?php if($row['gender'] == 'Female') echo 'selected'; ?>>
                                                    Female
                                                </option>
                                            </select>

                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="mb-20">
                                                <label for="name" class="form-label fw-semibold text-primary-light text-sm mb-8">Date of Birth<span class="text-danger-600">*</span></label>
                                                <input type="date" class="form-control form-control-sm radius-8" placeholder="Enter your born date" name="dob" value="<?php echo $row['dob'];?>" required>
                                            </div>
                                        </div>
                                        
                                        <div class="col-sm-6">
                                            <div class="mb-20">
                                                <label for="email" class="form-label fw-semibold text-primary-light text-sm mb-8">Department<span class="text-danger-600">*</span></label>
                                                <input type="text" class="form-control form-control-sm radius-8" placeholder="Write your Department" name="department" value="<?php echo $row['department'];?>" required>
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="mb-20">
                                                <label for="number" class="form-label fw-semibold text-primary-light text-sm mb-8">Designation</label>
                                                <input type="text" class="form-control form-control-sm radius-8" placeholder="Write your designation" name="designation" value="<?php echo $row['designation'];?>" required>
                                            </div>
                                        </div>

                                        <div class="col mb-sm-6">
                                            <label for="Language" class="form-label fw-semibold text-primary-light text-sm mb-8">Language <span class="text-danger-600">*</span> </label>
                                            <select class="form-control form-control-sm radius-8 form-select" name="language" required>
                                                <option disabled>Choose Your Language</option>

                                                <option value="English" <?php if($row['language'] == 'English') echo 'selected'; ?>>
                                                    English
                                                </option>

                                                <option value="Bangla" <?php if($row['language'] == 'Bangla') echo 'selected'; ?>>
                                                    Bangla
                                                </option>

                                                <option value="Hindi" <?php if($row['language'] == 'Hindi') echo 'selected'; ?>>
                                                    Hindi
                                                </option>

                                                <option value="Tamil" <?php if($row['language'] == 'Tamil') echo 'selected'; ?>>
                                                    Tamil
                                                </option>

                                                <option value="Nepali" <?php if($row['language'] == 'Nepali') echo 'selected'; ?>>
                                                    Nepali
                                                </option>

                                                <option value="Arabic" <?php if($row['language'] == 'Arabic') echo 'selected'; ?>>
                                                    Arabic
                                                </option>
                                            </select>

                                        </div>


                                    </div>

                                        <div class="mb-sm-6">
                                            <div class="mb-20">
                                                <label for="email" class="form-label fw-semibold text-primary-light text-sm mb-8">Address<span class="text-danger-600">*</span></label>
                                                <textarea class="form-control form-control-xl radius-8 " placeholder="Write your address"  name="address" required><?php echo $row['address'];?></textarea>
                                            </div>
                                        </div>

                                    <div class="d-flex align-items-center justify-content-center gap-3">
                                        <button type="button" class="btn border border-danger-600 bg-hover-danger-200 text-danger-600 text-md px-40 radius-8"onclick="window.location.href='dashboard.php'"> 
                                            Cancel
                                        </button>
                                        <button type="submit" class="btn btn-primary border border-primary-600 text-md px-40  radius-8"name="update"> 
                                            Save
                                        </button>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
  

<script>
    function loadInsertFile(event) {
        var output = document.getElementById('output_image');
        output.src = URL.createObjectURL(event.target.files[0]);
    }
    // ======================== Upload Image Start =====================
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#imagePreview').css('background-image', 'url('+e.target.result +')');
                $('#imagePreview').hide();
                $('#imagePreview').fadeIn(650);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#imageUpload").change(function() {
        readURL(this);
    });
    // ======================== Upload Image End =====================
</script>


  <!-- jQuery library js -->
  <script src="assets/js/lib/jquery-3.7.1.min.js"></script>
  <!-- Bootstrap js -->
  <script src="assets/js/lib/bootstrap.bundle.min.js"></script>
  <!-- Apex Chart js -->
  <script src="assets/js/lib/apexcharts.min.js"></script>
  <!-- Data Table js -->
  <script src="assets/js/lib/dataTables.min.js"></script>
  <!-- Iconify Font js -->
  <script src="assets/js/lib/iconify-icon.min.js"></script>
  <!-- jQuery UI js -->
  <script src="assets/js/lib/jquery-ui.min.js"></script>
  <!-- Vector Map js -->
  <script src="assets/js/lib/jquery-jvectormap-2.0.5.min.js"></script>
  <script src="assets/js/lib/jquery-jvectormap-world-mill-en.js"></script>
  <!-- Popup js -->
  <script src="assets/js/lib/magnifc-popup.min.js"></script>
  <!-- Slick Slider js -->
  <script src="assets/js/lib/slick.min.js"></script>
  <!-- prism js -->
  <script src="assets/js/lib/prism.js"></script>
  <!-- file upload js -->
  <script src="assets/js/lib/file-upload.js"></script>
  <!-- audioplayer -->
  <script src="assets/js/lib/audioplayer.js"></script>
  
  <!-- main js -->
  <script src="assets/js/app.js"></script>


  <!-- eye iconify password icon cdn -->
    <script src="assets/js/lib/jquery-3.7.1.min.js"></script>
    <script src="assets/js/lib/iconify-icon.min.js"></script>


<?php include('admin_masterpage/admin_footer.php'); ?>  



