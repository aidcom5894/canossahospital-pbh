<?php
  header("Cache-Control: no-cache, no-store, must-revalidate"); 
  header("Pragma: no-cache"); 
  header("Expires: 0"); 
  

  include('user_masterpage/user_dashboard_header.php');
  include('user_masterpage/user_sidebar.php');
  include('user_masterpage/user_navbar.php');

?>


    <?php
      // Total users count
      $countQuery = mysqli_query($conn, "SELECT COUNT(*) AS total FROM user_directory");
      $countRow = mysqli_fetch_assoc($countQuery);
      $totalUsers = $countRow['total'] ?? 0;
    ?>

    
  <div class="dashboard-main-body">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
      <h6 class="fw-semibold mb-0">Dashboard</h6>
      <ul class="d-flex align-items-center gap-2">
        <li class="fw-medium">
          <a href="user_dashboard.php" class="d-flex align-items-center gap-1 hover-text-primary">
            Dashboard
          </a>
        </li>
        <li>-</li>
        <li class="fw-medium"> Canossa Hospital</li>
      </ul>
    </div>

    <div class="row row-cols-xxxl-5 row-cols-lg-3 row-cols-sm-2 row-cols-1 gy-4">


      <div class="col">
          <div class="card shadow-none border bg-gradient-start-1 h-100">
              <div class="card-body p-20">

                  <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                      <div>

                          <?php if($totalUsers = 2): ?>
                              <p class="fw-medium text-primary-light mb-1">First Admin</p>

                          <?php else: ?>
                              <p class="fw-medium text-primary-light mb-1">Account Limit Full</p>
                          <?php endif; ?>

                      </div>

                      <div class="w-50-px h-50-px bg-cyan rounded-circle d-flex justify-content-center align-items-center">
                          <iconify-icon icon="gridicons:multiple-users" class="text-white text-2xl mb-0"></iconify-icon>
                      </div>
                  </div>

                  <p class="fw-medium text-sm text-primary-light mt-12 mb-0 d-flex align-items-center gap-2">
                      <span class="d-inline-flex align-items-center gap-1 text-success-main">
                          <iconify-icon icon="bxs:up-arrow" class="text-xs"></iconify-icon>
                      </span>

                      <?php
                      if($totalUsers = 2){
                          echo "1 Admin can also sign up";

                      } else {
                          echo "2 Admins Registered";
                      }
                      ?>
                  </p>

              </div>
          </div>
      </div>

      <div class="col">
        <div class="card shadow-none border bg-gradient-start-2 h-100">
          <div class="card-body p-20">
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
              <div>
                <p class="fw-medium text-primary-light mb-1">Total Subscription</p>
                <h6 class="mb-0"> </h6>
              </div>
              <div class="w-50-px h-50-px bg-purple rounded-circle d-flex justify-content-center align-items-center">
                <iconify-icon icon="fa-solid:award" class="text-white text-2xl mb-0"></iconify-icon>
              </div>
            </div>
            <p class="fw-medium text-sm text-primary-light mt-12 mb-0 d-flex align-items-center gap-2">
              <span class="d-inline-flex align-items-center gap-1 text-danger-main"><iconify-icon icon="bxs:down-arrow" class="text-xs"></iconify-icon> </span> 
              Last 30 days subscription
            </p>
          </div>
        </div><!-- card end -->
      </div>

      <div class="col">
        <div class="card shadow-none border bg-gradient-start-3 h-100">
          <div class="card-body p-20">
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
              <div>
                <p class="fw-medium text-primary-light mb-1">Total Free Users</p>
                <h6 class="mb-0"> </h6>
              </div>
              <div class="w-50-px h-50-px bg-info rounded-circle d-flex justify-content-center align-items-center">
                <iconify-icon icon="fluent:people-20-filled" class="text-white text-2xl mb-0"></iconify-icon>
              </div>
            </div>
            <p class="fw-medium text-sm text-primary-light mt-12 mb-0 d-flex align-items-center gap-2">
              <span class="d-inline-flex align-items-center gap-1 text-success-main"><iconify-icon icon="bxs:up-arrow" class="text-xs"></iconify-icon></span> 
              Last 30 days users
            </p>
          </div>
        </div><!-- card end -->
      </div>

      <div class="col">
        <div class="card shadow-none border bg-gradient-start-4 h-100">
          <div class="card-body p-20">
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
              <div>
                <p class="fw-medium text-primary-light mb-1"> Upcoming</p>
                <h6 class="mb-0"> Feature</h6>
              </div>
              <div class="w-50-px h-50-px bg-success-main rounded-circle d-flex justify-content-center align-items-center">
                <iconify-icon icon="material-symbols:nfc" class="text-white text-2xl"></iconify-icon>
              </div>
            </div>
            <p class="fw-medium text-sm text-primary-light mt-12 mb-0 d-flex align-items-center gap-2">
              <span class="d-inline-flex align-items-center gap-1 text-success-main"><iconify-icon icon="bxs:up-arrow" class="text-xs"></iconify-icon> NFC</span> 
              Available V-Cards
            </p>
          </div>
        </div><!-- card end -->
      </div>
      
      <div class="col">
        <div class="card shadow-none border bg-gradient-start-5 h-100">
          <div class="card-body p-20">
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
              <div>
                <p class="fw-medium text-primary-light mb-1">Aidcom BizCard</p>
                <h6 class="mb-0">Version-1</h6>
              </div>
              <div class="w-50-px h-50-px bg-red rounded-circle d-flex justify-content-center align-items-center">
                <span class="text-info">V-1</span>
              </div>
            </div>
            <p class="fw-medium text-sm text-primary-light mt-12 mb-0 d-flex align-items-center gap-2">
              <span class="d-inline-flex align-items-center gap-1 text-success-main"><iconify-icon icon="bxs:up-arrow" class="text-xs"></iconify-icon> </span> 
              This is Aidcom BizCard:1.0
            </p>
          </div>
        </div><!-- card end -->
      </div>
    </div>


  </div>



  <?php   include('user_masterpage/user_footer.php'); ?>