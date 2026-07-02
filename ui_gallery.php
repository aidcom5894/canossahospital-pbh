<?php 
    header("Cache-Control: no-cache, no-store, must-revalidate"); 

    include('user_masterpage/user_dashboard_header.php');
    include('user_masterpage/user_sidebar.php');
    include('user_masterpage/user_navbar.php');

    // error_reporting(E_ALL);
    // ini_set('display_errors', 1);

    // ==========================================
    // 1. SEARCH LOGIC (Updated for ui_gallery columns)
    // ==========================================
    $search_query = "";
    if (isset($_GET['search']) && !empty(trim($_GET['search']))) {
        $search = mysqli_real_escape_string($conn, trim($_GET['search']));
        // ui_gallery टेबल के सही कॉलम्स (title, category) पर सर्च लगाया
        $search_query = " WHERE (title LIKE '%$search%' OR category LIKE '%$search%') ";
    }

    // ==========================================
    // 2. PAGINATION LOGIC
    // ==========================================
    $limit = 6; 
    $page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
    if ($page < 1) $page = 1;
    $offset = ($page - 1) * $limit;

    $total_query = "SELECT COUNT(*) as total FROM ui_gallery" . $search_query;
    $total_result = mysqli_query($conn, $total_query);
    $total_row = mysqli_fetch_assoc($total_result);
    $total_records = $total_row['total'];
    $total_pages = ceil($total_records / $limit);
?>

<?php
        /* ---------------- INSERT FORM LOGIC ---------------- */
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_data'])) {

            // FIX: $_POST inputs को सही किया (जो modal form के name attributes से मैच करेंगे)
            $Category = isset($_POST['category']) ? mysqli_real_escape_string($conn, trim($_POST['category'])) : '';

            $Avatar = 'medikit/images/default-avatar.png'; // डिफ़ॉल्ट प्लेसहोल्डर

            /* -------- IMAGE UPLOAD -------- */
            if(isset($_FILES['avatar']) && $_FILES['avatar']['error'] === 0){
                $file_name  = $_FILES['avatar']['name'];
                $file_tmp   = $_FILES['avatar']['tmp_name'];
                
                $targetDir  = __DIR__ . "/gallery/";
                if (!is_dir($targetDir)) {
                    mkdir($targetDir, 0755, true);
                }

                $uniqueName = time() . "_" . basename($file_name);
                $targetFile = $targetDir . $uniqueName;
                
                $dbPath     = (isset($base_url) ? $base_url : '') . "/gallery/" . $uniqueName;

                if(move_uploaded_file($file_tmp, $targetFile)){
                    $Avatar = $dbPath; 
                }
            }

            // Database Insertion
            if (!empty($Category)) {
                $insertQuery = "INSERT INTO ui_gallery (category, avatar) VALUES ('$Category', '$Avatar')";
                $insert = mysqli_query($conn, $insertQuery);

                if ($insert) {
                    $showAlert     = true;
                    $alertTitle    = "Success!";
                    $alertText     = "Gallery photo added successfully!";
                    $alertIcon     = "success";
                    $alertRedirect = "ui_gallery"; 
                    $btnColor      = "#0284c7";
                    $btnText       = "Ok";
                }
            }
        }
?>
    <style>
        .d-col-avatar img {
            width: 80px !important;
            height: 80px !important;
            border-radius: 5px;
            object-fit: cover !important;
            flex-shrink: 0 !important; 
        }

        .noti-main-wrapper * {
            box-sizing: border-box !important;
        }

        .content-subheader {
            display: flex !important;
            justify-content: space-between !important;
            align-items: center !important;
            padding: 15px 5px !important;
            margin-bottom: 20px !important;
            border-bottom: 1px solid #edf2f9 !important;
            flex-wrap: wrap !important;
            gap: 15px !important;
        }
        .content-subheader__titles {
            display: flex !important;
            align-items: center !important;
            gap: 15px !important;
        }
        .content-subheader__title {
            font-size: 22px !important;
            font-weight: 600 !important;
            color: #1e293b !important;
            margin: 0 !important;
        }
        
        .btn-top-add {
            display: inline-flex !important;
            align-items: center !important;
            gap: 6px !important;
            padding: 8px 16px !important;
            font-size: 14px !important;
            font-weight: 500 !important;
            background-color: #10b981 !important;
            color: #ffffff !important;
            border: none !important;
            border-radius: 6px !important;
            text-decoration: none !important;
            cursor: pointer !important;
            transition: background 0.2s !important;
        }
        .btn-top-add:hover {
            background-color: #059669 !important;
        }

        .content-subheader__options {
            display: flex !important;
            align-items: center !important;
            gap: 12px !important;
            flex-wrap: wrap !important;
        }
        .content-subheader__search form {
            display: flex !important;
            align-items: center !important;
            gap: 8px !important;
        }
        .subheader-search__input {
            padding: 8px 14px !important;
            font-size: 14px !important;
            border: 1px solid #cbd5e1 !important;
            border-radius: 6px !important;
            width: 240px !important;
            outline: none !important;
            transition: border-color 0.2s !important;
            background: #fff !important;
            color: #334155 !important;
        }
        .subheader-search__input:focus {
            border-color: #3b82f6 !important;
        }
        .subheader-search__submit {
            padding: 8px 16px !important;
            font-size: 14px !important;
            font-weight: 500 !important;
            background-color: #3b82f6 !important;
            color: #ffffff !important;
            border: none !important;
            border-radius: 6px !important;
            cursor: pointer !important;
            transition: background 0.2s !important;
        }
        .subheader-search__submit:hover {
            background-color: #2563eb !important;
        }
        .search-clear-btn {
            font-size: 14px !important;
            color: #ef4444 !important;
            text-decoration: none !important;
            font-weight: 500 !important;
            padding: 8px !important;
        }
        .search-clear-btn:hover {
            text-decoration: underline !important;
        }

        .desktop-table-view {
            width: 100%;
            display: block;
        }
        .desktop-header {
            display: flex;
            background-color: #f8f9fa;
            font-weight: bold;
            padding: 12px 10px;
            border-bottom: 2px solid #eee;
        }
        .desktop-row {
            display: flex;
            align-items: center;
            padding: 15px 10px;
            border-bottom: 1px solid #edf2f9;
            color: inherit !important;
            text-decoration: none !important;
        }
        .desktop-row:hover {
            background-color: #f9f9f9;
        }
        
        .d-col-sr      { flex: 0 0 15%;   text-align: center; }
        .d-col-avatar  { flex: 0 0 30%;  text-align: center; display: flex; justify-content: center; }
        .d-col-name    { flex: 0 0 40%;  padding-left: 10px; text-align: left; font-weight: 600; color: #333; }
        .d-col-action  { flex: 0 0 7%;   text-align: center; }

        .truncate-txt {
            white-space: nowrap !important;
            overflow: hidden !important;
            text-overflow: ellipsis !important;
        }

        .btn-action-icon {
            font-size: 18px;
            padding: 6px 10px;
            border-radius: 4px;
            transition: all 0.2s;
            text-decoration: none !important;
        }
        .btn-action-icon.edit { color: #2563eb; }
        .btn-action-icon.edit:hover { background-color: #dbeafe; }
        .btn-action-icon.delete { color: #ef4444; }
        .btn-action-icon.delete:hover { background-color: #fee2e2; }

        .m-card-actions {
            display: flex;
            gap: 12px;
            margin-top: 12px;
            padding-top: 10px;
            border-top: 1px solid #f1f5f9;
            justify-content: flex-end; 
        }
        .m-btn-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            font-size: 18px;
            border-radius: 6px;
            text-decoration: none !important;
            transition: all 0.2s;
        }
        .m-btn-edit { background: #e0f2fe; color: #0369a1; }
        .m-btn-edit:hover { background: #38bdf8; color: #fff; }
        .m-btn-delete { background: #fee2e2; color: #b91c1c; }
        .m-btn-delete:hover { background: #f87171; color: #fff; }

        .mobile-cards-view {
            display: none; 
            width: 100%;
        }

        @media (max-width: 768px) {
            .content-subheader {
                flex-direction: column !important;
                align-items: flex-start !important;
            }
            .content-subheader__titles {
                width: 100% !important;
                justify-content: space-between !important;
            }
            .content-subheader__options {
                width: 100% !important;
            }
            .content-subheader__search {
                width: 100% !important;
            }
            .content-subheader__search form {
                width: 100% !important;
            }
            .subheader-search__input {
                flex-grow: 1 !important;
                width: auto !important;
            }

            .desktop-table-view {
                display: none !important; 
            }
            
            .mobile-cards-view {
                display: flex !important;
                flex-direction: column !important; 
                gap: 15px !important; 
                padding: 5px !important;
            }

            .noti-mobile-card {
                display: block !important;
                background: #ffffff !important;
                border-radius: 10px !important;
                padding: 15px !important;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05) !important; 
                border: 1px solid #edf2f9 !important;
                color: inherit !important;
                text-decoration: none !important;
                position: relative !important;
                width: 100% !important;
            }

            .card-main-content {
                display: flex !important;
                flex-direction: row !important; 
                align-items: flex-start !important;
                width: 100% !important;
                gap: 15px !important;
            }

            .card-avatar-box {
                flex: 0 0 48px !important;
                width: 48px !important;
                height: 48px !important;
            }
            .card-avatar-box img {
                width: 48px !important;
                height: 48px !important;
                border-radius: 50% !important;
                object-fit: cover !important;
            }

            .card-text-box {
                flex-grow: 1 !important;
                min-width: 0 !important;
                display: flex !important;
                flex-direction: column !important; 
                gap: 4px !important;
            }

            .m-sender-name {
                font-size: 13px !important;
                font-weight: 600 !important;
                color: #ff9f29 !important; 
            }

            .m-noti-title {
                font-size: 14px !important;
                font-weight: 700 !important;
                color: #1e293b !important;
                margin-top: 4px !important;
            }

            .responsive-pagination {
                justify-content: center !important;
                padding: 15px 0 !important;
            }
        }
    </style>

    <div class="noti-main-wrapper" style="display: flex; flex-direction: column; min-height: 75vh; justify-content: space-between; padding: 10px 20px;">
        
        <div>
            <div class="content-subheader">
                <div class="content-subheader__titles">
                    <h2 class="content-subheader__title">Gallery Page</h2>
                    <a href="#" class="btn-top-add open-add-modal"><i class="ri-add-circle-line"></i> Add New </a>
                </div>
                <div class="content-subheader__options">
                    <div class="content-subheader__search">
                        <form method="GET" action="ui_gallery">
                            <input type="text" name="search" class="subheader-search__input" placeholder="Search data..." value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>" />
                            <input type="submit" class="subheader-search__submit" value="Search" />
                            <?php if(!empty($search_query)): ?>
                                <a href="ui_gallery" class="search-clear-btn">Clear</a>
                            <?php endif; ?>
                        </form>
                    </div>
                </div>
            </div>

            <div class="grid__row">
                <div class="grid__col grid__col--padding bg-white" style="padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
                    
                    <div class="desktop-table-view">
                        <div class="desktop-header">
                            <div class="d-col-sr">#</div>
                            <div class="d-col-avatar">Gallery-Avatar</div>
                            <div class="d-col-name">Gallery-Category</div>
                            <div class="d-col-action">Edit</div>
                            <div class="d-col-action">Delete</div>
                        </div>
                        
                        <div class="table__body">
                            <?php 
                                $query = "SELECT * FROM ui_gallery " . $search_query . " ORDER BY id DESC LIMIT $limit OFFSET $offset";
                                $fetchData = mysqli_query($conn, $query);
                                $count = $offset + 1; 
                                
                                if(mysqli_num_rows($fetchData) > 0) {
                                    while($row = mysqli_fetch_assoc($fetchData)){
                                        $id         = $row['id'];
                                        $category   = htmlspecialchars($row['category']);
                                        $avatar     = !empty($row['avatar']) ? $row['avatar'] : "medikit/images/default-avatar.png";
                                ?>
                                <div class="desktop-row">
                                    <div class="d-col-sr"><?php echo $count++; ?></div>
                                    <div class="d-col-avatar">
                                        <img src="<?php echo $avatar; ?>" alt="avatar" />
                                    </div>
                                    <div class="d-col-name truncate-txt"><?php echo $category; ?></div>
                                    
                                    <div class="d-col-action">
                                        <a href="javascript:void(0);" class="btn-action-icon edit" onclick="confirmEdit('<?php echo $id; ?>')" title="Edit"><i class="ri-edit-box-line"></i></a>
                                    </div>
                                    <div class="d-col-action">
                                        <a href="javascript:void(0);" class="btn-action-icon delete" onclick="confirmDelete('<?php echo $id; ?>')" title="Delete"><i class="ri-delete-bin-line"></i></a>
                                    </div>
                                </div>
                            <?php 
                                    }
                                } else {
                                    echo '<div style="padding:30px; text-align:center; color:#999; font-size:14px;">No records found.</div>';
                                }
                            ?>
                        </div>
                    </div>

                    <div class="mobile-cards-view">
                        <?php 
                            if(mysqli_num_rows($fetchData) > 0) {
                                mysqli_data_seek($fetchData, 0); // Loop reset for mobile view
                                while($row = mysqli_fetch_assoc($fetchData)){
                                    $id         = $row['id'];
                                    $category   = htmlspecialchars($row['category']);
                                    $avatar     = !empty($row['avatar']) ? $row['avatar'] : "medikit/images/default-avatar.png";
                        ?>
                            <div class="noti-mobile-card">
                                <div class="card-main-content">
                                    <div class="card-avatar-box">
                                        <img src="<?php echo $avatar; ?>" alt="avatar" />
                                    </div>
                                    
                                    <div class="card-text-box">
                                        <div class="m-sender-name"><?php echo $category; ?></div>
                                    </div>
                                </div>
                                
                                <div class="m-card-actions">
                                    <a href="javascript:void(0);" class="m-btn-icon m-btn-edit" title="Edit" onclick="confirmEdit('<?php echo $id; ?>')"><i class="ri-edit-box-line"></i></a>
                                    <a href="javascript:void(0);" class="m-btn-icon m-btn-delete" onclick="confirmDelete('<?php echo $id; ?>')" title="Delete"><i class="ri-delete-bin-line"></i></a>
                                </div>
                            </div>
                        <?php 
                                }
                            } else {
                                echo '<div style="padding:20px; text-align:center; color:#999; font-size:14px;">No records found.</div>';
                            }
                        ?>
                    </div>

                </div>
            </div>

            <?php if($total_pages > 1): ?>
            <div class="grid grid--margin">
                <div class="grid__row">
                    <div class="grid__col grid__col--padding bg-white" style="border-radius:5px; margin-top: 15px;">
                        <ul class="responsive-pagination" style="display: flex; list-style: none; gap: 5px; padding-left: 0;">
                            <?php
                                $search_param = isset($_GET['search']) ? "&search=" . urlencode($_GET['search']) : "";

                                if($page > 1) {
                                    echo '<li><a href="ui_gallery?page='.($page - 1).$search_param.'" style="padding: 8px 12px; border: 1px solid #ddd; text-decoration: none; color: #007bff; display: inline-block; border-radius: 4px;">PREV</a></li>';
                                }

                                for($i = 1; $i <= $total_pages; $i++) {
                                    $active_class = ($i == $page) ? 'style="padding: 8px 12px; border: 1px solid #007bff; background: #007bff; color: #fff; text-decoration: none; font-weight: bold; display: inline-block; border-radius: 4px;"' : 'style="padding: 8px 12px; border: 1px solid #ddd; text-decoration: none; color: #007bff; display: inline-block; border-radius: 4px;"';
                                    echo '<li><a href="ui_gallery?page='.$i.$search_param.'" '.$active_class.'>'.$i.'</a></li>';
                                }

                                if($page < $total_pages) {
                                    echo '<li><a href="ui_gallery?page='.($page + 1).$search_param.'" style="padding: 8px 12px; border: 1px solid #ddd; text-decoration: none; color: #007bff; display: inline-block; border-radius: 4px;">NEXT</a></li>';
                                }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="modal fade" id="addTaskModal" tabindex="-1" aria-labelledby="addTaskModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title text-xl mb-0" id="addTaskModalLabel">Add New Gallery Data</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" onclick="window.location.href='ui_gallery'"></button>
                </div>
                <div class="modal-body">
                    <form id="taskForm" method="POST" enctype="multipart/form-data" autocomplete="off">
                        
                        <div class="mb-3">
                            <label for="taskCategory" class="form-label fw-semibold text-primary-light text-sm mb-8">Category</label>
                            <select name="category" class="form-control form-select" id="taskCategory" required>
                                <option value="" disabled selected>-- Select Category --</option>
                                <option value="Event">Event</option>
                                <option value="National Holiday">National Holiday</option>
                                <option value="Function">Function</option>
                            </select>
                        </div>
                        

                        <div class="mb-3">
                            <label for="taskImage" class="form-label fw-semibold text-primary-light text-sm mb-8">Image <span class="text-sm">(Jpg, Png format)</span> </label>
                            <input type="file" name="avatar" class="form-control" id="taskImage">
                            <img id="taskImagePreview" src="" alt="Image Preview" style="display:none; max-width:100px; margin-top:10px; border-radius:8px;">
                        </div>
                        <div class="modal-footer justify-content-center gap-3">
                            <button type="button" class="border border-danger-600 bg-hover-danger-200 text-danger-600 text-md px-50 py-11 radius-8" data-bs-dismiss="modal"> 
                                Cancel
                            </button>
                            <button type="submit" class="btn btn-primary border order-primary-600 text-md px-28 py-12 radius-8" id="saveTaskButton" name="submit_data"> 
                                Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var myModal = new bootstrap.Modal(document.getElementById('addTaskModal'));
            
            document.querySelectorAll('.open-add-modal').forEach(button => {
                button.addEventListener('click', function (e) {
                    e.preventDefault();
                    document.getElementById('taskForm').reset();
                    document.getElementById('taskImagePreview').style.display = 'none';
                    myModal.show();
                });
            });

            document.getElementById('taskImage').addEventListener('change', function () {
                var file = this.files[0];
                var reader = new FileReader();
                reader.onload = function (e) {
                    var preview = document.getElementById('taskImagePreview');
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                };
                if (file) {
                    reader.readAsDataURL(file);
                }
            });
        });

        function confirmDelete(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#64748b', 
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'ui_gallery-delete?id=' + id;
                }
            });
        }

        function confirmEdit(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "Edit this Gallery page data list!",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3b82f6',
                cancelButtonColor: '#64748b', 
                confirmButtonText: 'Yes, Edit it!',
                cancelButtonText: 'No, Discard'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'ui_edit-gallery?id=' + id; 
                }
            });
        }
    </script>

<?php include('user_masterpage/user_footer.php'); ?>