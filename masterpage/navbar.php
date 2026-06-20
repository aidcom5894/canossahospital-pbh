<!-- Content Header -->
<div class="section section--content" id="content">
    <header class="content-header">
        <div class="sidebar-resize"></div>
        <div class="mobile-menu">
            <div class="st-burger-icon st-burger-icon--medium"><span></span></div>
        </div>
        
        <!-- User Dropdown -->
        <div class="content-header__user content-header__dropdown">  
            <div class="content-header__user-avatar content-header__dropdown-activate" data-dropdown="userdropdown">
                <?php
                    $current_user = $_SESSION['user'] ?? '';
                    $fetchActiveUser = mysqli_query($conn, "SELECT * FROM user_directory WHERE email = '{$current_user}'");
                    $Name = "User"; // Default
                    $Avatar = "medikit/images/default-avatar.png"; // Default
                    if($row = mysqli_fetch_assoc($fetchActiveUser)) {
                        $Name = $row['name'];
                        $Avatar = $row['avatar'];
                    }
                ?>
                <div class="content-header__user-thumb" style="width: 40px; height: 40px; border-radius: 50%; overflow: hidden; display: flex; align-items: center; justify-content: center; border: 1px solid #ddd;">
                    
                    <img src="<?php echo $Avatar; ?>" alt="Profile" style="width: 100%; height: 100%; object-fit: cover; display: block;" />
                </div>
                    <span class="content-header__user-name"><?php echo $Name; ?></span>
            </div>  
            <nav class="dropdown-menu dropdown-menu--header dropdown-menu--user-menu" id="userdropdown">    
                <h3 class="dropdown-menu__subtitle">User menu</h3>
                <ul>   
                    <li><a href="profile.php">My profile</a></li>
                    <li><a href="all_notification.php">Messages</a></li>
                    <li><a href="sign-in.php">Switch Account</a></li>
                    <li class="logout"><a href="logout.php" class="button button--general button--red-border">Logout</a></li>
                </ul>
            </nav>
        </div>

        <?php
            // Notification Logic
            $countQuery = mysqli_query($conn, "SELECT COUNT(*) as total FROM notification");
            $countRow = mysqli_fetch_assoc($countQuery);
            $totalNotification = $countRow['total'] ?? 0;

            date_default_timezone_set('Asia/Kolkata');

            if (!function_exists('timeAgo')) {
                function timeAgo($datetime) {
                    $timestamp = strtotime($datetime);
                    if (!$timestamp) return "invalid time";
                    $diff = time() - $timestamp;
                    if ($diff < 60) return $diff . " sec ago";
                    if ($diff < 3600) return floor($diff / 60) . " min ago";
                    if ($diff < 86400) return floor($diff / 3600) . " hr ago";
                    if ($diff < 604800) return floor($diff / 86400) . " day ago";
                    return date('d M', $timestamp);
                }
            }
        ?>

        <!-- Notifications Dropdown -->
        <div class="content-header__notifications content-header__dropdown">  
            <div class="content-header__notifications-icon content-header__icon content-header__dropdown-activate" data-dropdown="notificationsdropdown">
                <img src="medikit/images/icons/icons-24-gray/notifications.png" alt="Notifications" />
                <?php if($totalNotification >= 1): ?>
                    <span class="content-header__icon-bubble"><?= $totalNotification; ?></span>
                <?php endif; ?>
            </div>  

            <nav class="dropdown-menu dropdown-menu--header dropdown-menu--notifications-menu" id="notificationsdropdown">
                <h3 class="dropdown-menu__subtitle">You have <strong><?= $totalNotification; ?></strong> notifications</h3>
                <ul>
                    <?php
                        // Limit dropdown to 5 items for better UI
                        $result = mysqli_query($conn, "SELECT * FROM notification ORDER BY id DESC LIMIT 5");
                        if(mysqli_num_rows($result) > 0) {
                            while($row = mysqli_fetch_assoc($result)) {
                                $noti_id = $row['id'];
                                $shortTitle = (mb_strlen($row['title']) > 15) ? mb_substr($row['title'], 0, 15).'...' : $row['title'];
                                $Subtitle = (mb_strlen($row['message']) > 20) ? mb_substr($row['message'], 0, 20).'...' : $row['message'];
                    ?>
                        <li>
                            <a href="read-notification.php?id=<?= $noti_id; ?>" class="d-flex justify-sb" style="display: flex !important; justify-content: space-between; align-items: center; color: #333; padding: 10px 0;">
                                <div style="display: flex; flex-direction: column;">
                                    <span style="font-size: 12px; font-weight: 600;"><?= $shortTitle; ?></span>
                                    <span style="font-size: 11px; color: #777;"><?= $Subtitle; ?></span>
                                </div>
                                <small style="color: #2196f3; font-size: 10px; white-space: nowrap;"><?= timeAgo($row['created_at'].'UTC'); ?></small>
                            </a>
                        </li>
                    <?php 
                            }
                        } else {
                            echo "<li style='padding:15px; text-align:center; font-size:12px; color:#999;'>No notifications</li>";
                        }
                    ?>

                    <?php if($totalNotification > 5): ?>
                        <li class="view-all" style="text-align: center; padding-top: 10px;">
                            <a href="all_notification.php" class="button button--general button--blue-border" >View all </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
                      
    </header>
    <style>
        .dropdown-menu--notifications-menu ul {
                max-height: 280px;
                overflow-y: auto !important;   
                overflow-x: hidden !important; 
                padding: 10px;
            }
            .dropdown-menu--notifications-menu ul li {
                list-style: none;
            }
            .dropdown-menu--notifications-menu ul::-webkit-scrollbar {
                width: 4px;
            }
            .dropdown-menu--notifications-menu ul::-webkit-scrollbar-thumb {
                background: #ccc;
                border-radius: 10px;
            }

        /* प्रोफाइल के अंदर यूजर का नाम */
        .content-header__user-name {
            font-size: 1.3rem !important;
            font-weight: 500 !important;
            color: #303544 !important;
            padding: 0 20px 0 10px !important;
            background: url(../images/drop-down.png) no-repeat right center !important;
        }


        /* यूजर वाले ड्रॉपडाउन की चौड़ाई */
        .dropdown-menu--header.dropdown-menu--user-menu { 
            width: 190px !important; 
            right: 0 !important; 
            border-radius: 0px !important;

        }

        /* नोटिफिकेशन वाले ड्रॉपडाउन की चौड़ाई */
        .dropdown-menu--header.dropdown-menu--notifications-menu { 
            width: 400px !important; 
            right: -20px !important; 
            border-radius: 0px !important;

        }


        /* --- 4. DROPDOWN CONTENTS (TEXT, LINKS & LISTS) --- */
        .dropdown-menu__subtitle {
            color: #b2b5c0 !important;
            font-size: 1.5rem !important;
            padding: 0 0 10px 0 !important;
            margin: 0 0 10px 0 !important;
            font-weight: 500 !important;
            border-bottom: 1px #e5e7ee solid !important;
        }
        @media (max-width: 767px) {
            .content-header__user-thumb{
                width: 30px !important;
                height: 30px !important;
            }
        }

    </style>

