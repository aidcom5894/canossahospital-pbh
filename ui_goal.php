<?php
    header("Cache-Control: no-cache, no-store, must-revalidate"); 

    include('user_masterpage/user_dashboard_header.php');
    include('user_masterpage/user_sidebar.php');
    include('user_masterpage/user_navbar.php');

    // error_reporting(E_ALL);
    // ini_set('display_errors', 1);

    // मान लेते हैं कि हम ID = 1 वाले 'About' सेक्शन को अपडेट कर रहे हैं
    $id = 1; 

    // 1. फॉर्म सबमिट होने पर अपडेट लॉजिक
    if (isset($_POST['update_about'])) { 

        $Heading1    = mysqli_real_escape_string($conn, $_POST['heading1']);
        $Heading2    = mysqli_real_escape_string($conn, $_POST['heading2']);
        $Heading3    = mysqli_real_escape_string($conn, $_POST['heading3']);
        $About1 = mysqli_real_escape_string($conn, $_POST['about1']);
        $About2 = mysqli_real_escape_string($conn, $_POST['about2']);
        $About3 = mysqli_real_escape_string($conn, $_POST['about3']);

        // पुराना डेटा लाना
        $old_data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT avatar FROM ui_goal WHERE id=$id"));
        $avatar   = $old_data['avatar'] ?? '';

        // फोल्डर का नाम सही किया
        if (!is_dir('gallery')) {
            mkdir('gallery', 0777, true);
        }

        // Avatar 1 Upload
        if (!empty($_FILES['avatar']['name'])) {
            $avatar_name = time() . '_1_' . $_FILES['avatar']['name'];
            $avatar_target = "gallery/" . $avatar_name;
            if (move_uploaded_file($_FILES['avatar']['tmp_name'], $avatar_target)) {
                $avatar = $avatar_target; 
            }
        }

        // 🔥 FIX 1: SQL UPDATE Query me subheading2 ko sahi mapping di
        $update_query = mysqli_query($conn, "UPDATE ui_goal SET 
                    heading1 = '$Heading1', 
                    heading2 = '$Heading2', 
                    heading3 = '$Heading3', 
                    about1   = '$About1', 
                    about2   = '$About2', 
                    about3   = '$About3', 
                    avatar   = '$avatar' 
                    WHERE id = $id");

        if ($update_query) {
            // Success Alert Variables
            $showAlert = true;
            $alertHeading = "Success!";
            $alertText = "Page data updated successfully!";
            $alertIcon = "success";
            $alertRedirect = "ui_goal.php"; 
            $btnColor = "#3085d6";
            $btnText = "Ok";
        } else {
            // Error Alert Variables
            $showAlert = true;
            $alertheading = "Error!";
            $alertText = "Something went wrong: " . mysqli_error($conn);
            $alertIcon = "error";
            $alertRedirect = "ui_goal.php"; 
            $btnColor = "#d33";
            $btnText = "Try Again";
        }
    }

    // 2. डेटा फेच करना
    $result = mysqli_query($conn, "SELECT * FROM ui_goal WHERE id=$id");
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
                <h6 class="fw-semibold mb-0"> Edit <span class="text-danger"> / </span> <span class="text-info fw-normal fs-5"> Our Goal-Page </span></h6>
            </div>  
        </div>
        
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-heading mb-0">Edit Your Page Content</h4>
                    </div>
                    <div class="card-body">
                        <div class="basic-form">
                            <form method="POST" class="form-valide-with-icon needs-validation" enctype="multipart/form-data" autocomplete="off">
                                
                                <div class="row">

                                    <div class="col-md-6 mb-3">
                                        <label class="text-label form-label fw-semibold">Heading: 1</label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <iconify-icon icon="solar:text-square-outline"></iconify-icon>
                                            </span>
                                            <input type="text" class="form-control form-control-lg" name="heading1" placeholder="Enter Main Heading heading1..." value="<?php echo isset($row['heading1']) ? htmlspecialchars($row['heading1']) : ''; ?>" required>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label class="text-label form-label fw-semibold">Heading: 2</label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <iconify-icon icon="solar:text-square-outline"></iconify-icon>
                                            </span>
                                            <input type="text" class="form-control form-control-lg" name="heading2" placeholder="Enter Main heading2..." value="<?php echo isset($row['heading2']) ? htmlspecialchars($row['heading2']) : ''; ?>">
                                        </div>
                                    </div>

  
                                </div>

                                <div class="row">

                                    <div class="col-md-6 mb-3">
                                        <label class="text-label form-label fw-semibold">Description: 1</label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <iconify-icon icon="solar:pen-new-square-outline"></iconify-icon>
                                            </span>
                                            <textarea class="form-control" name="about1" placeholder="Enter a Description1 ..." rows="3" style="resize: vertical;"><?php echo isset($row['about1']) ? htmlspecialchars($row['about1']) : ''; ?></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="text-label form-label fw-semibold">Description: 2</label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <iconify-icon icon="solar:pen-new-square-outline"></iconify-icon>
                                            </span>
                                            <textarea class="form-control" name="about2" placeholder="Enter Description2..." rows="3" style="resize: vertical;"><?php echo isset($row['about2']) ? htmlspecialchars($row['about2']) : ''; ?></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="text-label form-label fw-semibold">Heading: 3</label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <iconify-icon icon="solar:text-square-outline"></iconify-icon>
                                            </span>
                                            <input type="text" class="form-control form-control-lg" name="heading3" placeholder="Enter Main Heading heading3..." value="<?php echo isset($row['heading3']) ? htmlspecialchars($row['heading3']) : ''; ?>" required>
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="text-label form-label fw-semibold">Description: 3</label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <iconify-icon icon="solar:pen-new-square-outline"></iconify-icon>
                                            </span>
                                            <textarea class="form-control" name="about3" placeholder="Enter Description3..." rows="3" style="resize: vertical;"><?php echo isset($row['about3']) ? htmlspecialchars($row['about3']) : ''; ?></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="col mb-3">
                                    <div class="media-box">
                                        <label class="fw-semibold form-label">Avatar 1 (Image)</label>
                                        <input type="file" class="form-control" name="avatar" accept="image/*" onchange="previewFile(this, 'avatarPreview', 'image')">
                                        <img id="avatarPreview" class="img-preview" src="<?php echo (!empty($row['avatar']) && file_exists($row['avatar'])) ? $row['avatar'] : 'uploads/default-placeholder.png'; ?>" alt="Avatar Preview">
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