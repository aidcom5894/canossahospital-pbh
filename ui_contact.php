<?php
    header("Cache-Control: no-cache, no-store, must-revalidate"); 

    include('user_masterpage/user_dashboard_header.php');
    include('user_masterpage/user_sidebar.php');
    include('user_masterpage/user_navbar.php');

    // error_reporting(E_ALL);
    // ini_set('display_errors',1);

    $fetch = mysqli_query($conn, "SELECT * FROM ui_contact LIMIT 1");
    $row = mysqli_fetch_assoc($fetch);

    /* ---------------- UPDATE FORM LOGIC ---------------- */
    if(isset($_POST['update'])){

        $Title1 = mysqli_real_escape_string($conn, $_POST['title1']);
        $Title2 = mysqli_real_escape_string($conn, $_POST['title2']);
        $About  = mysqli_real_escape_string($conn, $_POST['about']);

        // पुराने इमेज पाथ का बैकअप
        $Avatar  = isset($row['avatar']) ? $row['avatar'] : '';
        $Avatar2 = isset($row['avatar2']) ? $row['avatar2'] : '';

        /* -------- IMAGE 1 UPLOAD -------- */
        if(isset($_FILES['image']) && $_FILES['image']['error'] === 0){
            $targetDir = __DIR__ . "/hImages/";
            $uniqueName = time() . "_1_" . basename($_FILES['image']['name']);
            if(move_uploaded_file($_FILES['image']['tmp_name'], $targetDir . $uniqueName)){
                $Avatar = $base_url . "/hImages/" . $uniqueName;
            }
        }

        /* -------- IMAGE 2 UPLOAD -------- */
        if(isset($_FILES['image2']) && $_FILES['image2']['error'] === 0){
            $targetDir = __DIR__ . "/hImages/";
            $uniqueName2 = time() . "_2_" . basename($_FILES['image2']['name']);
            if(move_uploaded_file($_FILES['image2']['tmp_name'], $targetDir . $uniqueName2)){
                $Avatar2 = $base_url . "/hImages/" . $uniqueName2;
            }
        }

        // 2. क्वेरी एक्जीक्यूट करें (avatar2 जोड़ दिया गया है)
        $updateQuery = "UPDATE ui_contact SET  
                            title1  = '$Title1',
                            title2  = '$Title2',
                            about   = '$About',
                            avatar  = '$Avatar',
                            avatar2 = '$Avatar2'
                        WHERE id    = '".$row['id']."'";
                        
        $update = mysqli_query($conn, $updateQuery);

        if($update){
            $showAlert = true;
            $alertTitle = "Success!";
            $alertText = "Contact Page updated successfully!";
            $alertIcon = "success";
            $btnText = "Continue";
            $alertRedirect = "ui_contact.php"; 
            
            $fetch = mysqli_query($conn, "SELECT * FROM ui_contact WHERE id = '".$row['id']."'");
            $row = mysqli_fetch_assoc($fetch);
        }
    }
?>

<style>
    .img-preview{ width: 200px; height: 120px; margin-top: 9px; border-radius: 10px; object-fit: cover; border: 1px solid #ddd; }
    .custom-btn-group { display: flex !important; justify-content: flex-end !important; gap: 15px !important; margin-top: 25px !important; }
    .custom-wide-btn { min-width: 140px !important; padding: 10px 24px !important; font-weight: 600 !important; }
</style>

<div class="dashboard-main-body">
    <div class="container-fluid">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <div class="card p-3 w-100">
                <h6 class="fw-semibold mb-0"> Edit <span class="text-danger"> / </span> <span class="text-info fw-normal fs-5"> Contact-Page </span></h6>
            </div>  
        </div>
        
        <div class="card">
            <div class="card-body">
                <form method="POST" enctype="multipart/form-data" autocomplete="off">
                    
                    <div class="mb-3">
                        <label class="text-label form-label">Title-1</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <iconify-icon icon="solar:user-outline"></iconify-icon>
                            </span>
                            <input type="text" class="form-control form-control-lg" name="title1" placeholder="Enter a Title-1" value="<?php echo isset($row['title1']) ? htmlspecialchars($row['title1']) : ''; ?>" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="text-label form-label">Title-2</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <iconify-icon icon="solar:text-outline"></iconify-icon>
                            </span>
                            <input type="text" class="form-control" name="title2" placeholder="Enter a Title-2 ..." value="<?php echo isset($row['title2']) ? htmlspecialchars($row['title2']) : ''; ?>" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="text-label form-label">About</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <iconify-icon icon="solar:calendar-outline"></iconify-icon>
                            </span>
                            <input type="text" class="form-control" name="about" placeholder="Enter an about..." value="<?php echo isset($row['about']) ? htmlspecialchars($row['about']) : ''; ?>" required>
                        </div>
                    </div>

                    <div class="row">


                        <!-- Image 2 -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Avatar</label>
                            <input type="file" class="form-control" name="image2" onchange="previewFile(this, 'output_image2')">
                            <img src="<?php echo $row['avatar2'] ?? 'default.png'; ?>" id="output_image2" class="img-preview">
                        </div>

                        <!-- Image 1 -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Background-Avatar</label>
                            <input type="file" class="form-control" name="image" onchange="previewFile(this, 'output_image1')">
                            <img src="<?php echo $row['avatar'] ?? 'default.png'; ?>" id="output_image1" class="img-preview">
                        </div>

                    </div>

                    <div class="custom-btn-group">
                        <button type="button" class="btn btn-outline-danger custom-wide-btn" onclick="window.location.href='user_dashboard.php'"> Cancel </button>
                        <button type="submit" class="btn btn-success custom-wide-btn" name="update"> Submit </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function previewFile(input, targetId) {
        var output = document.getElementById(targetId);
        if(input.files && input.files[0]){
            output.src = URL.createObjectURL(input.files[0]);
        }
    }
</script>

<?php include('user_masterpage/user_footer.php'); ?>