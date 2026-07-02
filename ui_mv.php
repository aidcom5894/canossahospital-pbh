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

        $About1 = mysqli_real_escape_string($conn, $_POST['about1_mission']);
        $About2 = mysqli_real_escape_string($conn, $_POST['about2_vision']);

   

        // 🔥 FIX 1: SQL UPDATE Query me subheading2 ko sahi mapping di
        $update_query = mysqli_query($conn, "UPDATE ui_mv SET 
                    about1_mission   = '$About1', 
                    about2_vision   = '$About2'
                    WHERE id = $id");

        if ($update_query) {
            // Success Alert Variables
            $showAlert = true;
            $alertHeading = "Success!";
            $alertText = "Page data updated successfully!";
            $alertIcon = "success";
            $alertRedirect = "ui_mv"; 
            $btnColor = "#3085d6";
            $btnText = "Ok";
        } else {
            // Error Alert Variables
            $showAlert = true;
            $alertheading = "Error!";
            $alertText = "Something went wrong: " . mysqli_error($conn);
            $alertIcon = "error";
            $alertRedirect = "ui_mv"; 
            $btnColor = "#d33";
            $btnText = "Try Again";
        }
    }

        // 2. डेटा फेच करना
        $result = mysqli_query($conn, "SELECT * FROM ui_mv WHERE id=$id");
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
                <h6 class="fw-semibold mb-0"> Edit <span class="text-danger"> / </span> <span class="text-info fw-normal fs-5">Mission & Vision:- Page </span></h6>
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
                                
                                <div class="mb-3">
                                    <label class="text-label form-label fw-semibold">About-Mission:</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <iconify-icon icon="solar:pen-new-square-outline"></iconify-icon>
                                        </span>
                                        <textarea class="form-control" name="about1_mission" placeholder="Enter a Description about mission ..." rows="4" style="resize: vertical;"><?php echo isset($row['about1_mission']) ? htmlspecialchars($row['about1_mission']) : ''; ?></textarea>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="text-label form-label fw-semibold">About-Vision:</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <iconify-icon icon="solar:pen-new-square-outline"></iconify-icon>
                                        </span>
                                        <textarea class="form-control" name="about2_vision" placeholder="Enter Description about Vision..." rows="4" style="resize: vertical;"><?php echo isset($row['about2_vision']) ? htmlspecialchars($row['about2_vision']) : ''; ?></textarea>
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
                                    <button type="button" class="btn btn-outline-danger custom-wide-btn" onclick="window.location.href='user_dashboard'"> Cancel </button>
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




<?php include('user_masterpage/user_footer.php'); ?>