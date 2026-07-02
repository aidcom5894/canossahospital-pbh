<?php
    header("Cache-Control: no-cache, no-store, must-revalidate"); 

    include('user_masterpage/user_dashboard_header.php');
    include('user_masterpage/user_sidebar.php');
    include('user_masterpage/user_navbar.php');

    // error_reporting(E_ALL);
    // ini_set('display_errors', 1);

    // 1. पहले चेक करें कि URL में ID है या नहीं
    if (!isset($_GET['id']) || empty($_GET['id'])) {
        echo "<script>window.location.href = 'ui_news_event';</script>";
        exit();
    }
    
    // अगर ID मौजूद है, तो उसे वेरिएबल में लें
    $edit_id = mysqli_real_escape_string($conn, $_GET['id']);
    
    // डेटाबेस से रिकॉर्ड निकालें
    $fetch = mysqli_query($conn, "SELECT * FROM news_events WHERE id = '$edit_id' LIMIT 1");
    $row = mysqli_fetch_assoc($fetch);

    // अगर ID गलत है या डेटाबेस में वो रिकॉर्ड नहीं है
    if (!$row) {
        echo "<div class='alert alert-danger m-3'>Record not found for ID: " . htmlspecialchars($edit_id) . "</div>";
        echo "<script>setTimeout(function(){ window.location.href = 'ui_news_event'; }, 2000);</script>";
        exit();
    }

    /* ---------------- UPDATE FORM LOGIC ---------------- */
    if (isset($_POST['update'])) {

        $Title       = mysqli_real_escape_string($conn, $_POST['title']);
        $Description = mysqli_real_escape_string($conn, $_POST['description']);
        $Tag         = mysqli_real_escape_string($conn, $_POST['tag']);
        $Date        = mysqli_real_escape_string($conn, $_POST['date']);

        // पुराना इमेज पाथ बैकअप रखें
        $oldImage    = isset($row['image']) ? $row['image'] : '';
        $Image       = $oldImage;

        /* -------- IMAGE UPLOAD -------- */
        if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {

            $file_name  = $_FILES['image']['name'];
            $file_tmp   = $_FILES['image']['tmp_name'];
            
            // फोल्डर सुनिश्चित करें (gallery/)
            $targetDir  = __DIR__ . "/gallery/";
            if (!is_dir($targetDir)) {
                mkdir($targetDir, 0755, true);
            }

            $uniqueName = time() . "_" . basename($file_name);
            $targetFile = $targetDir . $uniqueName;

            // बेस URL पाथ सेट करें
            $dbPath = "gallery/" . $uniqueName;

            if (move_uploaded_file($file_tmp, $targetFile)) {
                $Image = $dbPath; 

                // नई इमेज अपलोड होने पर पुरानी इमेज को सर्वर से डिलीट (Unlink) करें
                if (!empty($oldImage) && $oldImage != 'img/news/default.jpg') {
                    $oldFilename = basename($oldImage);
                    $oldTargetFile = __DIR__ . "/gallery/" . $oldFilename;
                    if (file_exists($oldTargetFile)) {
                        unlink($oldTargetFile);
                    }
                }
            }
        }

        // 2. क्वेरी एक्जीक्यूट करें
        $updateQuery = "UPDATE news_events SET  
                            title       = '$Title',
                            description = '$Description',
                            tag         = '$Tag',
                            date        = '$Date',
                            image       = '$Image'
                        WHERE id        = '$edit_id'";
                        
        $update = mysqli_query($conn, $updateQuery);

        if ($update) {
            // रीफ्रेश करें ताकि अपडेटेड डेटा तुरंत दिखे
            $fetch = mysqli_query($conn, "SELECT * FROM news_events WHERE id = '$edit_id' LIMIT 1");
            $row = mysqli_fetch_assoc($fetch);

            // अलर्ट पैरामीटर्स (फ़ुटर SweetAlert के लिए)
            $showAlert     = true;
            $alertTitle    = "Success!";
            $alertText     = "News & Event updated successfully!";
            $alertIcon     = "success";
            $alertRedirect = "ui_news_event"; 
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
                <h6 class="fw-semibold mb-0"> Edit <span class="text-danger"> / </span> <span class="text-info fw-normal fs-5"> News & Events </span></h6>
            </div>  
        </div>
        
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Edit News / Event Details</h4>
                    </div>
                    <div class="card-body">
                        <div class="basic-form">
                            <form method="POST" class="form-valide-with-icon needs-validation" enctype="multipart/form-data" autocomplete="off">

                                <div class="mb-3">
                                    <label class="text-label form-label">Title</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                           <iconify-icon icon="solar:document-text-outline"></iconify-icon>
                                        </span>
                                        <input type="text" class="form-control form-control-lg" name="title" placeholder="Enter title..." value="<?php echo isset($row['title']) ? htmlspecialchars($row['title']) : ''; ?>" required>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="text-label form-label">Description</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <iconify-icon icon="solar:notes-outline"></iconify-icon>
                                        </span>
                                        <textarea class="form-control " name="description" rows="5" placeholder="Enter description..." required><?php echo isset($row['description']) ? htmlspecialchars($row['description']) : ''; ?></textarea>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="text-label form-label">Tag / Category</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <iconify-icon icon="solar:tag-outline"></iconify-icon>
                                        </span>
                                        <input type="text" class="form-control form-control-lg" name="tag" placeholder="e.g. Celebration, Camp, News" value="<?php echo isset($row['tag']) ? htmlspecialchars($row['tag']) : ''; ?>" required>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="text-label form-label">Event Date</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <iconify-icon icon="solar:calendar-date-outline"></iconify-icon>
                                        </span>
                                        <input type="date" class="form-control form-control-lg" name="date" value="<?php echo isset($row['date']) ? htmlspecialchars($row['date']) : ''; ?>" required>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="text-label form-label">Event Image</label>
                                    <div class="input-group">
                                        <input type="file" class="form-control" name="image" onchange="loadInsertFile(event)">
                                    </div>
                                </div>

                                <div class="mb-3 text-start">
                                    <img src="<?php echo (!empty($row['image'])) ? $row['image'] : 'img/news/default.jpg'; ?>" id="output_image">
                                </div>    

                                <div class="mb-3">
                                    <div class="form-check d-flex align-items-center gap-1">
                                      <input class="form-check-input" type="checkbox" id="invalidCheck2" required checked>
                                      <label class="form-check-label" for="invalidCheck2">
                                        Confirm update details
                                      </label>
                                    </div>
                                </div>

                                <div class="custom-btn-group">
                                    <button type="button" class="btn btn-outline-danger custom-wide-btn" onclick="window.location.href='ui_news_event'"> Cancel </button>
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

<?php include('user_masterpage/user_footer.php'); ?>