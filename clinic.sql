-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 24, 2026 at 05:09 AM
-- Server version: 8.4.9-0ubuntu0.26.04.1
-- PHP Version: 8.5.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `clinic`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_directory`
--

CREATE TABLE `admin_directory` (
  `id` int NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `contact` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `language` varchar(50) COLLATE utf8mb4_general_ci DEFAULT 'English',
  `gender` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `department` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `designation` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `user_id` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `otp` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_directory`
--

INSERT INTO `admin_directory` (`id`, `name`, `email`, `contact`, `language`, `gender`, `dob`, `department`, `designation`, `user_id`, `password`, `avatar`, `address`, `otp`, `created_at`) VALUES
(1, 'Rahul Jaiswal', 'pclaptop794@gmail.com', '3333333333', 'English', ' Male', '2026-06-10', 'asdf', 'asdf', 'ADMRNM463', '$2y$12$MduIv58Aebqh1BXp37Q2VOb1TkN1hZebETncwj.vQ4PET4PAx0lb.', 'http://localhost/clinic//pImages/1781335110_me2.jpeg', 'asdf', NULL, '2026-06-13 01:49:33'),
(2, 'Robin Kujur', 'vrobinkujur@gmail.com', '3333333333', 'English', ' Male', '2001-01-10', 'Engineer', 'Softwar Engineer', 'ADMNYF729', '$2y$12$EuQTTSpWWeuhgvDNHyO98u0pyUvqxx2bPFGxrvDZm/xFn1VBM7oZu', 'http://localhost/clinic//pImages/1781328568_user.jpg', 'Victoriya It Park DargahMuhalla Bettiah, Bihar, India', NULL, '2026-06-13 01:50:00');

-- --------------------------------------------------------

--
-- Table structure for table `appointment`
--

CREATE TABLE `appointment` (
  `id` int NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `age` int NOT NULL,
  `service` varchar(150) COLLATE utf8mb4_general_ci NOT NULL,
  `appointment_date` date NOT NULL,
  `appointment_time` time NOT NULL,
  `message` text COLLATE utf8mb4_general_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contact_form`
--

CREATE TABLE `contact_form` (
  `id` int NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `message` text COLLATE utf8mb4_general_ci NOT NULL,
  `registration_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `news_events`
--

CREATE TABLE `news_events` (
  `id` int NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(255) NOT NULL DEFAULT 'img/news/default.jpg',
  `tag` varchar(50) DEFAULT 'Announcement',
  `date` date NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `news_events`
--

INSERT INTO `news_events` (`id`, `title`, `description`, `image`, `tag`, `date`, `created_at`) VALUES
(1, 'INDEPENDENCE DAY CELEBRATION 2020', 'As we honour our nation on its 74th independence day,The Canossian Hospital, Pratapgarh , joined the countrymen to pay homage to India and the brave soldiers who fought for the freedom. All of us gathered in the hospital premise in the morning hours. Rev. Fr. Anil Michael the parish priest and the chief guest of the function hoisted the flag and gave the Independence Day message. He paid rich tribute to all labored to build the prosperous nation that we possess today. He exhorted all in his message to maintain constant vigil in order not to slip in to any kind of slavery and lost the freedom which was won with a great prize Then the hospital staff presented a brief cultural fest including dances and singing patriotic song. The beautiful program added colour and meaning to our Independence Day celebration. The sweets distributed at the end of the program delighted everyone and made short celebration memorable.', 'gallery/1781921703_AUG15-1.jpg', 'Celebration', '2020-08-15', '2026-06-19 21:18:18'),
(2, 'INDEPENDENCE DAY CELEBRATION 2021', '15th August 2021, we had gathered in frond of the canossa Hospital for the flag hoisting . Rev Sr. Blandina Rodrigues our chief guest hoisted the flag and gave a meaningful message about freedom and slavery .There after we had a small cultural programme and followed by sweet distribution.', 'gallery/1781919839_new16.jpg', 'Celebration', '2021-08-15', '2026-06-20 01:43:59'),
(3, 'Hospital Mission', '\"Our mission is to deliver accessible and patient-centered healthcare services with excellence, compassion, and integrity. We are committed to:Serving all people regardless of their social, economic, or religious background.Promoting health, venting disease, and improving community well-being.Providing safe, ethical, and high-quality medical care.Supporting the needy through charitable healthcare initiatives.Upholding respect, dignity, and compassion in every patient encounter.\"', 'gallery/1781920177_new20.jpg', 'Camp', '2024-02-15', '2026-06-20 01:49:37'),
(5, 'Rahul Jaiswal', 'Rahul Jaiswal', 'gallery/1781930445_nicu3.jpg', 'Rahul Jaiswal', '2026-07-10', '2026-06-20 04:40:04');

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `id` int NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `message` text COLLATE utf8mb4_general_ci NOT NULL,
  `sender_email` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notification`
--

INSERT INTO `notification` (`id`, `title`, `message`, `sender_email`, `created_at`) VALUES
(51, 'sdfgsdfgsdfg', 'sdfgsdfgsdfg', 'vrobinkujur@gmail.com', '2026-06-15 18:59:47'),
(53, 'asdfas', 'asdf', 'pclaptop794@gmail.com', '2026-06-15 19:09:45');

-- --------------------------------------------------------

--
-- Table structure for table `ui_about`
--

CREATE TABLE `ui_about` (
  `id` int NOT NULL,
  `about_title` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `heading` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `about` text COLLATE utf8mb4_general_ci,
  `about_line1` text COLLATE utf8mb4_general_ci,
  `about_line2` text COLLATE utf8mb4_general_ci,
  `about_line3` text COLLATE utf8mb4_general_ci,
  `avatar` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `avatar2` varchar(360) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `video` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ui_about`
--

INSERT INTO `ui_about` (`id`, `about_title`, `heading`, `about`, `about_line1`, `about_line2`, `about_line3`, `avatar`, `avatar2`, `video`, `updated_at`) VALUES
(1, '85 Years of Medical Excellence', 'The Heart and Science of Medicine', 'We help your body restore itself by harnessing your own healing potential with a variety of techniques to combat areas of disease, injury or inflammation. This process involves a variety of techniques including a minimally invasive procedure conducted right in our clinic.', 'Equipped for all stages of care, from prevention to rehabilitation', 'Quality assessment program helps ensure smooth, effective operation', 'Prepared to treat a high volume of trauma patients 24/7', 'hImages/1781639899_1_pharmacy1.jpg', 'hImages/1781635653_2_video-poster-bg.png', 'hImages/1781637441_Short Animated Medical Laboratory Video_1080p.mp4', '2026-06-19 04:12:23');

-- --------------------------------------------------------

--
-- Table structure for table `ui_appointment`
--

CREATE TABLE `ui_appointment` (
  `id` int NOT NULL,
  `title1` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `about1` text COLLATE utf8mb4_general_ci,
  `subtitle1` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `title2` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `about2` text COLLATE utf8mb4_general_ci,
  `subtitle2` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `avatar` varchar(360) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `registration_date` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ui_appointment`
--

INSERT INTO `ui_appointment` (`id`, `title1`, `about1`, `subtitle1`, `title2`, `about2`, `subtitle2`, `avatar`, `registration_date`) VALUES
(1, 'Cured Patients ', 'For over 15 years, we have delighted our customers and provide them with the necessary services. ', '150K', 'Happy Clients', 'Absolutely all our clients are ready to assure you of the high quality of our services.', '100%', 'hImages/1781668354_1_online-appointment-bg.jpg', '2026-06-17 08:40:09');

-- --------------------------------------------------------

--
-- Table structure for table `ui_contact`
--

CREATE TABLE `ui_contact` (
  `id` int NOT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `avatar2` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `title1` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `title2` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `about` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `registration_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ui_contact`
--

INSERT INTO `ui_contact` (`id`, `avatar`, `avatar2`, `title1`, `title2`, `about`, `registration_date`) VALUES
(1, 'http://localhost/clinic//hImages/1781594724_1_contact-bg.png', 'http://localhost/clinic//hImages/1781594724_2_banner-callus.png', 'Looking for a', 'Certified Doctor?', ' We believe in providing the best possible care to all our existing patients and welcome new patients to sample.', '2026-06-16 07:10:55');

-- --------------------------------------------------------

--
-- Table structure for table `ui_dim`
--

CREATE TABLE `ui_dim` (
  `id` int NOT NULL,
  `name` varchar(360) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `post` varchar(360) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `about` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `avatar` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `registration_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ui_dim`
--

INSERT INTO `ui_dim` (`id`, `name`, `post`, `about`, `avatar`, `registration_date`) VALUES
(2, 'SR.ZINIA DE SOUZA', 'President', 'It’s my joy to introduce this website to all of you. It will give you a glimpse of Canossa hospital at Pratapgarh U.P, India. Today Canossa Hospital has made great strides to bring healing to a large number of people in the vicinity and in the nearby villages.It has a long history of evolution since 1935, from a humble beginning of dispensing medicine and teaching home remedies in the villages to a registered Hospital with 03 residential Doctors, 35 staff Nurses, 02 office staff 10 supportive staff; who are serving daily around 100-120 patients. We owe our gratitude to the panniers who worked tirelessly for thegrowth and development of Canossa Hospital. We also appreciate oursisters, doctors, Nurses and the employees who work withgenerosity and commitment. May this abode of healing continue to promote holistic health and prolife and may the Almighty God accompany all with His blessing.\r\nSR.ZINIA DE SOUZA - PROVINCE LEADER\r\nQueen of Peace Province,Lucknow', 'http://localhost/clinic//gallery/1781894041_srzinia.jpg', '2026-06-19 17:08:56'),
(3, 'SR. LEENA D\'SOUZA', 'Coordinator', '\"As the Coordinator of Canossa Hospital, it is my privilege to welcome you to an institution that has been a beacon of hope and healing in Pratapgarh since 1938. Following the holy spirit and charism of our Foundress, St. Magdalene of Canossa, we do not view healthcare merely as a medical service, but as a sacred mission of love, dignity, and comfort.\r\n\r\nOur ultimate goal is to bridge the rural healthcare gap by delivering accessible, affordable, and high-quality treatments to everyone, especially the poor, vulnerable, and underserved families of our society. From our humble origins as a small mobile clinic to a trusted 70-bed medical center, our dedicated team of doctors, GNM/ANM nurses, and supportive staff work tirelessly around the clock to treat our patients like family. We remain deeply committed to integrated community growth, preventive care, and ensuring that clinical excellence is a basic right accessible to everyone. May God bless you with good health and holistic well-being.\"', 'http://localhost/clinic//gallery/1781889077_srleena.jpg', '2026-06-19 17:10:54'),
(4, 'SR. LISA THUNDIYIL', 'Councillor-Incharge of PSC', 'Dear Friends, The Canossa (Mother) Hospital has been serving the people of Pratapgarh (U.P) for the last eight decades, with much dedication and commitment.We communicate and transmit the compassionate love of THE AUTHORE OF LIFE by comforting, assisting and instructing all who come to our Hospital, and there by providing holistic care. Prolife is our topmost aim; therefore the mother and child care is our first priority; as we know they are the most vulnerable and soft targets of social evil and atrocity in the society God has given us a life which is precious and priceless so it is the responsibility of all to respect, protect, promote and nurture the life of oneself and others.\r\nSR. LISA THUNDIYIL', 'http://localhost/clinic//gallery/1781894176_srlisa.jpg', '2026-06-19 17:14:27'),
(5, 'SR. ANITA CHILAMPIL', 'Administrator', '\"As the Administrator of Canossa Hospital, my primary focus is to uphold the highest standards of healthcare delivery, clinical excellence, and ethical management. Guided by the timeless vision of St. Magdalene of Canossa, we strive to manage this 70-bed institution with total transparency, efficiency, and a deep-rooted commitment to the community of Pratapgarh.\r\n\r\nMy administration ensures that modern medical advancements, expert staff management, and well-equipped infrastructure remain accessible to all sections of society, regardless of their social, economic, or religious backgrounds. We actively work towards bridging the medical gap in underserved rural sectors through structured medical camps and weekly mobile clinics. Our administrative priority is to provide a safe, compassionate, and patient-centered environment where healthcare is treated as a fundamental human right rather than a privilege. We thank you for your enduring trust in \'Mother Hospital\' and assure you of our selfless service, always.\"', 'http://localhost/clinic//gallery/1781894725_sranita.jpg', '2026-06-19 18:45:25'),
(6, 'SR. VINCY JAMES', 'Director', '\"From the very inception of Canossa Hospital, our journey in Pratapgarh has been defined not by the number of patients we treat, but by the lives we touch and heal. As the Director, I look back at our legacy as \'Mother Hospital\' with deep gratitude and look forward with a renewed commitment to our sacred calling. Following the footsteps of St. Magdalene of Canossa, our leadership is dedicated to ensuring that true healing goes beyond prescriptions and reaches the hearts of the broken, the poor, and the marginalized.\r\n\r\nHealthcare is rapidly evolving, but our core value remains unshakable: unconditional service to humanity. We are actively expanding our reach deep into the rural sectors of Pratapgarh through our weekly mobile health clinics and specialized medical camps, ensuring that quality healthcare is never a luxury out of reach for anyone. Together with our administrative team, dedicated doctors, and compassionate nursing sisters, we strive to maintain clinical excellence while keeping our doors open to all, regardless of background or financial status. We thank you for welcoming us into your families for generations, and we pledge to continue serving you with the highest standard of medical ethics, love, and professional care.\"', 'medikit/images/default-avatar.png', '2026-06-19 18:57:07');

-- --------------------------------------------------------

--
-- Table structure for table `ui_faci`
--

CREATE TABLE `ui_faci` (
  `id` int NOT NULL,
  `title` varchar(360) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `about` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `avatar` varchar(360) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `registration_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ui_faci`
--

INSERT INTO `ui_faci` (`id`, `title`, `about`, `avatar`, `registration_date`) VALUES
(2, 'In-House Pharmacy', 'A well-stocked, 24/7 internal pharmacy providing authentic, high-quality, and affordable medicines to meet all inpatient and outpatient needs promptly.', 'http://localhost/clinic//hImages/1781844634_pharmacy2.jpg', '2026-06-18 19:58:10'),
(3, 'Infertility Treatment', 'Expert consultations and compassionate medical care for couples seeking specialized guidance and reproductive health treatments.', 'http://localhost/clinic//hImages/1781844449_gallery2.jpg', '2026-06-18 20:08:12'),
(4, '24/7 Residential Medical Staff', 'Doctors\' quarters and Nurses\' hostel available inside the campus, ensuring prompt medical response and continuous care.', 'http://localhost/clinic//hImages/1781844162_new2.jpg', '2026-06-18 20:08:29'),
(5, '70-Bed Inpatient Ward', 'Fully equipped, comfortable general and specialized wards offering round-the-clock nursing care and patient monitoring.', 'http://localhost/clinic//hImages/1781844061_ot1.jpg', '2026-06-18 20:08:41'),
(6, 'Paediatric Care', 'Dedicated medical attention and treatment for infants, children, and adolescents, ensuring a healthier future generation.', 'http://localhost/clinic//hImages/1781843767_peadiatric-pic.png', '2026-06-18 20:09:30'),
(7, 'Obstetrics & Gynaecology', 'Specialized healthcare for women, handling comprehensive pregnancy care, safe deliveries, and advanced maternal treatments.', 'http://localhost/clinic//hImages/1781843670_gynacologist-pic.png', '2026-06-18 20:10:22');

-- --------------------------------------------------------

--
-- Table structure for table `ui_faq`
--

CREATE TABLE `ui_faq` (
  `id` int NOT NULL,
  `name` varchar(360) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `ques1` varchar(255) DEFAULT NULL,
  `ans1` text,
  `ques2` varchar(255) DEFAULT NULL,
  `ans2` text,
  `ques3` varchar(255) DEFAULT NULL,
  `ans3` text,
  `ques4` varchar(255) DEFAULT NULL,
  `ans4` text,
  `avatar` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `ui_faq`
--

INSERT INTO `ui_faq` (`id`, `name`, `ques1`, `ans1`, `ques2`, `ans2`, `ques3`, `ans3`, `ques4`, `ans4`, `avatar`, `created_at`) VALUES
(1, 'Patient Information', 'How do I make an appointment?', 'If you would like to make an appointment with one of our practitioners, please contact our reception staff. Alternatively you may book your appointments online. Every effort will be made to accommodate your preferred time and choice of practitioner.', 'How do I get a copy of my records to another provider?', 'Everyone’s needs are different, so have a chat to your dentist about how often you need to have your teeth checked by them based on the condition of your mouth, teeth and gums. It’s recommended that children see their dentist at least once a year.', 'Is there a charge for copies of my medical record?', 'Everyone’s needs are different, so have a chat to your dentist about how often you need to have your teeth checked by them based on the condition of your mouth, teeth and gums. It’s recommended that children see their dentist at least once a year.', 'How do I assure that my person I designate has access to my medical records?', 'Everyone’s needs are different, so have a chat to your dentist about how often you need to have your teeth checked by them based on the condition of your mouth, teeth and gums. It’s recommended that children see their dentist at least once a year.', 'hImages/1781691945_1_aaa.png', '2026-06-17 09:41:26');

-- --------------------------------------------------------

--
-- Table structure for table `ui_gallery`
--

CREATE TABLE `ui_gallery` (
  `id` int NOT NULL,
  `category` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `avatar` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `registration_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ui_gallery`
--

INSERT INTO `ui_gallery` (`id`, `category`, `avatar`, `registration_date`) VALUES
(1, 'Event', 'http://localhost/clinic//gallery/1781867141_AUG15-2.jpg', '2026-06-19 11:05:41'),
(2, 'Event', 'http://localhost/clinic//gallery/1781868002_med-camp1.jpg', '2026-06-19 11:19:18'),
(3, 'Event', 'http://localhost/clinic//gallery/1781868061_homepage-pic-shade.png', '2026-06-19 11:21:01'),
(4, 'Event', 'http://localhost/clinic//gallery/1781868072_about-img1.jpg', '2026-06-19 11:21:12'),
(5, 'Event', 'http://localhost/clinic//gallery/1781868089_aboutus-bg.jpg', '2026-06-19 11:21:29'),
(6, 'National Holiday', 'http://localhost/clinic//gallery/1781868129_new25.jpg', '2026-06-19 11:22:09'),
(7, 'National Holiday', 'http://localhost/clinic//gallery/1781868146_new20.jpg', '2026-06-19 11:22:26'),
(8, 'National Holiday', 'http://localhost/clinic//gallery/1781868170_new20.jpg', '2026-06-19 11:22:32'),
(9, 'National Holiday', 'http://localhost/clinic//gallery/1781868186_new21.jpg', '2026-06-19 11:23:06'),
(10, 'National Holiday', 'http://localhost/clinic//gallery/1781868211_AUG15-2.jpg', '2026-06-19 11:23:31'),
(11, 'Function', 'http://localhost/clinic//gallery/1781868228_new25.jpg', '2026-06-19 11:23:48'),
(12, 'Function', 'http://localhost/clinic//gallery/1781868240_new24.jpg', '2026-06-19 11:24:00'),
(13, 'Function', 'http://localhost/clinic//gallery/1781868257_new19.jpg', '2026-06-19 11:24:17'),
(14, 'Function', 'http://localhost/clinic//gallery/1781868270_new18.jpg', '2026-06-19 11:24:30'),
(15, 'Function', 'http://localhost/clinic//gallery/1781868285_new17.jpg', '2026-06-19 11:24:45'),
(16, 'Function', 'http://localhost/clinic//gallery/1781868302_new16.jpg', '2026-06-19 11:25:02'),
(17, 'Event', 'http://localhost/clinic//gallery/1781868314_new4.jpg', '2026-06-19 11:25:14'),
(18, 'Event', 'http://localhost/clinic//gallery/1781868323_gallery4.jpg', '2026-06-19 11:25:23'),
(19, 'Event', 'http://localhost/clinic//gallery/1781868340_vaccination1.jpg', '2026-06-19 11:25:40'),
(20, 'Event', 'http://localhost/clinic//gallery/1781868360_pharmacy2.jpg', '2026-06-19 11:26:00'),
(21, 'Event', 'http://localhost/clinic//gallery/1781868371_pharmacy1.jpg', '2026-06-19 11:26:11');

-- --------------------------------------------------------

--
-- Table structure for table `ui_home`
--

CREATE TABLE `ui_home` (
  `id` int NOT NULL,
  `heading` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `registration_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ui_home`
--

INSERT INTO `ui_home` (`id`, `heading`, `avatar`, `registration_date`) VALUES
(10, 'CANOSSA HOSPITAL PRATAPGARH', 'http://localhost/clinic//hImages/1781943416_gallery6.jpg', '2026-06-16 05:15:21'),
(11, 'CANOSSA HOSPITAL PRATAPGARH', 'http://localhost/clinic//hImages/1781719417_why-choose-us.png', '2026-06-16 05:15:46'),
(13, 'CANOSSA HOSPITAL PRATAPGARH', 'http://localhost/clinic//hImages/1781943839_new25.jpg', '2026-06-16 06:11:46'),
(14, 'CANOSSA HOSPITAL PRATAPGARH', 'http://localhost/clinic//hImages/1781943797_new2.jpg', '2026-06-16 06:44:36');

-- --------------------------------------------------------

--
-- Table structure for table `ui_service`
--

CREATE TABLE `ui_service` (
  `id` int NOT NULL,
  `heading` varchar(360) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `subtitle` varchar(360) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `line1` varchar(360) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `line2` varchar(360) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `line3` varchar(360) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `line4` varchar(360) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `line5` varchar(360) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `avatar` varchar(360) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `registration_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ui_service`
--

INSERT INTO `ui_service` (`id`, `heading`, `subtitle`, `line1`, `line2`, `line3`, `line4`, `line5`, `avatar`, `registration_date`) VALUES
(1, 'Primary Care Physicia', 'MedAll Centre provides the following healthcare services:', 'Complete Family Health Care', 'X-Ray', 'EKG', 'Ultrasound', 'Acute and Chronic Care', 'http://localhost/clinic//hImages/1781743242_medicine-pic.png', '2026-06-17 17:31:26'),
(3, 'Holistic Wellness', 'A lifestyle of holistic wellness rewards you with enhanced health', 'Weight loss', 'Therapeutic Medical Massage', 'Holistic Skin Care', 'K-laser Pain Management', 'Ayurveda & Detoxification', 'http://localhost/clinic//hImages/1781844767_surgion-pic.png', '2026-06-17 17:50:32'),
(5, 'Allergy and Immunology', 'You should feel your best no matter the season. ', 'Allergy and Immunology Conditions', 'Testing for Allergy and Immunology', 'Allergy and Immunology Treatments', 'Asthma Care', 'Pediatric Allergy and Immunology', 'http://localhost/clinic//hImages/1781742426_mfavicon.png', '2026-06-17 18:09:12');

-- --------------------------------------------------------

--
-- Table structure for table `ui_team`
--

CREATE TABLE `ui_team` (
  `id` int NOT NULL,
  `name` varchar(360) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `department` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `avatar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `registration_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ui_team`
--

INSERT INTO `ui_team` (`id`, `name`, `department`, `avatar`, `registration_date`) VALUES
(1, 'Dr. Berry Gardner', 'Cardiolog', 'http://localhost/clinic//hImages/1781716556_doctor-03.jpg', '2026-06-17 05:38:22'),
(3, 'Dr. Terri Williams', 'Psychiatrist', 'http://localhost/clinic//hImages/1781678573_doctor-05.jpg', '2026-06-17 06:16:19'),
(4, 'Dr. Robert Rush', 'Cardiolog', 'http://localhost/clinic//hImages/1781678558_doctor-04.jpg', '2026-06-17 06:16:46'),
(5, 'Dr. Terri Williams', 'Cardiolog', 'http://localhost/clinic//hImages/1781677030_doctor-01.jpg', '2026-06-17 06:17:10'),
(6, 'Dr. William Gardner', 'Psychiatrist', 'http://localhost/clinic//hImages/1781716516_img-1.jpg', '2026-06-17 07:08:53');

-- --------------------------------------------------------

--
-- Table structure for table `ui_why`
--

CREATE TABLE `ui_why` (
  `id` int NOT NULL,
  `title1` varchar(360) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `subtitle1` varchar(360) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `title2` varchar(360) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `subtitle2` varchar(360) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `title3` varchar(360) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `subtitle3` varchar(360) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `avatar` varchar(360) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `registration_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ui_why`
--

INSERT INTO `ui_why` (`id`, `title1`, `subtitle1`, `title2`, `subtitle2`, `title3`, `subtitle3`, `avatar`, `registration_date`) VALUES
(1, 'Patient-Centred', 'While our team brings important experience and knowledge, we know that each patient is the expert in their own life.\r\n', 'Comprehensive', 'We have flexible hours and are open on certain evenings and during the weekend, to accommodate your schedule.', 'Patient-Centred', 'We have flexible hours and are open on certain evenings and during the weekend, to accommodate your schedule.', 'hImages/1781747624_1_about-img1.jpg', '2026-06-18 01:02:32');

-- --------------------------------------------------------

--
-- Table structure for table `user_directory`
--

CREATE TABLE `user_directory` (
  `id` int NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `contact` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `language` varchar(50) COLLATE utf8mb4_general_ci DEFAULT 'English',
  `gender` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `department` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `designation` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `user_id` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `otp` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `address` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `otp_count` int DEFAULT '0',
  `last_otp_request` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_directory`
--

INSERT INTO `user_directory` (`id`, `name`, `email`, `contact`, `language`, `gender`, `dob`, `department`, `designation`, `user_id`, `password`, `avatar`, `otp`, `address`, `created_at`, `otp_count`, `last_otp_request`) VALUES
(1, 'Rahul Jaiswal', 'pclaptop794@gmail.com', '3333333333', 'English', 'Male', '2026-06-26', 'asdf', 'asdf', 'ADMDFR385', '$2y$12$yWUdltRWp8e5RafX8T9SGuZuX1HUUGXFPrmW/TWDhxTaERlD1mYO2', 'http://localhost/clinic//pImages/1781503723_me2.jpeg', '424641', 'asdf', '2026-06-15 06:07:31', 3, '2026-06-15 06:26:41'),
(2, 'Sunny Jaiswal', 'sunnyjaiswal@gmail.com', '3333333333', 'Nepali', 'Male', '2026-08-03', 'Dance', 'Cultural adsf', 'ADMARJ761', '$2y$12$9uY65eVWUugnSxDPgKG9Z.MeqY83j1GiG4luq4i0EfjtExx1uW632', 'http://localhost/clinic//pImages/1781547010_brother.png', NULL, 'asdfasdfsdafasdfasdfsda', '2026-06-15 06:19:46', 0, NULL),
(3, 'Chandan Jaiswal', 'cjl@gmail.com', '7292818092', 'English', 'Male', '2026-06-19', 'Development', 'Software Developer', 'ADMKMH205', '$2y$12$6ljs41h6czHZTx/xdq13uOK9KyROm.PNW0SDbEABCra1higzqp3q6', 'http://localhost/clinic//pImages/1781504749_user.jpg', NULL, 'Victoriya It Park , Bettiah', '2026-06-15 06:23:53', 0, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_directory`
--
ALTER TABLE `admin_directory`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `appointment`
--
ALTER TABLE `appointment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_form`
--
ALTER TABLE `contact_form`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `news_events`
--
ALTER TABLE `news_events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ui_about`
--
ALTER TABLE `ui_about`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ui_appointment`
--
ALTER TABLE `ui_appointment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ui_contact`
--
ALTER TABLE `ui_contact`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ui_dim`
--
ALTER TABLE `ui_dim`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ui_faci`
--
ALTER TABLE `ui_faci`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ui_faq`
--
ALTER TABLE `ui_faq`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ui_gallery`
--
ALTER TABLE `ui_gallery`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ui_home`
--
ALTER TABLE `ui_home`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ui_service`
--
ALTER TABLE `ui_service`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ui_team`
--
ALTER TABLE `ui_team`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ui_why`
--
ALTER TABLE `ui_why`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_directory`
--
ALTER TABLE `user_directory`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_directory`
--
ALTER TABLE `admin_directory`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `appointment`
--
ALTER TABLE `appointment`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contact_form`
--
ALTER TABLE `contact_form`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `news_events`
--
ALTER TABLE `news_events`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `ui_about`
--
ALTER TABLE `ui_about`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ui_appointment`
--
ALTER TABLE `ui_appointment`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ui_contact`
--
ALTER TABLE `ui_contact`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ui_dim`
--
ALTER TABLE `ui_dim`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `ui_faci`
--
ALTER TABLE `ui_faci`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `ui_faq`
--
ALTER TABLE `ui_faq`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ui_gallery`
--
ALTER TABLE `ui_gallery`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `ui_home`
--
ALTER TABLE `ui_home`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `ui_service`
--
ALTER TABLE `ui_service`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `ui_team`
--
ALTER TABLE `ui_team`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `ui_why`
--
ALTER TABLE `ui_why`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user_directory`
--
ALTER TABLE `user_directory`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
