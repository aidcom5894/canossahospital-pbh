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
                        <li><a href="index.php#home">HOME<span class="arrow"></span></a></li>

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
				<li><a href="gallery.php">Home</a></li>
				<li>Gallery</li>
			</ul>
		</div>
	</div>
	<!-- //Breadcrumbs Block -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css" />

<?php
// डेटाबेस से सभी गैलरी इमेजेज को निकालना
$gallery_query = mysqli_query($conn, "SELECT * FROM ui_gallery ORDER BY id DESC");
?>

<div class="block">
    <div class="container">
        <h2 class="text-center h-lg h-decor">Hospital Gallery</h2>
        <div class="text-center max-800">
            <p class="p-lg">explore the memorable moments, healthcare events, medical camps, and official functions that define the compassionate environment and dedicated community at Canossa Hospital.</p>
        </div>
        
        <div class="filters-by-category text-center">
            <ul class="option-set justify-content-center" data-option-key="filter">
                <li><a href="gallery-simple.html#filter" data-option-value="*" class="selected">All</a></li>
                <li><a href="gallery-simple.html#filter" data-option-value=".Event">Event</a></li>
                <li><a href="gallery-simple.html#filter" data-option-value=".National-Holiday">National Holiday</a></li>
                <li><a href="gallery-simple.html#filter" data-option-value=".Function">Function</a></li>
            </ul>
        </div>
        
        <div class="gallery-wrap">
            <div class="loading-content">
                <div class="inner-circles-loader"></div>
            </div>
            
            <div class="gallery-cleaning gallery-isotope" id="gallery">
                <?php 
                if (mysqli_num_rows($gallery_query) > 0) {
                    while ($gallery_row = mysqli_fetch_assoc($gallery_query)) {
                        
                        $db_category = isset($gallery_row['category']) ? $gallery_row['category'] : '';
                        $category_class = str_replace(' ', '-', $db_category);
                        
                        $title = isset($gallery_row['title']) ? htmlspecialchars($gallery_row['title']) : '';
                        $image_path = (!empty($gallery_row['avatar'])) ? $gallery_row['avatar'] : 'medikit/images/default-avatar.png';
                ?>
                        <div class="gallery-item <?php echo $category_class; ?>">
                            
                            <a href="<?php echo $image_path; ?>" data-fancybox="hospital-gallery" data-caption="<?php echo $title; ?>">
                                <img src="<?php echo $image_path; ?>" style="width: 570px !important; height: 350px !important; object-fit: cover !important; background: #F7F7F7; box-shadow: 0 4px 10px rgba(0,0,0,0.08);" alt="<?php echo $title; ?>"/>
                            </a>

                            <div class="gallery-caption">
                                <h5>Category</h5>
                                <p><?php echo htmlspecialchars($db_category); ?></p>
                            </div>
                        </div>
                <?php 
                    }
                } else {
                    echo "<div class='text-center w-100 p-4'>No images found in gallery.</div>";
                }
                ?>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
<script>
    Fancybox.bind("[data-fancybox='hospital-gallery']", {
        loop: false,        // आगे लूप नहीं होगा
        infinite: false,    // आगे रास्ता बंद हो जाएगा
        dragToClose: false  // स्वाइप करने पर बंद न हो
    });
</script>


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
	                    <div class="grid-item"><a href="index.php#home">Home</a></div>
	                    <div class="grid-item"><a href="about_us.php">About Us</a></div>
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

	    .filters-by-category .option-set a{
		    display:inline-block;
		    padding:10px 20px;
		    border:2px solid transparent;
		    border-radius:30px;
		    transition:.3s;
		    text-decoration:none;
		}

		.filters-by-category .option-set a.selected,
		.filters-by-category .option-set a.active-filter{
		    border:2px solid #4BA0E8 !important;
		    color:#4BA0E8 !important;
		    background:#fff !important;
		}

		.filters-by-category .option-set a:hover{
		    border:2px solid #4BA0E8 !important;
		}

		.filters-by-category .option-set a:focus{
		    outline:none;
		    box-shadow:none;
		}
	</style>

	<script>
		$(document).ready(function () {

		    // Filter button click
		    $('.filters-by-category .option-set a').on('click', function (e) {
		        e.preventDefault();

		        // Sabse pehle purana active hatao
		        $('.filters-by-category .option-set a').removeClass('selected active-filter');

		        // Jis par click hua usko active rakho
		        $(this).addClass('selected active-filter');
		    });

		});
	</script>

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