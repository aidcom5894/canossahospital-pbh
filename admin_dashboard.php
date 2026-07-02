<?php
	header("Cache-Control: no-cache, no-store, must-revalidate"); 
	header("Pragma: no-cache"); 
	header("Expires: 0"); 

	include('admin_masterpage/admin_header.php');
	include('admin_masterpage/admin_sidebar.php');
	include('admin_masterpage/admin_navbar.php');
?>

<?php
  $fetchActiveUser = mysqli_query($conn,"SELECT * FROM admin_directory WHERE email = '{$_SESSION['admin']}'");
  while($row = mysqli_fetch_assoc($fetchActiveUser)) {
      $Name = $row['name'];
      $Avatar = $row['avatar'];
  }
?>


	<div class="grid grid--margin">

		<div class="grid__row dashboard-intro">
			<div class="grid__col grid__col--margin grid__col--padding bg-white">
				<div class="grid__row">
					<div class="grid__col grid__col--margin grid__col--12">
						<div class="dashboard-intro__title">Good morning, <span><?php echo $Name; ?></span></div>
							<div class="dashboard-intro__subtitle">Here are your important tasks, updates and alerts. You can set your in app preferences here.</div>
					 </div>
					<div class="grid__col grid__col--12 d-flex justify-fe aligns-fs">
						<span class="show-more show-more--select show-more--select-gray has-dropdown" data-dropdown="moreoptions">Edit your options</span>
					</div>
					<nav class="dropdown-menu dropdown-menu--content" id="moreoptions"> 			
						<ul>
							<li><a href="admin_dashboard#">More Details</a></li>
							<li><a href="admin_dashboard#">View Report</a></li>
							<li><a href="admin_dashboard#">Edit Settings</a></li>
							<li><a href="admin_dashboard#">+ Add widget</a></li>
						</ul>
					</nav>
				</div>

				<div class="grid__row">

					<div class="grid__col grid__col--13 grid__col--margin grid__col--padding bg-gray10 mb0">
						<div class="grid__row justify-sb">
							<div class="grid__col grid__col--mb-12">
								<h3 class="grid__col-title">Important Tasks</h3>
								<span class="grid__col-subtitle">TODAY 24, JAN 2019</span>
							</div>
							<div class="grid__col grid__col--mb-12 d-flex justify-fe">
								<span class="show-more show-more--plus bg-white color-gray600 has-dropdown" data-dropdown="tasksdropdown">+</span>
							</div>
						</div>
						
						<nav class="dropdown-menu dropdown-menu--content" id="tasksdropdown"> 			
							<ul>
								<li><a href="admin_dashboard#">More Details</a></li>
								<li><a href="admin_dashboard#">View Activity</a></li>
								<li><a href="admin_dashboard#">Edit Settings</a></li>
								<li><a href="admin_dashboard#">+ Edit widget</a></li>
							</ul>
						</nav>
						<div class="d-flex align-c">
							<div class="info-nr info-nr--strong gradient-blue gradient-text">23</div>
							<div class="info-details">
								<p>3 URGENT</p>
								<p>16 LESS URGENT</p>
								<p>4 REQUIRED</p>
							</div>
						</div>
					</div>

					<div class="grid__col grid__col--13 grid__col--margin grid__col--padding bg-gray10 mb0">
						<div class="grid__row justify-sb">
							<div class="grid__col grid__col--mb-12">
								<h3 class="grid__col-title">New Patients</h3>
								<span class="grid__col-subtitle">REGISTERED IN JANUARY</span>
							</div>
							<div class="grid__col grid__col--mb-12 d-flex justify-fe">
								<span class="show-more show-more--plus bg-white color-gray600 has-dropdown" data-dropdown="newpatientsdropdown">+</span>
							</div>
						</div>
						<nav class="dropdown-menu dropdown-menu--content" id="newpatientsdropdown"> 			
							<ul>
								<li><a href="admin_dashboard#">More Details</a></li>
								<li><a href="admin_dashboard#">View Patients</a></li>
								<li><a href="admin_dashboard#">Edit Settings</a></li>
								<li><a href="admin_dashboard#">+ Edit widget</a></li>
							</ul>
						</nav>
						<div class="d-flex align-c">
							<div class="info-nr info-nr--strong gradient-lightblue gradient-text">15</div>
							<div class="info-details">
								<p>1 PREGNANCY</p>
								<p>10 DIABETIS</p>
								<p>14 KIDS</p>
							</div>
						</div>
					</div>

					<div class="grid__col grid__col--13 grid__col--margin grid__col--padding bg-gray10 mb0">
						<div class="grid__row justify-sb">
							<div class="grid__col grid__col--mb-12">
								<h3 class="grid__col-title">Alert</h3>
								<span class="grid__col-subtitle">LAST MONTH</span>
							</div>
							<div class="grid__col grid__col--mb-12 d-flex justify-fe">
								<span class="show-more show-more--plus bg-white color-gray600 has-dropdown" data-dropdown="alertdropdown">+</span>
							</div>
						</div>
						<nav class="dropdown-menu dropdown-menu--content" id="alertdropdown"> 			
							<ul>
								<li><a href="admin_dashboard#">More Details</a></li>
								<li><a href="admin_dashboard#">View Alerts</a></li>
								<li><a href="admin_dashboard#">Edit Settings</a></li>
								<li><a href="admin_dashboard#">+ Edit widget</a></li>
							</ul>
						</nav>
						<div class="d-flex align-c">
							<div class="info-nr info-nr--strong gradient-pink gradient-text">48</div>
							<div class="info-details">
								<p>New flue cases registered all over the states with potential longer number.</p>
							</div>
						</div>
				    </div>
				</div>

			</div>
		</div>

		<div class="grid__row">
			<div class="grid__col grid__col--16 grid__col--mb-12 grid__col--margin grid__col--padding gradient-blue widget-icon selected">
				<span class="widget-icon__badge">3 NEW</span>
				<img src="medikit/images/icons/icons-64-white/chat.png" alt="" title=""/>
				<h5>Active Conversations</h5>
			</div>

			<div class="grid__col grid__col--16 grid__col--mb-12 grid__col--margin grid__col--padding gradient-lightblue widget-icon selected">
				<span class="widget-icon__badge">14 NEW</span>
				<img src="medikit/images/icons/icons-64-white/laboratory.png" alt="" title=""/>
				<h5>Laboratory Results</h5>
			</div>

			<div class="grid__col grid__col--16 grid__col--mb-12 grid__col--margin grid__col--padding gradient-pink widget-icon selected">
				<span class="widget-icon__badge">2 NEW</span>
				<img src="medikit/images/icons/icons-64-white/calendar.png" alt="" title=""/>
				<h5>New Events</h5>
			</div>

			<div class="grid__col grid__col--16 grid__col--mb-12 grid__col--margin grid__col--padding bg-white widget-icon">
				<img src="medikit/images/icons/icons-64-blue/users.png" alt="" title=""/>
				<h5>Important Patients</h5>
			</div>

			<div class="grid__col grid__col--16 grid__col--mb-12 grid__col--margin grid__col--padding bg-white widget-icon">
				<img src="medikit/images/icons/icons-64-blue/reports.png" alt="" title=""/>
				<h5>Reports Archive</h5>
			</div>

			<div class="grid__col grid__col--16 grid__col--mb-12 grid__col--margin grid__col--padding bg-white widget-icon">
				<img src="medikit/images/icons/icons-64-blue/payments.png" alt="" title=""/>
				<h5>Payments</h5>
			</div>

		</div>

			
		<div class="grid__row">
			<div class="grid__col grid__col--13 grid__col--margin grid__col--padding bg-white mb0">
				<div class="grid__row justify-sb">
					<div class="grid__col grid__col--mb-12">
						<h3 class="grid__col-title">Calendar</h3>
						<span class="grid__col-subtitle">EVENTS BY MONTH</span>
					</div>

				</div>

				<div id="taskscalendar"></div>
			</div>
			

		</div>								

	</div>




<?php include('admin_masterpage/admin_footer.php'); ?>																																							