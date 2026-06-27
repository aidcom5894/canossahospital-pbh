<?php
    header("Cache-Control: no-cache, no-store, must-revalidate"); 

    include('user_masterpage/user_dashboard_header.php');
    include('user_sidebar.php');
    include('user_masterpage/user_navbar.php');

    // error_reporting(E_ALL);
    // ini_set('display_errors', 1);

    // 1. पहले चेक करें कि URL में ID है या नहीं
    if (!isset($_GET['id']) || empty($_GET['id'])) {
        echo "<script>window.location.href = 'ui_home.php';</script>";
        exit();
    }
    
    // अगर ID मौजूद है, तो उसे वेरिएबल में लें
    $edit_id = mysqli_real_escape_string($conn, $_GET['id']);
    
    // डेटाबेस से रिकॉर्ड निकालें
    $fetch = mysqli_query($conn, "SELECT * FROM ui_home WHERE id = '$edit_id' LIMIT 1");
    $row = mysqli_fetch_assoc($fetch);

    // अगर ID गलत है या डेटाबेस में वो रिकॉर्ड नहीं है
    if (!$row) {
        echo "<div class='alert alert-danger m-3'>Record not found for ID: " . htmlspecialchars($edit_id) . "</div>";
        echo "<script>setTimeout(function(){ window.location.href = 'ui_home.php'; }, 2000);</script>";
        exit();
    }

    /* ---------------- UPDATE FORM LOGIC ---------------- */
    if (isset($_POST['update'])) {

        $Heading  = mysqli_real_escape_string($conn, $_POST['heading']);
        // Title aur Subtitle ke $_POST variables ko yahan se hata diya hai

        // पुराना इमेज पाथ बैकअप रखें
        $oldImage = isset($row['avatar']) ? $row['avatar'] : '';
        $Avatar   = $oldImage;

        /* -------- IMAGE UPLOAD -------- */
        if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {

            $file_name  = $_FILES['image']['name'];
            $file_tmp   = $_FILES['image']['tmp_name'];
            
            // फोल्डर सुनिश्चित करें
            $targetDir  = __DIR__ . "/hImages/";
            if (!is_dir($targetDir)) {
                mkdir($targetDir, 0755, true);
            }

            $uniqueName = time() . "_" . basename($file_name);
            $targetFile = $targetDir . $uniqueName;

            // बेस URL पाथ सेट करें
            $dbPath = $base_url . "/hImages/" . $uniqueName;

            if (move_uploaded_file($file_tmp, $targetFile)) {
                $Avatar = $dbPath; 

                // नई इमेज अपलोड होने पर पुरानी इमेज को सर्वर से डिलीट (Unlink) करें
                if (!empty($oldImage)) {
                    $oldFilename = basename($oldImage);
                    $oldTargetFile = __DIR__ . "/hImages/" . $oldFilename;
                    if (file_exists($oldTargetFile)) {
                        unlink($oldTargetFile);
                    }
                }
            }
        }

        // UPDATE Query se title aur subtitle ko hata diya gaya hai
        $updateQuery = "UPDATE ui_home SET  
                            heading   = '$Heading',
                            avatar    = '$Avatar'
                        WHERE id      = '$edit_id'";
                        
        $update = mysqli_query($conn, $updateQuery);

        if ($update) {
            // रीफ्रेश करें ताकि अपडेटेड डेटा तुरंत दिखे
            $fetch = mysqli_query($conn, "SELECT * FROM ui_home WHERE id = '$edit_id' LIMIT 1");
            $row = mysqli_fetch_assoc($fetch);

            // अलर्ट पैरामीटर्स (फ़ुटर के लिए सेट कर रहे हैं)
            $showAlert     = true;
            $alertTitle    = "Success!";
            $alertText     = "Home Page updated successfully!";
            $alertIcon     = "success";
            $alertRedirect = "ui_home.php"; 
            $btnColor      = "#0284c7";
            $btnText       = "Ok";
        }
    }
?>

<style>
    #output_image{
        width: 250px;        /* fixed width */
        height: 150px;       /* fixed height */
        margin-top: 9px;
        border-radius: 10px;
        object-fit: cover;   /* 🔥 magic line */
        border: 1px solid #ddd;
    }

    /* 🌟 BUTTONS WIDTH AND ALIGNMENT STYLES 🌟 */
    .custom-btn-group {
        display: flex !important;
        justify-content: flex-end !important; /* बटन्स को दाईं तरफ ढकेलेगा */
        gap: 15px !important;
        margin-top: 25px !important;
    }
    .custom-wide-btn {
        min-width: 140px !important; /* बटन की चौड़ाई बढ़ाई गई */
        padding: 10px 24px !important; /* अंदर की पैडिंग बढ़ाई गई */
        font-weight: 600 !important;
        font-size: 15px !important;
        border-radius: 6px !important;
        display: inline-flex !important;
        justify-content: center !important;
        align-items: center !important;
    }
</style>
     
<div class="dashboard-main-body">
    <div class="container-fluid">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <div class="card p-3 w-100">
                <h6 class="fw-semibold mb-0"> Edit <span class="text-danger"> / </span> <span class="text-info fw-normal fs-5"> Home-Page </span></h6>
            </div>  
        </div>
        
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Edit Your Page</h4>
                    </div>
                    <div class="card-body">
                        <div class="basic-form">
                            <form method="POST" class="form-valide-with-icon needs-validation" enctype="multipart/form-data" autocomplete="off">

                                <div class="mb-3">
                                    <label class="text-label form-label">Heading</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <iconify-icon icon="solar:user-outline"></iconify-icon>
                                        </span>
                                        <input type="text" class="form-control form-control-lg" name="heading" placeholder="Enter a Main Heading..." value="<?php echo isset($row['heading']) ? htmlspecialchars($row['heading']) : ''; ?>" required>
                                    </div>
                                </div>

                                <!-- Title aur Sub-title inputs ko yahan se hata diya gaya hai -->

                                <div class="mb-3">
                                    <label class="text-label form-label">Avatar</label>
                                    <div class="input-group">
                                        <input type="file" class="form-control" name="image" onchange="loadInsertFile(event)">
                                    </div>
                                </div>

                                <div class="mb-3 text-start">
                                    <img src="<?php echo (!empty($row['avatar'])) ? $row['avatar'] : 'medikit/images/default-avatar.png'; ?>" id="output_image">
                                </div>    

                                <div class="mb-3">
                                    <div class="form-check d-flex align-items-center gap-1">
                                      <input class="form-check-input" type="checkbox" id="invalidCheck2" required checked>
                                      <label class="form-check-label" for="invalidCheck2">
                                        Check Me out
                                      </label>
                                    </div>
                                </div>

                                <div class="custom-btn-group">
                                    <button type="button" class="btn btn-outline-danger custom-wide-btn" onclick="window.location.href='ui_home.php'"> Cancel </button>
                                    <button type="submit" class="btn btn-success custom-wide-btn" name="update"> Submit </button>
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
        if(event.target.files[0]){
            output.src = URL.createObjectURL(event.target.files[0]);
        }
    }
</script>

<?php 
include('user_masterpage/user_footer.php'); 
?>