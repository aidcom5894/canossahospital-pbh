<?php
    header("Cache-Control: no-cache, no-store, must-revalidate"); 

    include('user_masterpage/user_dashboard_header.php');
    include('user_masterpage/user_sidebar.php');
    include('user_masterpage/user_navbar.php');

    // error_reporting(E_ALL);
    // ini_set('display_errors', 1);

    // ID = 1 वाले 'Appointment' सेक्शन को अपडेट कर रहे हैं
    $id = 1; 

    // 1. फॉर्म सबमिट होने पर अपडेट लॉजिक
    if (isset($_POST['appointment'])) { 
        $Title1    = mysqli_real_escape_string($conn, $_POST['title1']);
        $Subtitle1 = mysqli_real_escape_string($conn, $_POST['subtitle1']);
        $About1    = mysqli_real_escape_string($conn, $_POST['about1']);
        $Title2    = mysqli_real_escape_string($conn, $_POST['title2']);
        $Subtitle2 = mysqli_real_escape_string($conn, $_POST['subtitle2']);
        $About2    = mysqli_real_escape_string($conn, $_POST['about2']);

        // पुराना इमेज डेटा लाना
        $old_data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT avatar FROM ui_appointment WHERE id=$id"));
        $avatar   = $old_data['avatar'] ?? '';

        // फोल्डर चेक करना
        if (!is_dir('hImages')) {
            mkdir('hImages', 0777, true);
        }

        // Avatar Upload
        if (!empty($_FILES['avatar']['name'])) {
            $avatar_name = time() . '_1_' . $_FILES['avatar']['name'];
            $avatar_target = "hImages/" . $avatar_name;
            if (move_uploaded_file($_FILES['avatar']['tmp_name'], $avatar_target)) {
                $avatar = $avatar_target; 
            }
        }

        // SQL UPDATE QUERY (सभी वेरिएबल्स और कॉलम्स को सिंक किया गया है)
        $update_query = mysqli_query($conn, "UPDATE ui_appointment SET 
                        title1    = '$Title1', 
                        subtitle1 = '$Subtitle1', 
                        about1    = '$About1', 
                        title2    = '$Title2', 
                        subtitle2 = '$Subtitle2', 
                        about2    = '$About2', 
                        avatar    = '$avatar' 
                        WHERE id  = $id");

        if ($update_query) {
            $showAlert = true;
            $alertTitle = "Success!";
            $alertText = "Appointment data updated successfully!";
            $alertIcon = "success";
            $alertRedirect = "ui_appointment"; 
            $btnColor = "#3085d6";
            $btnText = "Ok";
        }
    }

    // 2. डेटा फेच करना
    $result = mysqli_query($conn, "SELECT * FROM ui_appointment WHERE id=$id");
    $row = mysqli_fetch_assoc($result);
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
                <h6 class="fw-semibold mb-0"> Edit <span class="text-danger"> / </span> <span class="text-info fw-normal fs-5"> Appointment-Page </span></h6>
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
                                        <label class="text-label form-label fw-semibold">Title:1</label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <iconify-icon icon="solar:text-square-outline"></iconify-icon>
                                            </span>
                                            <input type="text" class="form-control form-control-lg" name="title1" placeholder="Enter a Title1..." value="<?php echo isset($row['title1']) ? htmlspecialchars($row['title1']) : ''; ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="text-label form-label fw-semibold">Title: 2</label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <iconify-icon icon="solar:text-square-outline"></iconify-icon>
                                            </span>
                                            <input type="text" class="form-control form-control-lg" name="title2" placeholder="Enter a Title 2..." value="<?php echo isset($row['title2']) ? htmlspecialchars($row['title2']) : ''; ?>">
                                        </div>
                                    </div>

                                </div>    
                                

                                <div class="row">

                                    <div class="col-md-6 mb-3">
                                        <label class="text-label form-label fw-semibold">Sub-title: 1</label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <iconify-icon icon="solar:pen-new-square-outline"></iconify-icon>
                                            </span>
                                            <input type="text" class="form-control form-control-lg" name="subtitle1" placeholder="Enter a Subtitle-1..." value="<?php echo isset($row['subtitle1']) ? htmlspecialchars($row['subtitle1']) : ''; ?>">
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="text-label form-label fw-semibold">Sub-title: 2</label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <iconify-icon icon="solar:pen-new-square-outline"></iconify-icon>
                                            </span>
                                            <input type="text" class="form-control form-control-lg" name="subtitle2" placeholder="Enter a Subtitle 2..." value="<?php echo isset($row['subtitle2']) ? htmlspecialchars($row['subtitle2']) : ''; ?>">
                                        </div>
                                    </div>

                                </div>

                                <div class="row">

                                    <div class="col-md-6 mb-3">
                                        <label class="text-label form-label fw-semibold">About:1</label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <iconify-icon icon="solar:notes-outline"></iconify-icon>
                                            </span>
                                            <textarea class="form-control form-control-lg" name="about1" rows="3" placeholder="Enter about details1..."><?php echo isset($row['about1']) ? htmlspecialchars($row['about1']) : ''; ?></textarea>
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="text-label form-label fw-semibold">About:2</label>
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <iconify-icon icon="solar:notes-outline"></iconify-icon>
                                            </span>
                                            <textarea class="form-control form-control-lg" name="about2" rows="3" placeholder="Enter about details2..."><?php echo isset($row['about2']) ? htmlspecialchars($row['about2']) : ''; ?></textarea>
                                        </div>
                                    </div>

                                </div>


                                <!-- Image 1 -->
                                <div class="col mb-3">
                                    <label class="form-label">Background-Avatar</label>
                                    <input type="file" class="form-control" name="avatar" onchange="previewFile(this, 'output_image1')">
                                    <img src="<?php echo $row['avatar'] ?? 'default.png'; ?>" id="output_image1" class="img-preview">
                                </div>


                                <div class="col-md-12 mb-4 mt-2">
                                    <div class="form-check d-flex align-items-center gap-2">
                                        <input class="form-check-input" type="checkbox" id="invalidCheck2" required checked>
                                        <label class="form-check-label mb-0" for="invalidCheck2">
                                            I confirm that the above information is correct
                                        </label>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="custom-btn-group">
                                            <button type="button" class="btn btn-outline-danger custom-wide-btn" onclick="window.location.href='user_dashboard'"> Cancel </button>
                                            <button type="submit" class="btn btn-success custom-wide-btn" name="appointment"> Submit </button>
                                        </div>
                                    </div>
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
    function previewFile(input, targetId) {
        var output = document.getElementById(targetId);
        if(input.files && input.files[0]){
            output.src = URL.createObjectURL(input.files[0]);
        }
    }
</script>

<?php include('user_masterpage/user_footer.php'); ?>