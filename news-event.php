<?php include ('config.php'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="html 5 template, cleaning service template, cleaning template, cleaning company template">
	<meta name="author" content="">
	<meta name="format-detection" content="telephone=no">
	<link rel="icon" href="medera/images/cfavicon.png">
	<title>Canossa Hopital Partapgarh</title>
	<!-- Vendors -->
	<link href="proclena/css/vendor/bootstrap.min.css" rel="stylesheet">
	<link href="proclena/css/vendor/animate.min.css" rel="stylesheet">
	<link href="proclena/css/vendor/slick.css" rel="stylesheet">
	<link href="proclena/css/vendor/lightbox.css" rel="stylesheet">
	<link href="proclena/css/vendor/bootstrap-datetimepicker.css" rel="stylesheet">
	<link href="proclena/css/vendor/nouislider.css" rel="stylesheet">	<!-- Template Style -->
	<link href="proclena/css/custom.css" rel="stylesheet">
	<link href="proclena/color/color.css" rel="stylesheet">
	<!-- Icon Font-->
	<link href="proclena/fonts/icomoon/style.css" rel="stylesheet">
	<!-- Google Fonts -->
	<link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,900" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i" rel="stylesheet">
</head>

<body>

<!-- Header -->
<header class="page-header page-header--style2 header-sticky">
    <div class="page-header-top">
        <div class="container">
            
            <!-- 1. Brand Logo Area -->
            <div class="logo">
                <a href="https://canossahospitalpbh.in/">
                    <img src="medera/images/cfavicon.png" style="height: 50px; width: 210px;">
                </a>
                <div class="shine"></div>
            </div>

            <!-- 2. Clean Single Navigation Menu -->
            <div class="page-header-menu">
                <div class="container">
                    <ul class="menu">
                        <li><a href="<?php echo $base_url; ?>">HOME<span class="arrow"></span></a></li>

                        <li class="active"><a href="#">About Us<span class="arrow"></span></a>
                            <ul class="sub-menu">
                                <li><a href="about_us.php">ABOUT US</a></li>
                                <li><a href="gallery.php">GALLERY</a></li>
                                <li><a href="news-event.php">NEWS & EVENT</a></li>
                                <li><a href="index.php#facilities">Facilities</a></li>
                                <li><a href="about_us.php#message">Message</a></li>
                            </ul>
                        </li>
                        <li><a href="index.php#departmentsSection">DEPARTMENT<span class="arrow"></span></a></li>
                        <li><a href="index.php#servicesSection">SERVICES<span class="arrow"></span></a></li>
                        <li><a href="index.php#faqSection">FAQ<span class="arrow"></span></a></li>
                        <li><a href="index.php#specialistsSection">TEAM<span class="arrow"></span></a></li>
                        <li><a href="index.php#contactSection">CONTACT US<span class="arrow"></span></a></li>
                        <li><a href="sign-in.php">LOGIN<span class="arrow"></span></a></li>
                    </ul>
                </div>
            </div>

            <!-- 3. Mobile Hamburger Menu Toggle Trigger -->
            <div class="page-header-top-right">
                <a href="index.php#" class="menu-toggle">
                    <i class="icon-menu"></i><i class="icon-cancel2"></i>
                </a>
            </div>

        </div>
    </div>
</header>
<!-- /Header -->

	<main class="page-main">
		<!-- Breadcrumbs Block -->
		<div class="block breadcrumbs">
			<div class="container">
				<ul class="breadcrumb">
					<li><a href="news-event.php">Home</a></li>
					<li>News & Event</li>
				</ul>
			</div>
		</div>
		<!-- //Breadcrumbs Block -->


	<?php
		// 1. सबसे पहले चेक करेंगे कि URL में id पास की गई है या नहीं
		if (isset($_GET['id']) && !empty($_GET['id'])) {
		    
		    // अगर ID मौजूद है, तो उसे वेरिएबल में लें
		    $edit_id = mysqli_real_escape_string($conn, $_GET['id']);
		    
		    // डेटाबेस से रिकॉर्ड निकालें
		    $fetch = mysqli_query($conn, "SELECT * FROM news_events WHERE id = '$edit_id' LIMIT 1");
		    
		    if (mysqli_num_rows($fetch) > 0) {
		        $row = mysqli_fetch_assoc($fetch);

		        $Avatar      = $row['image'];
		        $Title       = $row['title'];
		        $Tag         = $row['tag'];
		        $Date        = $row['date'];
		        $Description = $row['description'];
		?>
	        <div class="block" id="news">
	            <h2 class="text-center h-lg h-decor">Blog Details</h2>
	            <div class="container">
	                <div class="row">
	                    <div class="col">
	                        <div class="blog-post single">
	                            <div class="post-image">
	                                <img src="<?php echo $Avatar; ?>" style="width: 100% !important; height: 500px !important; object-fit: cover !important; border-radius: 8px;" >
	                            </div>
	                            <ul class="post-meta" style="margin-top: 15px;">
	                                <li class="post-meta-date"><i class="icon-clock1"></i> <?php echo date('d M, Y', strtotime($Date)); ?></li>
	                            </ul>
	                            <h2 class="post-title" style="margin-top: 10px; margin-bottom: 5px;"><?php echo $Title; ?></h2>
	                            
	                            <?php if(!empty($Tag)) { ?>
	                                <div class="post-author" style="margin-bottom: 20px;">
	                                    <span class="badge" style="background-color: #5C6895; color: white; padding: 5px 10px; border-radius: 4px;">Tag: <?php echo $Tag; ?></span>
	                                </div>
	                            <?php } ?>

	                            <div class="post-content" style="text-align: justify; line-height: 1.8;">
	                                <?php
	                                $clean_desc = str_ireplace(array("<br />", "<br>", "<br/>", "</p>", "<p>"), "\n", $Description);
	                                $paragraphs = explode("\n", $clean_desc);
	                                $final_paragraphs = array();
	                                foreach ($paragraphs as $p) {
	                                    $trimmed = trim(strip_tags($p));
	                                    if (!empty($trimmed)) { $final_paragraphs[] = $trimmed; }
	                                }
	                                $total_p = count($final_paragraphs);

	                                if ($total_p > 0) {
	                                    echo "<p>" . $final_paragraphs[0] . "</p>";
	                                    if ($total_p > 1) {
	                                        echo '<div class="quote" style="margin: 25px 0; padding: 15px 20px; border-left: 4px solid #5C6895; background-color: #f8fafc; font-style: italic;">';
	                                        echo "<p>" . $final_paragraphs[1] . "</p>";
	                                        if (isset($final_paragraphs[2])) { echo "<p>" . $final_paragraphs[2] . "</p>"; }
	                                        echo '</div>';
	                                    }
	                                    if ($total_p > 3) {
	                                        for ($i = 3; $i < $total_p; $i++) { echo "<p>" . $final_paragraphs[$i] . "</p>"; }
	                                    }
	                                } else {
	                                    echo "<p>" . nl2br($Description) . "</p>";
	                                }
	                                ?>
	                            </div>
	                            
	                        </div>
	                    </div>
	                </div>
	                
	                <div class="text-center" style="margin-top: 30px;">
	                    <a href="news-event.php" class="btn btn-hover-fill" style="background-color: #5C6895; color: white; padding: 10px 20px; border-radius: 4px; text-decoration: none;">View All News & Events</a>
	                </div>
	            </div>
	        </div>
	<?php
	    } else {
	        // अगर कोई गलत ID डाल दे URL में तो वापस रीडायरेक्ट या मैसेज दिखाएं
	        echo "<div class='block text-center'><h3>Event not found!</h3><a href='news-event.php' style='color:#5C6895;'>Go Back</a></div>";
	    }

	} else { 
	    // 🌟 ब्लॉक 2: वरना नॉर्मल होने पर यह पूरा ग्रिड व्यू दिखाएगा (जब URL में कोई ID न हो) 🌟
	?>
	    <div class="block" id="readNewevent">
	        <div class="container">
	            <p class="text-center h-lg h-decor">Latest Update</p>
	            <h2 class="text-center h-lg h-decor">News & Events</h2>
	            
	            <div class="news-grid row">

	                    <?php 
	                        // Database से सारे न्यूज़ का डेटा लाना (बिना किसी LIMIT के ताकि सभी 50+ रिकॉर्ड्स आएं)
	                        $news_query = mysqli_query($conn, "SELECT * FROM news_events ORDER BY id DESC");
	                        
	                        while ($row = mysqli_fetch_assoc($news_query)) {
	                            $Id          = $row['id'];  
	                            $Avatar      = $row['image'];  
	                            $Title       = htmlspecialchars($row['title']);   
	                            $Description = htmlspecialchars($row['description']); 
	                            $Date        = date('d F, Y', strtotime($row['date']));
	                    ?>

	                    <div class="col-sm-6 col-md-4" style="margin-bottom: 30px;">
	                        <div class="news-prw">
	                            <div class="news-prw-image">
	                                <a href="news-event.php?id=<?php echo $Id; ?>">
	                                    <img src="<?php echo $Avatar; ?>" alt="<?php echo $Title; ?>" style="width: 370px !important; height: 249px !important; object-fit: cover; overflow: hidden;">
	                                    <span><i class="icon-link"></i></span>
	                                </a>
	                            </div>
	                            <div class="news-prw-date"><?php echo $Date; ?></div>
	                            <h3 class="news-prw-title" style="font-size: 22px; min-height: 55px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
	                                <?php echo $Title; ?>
	                            </h3>
	                            <p style="text-align: justify !important; min-height: 65px; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;">
	                                <?php echo (mb_strlen($Description) > 100) ? mb_substr($Description, 0, 100).'...' : $Description; ?>
	                            </p>
	                            <a href="news-event.php?id=<?php echo $Id; ?>" class="btn-read-more"><i class="icon-play"></i>Read more</a>
	                        </div>
	                    </div>

	                    <?php 
	                        } // while लूप बंद 
	                    ?>

	            </div> 
	        </div>
	    </div>
	    <?php 
	} // if-else कंडीशन का अंत
	?>

	</main>



	<!---====== START LIQUID FLEX GRID FOOTER ====== --->
	<footer class="page-footer mt-0" style="background-color:rgb(247, 247, 247) !important; color: #787878; padding-top: 50px; padding-bottom: 0px !important;">
	    <div class="container">
	        <div class="row py-4" style="color: #787878;">
	            
	            <!-- Column 1: Google Map Section -->
	            <div class="col-md-4 mb-4 mb-md-0">
	                <div class="footer-map-wrapper" style="border-radius: 8px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.3);">
	                    <iframe
	                        src="https://maps.google.com/maps?q=Canossa%20Hospital%20Pratapgarh&t=&z=13&ie=UTF8&iwloc=&output=embed"
	                        style="width:100%; height:220px; border:0; display:block;"
	                        allowfullscreen=""
	                        loading="lazy">
	                    </iframe>
	                </div>
	            </div>

	            <!-- Column 2: Hospital Contact Info -->
	            <div class="col-sm-6 col-md-4 mb-4 mb-sm-0">
	                <h4 style="color: #444444; margin-bottom: 20px; font-size: 18px; font-weight: 600; letter-spacing: 0.5px;">CANOSSA HOSPITAL</h4>
	                
	                <div class="page-footer-info" style="display: flex; align-items: flex-start; margin-bottom: 15px; color: #787878;">
	                    <i class="icon icon-location" style="margin-top: 4px; margin-right: 10px; color: #787878;"></i>
	                    <span>Civil Lines, Avadh, Pratapgarh,<br>Uttar Pradesh, India, Pin: 230001</span>
	                </div>
	                
	                <div class="page-footer-info" style="display: flex; align-items: center; margin-bottom: 15px; color: #787878;">
	                    <i class="icon icon-clock1" style="margin-right: 10px; color: #787878;"></i>
	                    <span>Mon - Sat: 8:00 am – 6:00 pm</span>
	                </div>
	                
	                <div class="page-footer-info" style="display: flex; align-items: center; margin-bottom: 15px; color: #787878;">
	                    <i class="icon icon-phone" style="margin-right: 10px; color: #787878;"></i>
	                    <span>05342-220461</span>
	                </div>
	                
	                <div class="page-footer-info" style="display: flex; align-items: center; color: #787878;">
	                    <i class="icon icon-letter" style="margin-right: 10px; color: #787878;"></i>
	                    <a href="mailto:canossa@yahoo.in" style="color: #787878; text-decoration: none;">canossa@yahoo.in</a>
	                </div>
	            </div>

	            <!-- Column 3: Quick Access (Direct CSS Grid Injection) -->
	            <div class="col-sm-6 col-md-4">
	                <h4 style="color: #444444; margin-bottom: 20px; font-size: 18px; font-weight: 600; letter-spacing: 0.5px;">QUICK ACCESS</h4>
	                
	                <!-- Pure Flexbox Grid layout to enforce 3 items per line perfectly -->
	                <div class="screenshot-flex-wrapper">
	                    <div class="grid-item"><a href="<?php echo $base_url; ?>">Home</a></div>
	                    <div class="grid-item"><a href="about_us">About Us</a></div>
	                    <div class="grid-item"><a href="index.php#departmentsSection">Departments</a></div>
	                    
	                    <div class="grid-item"><a href="index.php#facilities">Facilities</a></div>
	                    <div class="grid-item"><a href="index.php#servicesSection">Service</a></div>
	                    <div class="grid-item"><a href="index.php#faqSection">Faq</a></div>
	                    
	                    <div class="grid-item"><a href="index.php#specialistsSection">Team</a></div>
	                    <div class="grid-item"><a href="index.php#contactSection">Contact Us</a></div>
	                    <div class="grid-item"><a href="about_us.php#goal">Our Goal</a></div>
                        <div class="grid-item"><a href="news-event.php">News & Event</a></div>
	                    
	                    <div class="grid-item"><a href="gallery.php">Gallery</a></div>
	                </div>
	            </div>
	            
	        </div>
	    </div>

	    <!-- Footer Bottomline -->
	    <div class="page-footer-bottomline" style="background-color: #5C6895 !important; padding: 17px 0; margin-bottom: 0px;">
	        <div class="container">
	            <div class="row align-items-center">
	                <div class="col-md-6 text-center text-md-left mb-2 mb-md-0">
	                    <div class="footer-copyright" style="color: white; font-size: 14px;">
	                        Copyright © <?php echo date('Y'); ?> <a href="index.php" style="color: white; text-decoration:none; font-weight: 500;">Canossa Hospital.</a> All rights reserved.
	                    </div>
	                </div>
	                <div class="col-md-6 text-center text-md-right">
	                    <div style="color: white; font-size: 14px;">
	                        Developed by  <a href="https://www.aidcom.in" style="color: white; text-decoration:none; font-weight: 500;" target="_blank">Aidcom</a>
	                    </div>
	                </div>
	            </div>
	        </div>
	    </div>

	    <!-- Back to Top Button -->
	    <div class="backToTop js-backToTop" style="color: #5C6895 !important; background-color:  #5C6895 !important;">
	        <i class="icon icon-right-arrow" style="color: white; !important; background-color:  #5C6895 !important;"></i>
	    </div>
	</footer>

	<style>

		/* Remove default black outline/border on click for all links, buttons and active elements */
		a:focus, 
		a:active, 
		a:visited,
		.screenshot-flex-wrapper a:focus,
		.menu a:focus,
		button:focus,
		.btn:focus,
		[role="button"]:focus {
		    outline: none !important;
		    border-color: transparent !important;
		    box-shadow: none !important;
		}

		/* Specific fix for anchor tags embedded inside lists or carousels */
		a:focus-visible {
		    outline: none !important;
		}

	    /* Nayi flex management taaki width constraint crash na ho */
	    .screenshot-flex-wrapper {
	        display: flex !important;
	        flex-wrap: wrap !important;
	        width: 100% !important;
	        padding: 0 !important;
	        margin: 0 !important;
	    }
	    
	    .screenshot-flex-wrapper .grid-item a:hover{
		        color: #5C6895 !important;
		}
	    .screenshot-flex-wrapper .grid-item {
	        flex: 0 0 33.333% !important; /* Ek line me exact 3 items space block karega */
	        max-width: 33.333% !important;
	        margin-bottom: 15px !important;
	        box-sizing: border-box !important;
	        padding-right: 5px !important;
	    }
	    
	    .screenshot-flex-wrapper{
	        margin-bottom: 5rem !important;

	    }
	    .screenshot-flex-wrapper a {
	        color: #787878 !important; 
	        text-decoration: none !important;
	        font-size: 14px !important;
	        white-space: nowrap !important; /* Kisi bhi haal me word break nahi hoga */
	        display: inline-block !important;
	    }
	    

	    /* Mobile standard view adjustment */
	    @media (max-width: 480px) {
	        .screenshot-flex-wrapper .grid-item {
	            flex: 0 0 50% !important; /* Mobile par width bachane ke liye automatic 2 columns */
	            max-width: 50% !important;
	        }
	    }
	</style>
<!---====== END LIQUID FLEX GRID FOOTER ====== --->

	<!-- External JavaScripts -->
	<script src="proclena/js/vendor/jquery.js"></script>
	<script src="proclena/js/vendor/bootstrap.min.js"></script>
	<script src="proclena/js/vendor/slick.min.js"></script>
	<script src="proclena/js/vendor/isotope.pkgd.min.js"></script>
	<script src="proclena/js/vendor/imagesloaded.pkgd.min.js"></script>
	<script src="proclena/js/vendor/lightbox.min.js"></script>
	<script src="proclena/js/vendor/jquery.scroll-with-ease.min.js"></script>
	<script src="proclena/js/vendor/jquery.form.js"></script>
	<script src="proclena/js/vendor/jquery.validate.min.js"></script>
	<script src="proclena/js/vendor/moment.js"></script>
	<script src="proclena/js/vendor/bootstrap-datetimepicker.min.js"></script>
	<script src="proclena/js/vendor/jquery.waypoints.min.js"></script>
	<script src="proclena/js/vendor/jquery.countTo.js"></script>
	<script src="proclena/js/vendor/jquery.print.js"></script>
	<script src="proclena/js/vendor/jquery.dotdotdot.min.js"></script>
	<script src="proclena/js/vendor/jquery.doubletaptogo.min.js"></script>
	<script src="proclena/js/vendor/nouislider.min.js"></script>
	<script src="proclena/js/vendor/jquery.elevateZoom-3.0.8.min.js"></script>
	<!-- Custom JavaScripts -->
	<script src="proclena/js/custom.js"></script>
	<script src="proclena/js/forms.js"></script>
	<script src="proclena/color/color.js"></script>
</body>

</html>