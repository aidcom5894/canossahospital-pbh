<?php
    header("Cache-Control: no-cache, no-store, must-revalidate"); 

    include('user_masterpage/user_dashboard_header.php');
    include('user_masterpage/user_sidebar.php');
    include('user_masterpage/user_navbar.php');

    // error_reporting(E_ALL);
    // ini_set('display_errors', 1);

    // ID = 1 wale FAQ/About section ko update karne ke liye
    $id = 1; 

    // 1. फॉर्म सबमिट होने पर अपडेट लॉजिक
    if (isset($_POST['update_faq'])) { 
        // Variables ko alag-alag aur sahi name ke sath capture kiya (FIXED OVERWRITING)
        $Name  = mysqli_real_escape_string($conn, $_POST['name'] ?? '');
        $Ques1 = mysqli_real_escape_string($conn, $_POST['ques1'] ?? '');
        $Ques2 = mysqli_real_escape_string($conn, $_POST['ques2'] ?? '');
        $Ques3 = mysqli_real_escape_string($conn, $_POST['ques3'] ?? '');
        $Ques4 = mysqli_real_escape_string($conn, $_POST['ques4'] ?? '');
        
        $Ans1  = mysqli_real_escape_string($conn, $_POST['ans1'] ?? '');
        $Ans2  = mysqli_real_escape_string($conn, $_POST['ans2'] ?? '');
        $Ans3  = mysqli_real_escape_string($conn, $_POST['ans3'] ?? '');
        $Ans4  = mysqli_real_escape_string($conn, $_POST['ans4'] ?? '');

        // पुराना डेटा लाना
        $old_data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT avatar FROM ui_faq WHERE id=$id"));
        $avatar   = $old_data['avatar'] ?? '';

        // फोल्डर चेक और बनाना
        if (!is_dir('hImages')) {
            mkdir('hImages', 0777, true);
        }

        // Avatar Image Upload
        if (!empty($_FILES['avatar']['name'])) {
            $avatar_name = time() . '_1_' . basename($_FILES['avatar']['name']);
            $avatar_target = "hImages/" . $avatar_name;
            if (move_uploaded_file($_FILES['avatar']['tmp_name'], $avatar_target)) {
                $avatar = $avatar_target; 
            }
        }

        // SQL UPDATE QUERY (Sahi variables ke sath map kiya)
        $update_query = mysqli_query($conn, "UPDATE ui_faq SET 
                        name   = '$Name', 
                        ques1  = '$Ques1', 
                        ques2  = '$Ques2', 
                        ques3  = '$Ques3', 
                        ques4  = '$Ques4', 
                        ans1   = '$Ans1', 
                        ans2   = '$Ans2', 
                        ans3   = '$Ans3', 
                        ans4   = '$Ans4', 
                        avatar = '$avatar'
                        WHERE id = $id");

        if ($update_query) {
            $showAlert = true;
            $alertTitle = "Success!";
            $alertText = "FAQ updated successfully!";
            $alertIcon = "success";
            $alertRedirect = "ui_faq"; 
            $btnColor = "#3085d6";
            $btnText = "Continue";
        }
    } 

    // 2. डेटा फेच करना (Form me autofill karne ke liye)
    $result = mysqli_query($conn, "SELECT * FROM ui_faq WHERE id=$id");
    $row = mysqli_fetch_assoc($result);
?>

<style>
    .img-preview { width: 160px; height: 160px; margin-top: 9px; border-radius: 50%; object-fit: cover; border: 2px dashed #3085d6; display: block; }
    .custom-btn-group { display: flex !important; justify-content: flex-end !important; gap: 15px !important; margin-top: 25px !important; }
    .custom-wide-btn { min-width: 140px !important; padding: 10px 24px !important; font-weight: 600 !important; }
    .media-box { background: #f8f9fa; padding: 15px; border-radius: 8px; border: 1px solid #edf2f7; margin-bottom: 15px; }
    .faq-card { border: 1px solid #e3e6f0; border-radius: 8px; background: #ffffff; padding: 20px; margin-bottom: 20px; box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.05); }
    .input-group-text { background-color: #f1f3f9; color: #4e73df; }
</style>

<div class="dashboard-main-body">
    <div class="container-fluid">
        
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
            <div class="card p-3 w-100">
                <h6 class="fw-semibold mb-0"> Edit <span class="text-danger"> / </span> <span class="text-info fw-normal fs-5"> Faq-Page </span></h6>
            </div>  
        </div>
        
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header bg-light">
                        <h4 class="card-title mb-0 text-primary"><iconify-icon icon="fluent:edit-settings-24-regular" class="me-2"></iconify-icon>Update FAQ Content</h4>
                    </div>
                    <div class="card-body">
                        <div class="basic-form">
                            <form method="POST" class="form-valide-with-icon needs-validation" enctype="multipart/form-data" autocomplete="off">
                                
                                <div class="row align-items-center mb-4">
                                    <div class="col-md-8">
                                        <div class="mb-3">
                                            <label class="fw-semibold form-label text-dark">Name / Title</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><iconify-icon icon="solar:user-bold"></iconify-icon></span>
                                                <input type="text" class="form-control" name="name" value="<?php echo htmlspecialchars($row['name'] ?? ''); ?>" placeholder="Enter Name or Section Title" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="media-box text-center d-flex flex-column align-items-center">
                                            <label class="fw-semibold form-label text-dark"><iconify-icon icon="solar:camera-add-bold" class="me-1"></iconify-icon>Avatar (Image)</label>
                                            <input type="file" class="form-control" name="avatar" accept="image/*" onchange="previewFile(this, 'avatarPreview', 'image')">
                                            <img id="avatarPreview" class="img-preview" src="<?php echo (!empty($row['avatar']) && file_exists($row['avatar'])) ? $row['avatar'] : 'uploads/default-placeholder.png'; ?>" alt="Avatar Preview">
                                        </div>
                                    </div>
                                </div>

                                <hr class="my-4">
                                <h5 class="mb-4 text-secondary"><iconify-icon icon="solar:help-list-bold" class="me-2"></iconify-icon>Frequently Asked Questions (FAQs)</h5>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="faq-card">
                                            <h6 class="text-primary mb-3"><span class="badge bg-primary me-2">FAQ 1</span> Question & Answer</h6>
                                            <div class="mb-3">
                                                <div class="input-group">
                                                    <span class="input-group-text"><iconify-icon icon="solar:question-square-bold"></iconify-icon></span>
                                                    <input type="text" class="form-control" name="ques1" value="<?php echo htmlspecialchars($row['ques1'] ?? ''); ?>" placeholder="Enter Question 1">
                                                </div>
                                            </div>
                                            <div>
                                                <textarea class="form-control" name="ans1" rows="4" placeholder="Enter Answer 1"><?php echo htmlspecialchars($row['ans1'] ?? ''); ?></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="faq-card">
                                            <h6 class="text-primary mb-3"><span class="badge bg-primary me-2">FAQ 2</span> Question & Answer</h6>
                                            <div class="mb-3">
                                                <div class="input-group">
                                                    <span class="input-group-text"><iconify-icon icon="solar:question-square-bold"></iconify-icon></span>
                                                    <input type="text" class="form-control" name="ques2" value="<?php echo htmlspecialchars($row['ques2'] ?? ''); ?>" placeholder="Enter Question 2">
                                                </div>
                                            </div>
                                            <div>
                                                <textarea class="form-control" name="ans2" rows="4" placeholder="Enter Answer 2"><?php echo htmlspecialchars($row['ans2'] ?? ''); ?></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="faq-card">
                                            <h6 class="text-primary mb-3"><span class="badge bg-primary me-2">FAQ 3</span> Question & Answer</h6>
                                            <div class="mb-3">
                                                <div class="input-group">
                                                    <span class="input-group-text"><iconify-icon icon="solar:question-square-bold"></iconify-icon></span>
                                                    <input type="text" class="form-control" name="ques3" value="<?php echo htmlspecialchars($row['ques3'] ?? ''); ?>" placeholder="Enter Question 3">
                                                </div>
                                            </div>
                                            <div>
                                                <textarea class="form-control" name="ans3" rows="4" placeholder="Enter Answer 3"><?php echo htmlspecialchars($row['ans3'] ?? ''); ?></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="faq-card">
                                            <h6 class="text-primary mb-3"><span class="badge bg-primary me-2">FAQ 4</span> Question & Answer</h6>
                                            <div class="mb-3">
                                                <div class="input-group">
                                                    <span class="input-group-text"><iconify-icon icon="solar:question-square-bold"></iconify-icon></span>
                                                    <input type="text" class="form-control" name="ques4" value="<?php echo htmlspecialchars($row['ques4'] ?? ''); ?>" placeholder="Enter Question 4">
                                                </div>
                                            </div>
                                            <div>
                                                <textarea class="form-control" name="ans4" rows="4" placeholder="Enter Answer 4"><?php echo htmlspecialchars($row['ans4'] ?? ''); ?></textarea>
                                            </div>
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
                                    <button type="button" class="btn btn-outline-danger custom-wide-btn" onclick="window.location.href='user_dashboard'">
                                        <iconify-icon icon="material-symbols:close" class="me-1"></iconify-icon> Cancel
                                    </button>
                                    <button type="submit" class="btn btn-success custom-wide-btn" name="update_faq">
                                        <iconify-icon icon="material-symbols:check-circle-rounded" class="me-1"></iconify-icon> Submit
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
    function previewFile(input, targetId, type) {
        var output = document.getElementById(targetId);
        if(input.files && input.files[0]){
            var reader = new FileReader();
            reader.onload = function(e) {
                if(type === 'image') {
                    output.src = e.target.result;
                }
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>

<?php include('user_masterpage/user_footer.php'); ?>