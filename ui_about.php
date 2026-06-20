<?php
    header("Cache-Control: no-cache, no-store, must-revalidate"); 

    include('user_masterpage/user_dashboard_header.php');
    include('user_masterpage/user_sidebar.php');
    include('user_masterpage/user_navbar.php');

    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    // मान लेते हैं कि हम ID = 1 वाले 'About' सेक्शन को अपडेट कर रहे हैं
    $id = 1; 

    // 1. फॉर्म सबमिट होने पर अपडेट लॉजिक
    if (isset($_POST['update_about'])) { 
        $about_title = mysqli_real_escape_string($conn, $_POST['about_title']);
        $heading     = mysqli_real_escape_string($conn, $_POST['heading']);
        $about       = mysqli_real_escape_string($conn, $_POST['about']);
        $about_line1 = mysqli_real_escape_string($conn, $_POST['about_line1']);
        $about_line2 = mysqli_real_escape_string($conn, $_POST['about_line2']);
        $about_line3 = mysqli_real_escape_string($conn, $_POST['about_line3']);

        // पुराना डेटा लाना
        $old_data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT avatar, avatar2, video FROM ui_about WHERE id=$id"));
        $avatar   = $old_data['avatar'] ?? '';
        $avatar2  = $old_data['avatar2'] ?? ''; 
        $video    = $old_data['video'] ?? '';

        // फोल्डर का नाम सही किया (Spelling error fixed)
        if (!is_dir('hImages')) {
            mkdir('hImages', 0777, true);
        }

        // Avatar 1 Upload
        if (!empty($_FILES['avatar']['name'])) {
            $avatar_name = time() . '_1_' . $_FILES['avatar']['name'];
            $avatar_target = "hImages/" . $avatar_name;
            if (move_uploaded_file($_FILES['avatar']['tmp_name'], $avatar_target)) {
                $avatar = $avatar_target; 
            }
        }

        // Avatar 2 Upload
        if (!empty($_FILES['avatar2']['name'])) {
            $avatar2_name = time() . '_2_' . $_FILES['avatar2']['name'];
            $avatar2_target = "hImages/" . $avatar2_name;
            if (move_uploaded_file($_FILES['avatar2']['tmp_name'], $avatar2_target)) {
                $avatar2 = $avatar2_target; 
            }
        }

        // Video Upload
        if (!empty($_FILES['video']['name'])) {
            $video_name = time() . '_' . $_FILES['video']['name'];
            $video_target = "hImages/" . $video_name;
            if (move_uploaded_file($_FILES['video']['tmp_name'], $video_target)) {
                $video = $video_target; 
            }
        }

        // SQL UPDATE QUERY
        $update_query = mysqli_query($conn, "UPDATE ui_about SET 
                        about_title = '$about_title', 
                        heading = '$heading', 
                        about = '$about', 
                        about_line1 = '$about_line1', 
                        about_line2 = '$about_line2', 
                        about_line3 = '$about_line3', 
                        avatar = '$avatar', 
                        avatar2 = '$avatar2', 
                        video = '$video' 
                        WHERE id = $id");

        if ($update_query) {
            // Success Alert Variables
            $showAlert = true;
            $alertTitle = "Success!";
            $alertText = "About data updated successfully!";
            $alertIcon = "success";
            $alertRedirect = "ui_about.php"; 
            $btnColor = "#3085d6";
            $btnText = "Ok";
        } else {
            // Error Alert Variables (जो मिसिंग था, उसे जोड़ दिया है)
            $showAlert = true;
            $alertTitle = "Error!";
            $alertText = "Something went wrong: " . mysqli_error($conn);
            $alertIcon = "error";
            $alertRedirect = "ui_about.php"; 
            $btnColor = "#d33";
            $btnText = "Try Again";
        }
    } // <-- यह ब्रैकेट बंद होना छूटा हुआ था, जिसे फिक्स कर दिया गया है

    // 2. डेटा फेच करना
    $result = mysqli_query($conn, "SELECT * FROM ui_about WHERE id=$id");
    $row = mysqli_fetch_assoc($result);
?>

<style>
    .img-preview { width: 160px; height: 100px; margin-top: 9px; border-radius: 10px; object-fit: cover; border: 1px solid #ddd; display: block; }
    .video-preview { width: 240px; height: 135px; margin-top: 9px; border-radius: 10px; border: 1px solid #ddd; display: block; }
    .custom-btn-group { display: flex !important; justify-content: flex-end !important; gap: 15px !important; margin-top: 25px !important; }
    .custom-wide-btn { min-width: 140px !important; padding: 10px 24px !important; font-weight: 600 !important; }
    .media-box { background: #f8f9fa; padding: 15px; border-radius: 8px; border: 1px solid #edf2f7; margin-bottom: 15px; }
    .input-group-text iconify-icon { font-size: 20px; color: #5e6e82; }
</style>

<div class="dashboard-main-body">
    <div class="container-fluid">
        
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <div class="card p-3 w-100">
                <h6 class="fw-semibold mb-0"> Edit <span class="text-danger"> / </span> <span class="text-info fw-normal fs-5"> About-Page </span></h6>
            </div>  
        </div>
        
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Edit Your Page Content</h4>
                    </div>
                    <div class="card-body">
                        <div class="basic-form">
                            <form method="POST" class="form-valide-with-icon needs-validation" enctype="multipart/form-data" autocomplete="off">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="text-label form-label fw-semibold">About Title</label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <iconify-icon icon="solar:text-square-outline"></iconify-icon>
                                            </span>
                                            <input type="text" class="form-control" name="about_title" placeholder="Enter About Title..." value="<?php echo isset($row['about_title']) ? htmlspecialchars($row['about_title']) : ''; ?>" required>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label class="text-label form-label fw-semibold">Heading</label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <iconify-icon icon="solar:text-bold-outline"></iconify-icon>
                                            </span>
                                            <input type="text" class="form-control" name="heading" placeholder="Enter a Main Heading..." value="<?php echo isset($row['heading']) ? htmlspecialchars($row['heading']) : ''; ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="text-label form-label fw-semibold">About Line: 1</label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <iconify-icon icon="solar:pen-new-square-outline"></iconify-icon>
                                            </span>
                                            <input type="text" class="form-control" name="about_line1" placeholder="Enter Line 1 text..." value="<?php echo isset($row['about_line1']) ? htmlspecialchars($row['about_line1']) : ''; ?>">
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="text-label form-label fw-semibold">About Line: 2</label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <iconify-icon icon="solar:pen-new-square-outline"></iconify-icon>
                                            </span>
                                            <input type="text" class="form-control" name="about_line2" placeholder="Enter Line 2 text..." value="<?php echo isset($row['about_line2']) ? htmlspecialchars($row['about_line2']) : ''; ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="text-label form-label fw-semibold">About Line: 3</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <iconify-icon icon="solar:pen-new-square-outline"></iconify-icon>
                                        </span>
                                        <input type="text" class="form-control" name="about_line3" placeholder="Enter Line 3 text..." value="<?php echo isset($row['about_line3']) ? htmlspecialchars($row['about_line3']) : ''; ?>">
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="text-label form-label fw-semibold">About Description</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <iconify-icon icon="solar:notes-outline"></iconify-icon>
                                        </span>
                                        <textarea class="form-control" name="about" rows="3" placeholder="Enter description details..."><?php echo isset($row['about']) ? htmlspecialchars($row['about']) : ''; ?></textarea>
                                    </div>
                                </div>

                                <div class="row mt-4">
                                    <div class="col-md-4 mb-3">
                                        <div class="media-box">
                                            <label class="fw-semibold form-label">Avatar 1 (Image)</label>
                                            <input type="file" class="form-control" name="avatar" accept="image/*" onchange="previewFile(this, 'avatarPreview', 'image')">
                                            <img id="avatarPreview" class="img-preview" src="<?php echo (!empty($row['avatar']) && file_exists($row['avatar'])) ? $row['avatar'] : 'uploads/default-placeholder.png'; ?>" alt="Avatar Preview">
                                        </div>
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <div class="media-box">
                                            <label class="fw-semibold form-label">Avatar 2 (Second Image)</label>
                                            <input type="file" class="form-control" name="avatar2" accept="image/*" onchange="previewFile(this, 'avatar2Preview', 'image')">
                                            <img id="avatar2Preview" class="img-preview" src="<?php echo (!empty($row['avatar2']) && file_exists($row['avatar2'])) ? $row['avatar2'] : 'uploads/default-placeholder.png'; ?>" alt="Avatar 2 Preview">
                                        </div>
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <div class="media-box">
                                            <label class="fw-semibold form-label">Video File</label>
                                            <input type="file" class="form-control" name="video" accept="video/*" onchange="previewFile(this, 'videoPreview', 'video')">
                                            <video id="videoPreview" class="video-preview" controls>
                                                <source src="<?php echo !empty($row['video']) ? $row['video'] : ''; ?>" type="video/mp4">
                                                Your browser does not support the video tag.
                                            </video>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-4 mt-2">
                                    <div class="form-check d-flex align-items-center gap-2">
                                        <input class="form-check-input" type="checkbox" id="invalidCheck2" required checked>
                                        <label class="form-check-label mb-0" for="invalidCheck2">
                                            I confirm that the above information is correct
                                        </label>
                                    </div>
                                </div>

                                <div class="custom-btn-group">
                                    <button type="button" class="btn btn-outline-danger custom-wide-btn" onclick="window.location.href='user_dashboard.php'"> Cancel </button>
                                    <button type="submit" class="btn btn-success custom-wide-btn" name="update_about"> Submit </button>
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
    function previewFile(input, targetId, type) {
        var output = document.getElementById(targetId);
        if(input.files && input.files[0]){
            var reader = new FileReader();
            reader.onload = function(e) {
                if(type === 'image') {
                    output.src = e.target.result;
                } else if(type === 'video') {
                    output.src = e.target.result;
                    output.load(); 
                }
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>

<?php include('user_masterpage/user_footer.php'); ?>