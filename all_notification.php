<?php
    header("Cache-Control: no-cache, no-store, must-revalidate"); 

    include('user_masterpage/user_dashboard_header.php');
    include('user_masterpage/user_sidebar.php');
    include('user_masterpage/user_navbar.php');

    // error_reporting(E_ALL);
    // ini_set('display_errors',1);

    // ==========================================
    // 1. SEARCH LOGIC
    // ==========================================
    $search_query = "";
    if (isset($_GET['search']) && !empty(trim($_GET['search']))) {
        $search = mysqli_real_escape_string($conn, trim($_GET['search']));
        $search_query = " WHERE (n.title LIKE '%$search%' OR n.message LIKE '%$search%' OR a.name LIKE '%$search%') ";
    }

    // ==========================================
    // 2. PAGINATION LOGIC
    // ==========================================
    $limit = 6; 
    $page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
    if ($page < 1) $page = 1;
    $offset = ($page - 1) * $limit;

    $total_query = "SELECT COUNT(*) as total FROM notification n LEFT JOIN admin_directory a ON n.sender_email = a.email" . $search_query;
    $total_result = mysqli_query($conn, $total_query);
    $total_row = mysqli_fetch_assoc($total_result);
    $total_records = $total_row['total'];
    $total_pages = ceil($total_records / $limit);
?>

    <style>
        .d-col-avatar img {
            width: 40px !important;
            height: 40px !important;
            border-radius: 50% !important;
            object-fit: cover !important;
            flex-shrink: 0 !important; /* यह इमेज को सिकुड़ने या टेढ़ा होने नहीं देगा */
        }

        /* Global Reset inside container */
        .noti-main-wrapper * {
            box-sizing: border-box !important;
        }

        /* 🌟 SUBHEADER AND SEARCH BAR FIXES 🌟 */
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
        .content-subheader__title {
            font-size: 22px !important;
            font-weight: 600 !important;
            color: #1e293b !important;
            margin: 0 !important;
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

        /* --- DESKTOP VIEW (PC Table Structure) --- */
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
            text-decoration: none !important;
            color: inherit !important;
        }
        .desktop-row:hover {
            background-color: #f9f9f9;
        }
        
        /* PC Column Widths */
        .d-col-sr     { flex: 0 0 5%;   text-align: center; }
        .d-col-avatar { flex: 0 0 8%;   text-align: center; display: flex; justify-content: center; }
        .d-col-name   { flex: 0 0 17%;  padding-left: 10px; text-align: left; font-weight: 600; color: #333; }
        .d-col-title  { flex: 0 0 20%;  padding-left: 10px; text-align: left; font-weight: 500; }
        .d-col-msg    { flex: 0 0 35%;  padding-left: 10px; text-align: left; color: #6c757d; }
        .d-col-date   { flex: 0 0 15%;  text-align: center; color: #868e96; }

        .truncate-txt {
            white-space: nowrap !important;
            overflow: hidden !important;
            text-overflow: ellipsis !important;
        }

        /* --- MOBILE VIEW --- */
        .mobile-cards-view {
            display: none; 
            width: 100%;
        }

        /* Responsive Media Query */
        @media (max-width: 768px) {
            .content-subheader {
                flex-direction: column !important;
                align-items: flex-start !important;
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
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08) !important; 
                border: 1px solid #edf2f9 !important;
                text-decoration: none !important;
                color: inherit !important;
                position: relative !important;
                width: 100% !important;
            }

            .card-top-bar {
                display: flex !important;
                justify-content: space-between !important;
                align-items: center !important;
                width: 100% !important;
                margin-top: 6px !important;
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
                width: 50px !important;
                height: 50px !important;
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

            .m-noti-msg {
                font-size: 13px !important;
                color: #64748b !important;
                line-height: 1.5 !important;
                white-space: normal !important;
                word-wrap: break-word !important;
                overflow-wrap: break-word !important;
            }

            .m-noti-date {
                font-size: 11px !important;
                color: #94a3b8 !important;
                font-weight: 500 !important;
                white-space: nowrap !important;
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
                    <h2 class="content-subheader__title">All Notifications</h2>
                </div>
                <div class="content-subheader__options">
                    <div class="content-subheader__search">
                        <form method="GET" action="all_notification.php">
                            <input type="text" name="search" class="subheader-search__input" placeholder="Search notification..." value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>" />
                            <input type="submit" class="subheader-search__submit" value="Search" />
                            <?php if(!empty($search_query) && isset($_GET['search']) && !empty(trim($_GET['search']))): ?>
                                <a href="all_notification.php" class="search-clear-btn">Clear</a>
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
                            <div class="d-col-avatar">SENDER</div>
                            <div class="d-col-name">NAME</div>
                            <div class="d-col-title">TITLE</div>
                            <div class="d-col-msg">MESSAGE</div>
                            <div class="d-col-date">SENT_AT</div>
                        </div>
                        
                        <div class="table__body">
                            <?php 
                                $query = "SELECT n.*, a.name AS sender_name, a.avatar AS sender_avatar 
                                          FROM notification n 
                                          LEFT JOIN admin_directory a ON n.sender_email = a.email 
                                          $search_query 
                                          ORDER BY n.id DESC 
                                          LIMIT $offset, $limit";

                                $fetchNotifications = mysqli_query($conn, $query);
                                $count = $offset + 1; 
                                
                                if(mysqli_num_rows($fetchNotifications) > 0) {
                                    while($row = mysqli_fetch_assoc($fetchNotifications)){
                                        $id           = $row['id'];
                                        $title         = $row['title'];
                                        $message       = $row['message'];
                                        $date          = $row['created_at'];
                                        
                                        $senderName   = !empty($row['sender_name']) ? $row['sender_name'] : "System / Unknown";
                                        $senderAvatar = !empty($row['sender_avatar']) ? $row['sender_avatar'] : "medikit/images/default-avatar.png";
                                ?>
                                <a href="read-notification.php?id=<?php echo $id; ?>" class="desktop-row">
                                    <div class="d-col-sr"><?php echo $count++; ?></div>
                                    <div class="d-col-avatar">
                                        <img src="<?php echo $senderAvatar; ?>" width="40" height="40" style="border-radius: 50%; object-fit: cover;" alt="avatar" />
                                    </div>
                                    <div class="d-col-name truncate-txt"><?php echo $senderName; ?></div>
                                    <div class="d-col-title truncate-txt"><?php echo (mb_strlen($title) > 25) ? mb_substr($title, 0, 25).'...' : $title; ?></div>
                                    <div class="d-col-msg truncate-txt"><?php echo (mb_strlen($message) > 40) ? mb_substr($message, 0, 40).'...' : $message; ?></div>
                                    <div class="d-col-date"><?php echo date('d M Y, h:i A', strtotime($date)); ?></div>
                                </a>
                            <?php 
                                    }
                                } else {
                                    echo '<div style="padding:30px; text-align:center; color:#999; font-size:14px;">No notifications found.</div>';
                                }
                            ?>
                        </div>
                    </div>

                    <div class="mobile-cards-view">
                        <?php 
                            if(mysqli_num_rows($fetchNotifications) > 0) {
                                mysqli_data_seek($fetchNotifications, 0); 
                                while($row = mysqli_fetch_assoc($fetchNotifications)){
                                    $id           = $row['id'];
                                    $title         = $row['title'];
                                    $message       = $row['message'];
                                    $date          = $row['created_at'];
                                    
                                    $senderName   = !empty($row['sender_name']) ? $row['sender_name'] : "System / Unknown";
                                    $senderAvatar = !empty($row['sender_avatar']) ? $row['sender_avatar'] : "medikit/images/default-avatar.png";
                            ?>
                            <a href="read-notification.php?id=<?php echo $id; ?>" class="noti-mobile-card">
                                <div class="card-main-content">
                                    <div class="card-avatar-box">
                                        <img src="<?php echo $senderAvatar; ?>" alt="sender photo" />
                                    </div>
                                    
                                    <div class="card-text-box">
                                        <div class="card-top-bar">
                                            <div class="m-sender-name"><?php echo (mb_strlen($senderName) > 25) ? mb_substr($senderName, 0, 25).'<br>' : $senderName; ?></div>
                                            <div class="m-noti-date"><?php echo date('d.m.y', strtotime($date)); ?></div>
                                        </div>
                                        
                                        <div class="m-noti-title truncate-txt"><?php echo (mb_strlen($title) > 18) ? mb_substr($title, 0, 18).'<br>' : $title; ?></div>
                                        
                                        <div class="m-noti-msg"> <?php echo $message; ?> </div>
                                    </div>
                                </div>
                            </a>
                        <?php 
                                }
                            } else {
                                echo '<div style="padding:20px; text-align:center; color:#999; font-size:14px;">No notifications found.</div>';
                            }
                        ?>
                    </div>

                </div>
            </div>

            <?php if($total_pages > 1): ?>
            <div class="grid grid--margin">
                <div class="grid__row">
                    <div class="grid__col grid__col--padding bg-white" style="border-radius:5px;">
                        <ul class="responsive-pagination" style="display: flex; list-style: none; gap: 5px; padding-left: 0;">
                            <?php
                                $search_param = isset($_GET['search']) ? "&search=" . urlencode($_GET['search']) : "";

                                if($page > 1) {
                                    echo '<li><a href="all_notification.php?page='.($page - 1).$search_param.'" style="padding: 8px 12px; border: 1px solid #ddd; text-decoration: none; color: #007bff; display: inline-block; border-radius: 4px;">PREV</a></li>';
                                }

                                for($i = 1; $i <= $total_pages; $i++) {
                                    $active_class = ($i == $page) ? 'style="padding: 8px 12px; border: 1px solid #007bff; background: #007bff; color: #fff; text-decoration: none; font-weight: bold; display: inline-block; border-radius: 4px;"' : 'style="padding: 8px 12px; border: 1px solid #ddd; text-decoration: none; color: #007bff; display: inline-block; border-radius: 4px;"';
                                    echo '<li><a href="all_notification.php?page='.$i.$search_param.'" '.$active_class.'>'.$i.'</a></li>';
                                }

                                if($page < $total_pages) {
                                    echo '<li><a href="all_notification.php?page='.($page + 1).$search_param.'" style="padding: 8px 12px; border: 1px solid #ddd; text-decoration: none; color: #007bff; display: inline-block; border-radius: 4px;">NEXT</a></li>';
                                }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>

    </div>

<?php include('user_masterpage/user_footer.php'); ?>