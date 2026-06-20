
		<!-- Content -->
			<div class="section section--content" id="content">
				<header class="content-header">
				
						<div class="sidebar-resize"></div>
						<div class="mobile-menu"><div class="st-burger-icon st-burger-icon--medium"><span></span></div></div>
						
						<div class="content-header__user content-header__dropdown">  
						    <div class="content-header__user-avatar content-header__dropdown-activate" data-dropdown="userdropdown">
					    	    <?php
  						            $current_user = $_SESSION['admin'] ?? '';
							            $fetchActiveUser = mysqli_query($conn, "SELECT * FROM admin_directory WHERE email = '{$current_user}'");
                            while($row = mysqli_fetch_assoc($fetchActiveUser))
                            {
                                $Name = $row['name'];
                                $Avatar = $row['avatar'];
                            }

                     ?>

								<div class="content-header__user-thumb" style="width: 45px; height: 45px; border-radius: 50%; overflow: hidden; display: flex; align-items: center; justify-content: center; border: 1px solid #ddd;">

					                <img src="<?php echo $Avatar; ?>" alt="Profile" />

					            </div>
										<span class="content-header__user-name "><?php echo $Name; ?></span>
							  </div>  
									<nav class="dropdown-menu dropdown-menu--header dropdown-menu--user-menu " id="userdropdown" > 	
									<h3 class="dropdown-menu__subtitle" >Admin menu</h3>
									<ul>   
									    <li><a href="admin_profile.php">My profile</a></li>
									    <li><a href="admin_dashboard.php#">Activity</a></li>
									    <li><a href="admin_sign-in.php#">Switch account</a></li>
									    <li><a href="admin_dashboard.php#">Support</a></li>
									    <li class="logout"><a href="admin_logout.php" class="button button--general button--red-border">Logout</a></li>
									</ul>
								</nav>
						</div>
							
						<?php
							$result = mysqli_query($conn,"SELECT * FROM notification");
							while($row = mysqli_fetch_assoc($result)){
							    $Title = $row['title'];
							    $Message = $row['message'];
							    $Time = $row['created_at'];
							}

							$countQuery = mysqli_query($conn,"SELECT COUNT(*) as total FROM notification");
							$countRow = mysqli_fetch_assoc($countQuery);

							$totalNotification = $countRow['total'];

						?>                                    

                        <?php
                             $Email = $_SESSION['email'] ?? 0;

                              $fetchActiveUser = mysqli_query($conn,"SELECT * FROM user_directory WHERE email = 'Email'");
                              while($row = mysqli_fetch_assoc($fetchActiveUser))
                              {
                                  $Name = $row['name'];
                                  $Avatar = $row['avatar'];
                              }
                        ?>


						
						<div class="content-header__notifications content-header__dropdown">  
						    <div class="content-header__notifications-icon content-header__icon content-header__dropdown-activate" data-dropdown="notificationsdropdown">
									<img src="medikit/images/icons/icons-24-gray/notifications.png" alt="" title=""/>
									<span class="content-header__icon-bubble">2</span>
							  </div>  

								<nav class="dropdown-menu dropdown-menu--header dropdown-menu--notifications-menu" id="notificationsdropdown"> 			
									<h3 class="dropdown-menu__subtitle">You have <strong>6</strong> notifications</h3>
									<ul>    
											<li class="d-flex justify-sb"><span class="important">IMPORTANT</span>Michael D. kidney surgery <b class="task-time">today</b></li>
											<li class="d-flex justify-sb"><span class="important">IMPORTANT</span>FLU Alert report generated <b class="task-time">today</b></li>
											
											<li class="view-all"><a href="#" class="button button--general button--blue-border">View all</a></li>
									</ul>
								</nav>
						</div>
						

					
				</header>

