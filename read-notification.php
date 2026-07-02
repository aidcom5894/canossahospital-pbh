<?php
    header("Cache-Control: no-cache, no-store, must-revalidate"); 

    include('user_masterpage/user_dashboard_header.php');
    include('user_masterpage/user_sidebar.php');
    include('user_masterpage/user_navbar.php');

    // error_reporting(E_ALL);
    // ini_set('display_errors',1);

    // ==========================================
    // 1. VALIDATE NOTIFICATION ID
    // ==========================================
    if (!isset($_GET['id']) || empty(trim($_GET['id'])) || !is_numeric($_GET['id'])) {
        echo "<script>window.location.href='all_notification';</script>";
        exit;
    }

    $notification_id = (int)$_GET['id'];

    // ==========================================
    // 2. FETCH NOTIFICATION & SENDER DETAILS
    // ==========================================
    $query = "SELECT n.*, a.name AS sender_name, a.avatar AS sender_avatar 
              FROM notification n 
              LEFT JOIN admin_directory a ON n.sender_email = a.email 
              WHERE n.id = $notification_id";

    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 0) {
        echo "<div style='padding: 40px; text-align: center; color: red; font-weight: bold;'>Notification not found or already read! <a href='all_notification'>Go Back</a></div>";
        include('user_masterpage/user_footer');
        exit;
    }

    $row = mysqli_fetch_assoc($result);
    $title        = $row['title'];
    $message      = $row['message'];
    $date          = $row['created_at'];
    $senderName   = !empty($row['sender_name']) ? $row['sender_name'] : "System / Unknown";
    $senderAvatar = !empty($row['sender_avatar']) ? $row['sender_avatar'] : "medikit/images/default-avatar.png";

    // ==========================================
    // 3. AUTOMATIC DELETE LOGIC
    // ==========================================
    $delete_query = "DELETE FROM notification WHERE id = $notification_id";
    mysqli_query($conn, $delete_query);
?>

    <style>
        .read-noti-wrapper * {
            box-sizing: border-box !important;
        }
        
        /* Subheader Layout Fix */
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
        
        /* Custom Button Style */
        .custom-back-btn {
            background-color: #3b82f6 !important;
            color: #ffffff !important;
            padding: 10px 18px !important;
            font-size: 14px !important;
            font-weight: 500 !important;
            text-decoration: none !important;
            border-radius: 6px !important;
            display: inline-flex !important;
            align-items: center !important;
            gap: 6px !important;
            transition: background 0.2s !important;
            box-shadow: 0 2px 4px rgba(59, 130, 246, 0.2) !important;
        }
        .custom-back-btn:hover {
            background-color: #2563eb !important;
            color: #ffffff !important;
        }

        /* Avatar Container Fixes */
        .sender-info-box {
            display: flex !important;
            align-items: center !important;
            gap: 15px !important;
        }
        .sender-info-box img {
            width: 55px !important;
            height: 55px !important;
            border-radius: 50% !important;
            object-fit: cover !important;
            flex-shrink: 0 !important;
        }

        /* 📱 RESPONSIVE MEDIA QUERY - FIXED FOR RIGHT ALIGNMENT */
        @media (max-width: 768px) {
            .content-subheader {
                flex-direction: column !important;
                align-items: flex-start !important;
                gap: 10px !important;
            }
            .custom-back-btn {
                width: 100% !important;
                justify-content: center !important;
            }
            .meta-top-bar {
                flex-direction: row !important; /* Mobile me bhi side-by-side rakhega */
                justify-content: space-between !important;
                align-items: flex-start !important;
                width: 100% !important;
            }
            .sender-info-box {
                flex: 1 !important;
            }
            .meta-date-box {
                text-align: right !important; /* Mobile me right side hi rakhega */
                font-size: 11px !important; /* Choti screen ke liye size thoda set kiya */
                white-space: nowrap !important;
            }
        }

        .m-noti-msg{
            font-size:13px;
            color:#64748b;
            line-height:1.5;

            white-space:normal !important;
            word-wrap:break-word !important;
            overflow-wrap:break-word !important;
        }

    </style>

<div class="read-noti-wrapper" style="padding: 10px 20px;">
    
    <div class="content-subheader">
        <div class="content-subheader__titles">
            <h2 class="content-subheader__title">Notification Details (Read & Removed)</h2>
        </div>
        <div class="content-subheader__options">
            <a href="all_notification" class="custom-back-btn">
                ← Back to All Notifications
            </a>
        </div>
    </div>

    <div class="grid__row">
        <div class="grid__col grid__col--padding bg-white" style="padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
            
            <div class="meta-top-bar" style="display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid #edf2f9; padding-bottom: 20px; margin-bottom: 25px;">
                <div class="sender-info-box">
                    <img src="<?php echo $senderAvatar; ?>" alt="sender avatar" style="border: 2px solid #3b82f6; box-shadow: 0 2px 5px rgba(0,0,0,0.1);" />
                    
                    <div style="display:flex; flex-direction: column; gap: 4px;">
                        <span style="margin: 0; font-size: 16px; font-weight: 600; color: #333;"><?php echo $senderName; ?></span>
                        <span style="font-size: 12px; color: #dc3545; font-weight: 500;">Opened (Will be cleared)</span>
                    </div>
                </div>
                
                <div class="meta-date-box" style="text-align: right; color: #868e96; font-size: 13px; font-weight: 500; line-height: 1.4;">
                    <div><strong>Sent On:</strong></div>
                    <div style="color: #475569; font-weight: 600; margin-top: 2px;"><?php echo date('d M Y', strtotime($date)); ?></div>
                    <div style="color: #64748b;"><?php echo date('h:i A', strtotime($date)); ?></div>
                </div>
            </div>

            <div class="notification-body-wrapper">
                
                <h1  class="m-noti-msg" style="font-size: 22px; font-weight: 700; color: #1e293b; margin-bottom: 20px; line-height: 1.4;">
                    <?php echo (mb_strlen($title) > 25) ? mb_substr($title, 0, 25).'...' : $title; ?>
                </h1>
                
                <div  class="m-noti-msg" style="background-color: #f8f9fa; border-left: 4px solid #dc3545; padding: 20px; border-radius: 0 8px 8px 0; min-height: 150px; line-height: 1.6; color: #334155; font-size: 16px; white-space: pre-line; font-family: sans-serif !important;">
                    <?php echo htmlspecialchars($message); ?>
                </div>
                
            </div>

            <div style="margin-top: 30px; border-top: 1px solid #edf2f9; padding-top: 20px; display: flex; justify-content: flex-end;">
                <a href="all_notification" style="color: #3b82f6; text-decoration: none; font-size: 14px; font-weight: 600; transition: color 0.2s;" onmouseover="this.style.color='#1d4ed8'" onmouseout="this.style.color='#3b82f6'">
                    Close & Return →
                </a>
            </div>

        </div>
    </div>
</div>

<?php include('user_masterpage/user_footer.php'); ?>