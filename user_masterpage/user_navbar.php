<?php
    // Session start zaroori hai agar aap $_SESSION use kar rahe hain
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    include('config.php');
    date_default_timezone_set('Asia/Kolkata');

    // TimeAgo function ko ek hi baar declare karne ke liye safe check
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

    // 1. Total Notification Count Logic
    $countQuery = mysqli_query($conn, "SELECT COUNT(*) as total FROM notification");
    $countRow = mysqli_fetch_assoc($countQuery);
    $totalNotification = $countRow['total'] ?? 0;
?>

<main class="dashboard-main">
  <div class="navbar-header">
      <div class="row align-items-center justify-content-between">
        <div class="col-auto">
          <div class="d-flex flex-wrap align-items-center gap-4">
            <button type="button" class="sidebar-toggle">
              <iconify-icon icon="heroicons:bars-3-solid" class="icon text-2xl non-active"></iconify-icon>
              <iconify-icon icon="iconoir:arrow-right" class="icon text-2xl active"></iconify-icon>
            </button>
            <button type="button" class="sidebar-mobile-toggle">
              <iconify-icon icon="heroicons:bars-3-solid" class="icon"></iconify-icon>
            </button>
          </div>
        </div>

        <div class="col-auto">
          <div class="d-flex flex-wrap align-items-center gap-3">
            <button type="button" data-theme-toggle class="w-40-px h-40-px bg-neutral-200 rounded-circle d-flex justify-content-center align-items-center"></button>

            <!-- ==== START Notification dropdown ====== --> 
            <div class="dropdown">
              <button class="has-indicator w-40-px h-40-px bg-neutral-200 rounded-circle d-flex justify-content-center align-items-center" type="button" data-bs-toggle="dropdown">
                <iconify-icon icon="iconoir:bell" class="text-primary-light text-xl"></iconify-icon>

                <!-- 🔴 Badge (only if notification > 0) -->
                <?php if($totalNotification >= 1): ?>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-success">
                        <?= $totalNotification > 99 ? '99+' : $totalNotification ?>
                    </span>
                <?php endif; ?>
              </button>
              
              <div class="dropdown-menu to-top dropdown-menu-lg p-0">
                <div class="m-16 py-12 px-16 radius-8 bg-primary-50 mb-16 d-flex align-items-center justify-content-between gap-2">
                  <div>
                    <h6 class="text-lg text-primary-light fw-semibold mb-0">Notifications</h6>
                  </div>
                  <?php if($totalNotification >= 1): ?>
                    <span class="text-primary-600 fw-semibold text-lg w-40-px h-40-px rounded-circle bg-base d-flex justify-content-center align-items-center"><?= $totalNotification ?></span>
                  <?php endif; ?>
                </div>

                <!-- ===== Notification List ===== -->
                <div class="max-h-400-px overflow-y-auto scroll-sm pe-4">
                    <?php 
                    if($totalNotification > 0) { 
                        // Pagination variables (Define agar config me nahi hain to, default values lagayi hain)
                        $limit = isset($limit) ? $limit : 5;
                        $offset = isset($offset) ? $offset : 0;
                        $search_query = isset($search_query) ? $search_query : "";

                        $query = "SELECT n.*, a.name AS sender_name, a.avatar AS sender_avatar 
                                  FROM notification n 
                                  LEFT JOIN admin_directory a ON n.sender_email = a.email 
                                  $search_query 
                                  ORDER BY n.id DESC 
                                  LIMIT $offset, $limit";

                        // Query execute karna zaroori tha
                        $notificationResult = mysqli_query($conn, $query);

                        while($row = mysqli_fetch_assoc($notificationResult)) {
                            // Short Titles Logic
                            $shortTitle = (mb_strlen($row['title']) > 15) ? mb_substr($row['title'], 0, 15).'...' : $row['title'];

                              $Subtitle = (mb_strlen($row['message']) > 15) ? mb_substr($row['message'], 0, 15).'...' : $row['message'];
                            
                            // Sender Avatar fallback logic
                            $senderImage = (!empty($row['sender_avatar'])) ? $row['sender_avatar'] : "medikit/images/default-avatar.png";
                    ?>
                      
                        <a href="read-notification?id=<?= $row['id']; ?>" class="px-24 py-12 d-flex align-items-start justify-content-between gap-3 border-bottom">
                            <!-- 🔹 LEFT SIDE -->
                            <div class="d-flex align-items-center gap-3 flex-grow-1">
                                <img src="<?= htmlspecialchars($senderImage); ?>" alt="profile" class="w-50-px h-50-px rounded flex-shrink-0">
                                <div>
                                    <h6 class="text-md fw-semibold mb-1"><?= htmlspecialchars($shortTitle); ?></h6>
                                    <p class="mb-0 text-sm text-secondary-light"><?= htmlspecialchars($Subtitle); ?></p>
                                </div>
                            </div>
                            <!-- 🔹 RIGHT SIDE -->
                            <span class="text-sm text-secondary-light text-end flex-shrink-0">
                                <?= timeAgo($row['created_at']); ?>
                            </span>
                        </a>

                    <?php 
                        } // While loop ends
                    } else { 
                    ?>
                        <p class="text-center text-secondary py-4">No Notification Found</p>
                    <?php } ?>
                </div>

                <!-- ===== Footer ===== -->
                <?php if($totalNotification > 5): ?>
                    <div class="text-center py-12 px-16">
                        <a href="all_notification" class="text-primary-600 fw-semibold text-md">See All Notifications</a>
                    </div>
                <?php endif; ?>
              </div>
            </div><!-- Notification dropdown end -->

            <!-- ==== START Profile dropdown ====== --> 
            <div class="dropdown">
                <?php
                    $current_user = $_SESSION['user'] ?? '';
                    $Name = "User"; // Default Name
                    $Avatar = "medikit/images/default-avatar.png"; // Default Avatar

                    if(!empty($current_user)) {
                        $fetchActiveUser = mysqli_query($conn, "SELECT * FROM user_directory WHERE email = '" . mysqli_real_escape_string($conn, $current_user) . "'");
                        if($userRow = mysqli_fetch_assoc($fetchActiveUser)) {
                            $Name = $userRow['name'];
                            $Avatar = !empty($userRow['avatar']) ? $userRow['avatar'] : $Avatar;
                        }
                    }
                ?>

              <button class="d-flex justify-content-center align-items-center rounded-circle" type="button" data-bs-toggle="dropdown">
                <img src="<?= htmlspecialchars($Avatar); ?>" alt="image" class="w-40-px h-40-px object-fit-cover rounded-circle">
              </button>
              
              <div class="dropdown-menu to-top dropdown-menu-sm">
                <div class="py-12 px-16 radius-8 bg-primary-50 mb-16 d-flex align-items-center justify-content-between gap-2">
                  <div>
                    <h6 class="text-lg text-primary-light fw-semibold mb-2"><?= htmlspecialchars($Name); ?></h6>
                    <span class="text-secondary-light fw-medium text-sm">Admin</span>
                  </div>
                  <button type="button" class="hover-text-danger">
                    <iconify-icon icon="radix-icons:cross-1" class="icon text-xl"></iconify-icon>
                  </button>
                </div>
                <ul class="to-top-list">
                  <li>
                    <a class="dropdown-item text-black px-0 py-8 hover-bg-transparent hover-text-primary d-flex align-items-center gap-3" href="profile">
                      <iconify-icon icon="solar:user-linear" class="icon text-xl"></iconify-icon> My Profile
                    </a>
                  </li>
                  <li>
                    <a class="dropdown-item text-black px-0 py-8 hover-bg-transparent hover-text-primary d-flex align-items-center gap-3" href="all_notification">
                      <iconify-icon icon="tabler:message-check" class="icon text-xl"></iconify-icon> Inbox
                    </a>
                  </li>
                  <li>
                    <a class="dropdown-item text-black px-0 py-8 hover-bg-transparent hover-text-danger d-flex align-items-center gap-3" href="logout">
                      <iconify-icon icon="lucide:power" class="icon text-xl"></iconify-icon> Log Out
                    </a>
                  </li>
                </ul>
              </div>
            </div><!-- Profile dropdown end -->

          </div>
        </div>
      </div>
  </div>
