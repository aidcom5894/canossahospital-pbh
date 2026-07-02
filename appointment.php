<?php
    // 1. सबसे पहले सेशन स्टार्ट करें
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    

    // error_reporting(E_ALL);
    // ini_set('display_errors', 1);


    // डेटाबेस कनेक्शन फ़ाइल शामिल करें
    include('config.php'); 

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require 'PHPMailer/src/PHPMailer.php';
    require 'PHPMailer/src/SMTP.php';
    require 'PHPMailer/src/Exception.php';

    if(isset($_POST['send_appointment']))
    {   
        $Name    = mysqli_real_escape_string($conn, trim($_POST['bookingname']));
        $Phone   = mysqli_real_escape_string($conn, trim($_POST['bookingphone']));
        $Email   = mysqli_real_escape_string($conn, trim($_POST['bookingemail']));
        $Age     = mysqli_real_escape_string($conn, trim($_POST['bookingage']));
        $Service = mysqli_real_escape_string($conn, trim($_POST['bookingservice']));

        // तारीख को DD/MM/YYYY से YYYY-MM-DD में बदलें
        $rawDate = trim($_POST['bookingdate']);
        if (!empty($rawDate)) {
            $dateObj = DateTime::createFromFormat('d/m/Y', $rawDate);
            $Date = $dateObj ? $dateObj->format('Y-m-d') : date('Y-m-d');
        } else {
            $Date = date('Y-m-d');
        }
        $Date = mysqli_real_escape_string($conn, $Date);

        // समय को 12-घंटे AM/PM से 24-घंटे (H:i:s) में बदलें
        $rawTime = trim($_POST['bookingtime']);
        if (!empty($rawTime)) {
            $timeObj = DateTime::createFromFormat('g:i A', $rawTime) ?: DateTime::createFromFormat('h:i A', $rawTime);
            $Time = $timeObj ? $timeObj->format('H:i:s') : date('H:i:s');
        } else {
            $Time = date('H:i:s');
        }
        $Time = mysqli_real_escape_string($conn, $Time);
        
        $Message = mysqli_real_escape_string($conn, trim($_POST['bookingmessage']));

        $insertQuery = "INSERT INTO appointment (name, email, phone, age, service, appointment_date, appointment_time, message) 
                        VALUES ('$Name', '$Email', '$Phone', '$Age', '$Service', '$Date', '$Time', '$Message')";
        
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

                $mail->setFrom('support@aidcombizcard.in', 'Canossa Hospital');
                $mail->addAddress($Email);

                $mail->isHTML(true);
                $mail->Subject = 'New Appointment Booking Request from ' . $Name;

                $mail->Body = "
                <div style='font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; border: 1px solid #e1e1e1; border-radius: 8px; overflow: hidden;'>
                    <div style='background-color: #0284c7; color: #ffffff; padding: 20px; text-align: center;'>
                        <h2 style='margin: 0; font-size: 22px; font-weight: 600;'>Canossa Hospital</h2>
                        <p style='margin: 5px 0 0 0; font-size: 14px; opacity: 0.9;'>New Appointment Booking Received</p>
                    </div>
                    <div style='padding: 24px; background-color: #fcfcfc;'>
                        <p style='font-size: 15px; color: #555; margin-top: 0;'>Dear Admin,</p>
                        <p style='font-size: 15px; color: #555;'>You have received a new patient appointment request from your website booking portal. Below are the complete schedule and patient details:</p>
                        <table style='width: 100%; border-collapse: collapse; margin: 20px 0; background-color: #ffffff;'>
                            <tr><td style='padding: 12px; border: 1px solid #eeeeee; font-weight: bold; width: 35%; color: #444; background-color: #f9f9f9;'>Patient Name</td><td style='padding: 12px; border: 1px solid #eeeeee; color: #222;'>$Name</td></tr>
                            <tr><td style='padding: 12px; border: 1px solid #eeeeee; font-weight: bold; color: #444; background-color: #f9f9f9;'>Age</td><td style='padding: 12px; border: 1px solid #eeeeee; color: #222;'>$Age Years</td></tr>
                            <tr><td style='padding: 12px; border: 1px solid #eeeeee; font-weight: bold; color: #444; background-color: #f9f9f9;'>Phone Number</td><td style='padding: 12px; border: 1px solid #eeeeee; color: #222;'>$Phone</td></tr>
                            <tr><td style='padding: 12px; border: 1px solid #eeeeee; font-weight: bold; color: #444; background-color: #f9f9f9;'>Email Address</td><td style='padding: 12px; border: 1px solid #eeeeee; color: #0284c7;'>$Email</td></tr>
                            <tr><td style='padding: 12px; border: 1px solid #eeeeee; font-weight: bold; color: #444; background-color: #f9f9f9;'>Requested Service</td><td style='padding: 12px; border: 1px solid #eeeeee; color: #222; font-weight: 600;'>$Service</td></tr>
                            <tr><td style='padding: 12px; border: 1px solid #eeeeee; font-weight: bold; color: #444; background-color: #f9f9f9;'>Appointment Date</td><td style='padding: 12px; border: 1px solid #eeeeee; color: #e33d55; font-weight: 600;'>$Date</td></tr>
                            <tr><td style='padding: 12px; border: 1px solid #eeeeee; font-weight: bold; color: #444; background-color: #f9f9f9;'>Appointment Time</td><td style='padding: 12px; border: 1px solid #eeeeee; color: #e33d55; font-weight: 600;'>$Time</td></tr>
                            <tr><td style='padding: 12px; border: 1px solid #eeeeee; font-weight: bold; color: #444; background-color: #f9f9f9;'>Patient Comments</td><td style='padding: 12px; border: 1px solid #eeeeee; color: #222; white-space: pre-line;'>$Message</td></tr>
                        </table>
                        <p style='font-size: 13px; color: #666; margin-bottom: 0;'><i>* This is an automated system-generated verification. Please coordinate with the clinical staff to confirm or reschedule this slot.</i></p>
                    </div>
                    <div style='background-color: #f1f5f9; padding: 15px; text-align: center; border-top: 1px solid #e2e8f0; font-size: 12px; color: #64748b;'>
                        &copy; " . date('Y') . " Canossa Hospital Management System. All Rights Reserved. <br>
                        Powered by <a href='https://www.aidcom.in' target='_blank' style='color: #0284c7; text-decoration: none; font-weight: bold;'>Aidcom</a>
                    </div>
                </div>
                ";

                $mail->send();

                $_SESSION['appointment_status'] = "success";
                $_SESSION['appointment_message'] = "Your appointment request has been submitted and email confirmation sent successfully!";

            } catch (Exception $e) {
                $_SESSION['appointment_status'] = "success";
                $_SESSION['appointment_message'] = "Appointment saved in database, but confirmation email could not be routed.";
            }
            
            // CHANGED: रिडायरेक्ट टू index.php
            header("Location: " . $base_url);
            exit();
        } else {
            $_SESSION['appointment_status'] = "error";
            $_SESSION['appointment_message'] = "Database Error: " . mysqli_error($conn);
            
            // CHANGED: रिडायरेक्ट टू ui
            header("Location: " . $base_url);
            exit();
        }
    }   
?>