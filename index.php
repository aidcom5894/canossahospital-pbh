<?php
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    // error_reporting(E_ALL);
    // ini_set('display_errors', 1);

    include('config.php');

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require 'PHPMailer/src/PHPMailer.php';
    require 'PHPMailer/src/SMTP.php';
    require 'PHPMailer/src/Exception.php';

    if(isset($_POST['send_message']))
    {   
        $Name = mysqli_real_escape_string($conn, trim($_POST['name']));
        $Phone = mysqli_real_escape_string($conn, trim($_POST['phone']));
        $Email = mysqli_real_escape_string($conn, trim($_POST['email']));
        $Message = mysqli_real_escape_string($conn, trim($_POST['message']));

        // FIXED: SQL Query में 'phone' कॉलम मिसिंग था, उसे सही जगह पर जोड़ दिया है
        $insertQuery = "INSERT INTO contact_form (name, phone, email, message) VALUES ('$Name', '$Phone', '$Email', '$Message')";
        $insertData = mysqli_query($conn, $insertQuery);

        if($insertData)
        {
            $mail = new PHPMailer(true);

            try {
                $mail->isSMTP();
                $mail->Host       = 'smtp.hostinger.com';
                $mail->SMTPAuth   = true;
                $mail->Username   = 'support@aidcombizcard.in';
                $mail->Password   = 'FinTech@2026#@';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                $mail->Port       = 465;

                $mail->setFrom('support@aidcombizcard.in', 'Website Contact');
                $mail->addAddress($Email);

                $mail->isHTML(true);

				// ईमेल का सब्जेक्ट भी थोड़ा और बेहतर कर देते हैं
                $mail->Subject = 'New Inquiry: Consultation Request from ' . $Name;

                // प्रोफेशनल और रियल-वर्ल्ड HTML टेम्पलेट
                $mail->Body = "
                <div style='font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; border: 1px solid #e1e1e1; border-radius: 8px; overflow: hidden;'>
                    <div style='background-color: #0284c7; color: #ffffff; padding: 20px; text-align: center;'>
                        <h2 style='margin: 0; font-size: 22px; font-weight: 600;'>Canossa Hospital</h2>
                        <p style='margin: 5px 0 0 0; font-size: 14px; opacity: 0.9;'>New Website Contact Form Submission</p>
                    </div>
                    
                    <div style='padding: 24px; background-color: #fcfcfc;'>
                        <p style='font-size: 15px; color: #555; margin-top: 0;'>Dear Admin,</p>
                        <p style='font-size: 15px; color: #555;'>You have received a new consultation request/inquiry from the website contact form. Below are the details provided by the visitor:</p>
                        
                        <table style='width: 100%; border-collapse: collapse; margin: 20px 0; background-color: #ffffff;'>
                            <tr>
                                <td style='padding: 12px; border: 1px solid #eeeeee; font-weight: bold; width: 30%; color: #444; background-color: #f9f9f9;'>Full Name</td>
                                <td style='padding: 12px; border: 1px solid #eeeeee; color: #222;'>$Name</td>
                            </tr>
                            <tr>
                                <td style='padding: 12px; border: 1px solid #eeeeee; font-weight: bold; color: #444; background-color: #f9f9f9;'>Phone Number</td>
                                <td style='padding: 12px; border: 1px solid #eeeeee; color: #222;'>$Phone</td>
                            </tr>
                            <tr>
                                <td style='padding: 12px; border: 1px solid #eeeeee; font-weight: bold; color: #444; background-color: #f9f9f9;'>Email Address</td>
                                <td style='padding: 12px; border: 1px solid #eeeeee; color: #0284c7;'>$Email</td>
                            </tr>
                            <tr>
                                <td style='padding: 12px; border: 1px solid #eeeeee; font-weight: bold; color: #444; background-color: #f9f9f9;'>Message / Inquiry</td>
                                <td style='padding: 12px; border: 1px solid #eeeeee; color: #222; white-space: pre-line;'>$Message</td>
                            </tr>
                        </table>
                        
                        <p style='font-size: 13px; color: #666; margin-bottom: 0;'>
                            <i>* This is an automated system-generated notification from your website's contact form framework. Please reply directly to the patient's email if action is required.</i>
                        </p>
                    </div>
                    
                    <div style='background-color: #f1f5f9; padding: 15px; text-align: center; border-top: 1px solid #e2e8f0; font-size: 12px; color: #64748b;'>
                        &copy; " . date('Y') . " Canossa Hospital Management System. All Rights Reserved. <br>
                        Powered by <a href='https://www.aidcom.in' target='_blank' style='color: #0284c7; text-decoration: none; font-weight: bold;'>Aidcom</a>
                    </div>
                </div>
                ";

                $mail->send();

                // FIXED: ईमेल भेजने के बाद का सक्सेस मैसेज
                $_SESSION['status'] = "success";
                $_SESSION['message'] = "Message sent and email delivered successfully!";

            } catch (Exception $e) {
                // अगर ईमेल फेल भी हो जाए, तब भी डेटाबेस में तो डेटा आ चुका है
                $_SESSION['status'] = "success";
                $_SESSION['message'] = "Message saved, but mail notification could not be sent.";
            }
            
            header("Location: ".$_SERVER['PHP_SELF']);
            exit();
        } else {
            // अगर डेटाबेस में इन्सर्ट ही फेल हो जाए
            $_SESSION['status'] = "error";
            $_SESSION['message'] = "Database Error: " . mysqli_error($conn);
            header("Location: ".$_SERVER['PHP_SELF']);
            exit();
        }
    }   
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<meta name="format-detection" content="telephone=no">
	<title>Canossa Hospital-Partapgarh</title>
	<!-- Stylesheets -->
	<!--Favicon-->
	<link rel="icon" href="medera/images/cfavicon.png" type="image/x-icon">
	<link href="medera/vendor/slick/slick.css" rel="stylesheet">
	<link href="medera/vendor/animate/animate.min.css" rel="stylesheet">
	<link href="medera/icons/style.css" rel="stylesheet">
	<link href="medera/vendor/bootstrap-datetimepicker/bootstrap-datetimepicker.css" rel="stylesheet">
	<link href="medera/css/style.css" rel="stylesheet">
    <link href="medera/color/color.css" rel="stylesheet">

	<!-- Google Fonts -->
	<link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

	<style>
		@media (min-width: 992px) {
		    .navbar-nav .nav-item.dropdown:hover .dropdown-menu {
		        display: block;
		        margin-top: 0;
		    }
		}
	</style>
</head>

<body class="shop-page layout-landing">
    <!---======  START HEADER ====== --->
		<header class="header" id="home">
			<div class="header-quickLinks js-header-quickLinks d-lg-none">
				<div class="quickLinks-top js-quickLinks-top"></div>
				<div class="js-quickLinks-wrap-m">
				</div>
			</div>


			<div class="header-content">
				<div class="container">
					<div class="row align-items-lg-center">
						<button class="navbar-toggler collapsed" data-toggle="collapse" data-target="#navbarNavDropdown">
							<span class="icon-menu"></span>
						</button>
						<div class="col-lg-auto col-lg-2 d-flex align-items-lg-center">
							<a href="https://canossahospitalpbh.in/" ><img src="img/canossalogo1.png" alt="" style="width:208px; height: 50px;"></a>
						</div>
						<div class="col-lg ml-auto header-nav-wrap">
							<div class="header-nav js-header-nav">
								<nav class="navbar navbar-expand-lg btco-hover-menu">
									<div class="collapse navbar-collapse justify-content-center" id="navbarNavDropdown">
										<ul class="navbar-nav">
											<li class="nav-item">
												<a class="nav-link link-inside" href="#home">Home</a>
											</li>
											<li class="nav-item dropdown">
		                                        <a class="nav-link dropdown-toggle" href="#" id="aboutDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		                                            About Us
		                                        </a>
		                                        <div class="dropdown-menu" aria-labelledby="aboutDropdown">
		                                            <a class="dropdown-item " href="about_us">About Us</a>
		                                            <a class="dropdown-item" href="gallery.php">GALLERY</a>
		                                            <a class="dropdown-item " href="news-event#readNewevent">NEWS & EVENT</a>
		                                            <a class="dropdown-item link-inside" href="#facilities">FACILITIES</a>
		                                            <a class="dropdown-item " href="about_us#message">Message</a>
		                                        </div>
		                                    </li>
											<li class="nav-item">
												<a class="nav-link link-inside" href="#departmentsSection">Departments</a>
											</li>
											<li class="nav-item">
												<a class="nav-link link-inside" href="#servicesSection">Services</a>
											</li>
											<li class="nav-item">
												<a class="nav-link link-inside" href="#faqSection">Faq</a>
											</li>
											<li class="nav-item">
												<a class="nav-link link-inside" href="#specialistsSection">Team</a>
											</li>

											<li class="nav-item">
												<a class="nav-link link-inside" href="#contactSection">Contact Us</a>
											</li>
											<li class="nav-item">
												<a class="nav-link " href="sign-in">Login</a>
											</li>
										</ul>
									</div>
								</nav>
							</div>

						</div>
					</div>
				</div>
			</div>

		</header>
    <!---======  END HEADER ====== --->

	<div class="page-content">

	<!---======  START SLIDER ====== --->
		<div class="section mt-0">
		    <div id="mainSliderWrapper">
		        <div class="loading-content">
		            <div class="inner-circles-loader"></div>
		        </div>

		        <div class="main-slider mb-0 arrows-white arrows-bottom" id="mainSlider" data-slick='{"arrows": false, "dots": true}'>
		            
		            <?php 
		            // डेटाबेस से शुरुआत के 3 रिकॉर्ड्स लाना (Ab SELECT me title aur subtitle nikalne ki zaroorat nahi hai)
		            $slider = mysqli_query($conn, "SELECT id, heading, avatar FROM ui_home ORDER BY rand() LIMIT 3");
		            
		            // यह काउंटर बटन लिंक्स को अलग-अलग सेक्शन पर भेजने के लिए है
		            $slide_counter = 1;

		            // while लूप तीनों रिकॉर्ड्स को एक-एक करके घुमाएगा
		            while($row = mysqli_fetch_assoc($slider)) {
		                $Avatar   = $row['avatar'];
		                $Heading  = $row['heading'];

		                // Title aur Subtitle variables ko yahan se hata diya gaya hai
						$FormattedHeading = wordwrap($Heading, 17, "<br>\n", false);
						
		                // हर स्लाइड के बटन के लिए अलग लिंक सेट करना
		                if ($slide_counter == 1) {
		                    $btn_link = "index#aboutSection"; // .php hata diya hai htaccess ke mutabik
		                    $btn_text = "EXPLORE OUR SERVICES";
		                } elseif ($slide_counter == 2) {
		                    $btn_link = "index#servicesSection";
		                    $btn_text = "KNOW MORE";
		                } else {
		                    $btn_link = "index#faqSection";
		                    $btn_text = "CONTACT US";
		                }
		            ?>
		            
		            <div class="slide">
		                <div class="img--holder" data-bg="<?php echo $Avatar; ?>"></div>
		                <div class="slide-content center">
		                    <div class="vert-wrap container">
		                        <div class="vert">
		                            <div class="container" style="text-align: left;">
		                                
		                                <div class="slide-txt1" data-animation="fadeInDown" data-animation-delay="1s" style="color: #2c3e50; font-weight: 700; font-size: 38px; line-height: 1.2; text-transform: uppercase; margin-bottom: 10px;">
		                                    <?php echo $FormattedHeading; ?>
		                                </div>
		                                <h4 style="color: #00a896; font-weight: 700; font-size: 16px; letter-spacing: 1px; margin-bottom: 25px; text-transform: uppercase;">
		                                    TO COMFORT, TO ASSIST & TO INSTRUCT
		                                </h4>

		                                <div class="info-card-box" data-animation="fadeInUp" data-animation-delay="1.3s" style="background: rgba(255, 255, 255, 0.85); backdrop-filter: blur(5px); border-radius: 8px; padding: 25px 30px; max-width: 550px; box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1); border: 1px solid rgba(255, 255, 255, 0.2);">
		                                    
		                                    <div style="display: flex; align-items: flex-start; margin-bottom: 15px;">
		                                        <div style="color: #79d23f; font-size: 20px; margin-right: 12px; font-weight: bold;">✔</div>
		                                        <div>
		                                            <strong style="color: #333; font-size: 15px; display: block;">We are called Mother Hospital</strong>
		                                            <span style="color: #666; font-size: 13px;">Motherly affection and caring of Canossian Sisters (Mothers)</span>
		                                        </div>
		                                    </div>

		                                    <div style="display: flex; align-items: flex-start; margin-bottom: 15px;">
		                                        <div style="color: #79d23f; font-size: 20px; margin-right: 12px; font-weight: bold;">✔</div>
		                                        <div>
		                                            <strong style="color: #333; font-size: 15px; display: block;">Extended service through Mobile Clinic</strong>
		                                            <span style="color: #666; font-size: 13px;">We ensure the availability of medical facility through Mobile Clinic</span>
		                                        </div>
		                                    </div>

		                                    <div style="display: flex; align-items: flex-start; margin-bottom: 20px;">
		                                        <div style="color: #79d23f; font-size: 20px; margin-right: 12px; font-weight: bold;">✔</div>
		                                        <div>
		                                            <strong style="color: #333; font-size: 15px; display: block;">Special care for mother and child</strong>
		                                            <span style="color: #666; font-size: 13px;">Providing comprehensive healthcare services for families.</span>
		                                        </div>
		                                    </div>

		                                    <div class="slide-btn" style="text-align: right; margin-top: 15px;">
		                                        <a href="<?php echo $btn_link; ?>" class="btn" style="background-color: #4cd1db; color: white; padding: 10px 22px; font-weight: bold; border-radius: 4px; text-decoration: none; display: inline-flex; align-items: center; font-size: 13px; letter-spacing: 0.5px; box-shadow: 0 4px 10px rgba(76, 209, 219, 0.3); transition: all 0.3s ease;">
		                                            <span><?php echo $btn_text; ?></span> <i class="icon-right-arrow" style="margin-left: 8px;"></i>
		                                        </a>
		                                    </div>

		                                </div>
		                                </div>
		                        </div>
		                    </div>
		                </div>
		            </div>

		            <?php 
		                $slide_counter++; // काउंटर को बढ़ाएं
		            } // while लूप यहाँ बंद हुआ
		            ?>
		            
		        </div> 
		    </div>
		</div>
	<!---======  START SLIDER ====== --->


	    <!---======  SECTION ====== --->
			<div class="section mt-0 shadow-bot pt-2 pb-0 py-sm-4 mb-2">
				<div class="container">
					<div class="row js-icn-text-alt-carousel">
						<div class="col-md-6 col-lg-4">
							<div class="icn-text-alt">
								<div class="icn-text-alt-icn"><i class="icon-first-aid-kit"></i></div>
								<div>
									<h4 class="icn-text-alt-title">24 Hour Emergency</h4>
									<p>Open round the clock for convenience, quick and easy access</p>
								</div>
							</div>
						</div>
						<div class="col-md-6 col-lg-4">
							<div class="icn-text-alt">
								<div class="icn-text-alt-icn"><i class="icon-flask"></i></div>
								<div>
									<h4 class="icn-text-alt-title">Complete Lab Services</h4>
									<p>Cost-efficient, comprehensive and clinical laboratory services</p>
								</div>
							</div>
						</div>
						<div class="col-md-6 col-lg-4">
							<div class="icn-text-alt">
								<div class="icn-text-alt-icn"><i class="icon-doctor"></i></div>
								<div>
									<h4 class="icn-text-alt-title">Medical Professionals</h4>
									<p>Qualified and certified physicians for quality medical care</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
	    <!---======  SECTION ====== --->



	    <!---======  START ABOUT ====== --->
			<?php
			    // डेटाबेस से रिकॉर्ड लाना
			    $about_query = mysqli_query($conn, "SELECT * FROM ui_about LIMIT 1");
			    $row = mysqli_fetch_assoc($about_query);

			    // अगर डेटा मिला है तो हेडिंग को 16 कैरेक्टर के बाद तोड़ना (Br लगाना)
				$Heading = "";
				if ($row) {
				    // अगर हेडिंग 23 अक्षर से बड़ी है, तो उसी वेरिएबल में तोड़कर स्पैन जोड़ेंगे
				    if (mb_strlen($row['heading']) > 22) {
				        $Heading = mb_substr($row['heading'], 0, 22) . '<span class="theme-color">' . mb_substr($row['heading'], 22) . '</span>';
				    } else {
				        $Heading = $row['heading'];
				    }
				}
			?>
			<div class="section" id="aboutSection">
				<div class="container pt-lg-2">
					<div class="row mt-2 mt-md-3 mt-lg-0">
						<div class="col-md-6">
							<div class="title-wrap text-center text-md-left">
								<div class="h-sub" style="white-space:normal; word-wrap:break-word;overflow-wrap: break-word; text-align: justify;"><?php echo $row['about_title']; ?></div>
								<h2 class="h1"><?php echo $Heading; ?></h2>
							</div>
							<div class="pr-xl-1">
								<p style="white-space:normal; word-wrap:break-word;overflow-wrap: break-word; text-align: justify;"><?php echo $row['about'];?></p>
								<ul class="marker-list-md">
									<li style="white-space:normal; word-wrap:break-word;overflow-wrap: break-word; text-align: justify;"><?php echo $row['about_line1'];?></li>
									<li style="white-space:normal; word-wrap:break-word;overflow-wrap: break-word; text-align: justify;"><?php echo $row['about_line2'];?></li>
									<li style="white-space:normal; word-wrap:break-word;overflow-wrap: break-word; text-align: justify;"><?php echo $row['about_line3'];?></li>
								</ul>
							</div>

						</div>
						<div class="col-md-6 mt-4 mt-md-0">
							<div class="video-box">
								<div class="video-box-poster">
									<img src="<?php echo$row['avatar'];?>" alt="" class="img-fluid">
								</div>
								<a href="javascript(void)" class="video-btn js-video-btn" data-toggle="modal" data-src="<?php echo$row['video'];?>" data-target="#videoModal">
									<span>Watch Video</span>
									<span><i class="icon-play"></i></span>
								</a>
								<div class="video-box-bg"><img src="<?php echo$row['avatar2'];?>" alt=""></div>
							</div>
							<!-- Video Modal -->
							<div class="modal fade" id="videoModal">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-body">
											<div class="embed-responsive embed-responsive-16by9">
												<iframe class="embed-responsive-item video" src="<?php echo$row['video'];?>" allowscriptaccess="always" allow="autoplay"></iframe>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
	    <!---======  START ABOUT ====== --->



	    <!---======  START DEPARTMENTS ====== --->
			<div class="section" id="departmentsSection">
				<div class="container">
					<div class="title-wrap text-center">
						<h2 class="h1">Our Departments</h2>
						<div class="h-decor"></div>
					</div>
					<p class="text-center max-500">Canossa Medical Center specializes in different medical services for the convenience of community:</p>
					<div class="row mt-lg-4">
						<div class="col-lg-8 col-xl-9">
							<div class="department-tabs js-department-tabs d-none d-sm-flex">
								<div class="department-tab active">
									<div class="department-tab-icon"><i class="icon-brain"></i></div>
									<div class="department-tab-text">Psychiatry</div>
								</div>
								<div class="department-tab">
									<div class="department-tab-icon"><i class="icon-lab"></i></div>
									<div class="department-tab-text">Laboratory</div>
								</div>
								<div class="department-tab">
									<div class="department-tab-icon"><i class="icon-dental"></i></div>
									<div class="department-tab-text">Dental Medicine</div>
								</div>
								<div class="department-tab">
									<div class="department-tab-icon"><i class="icon-cardiology"></i></div>
									<div class="department-tab-text">Cardiology</div>
								</div>
								<div class="department-tab">
									<div class="department-tab-icon"><i class="icon-gynecology"></i></div>
									<div class="department-tab-text">Gynecology</div>
								</div>
								<div class="department-tab">
									<div class="department-tab-icon"><i class="icon-medicine"></i></div>
									<div class="department-tab-text">Medicine</div>
								</div>
								<div class="department-tab">
									<div class="department-tab-icon"><i class="icon-traumatology"></i></div>
									<div class="department-tab-text">Traumatology</div>
								</div>
								<div class="department-tab">
									<div class="department-tab-icon"><i class="icon-pediatrics"></i></div>
									<div class="department-tab-text">Pediatrics</div>
								</div>
							</div>
						</div>
						<div class="col-lg-4 col-xl-3">
							<div class="department-carousel js-department-carousel">
								<div class="department-item">
									<h3 data-title="Psychiatry"><span>Psychiatry</span></h3>
									<div class="department-tab">
										<div class="department-tab-icon"><i class="icon-brain"></i></div>
										<div class="department-tab-text">Psychiatry</div>
									</div>
									<p>We provide a comprehensive continuum of mental health and substance abuse services that include both inpatient an ambulatory services with varying levels of intensity.</p>
									<p>The treatment programs are designed to meet the needs of dual diagnosis.</p>
								</div>
								<div class="department-item">
									<h3 data-title="Laboratory"><span>Laboratory</span></h3>
									<div class="department-tab">
										<div class="department-tab-icon"><i class="icon-lab"></i></div>
										<div class="department-tab-text">Laboratory</div>
									</div>
									<p>The laboratory has a superior record of high quality performance and is dedicated to provide accurate, timely and cost effective service to our clinicians, their patients and community at large. </p>
									<p>Our Laboratory operates 24 hours a day, seven days a week, providing excellent turn-around times. </p>
								</div>
								<div class="department-item">
									<h3 data-title="Dental Medicine"><span>Dental Medicine</span></h3>
									<div class="department-tab">
										<div class="department-tab-icon"><i class="icon-dental"></i></div>
										<div class="department-tab-text">Dental Medicine</div>
									</div>
									<p>The Department of Dental Medicine offers comprehensive dental, oral surgery and oral health services in the state of the art, modern facility. </p>
									<p>Children and adults are cared for by general and pediatric dentist and Board Certified specialists from the more complex procedures. </p>
								</div>
								<div class="department-item">
									<h3 data-title="Cardiology"><span>Cardiology</span></h3>
									<div class="department-tab">
										<div class="department-tab-icon"><i class="icon-cardiology"></i></div>
										<div class="department-tab-text">Cardiology</div>
									</div>
									<p>The Cardiology Department performs all non-invasive cardiac diagnostic procedures.</p>
									<p>The biggest area of heart disease treated is coronary artery disease e.g. angina. Also treated are abnormal heart rhythms, heart failure, high blood pressure and some rarer conditions.</p>
								</div>
								<div class="department-item">
									<h3 data-title="Gynecology"><span>Gynecology</span></h3>
									<div class="department-tab">
										<div class="department-tab-icon"><i class="icon-gynecology"></i></div>
										<div class="department-tab-text">Gynecology</div>
									</div>
									<p>The Department of Gynecology provides a comprehensive array of services from adolescence through, and beyond menopause. </p>
									<p>Surgical procedures for emergency and other gynecological conditions are being provided by experienced physicians committed to the welfare of the female population.</p>
								</div>
								<div class="department-item">
									<h3 data-title="Medicine"><span>Medicine</span></h3>
									<div class="department-tab">
										<div class="department-tab-icon"><i class="icon-medicine"></i></div>
										<div class="department-tab-text">Medicine</div>
									</div>
									<p>The Department has a large Internal Medicine residency program and sub-specialty whose Residents and Fellows under the close supervision of our skilled Attending Physicians work together to provide comprehensive, up to date, and effective patient care based on the physicians' extensive medical knowledge and clinical experience.</p>
								</div>
								<div class="department-item">
									<h3 data-title="Traumatology"><span>Traumatology</span></h3>
									<div class="department-tab">
										<div class="department-tab-icon"><i class="icon-traumatology"></i></div>
										<div class="department-tab-text">Traumatology</div>
									</div>
									<p>Our department deals with initial treatment as well as further surgical treatment of accident victims and polytrauma patients. Every member of the team contributes to the continuum of quality trauma care.</p>
									<p>In addition to treating adults, we provide complex service in the treatment of pediatric patients.</p>
								</div>
								<div class="department-item">
									<h3 data-title="Pediatrics"><span>Pediatrics</span></h3>
									<div class="department-tab">
										<div class="department-tab-icon"><i class="icon-pediatrics"></i></div>
										<div class="department-tab-text">Pediatrics</div>
									</div>
									<p>In addition to treating adults, we provide complex service in the treatment of pediatric patients.</p>
									<p>Our department deals with initial treatment as well as further surgical treatment of accident victims and polytrauma patients. Every member of the team contributes to the continuum of quality trauma care.</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
	    <!---======  START DEPARTMENTS ====== --->


		<!--START WHY CHOOSE US-->
		    <?php
		        $why = mysqli_query($conn, " SELECT * FROM ui_why LIMIT 1");
		        $row = mysqli_fetch_assoc($why);
		    ?>
			<div class="section" id="whySection">
				<div class="container-fluid px-0 text-image-block">
					<div class="row no-gutters">
						<div class="col-md-6 image-col"><img src="<?php echo $row['avatar'];?>" alt=""></div>
						<div class="col-md-6 text-col">
							<div class="title-wrap">
								<div class="h-sub theme-color">See the Difference</div>
								<h2 class="h1" data-title="Why Choose Us?"><span>Why Choose Us?</span></h2>
							</div>
							<div class="mt-2 mt-lg-4"></div>
							<ul class="numbered-list-xl">
								<li data-num='01.'>
									<h5 ><?php echo $row['title1'];?></h5>
									<?php echo $row['subtitle1'];?>
								</li>
								<li data-num='02.'>
									<h5><?php echo $row['title2'];?></h5>
									<?php echo $row['subtitle2'];?>
								</li>
								<li data-num='03.'>
									<h5><?php echo $row['title3'];?></h5>
									<?php echo $row['subtitle3'];?>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		<!--//END OF WHY CHOOSE US-->



		<!---======  START FACILITES ====== --->
			<div class="facilities-block py-4 mt-3" id="facilities">
			    <div class="container">
			        
			        <div class="text-center mb-5">
			            <h2 style="font-weight: 700; margin-bottom: 15px;">Our Facilities</h2>
			            <div class="mx-auto" style="max-width: 800px;">
			                <p class="text-muted" style="font-size: 16px; line-height: 1.6;">
			                    Serving the community for over 85 years with advanced medical care, comprehensive infrastructure, and a deep commitment to patient recovery and well-being.
			                </p>
			            </div>
			        </div>

			        <div class="row">
			            <?php 
			            // डेटाबेस से शुरुआत के 6 रैंडम रिकॉर्ड्स लाना
			            $Service = mysqli_query($conn, "SELECT * FROM ui_faci ORDER BY rand() LIMIT 6");
			            while($row = mysqli_fetch_assoc($Service)) {
			                $Avatar = $row['avatar'];
			                $Title = $row['title'];
			                $About = $row['about'];
			            ?>
			            
			            <div class="col-12 col-md-4 mb-5 text-center text-icon">
			                <div class="text-icon-icon mb-3">
			                    <img src="<?php echo $Avatar; ?>" style="width: 120px !important; height: 120px !important; border-radius: 50% !important; object-fit: cover !important; overflow: hidden; background: #F7F7F7; box-shadow: 0 4px 10px rgba(0,0,0,0.08);">
			                </div>
			                <h4 class="text-icon-title" style="font-size: 20px; font-weight: 600; line-height: 1.4; color: #333;">
			                    <?php echo $Title; ?>
			                </h4>
			                <div class="text-icon-text text-muted mt-2" style="font-size: 15px; line-height: 1.5; padding: 0 10px;">
			                    <?php echo $About; ?>
			                </div>
			            </div>
			            <?php } ?>

			        </div>
			    </div>
			</div>
	    <!---====== END FACILITES ====== --->


	    <!---======  START SERVICES ====== --->
			<div class="section mt-0" id="servicesSection">
				<div class="container">
					<div class="title-wrap text-center">
						<h2 class="h1">Our Services</h2>
						<div class="h-decor"></div>
					</div>
					<div class="row js-service-card-style2-carousel">
			            <?php 
				            // डेटाबेस से शुरुआत के 3 रिकॉर्ड्स (ID 1, 2, 3) लाना
				            $Service = mysqli_query($conn, "SELECT * FROM ui_service ORDER BY rand() LIMIT 3");
				            while($row = mysqli_fetch_assoc($Service)) {
				                $Avatar   = $row['avatar'];
				                $Heading  = $row['heading'];
				                $Subtitle = $row['subtitle'];
			            ?>
			            

							<div class="col-md-6 col-lg-4">
								<div class="service-card-style2">
									<div class="service-card-icon">
										<img src="<?php echo $Avatar; ?>" style="  width: 55px !important;height: 52px !important;border-radius: 10% !important;object-fit: cover !important;">
									</div>
									<h5 class="service-card-name" style="white-space:normal; word-wrap:break-word;overflow-wrap: break-word;"><?php echo $Heading;?></h5>
									<p style="white-space:normal; word-wrap:break-word;overflow-wrap: break-word;"><?php echo $Subtitle;?></p>
									<ul class="marker-list-md">
										<li style="white-space:normal; word-wrap:break-word;overflow-wrap: break-word;"><?php echo $row['line1'];?></li>
										<li style="white-space:normal; word-wrap:break-word;overflow-wrap: break-word;"><?php echo $row['line2'];?></li>
										<li style="white-space:normal; word-wrap:break-word;overflow-wrap: break-word;"><?php echo $row['line3'];?></li>
										<li style="white-space:normal; word-wrap:break-word;overflow-wrap: break-word;"><?php echo $row['line4'];?></li>
										<li style="white-space:normal; word-wrap:break-word;overflow-wrap: break-word;"><?php echo $row['line5'];?></li>
									</ul>
								</div>
							</div>
						<?php }?>
					</div>
				</div>
			</div>
	    <!---======  END SERVICES ====== --->


		<!---======  START FAQS ====== --->
			<?php
			    // डेटाबेस से रिकॉर्ड लाना
			    $Faq = mysqli_query($conn, "SELECT * FROM ui_faq LIMIT 1");
			    $row = mysqli_fetch_assoc($Faq);
    		?>
			<div class="section bg-grey py-0" id="faqSection">
				<div class="container-fluid px-0">
					<div class="row no-gutters">
						<div class="col-xl-6 order-2 order-xl-1">
							<div class="faq-wrap px-15 px-lg-8">
								<div class="title-wrap">
									<h2 class="h1"><?php echo $row['name'];?></h2>
								</div>
								<div class="mt-2 mt-lg-4"></div>
								<div class="faq-item">
									<a data-toggle="collapse" data-parent="#faqAccordion1" href="#faqItem1" aria-expanded="true"><span>1.</span><span><?php echo $row['ques1'];?></span></a>
									<div id="faqItem1" class="collapse show faq-item-content" role="tabpanel">
										<div><p  style="white-space:normal; word-wrap:break-word;overflow-wrap: break-word;"><?php echo $row['ans1'];?></p></div>
									</div>
								</div>
								<div class="faq-item">
									<a data-toggle="collapse" data-parent="#faqAccordion1" href="#faqItem2" aria-expanded="false" class="collapsed"><span>2.</span><span><?php echo $row['ques2'];?></span></a>
									<div id="faqItem2" class="collapse faq-item-content"role="tabpanel">
										<div><p  style="white-space:normal; word-wrap:break-word;overflow-wrap: break-word;"><?php echo $row['ans2'];?></p></div>
									</div>
								</div>
								<div class="faq-item">
									<a data-toggle="collapse" data-parent="#faqAccordion1" href="#faqItem3" aria-expanded="false" class="collapsed"><span>3.</span><span><?php echo $row['ques3'];?></span></a>
									<div id="faqItem3" class="collapse faq-item-content"role="tabpanel">
										<div><p  style="white-space:normal; word-wrap:break-word;overflow-wrap: break-word;"><?php echo $row['ans3'];?></p></div>
									</div>
								</div>
								<div class="faq-item">
									<a data-toggle="collapse" data-parent="#faqAccordion1" href="#faqItem4" aria-expanded="false" class="collapsed"><span>4.</span><span><?php echo $row['ques4'];?></span></a>
									<div id="faqItem4" class="collapse faq-item-content"role="tabpanel">
										<div><p  style="white-space:normal; word-wrap:break-word;overflow-wrap: break-word;"><?php echo $row['ans4'];?></p>
										</div>
									</div>
								</div>

							</div>
						</div>
						<div class="col-xl-6 banner-left bg-cover order-1 order-xl-2" style="background-image: url(<?php echo $row['avatar'];?> )"></div>
					</div>
				</div>
			</div>
	    <!---======  END FAQS   ====== --->


 	    <!---======  START  SPECIALISTS ====== --->
			<div class="section" id="specialistsSection">
				<div class="container">
					<div class="title-wrap text-center">
						<div class="h-sub theme-color">Meet the Team</div>
						<h1>Our Specialists</h1>
						<div class="h-decor"></div>
					</div><p class="text-center max-600">We offer highly specialised medical care, on one site, from some of the </p>

					<div class="row specialist-carousel js-specialist-carousel">
						<?php 
				            // डेटाबेस से शुरुआत के 3 रिकॉर्ड्स (ID 1, 2, 3) लाना
				            $team = mysqli_query($conn, "SELECT * FROM ui_team ORDER BY rand() LIMIT 10");
				            
				            // यह काउंटर बटन लिंक्स को अलग-अलग सेक्शन पर भेजने के लिए है
				            $team_counter = 1;

				            // while लूप तीनों रिकॉर्ड्स को एक-एक करके घुमाएगा
				            while($row = mysqli_fetch_assoc($team)) {
				                $Avatar   = $row['avatar'];
				                $Name  = $row['name'];
				                $Department    = $row['department'];


			            ?>

			            <div class="col-sm-6 col-md-4 category1">
							<div class="doctor-box doctor-box-style2 text-center">
								<div class="doctor-box-photo" style="width: 370px; height: 361px; overflow: hidden; border-radius: 8px;">
								    <img src="<?php echo $Avatar; ?>" style="width: 100%; height: 100%; object-fit: cover;" alt="">
								</div>
								<div class="doctor-box-top">
									<h5 class="doctor-box-name"><?php echo $Name; ?></h5>
									<div class="doctor-box-position me-2"><?php echo $Department; ?></div>

								</div>
							</div>
						</div>

			            <?php 
			                $team_counter++; // काउंटर को बढ़ाएं
			            } // while लूप यहाँ बंद हुआ
			            ?>
			        </div>

				</div>
			</div>
	    <!---======  END  SPECIALISTS ====== --->


	    <!---======  START ONLINE OPPOINTMENTS ====== --->
			<?php
			    // डेटाबेस से रिकॉर्ड लाना
			    $about_query = mysqli_query($conn, "SELECT * FROM ui_appointment LIMIT 1");
			    $row = mysqli_fetch_assoc($about_query);

			    // trim() लगाने से टेक्स्ट के आगे-पीछे की फालतू खाली जगह (Spaces) साफ हो जाएगी
			    $clean_subtitle = isset($row['subtitle1']) ? trim($row['subtitle1']) : '';

			    if (!empty($clean_subtitle)) {
			        // 1. आखिरी कैरेक्टर को छोड़कर पूरा टेक्स्ट निकालें
			        $mainText = mb_substr($clean_subtitle, 0, -1);

			        // 2. सिर्फ आखिरी कैरेक्टर को निकालें
			        $lastChar = mb_substr($clean_subtitle, -1);

			        // 3. दोनों को आपस में जोड़ें
			        $Subtitle1 = $mainText . '<sup>' . $lastChar . '</sup>';
			    } else {
			        $Subtitle1 = '';
			    }
			    // trim() लगाने से टेक्स्ट के आगे-पीछे की फालतू खाली जगह (Spaces) साफ हो जाएगी
			    $clean_subtitle2 = isset($row['subtitle2']) ? trim($row['subtitle2']) : '';

			    if (!empty($clean_subtitle2)) {
			        // 1. आखिरी कैरेक्टर को छोड़कर पूरा टेक्स्ट निकालें
			        $mainText2 = mb_substr($clean_subtitle2, 0, -1);

			        // 2. सिर्फ आखिरी कैरेक्टर को निकालें
			        $lastChar2 = mb_substr($clean_subtitle2, -1);

			        // 3. दोनों को आपस में जोड़ें
			        $Subtitle2 = $mainText . '<sup>' . $lastChar2 . '</sup>';
			    } else {
			        $Subtitle2 = '';
			    }
			?>
			<div class="section">
				<div class="container-fluid px-0">
					<div class="block-full-appointment bg-cover" style="background-image: url(<?php echo $row['avatar'];?> )">
						<div class="container">
							<div class="row">
								<div class="col-sm-6">
									<div class="box-progress">
										<div class="box-progress-number"><?php echo $Subtitle1;?></sup></div>
										<div class="box-progress-text"><h5><?php echo $row['title1'];?></h5>
										<p style="white-space:normal; word-wrap:break-word;overflow-wrap: break-word; text-align: justify;"><?php echo $row['about1'];?></p></div>
									</div>
									<div class="box-progress">
										<div class="box-progress-number"><?php echo $Subtitle2;?></div>
										<div class="box-progress-text"><h5><?php echo $row['title2'];?></h5>
										<p style="white-space:normal; word-wrap:break-word;overflow-wrap: break-word; text-align: justify;"><?php echo $row['about2'];?></p></div>
									</div>
								</div>
								<div class="col-sm-6 mt-5 mt-md-0 text-center text-md-right">
									<h2 class="text1">Online Appointments<br>
										and Prescriptions</h2>
									<div class="text2">You can now book a limited amount of doctors’ appointments online</div>
									<a href="index.php#" class="btn mt-2 mt-sm-3 mt-lg-4" data-toggle="modal" data-target="#modalBooking"><i class="icon-right-arrow"></i><span>Request an appointment</span><i class="icon-right-arrow"></i></a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
	    <!---======  END OPPOINTMENTS ====== --->


        <!-- ================= START DYNAMIC NEWS & EVENTS SECTION ================= -->
			<div class="section" id="newsEventsSection">
			    <div class="container">
			        
			        <div class="title-wrap text-center">
			            <div class="h-sub theme-color">Latest Updates</div>
			            <h1>News & Events</h1>
			            <div class="h-decor"></div>
			        </div>
			        <p class="text-center" style="margin-bottom: 40px;">
			            Serving the community for over 85 years with advanced medical care, comprehensive infrastructure,<br> and a deep commitment to patient recovery.
			        </p>

			        <div class="row specialist-carousel js-specialist-carousel">
			            <?php 
			                // Database से न्यूज़ का डेटा लाना
			                $news_query = mysqli_query($conn, "SELECT * FROM news_events ORDER BY id DESC LIMIT 12");
			                
			                while($news_row = mysqli_fetch_assoc($news_query)) {
			                    $News_Image   = !empty($news_row['image']) ? $news_row['image'] : 'medera/images/content/news-img-2.jpg';  
			                    $News_Title   = htmlspecialchars($news_row['title']);   
			                    $News_Desc    = htmlspecialchars($news_row['description']); 
			                    $News_Tag     = htmlspecialchars($news_row['tag']);     
			                    $News_Date    = date('d F, Y', strtotime($news_row['date']));
			                    $Id    =  $news_row['id'];
			            ?>

			                <div class="col-sm-6 col-md-4 category1">
			                    <div class="doctor-box doctor-box-style2 text-center" style="padding-bottom: 20px; background: #fff; box-shadow: 0 4px 15px rgba(0,0,0,0.03); border-radius: 2px;">
			                        
			                        <div class="doctor-box-photo" style="width: 370px; height: 361px; overflow: hidden; border-radius: 8px;">
			                            <img src="<?php echo $News_Image; ?>" style="width: 100%; height: 100%; object-fit: cover;" alt="<?php echo $News_Title; ?>">
			                            
			                            <?php if(!empty($News_Tag)) { ?>
			                            <span style="position: absolute; top: 15px; left: 15px; background: #0284c7; color: white; padding: 3px 10px; border-radius: 4px; font-size: 11px; font-weight: 600; text-transform: uppercase; z-index: 5;">
			                                <?php echo $News_Tag; ?>
			                            </span>
			                            <?php } ?>
			                        </div>
			                        
			                        <div class="doctor-box-top bg" style="padding: 15px; text-align: left;background-color: #f7;">
			                            
			                            <div style="font-size: 13px; color: #64748b; margin-bottom: 8px;">
			                                <i class="fa fa-calendar-o" style="margin-right: 5px; color: #0284c7;"></i> <?php echo $News_Date; ?>
			                            </div>
			                            
			                            <h5 class="doctor-box-name" style="font-size: 18px; font-weight: 600; line-height: 1.4; margin-bottom: 10px; min-height: 50px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
			                                <?php echo $News_Title; ?>
			                            </h5>
			                            
			                            <p style="font-size: 14px; color: #64748b; line-height: 1.6; margin-bottom: 15px; min-height: 65px; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; text-align: justify;">
			                                <?php echo $News_Desc; ?>
			                            </p>
			                            
			                            <a href="news-event?id=<?php echo $Id; ?>" class="btn-read-more" style="font-weight: 500; font-size: 14px; color: #0284c7; text-decoration: none;">
			                                <i class="icon-play" style="font-size: 11px; margin-right: 5px;"></i>Read more
			                            </a>
			                        </div>

			                    </div>
			                </div>

			            <?php 
			                } // while लूप बंद
			            ?>
			        </div>

			    </div>
			</div>
        <!-- ================= END DYNAMIC NEWS & EVENTS SECTION ================= -->


	    <!---======  START CONTACTS ====== --->
	        <?php
	            $contact = mysqli_query($conn, " SELECT * FROM ui_contact Limit 1");
	            $row = mysqli_fetch_assoc($contact);
	        ?>
			<div class="section" id="contactSection">
				<div class="banner-contact-us" style="background-image: url(<?php echo $row['avatar'];?>)">
					<div class="container">
						<div class="row no-gutters">
							<div class="col-sm-6 col-lg-6 order-2 order-sm-1 mt-3 mt-md-0 text-center text-md-right d-flex align-items-end">
								<img src="<?php echo $row['avatar2'];?>" alt="" class="shift-left">
							</div>
							<div class="col-sm-6 col-lg-6 order-1 order-sm-2 d-flex">
								<div class="pt-2 pt-lg-6">
									<h2 data-title="Looking for a Certified Doctor?"><span><?php echo $row['title1'];?> <br class="d-lg-none"> a <span class="theme-color"><?php echo $row['title2'];?></span></span></h2>
									<p><?php echo $row['about'];?></p>
									<form class="contact-form" method="post" >

										<div>
											<input type="text" class="form-control" name="name" placeholder="Your name*" required>
										</div>
										<div class="row row-sm-space mt-15">
											<div class="col-sm-6"><input type="number" class="form-control" name="phone" placeholder="Your Phone" required></div>
											<div class="col-sm-6 mt-15 mt-sm-0"><input type="text" class="form-control" name="email" placeholder="Email*" required></div>
										</div>
										<div class="mt-15">
											<textarea class="form-control" name="message" placeholder="Message" minlength="20" min="20" required></textarea>
										</div>
										<div class="mt-2 mt-lg-4 text-center text-md-left">
											<button type="submit" class="btn" name="send_message" ><i class="icon-right-arrow"></i><span>Send request</span><i class="icon-right-arrow"></i></button>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
	    <!---======  END CONTACTS ====== --->

	</div>

    <!---======  START FOOTER ====== --->
		<div class="footer mt-0">
			<div class="container">
				<div class="row py-1 py-md-2 px-lg-0">
					<div class="col-lg-4 footer-col1">
					    <iframe
					        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3589.220652519652!2d81.9468851143426!3d25.895115909386863!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x399a941c197938e5%3A0x384b8e04f52cef36!2sCanossa%20hospital!5e0!3m2!1sen!2sin!4v1593370674314!5m2!1sen!2sin"
					        style="width:100%;height:220px;border:0;"
					        allowfullscreen=""
					        loading="lazy">
					    </iframe>
					</div>

					<div class="col-sm-6 col-lg-4">
					    <ul class="icn-list">
                            <li>
					    		<header style="color:#444444; font-size: 20px;">CANOSSA HOSPITAL</header>
							</li>
                            <li>
							    <p>
							        Civil Lines, Avadh, Pratapgarh,
							        Uttar Pradesh, India, Pin:230001
							    </p>
							</li>
							<li>
								<span class="fa-stack fa-lg">
									<i class="fa fa-circle fa-stack-2x"></i>
									<i class="fa fa-calendar-o fa-stack-1x fa-inverse"></i>
								</span> Monday - Saturday, 8am to 6pm
							</li>
							<li>
								<span class="fa-stack fa-lg">
									<i class="fa fa-circle fa-stack-2x"></i>
									<i class="fa fa-phone fa-stack-1x fa-inverse"></i>
								</span> 05342-220461
							</li>
							<li>
								<span class="fa-stack fa-lg">
									<i class="fa fa-circle fa-stack-2x"></i>
									<i class="fa fa-envelope-o fa-stack-1x fa-inverse"></i>
								</span> canossa@yahoo.in
							</li>
					    </ul>
					</div>

					<div class="col-sm-6 col-lg-4">
						<ul class="list-unstyled">
							<li>
					    		<header style="color:#444444; font-size: 20px;">QUICK ACCESS</header>
							</li>
						</ul>

						<ul class="row list-unstyled li-a">
						    <li class="col-4"><a href="#home">Home</a></li>
						    <li class="col-4"><a href="about_us">About Us</a></li>
						    <li class="col-4"><a href="#departmentsSection">Departments</a></li>
						    <li class="col-4"><a href="#facilities">Facilities</a></li>
						    <li class="col-4"><a href="#servicesSection">Service</a></li>
						    <li class="col-4"><a href="#faqSection">Faq</a></li>
						    <li class="col-4"><a href="#specialistsSection">Team</a></li>
						    <li class="col-4"><a href="#contactSection">Contact Us</a></li>

						    <li class="col-4"><a href="about_us#goal">Our Goal</a></li>
						    <li class="col-4"><a href="news-event">News & Event</a></li>
						    <li class="col-4"><a href="#gallery">Gallery</a></li>
						</ul>
					</div>
				</div>
			</div>
			<div class="footer-bottom">
				<div class="container">
					<div class="row text-center text-md-left">
						<div class="col-sm">Copyright © <?php echo date('Y');?> <a href="index.php" style="text-decoration:none;">Canossa Hospital.</a> All rights reserved.
						</div>
						<div class="col-sm-auto ml-auto"><span class="d-none d-sm-inline">Developed by</span>&nbsp;&nbsp;<a href="https://www.aidcom.in" style="text-decoration:none;" target="_blank">Aidcom</a></div>
					</div>
				</div>
			</div>
		</div> 
    <!---======  END FOOTER ====== --->

	<div class="backToTop js-backToTop">
		<i class="icon icon-up-arrow"></i>
	</div>

	<style>
		.li-a li a{
			text-decoration: none;
		}

	</style>

	<!-- ====== CAROUSEL INITIALIZATION SCRIPT ====== -->
	<!-- Ise aap page ke sabse niche scripts wale area me paste kar sakte hain -->
	<script>
		$(document).ready(function(){
		    if ($('.news-carousel').length) {
		        $('.news-carousel').slick({
		            slidesToShow: 3,         // Desktop par ek sath 3 cards dikhenge
		            slidesToScroll: 1,
		            autoplay: true,          // Automatic scroll hoga
		            autoplaySpeed: 4000,     // 4 seconds ki speed
		            dots: true,              // Niche indicators dikhenge
		            arrows: false,           // Side arrows ko clean rakha hai slider UI clean karne ke liye
		            responsive: [
		                {
		                    breakpoint: 992, // Tablets ke liye
		                    settings: {
		                        slidesToShow: 2
		                    }
		                },
		                {
		                    breakpoint: 576, // Mobile screens ke liye
		                    settings: {
		                        slidesToShow: 1
		                    }
		                }
		            ]
		        });
		    }
		});
	</script>

	<style>

	    /* Slick Dots customization taaki theme ke sath blend ho jaye */
	    .slick-dots {
	        display: flex;
	        justify-content: center;
	        list-style: none;
	        padding: 0;
	        margin-top: 25px;
	    }
	    .slick-dots li {
	        margin: 0 5px;
	    }
	    .slick-dots li button {
	        font-size: 0;
	        width: 10px;
	        height: 10px;
	        border-radius: 50%;
	        background-color: #cbd5e1;
	        border: none;
	        cursor: pointer;
	        padding: 0;
	        transition: all 0.3s ease;
	    }
	    .slick-dots li.slick-active button {
	        background-color: #5C6895;
	        width: 24px;
	        border-radius: 10px;
	    }
	    .btn-read-more:hover{
	    color: #5C6895 !important;
	    }

	</style>

	<!-- REMOVED CRASHING PHP BLOCK FROM HERE -->
	<div class="modal modal-form fade" id="modalBooking">
	    <div class="modal-dialog">
	        <div class="modal-content">
	            <button aria-label='Close' class='close' data-dismiss='modal'>
	                <i class="icon-error"></i>
	            </button>
	            <div class="modal-body">
	                <div class="modal-form">
	                    <h3>Book an Appointment</h3>
	                    
	                    <form class="mt-15"  method="post" action="appointment.php">
	                        
	                        <div class="input-group">
	                            <span><i class="icon-user"></i></span>
	                            <input type="text" name="bookingname" class="form-control" autocomplete="off" placeholder="Your Name*" required/>
	                        </div>
	                        
	                        <div class="row row-xs-space mt-1">
	                            <div class="col-sm-6">
	                                <div class="input-group">
	                                    <span><i class="icon-email2"></i></span>
	                                    <input type="email" name="bookingemail" class="form-control" autocomplete="off" placeholder="Your Email*" required/>
	                                </div>
	                            </div>
	                            <div class="col-sm-6 mt-1 mt-sm-0">
	                                <div class="input-group">
	                                    <span><i class="icon-smartphone"></i></span>
	                                    <input type="text" name="bookingphone" class="form-control" autocomplete="off" placeholder="Your Phone" required/>
	                                </div>
	                            </div>
	                        </div>
	                        
	                        <div class="row row-xs-space mt-1">
	                            <div class="col-sm-6">
	                                <div class="input-group">
	                                    <span><i class="icon-birthday"></i></span>
	                                    <input type="number" name="bookingage" class="form-control" autocomplete="off" placeholder="Your age" required/>
	                                </div>
	                            </div>
	                        </div>
	                        
	                        <div class="selectWrapper input-group mt-1">
	                            <span><i class="icon-tooth"></i></span>
	                            <select name="bookingservice" class="form-control" required>
	                                <option selected="selected" disabled="disabled" value="">Select Service</option>
	                                <option value="Cosmetic Dentistry">Cosmetic Dentistry</option>
	                                <option value="General Dentistry">General Dentistry</option>
	                                <option value="Orthodontics">Orthodontics</option>
	                                <option value="Children`s Dentistry">Children`s Dentistry</option>
	                                <option value="Dental Implants">Dental Implants</option>
	                                <option value="Dental Emergency">Dental Emergency</option>
	                            </select>
	                        </div>
	                        
	                        <div class="input-group flex-nowrap mt-1">
	                            <span><i class="icon-calendar2"></i></span>
	                            <div class="datepicker-wrap">
	                                <input name="bookingdate" type="text" class="form-control datetimepicker" placeholder="Date" readonly required>
	                            </div>
	                        </div>
	                        
	                        <div class="input-group flex-nowrap mt-1">
	                            <span><i class="icon-clock"></i></span>
	                            <div class="datepicker-wrap">
	                                <input name="bookingtime" type="text" class="form-control timepicker" placeholder="Time" required>
	                            </div>
	                        </div>
	                        
	                        <textarea name="bookingmessage" class="form-control" placeholder="Your comment" minlength="20" required></textarea>
	                        
	                        <div class="text-right mt-2">
	                            <button type="submit" name="send_appointment" class="btn btn-sm btn-hover-fill">Book now</button>
	                        </div>
	                    </form>
	                </div>
	            </div>
	        </div>
	    </div>
	</div>

	<!-- Vendors -->
	<script src="medera/vendor/jquery/jquery-3.2.1.min.js"></script>	
	<script src="medera/vendor/jquery-migrate/jquery-migrate-3.0.1.min.js"></script>
	<script src="medera/vendor/cookie/jquery.cookie.js"></script>
	<script src="medera/vendor/bootstrap-datetimepicker/moment.js"></script>
	<script src="medera/vendor/bootstrap-datetimepicker/bootstrap-datetimepicker.min.js"></script>
	<script src="medera/vendor/popper/popper.min.js"></script>
	<script src="medera/vendor/bootstrap/bootstrap.min.js"></script>
	<script src="medera/vendor/waypoints/jquery.waypoints.min.js"></script>
	<script src="medera/vendor/waypoints/sticky.min.js"></script>
	<script src="medera/vendor/imagesloaded/imagesloaded.pkgd.min.js"></script>
	<script src="medera/vendor/slick/slick.min.js"></script>
	<script src="medera/vendor/scroll-with-ease/jquery.scroll-with-ease.min.js"></script>
	<script src="medera/vendor/countTo/jquery.countTo.js"></script>
	<script src="medera/vendor/form-validation/jquery.form.js"></script>
	<script src="medera/vendor/form-validation/jquery.validate.min.js"></script>
	<script src="medera/vendor/isotope/isotope.pkgd.min.js"></script>
	<!-- Custom Scripts -->
	<script src="medera/js/app.js"></script>
	<script src="medera/color/color.js"></script>
	<script src="medera/js/app-shop.js"></script>
	<script src="medera/form/forms.js"></script>

	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


	<!-- 2. CONTACT FORM SWEETALERT TRIGGER -->
		<?php if (isset($_SESSION['status'])): ?>
			<script>
			    document.addEventListener('DOMContentLoaded', function() {
			        Swal.fire({
			            title: "<?php echo ($_SESSION['status'] == 'success') ? 'Thank You!' : 'Oops!'; ?>",
			            text: "<?php echo $_SESSION['message']; ?>",
			            icon: "<?php echo $_SESSION['status']; ?>",
			            confirmButtonColor: "<?php echo ($_SESSION['status'] == 'success') ? '#4e73df' : '#d33'; ?>",
			            confirmButtonText: "OK"
			        });
			    });
			</script>
		<?php 
		    unset($_SESSION['status']);
		    unset($_SESSION['message']);
		endif; 
		?>
	<!-- 2. CONTACT FORM SWEETALERT TRIGGER -->


	<!-- 1. APPOINTMENT FORM SWEETALERT TRIGGER -->
		<?php if (isset($_SESSION['appointment_status'])): ?>
			<script>
			    document.addEventListener('DOMContentLoaded', function() {
			        Swal.fire({
			            title: "<?php echo ($_SESSION['appointment_status'] == 'success') ? 'Booking Successful!' : 'Booking Failed!'; ?>",
			            text: "<?php echo $_SESSION['appointment_message']; ?>",
			            icon: "<?php echo $_SESSION['appointment_status']; ?>",
			            confirmButtonColor: "<?php echo ($_SESSION['appointment_status'] == 'success') ? '#0284c7' : '#d33'; ?>",
			            confirmButtonText: "OK"
			        });
			    });
			</script>
		<?php 
		    unset($_SESSION['appointment_status']);
		    unset($_SESSION['appointment_message']);
		endif; 
		?>
	<!-- 1. APPOINTMENT FORM SWEETALERT TRIGGER -->


</body>
</html>