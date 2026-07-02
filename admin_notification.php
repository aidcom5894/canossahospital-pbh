<?php
    header("Cache-Control: no-cache, no-store, must-revalidate"); 

    include('admin_masterpage/admin_header.php');
    include('admin_masterpage/admin_sidebar.php');
    include('admin_masterpage/admin_navbar.php');



    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    if(isset($_POST['submit'])){

        $title = mysqli_real_escape_string($conn, $_POST['title']);
        $message = mysqli_real_escape_string($conn, $_POST['message']);
        
        // 🔥 YAHAN SESSIONS SE ADMIN KI EMAIL NIKALI
        $sender_email = $_SESSION['admin']; 

        // 🔥 QUERY MEIN SENDER_EMAIL KO BHI INSERT KIYA
        $insert = mysqli_query($conn, "INSERT INTO notification (title, message, sender_email) VALUES ('$title', '$message', '$sender_email')");

        if($insert){
            echo "
            <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
            <script>
                Swal.fire({
                    title: 'Success',
                    titleText: 'Notification Sent Successfully!',
                    icon: 'success'
                }).then(() => {
                    window.location.href='admin_notification';
                });
            </script>";
            exit;
        }
    }
?>

    <div class="content-subheader">
        <div class="content-subheader__titles">
            <h2 class="content-subheader__title">Send Message to Admin</h2>
        </div>
    </div>
        
        <div class="grid grid--margin bg-white">    
            <div class="grid__row">
                <div class="grid__col grid__col--padding">
                    <h3 class="grid__col-title">Personal Information</h3>
            
                </div>      
            </div>  
            <form method="POST">
                <div class="grid__row grid__row--margin">                               
                    <div class="grid__col grid__col--13 grid__col--margin">

                        <div class="grid__row">  
                            <div class="grid__col grid__col--margin">
                                <label class="form-control form-control-xl radius-8 form__label">MESSAGE TITLE </label>
                                <input name="title" class="form__input required" placeholder="Write your message title" type="text" />  
                            </div>
                        </div>

                        <div class="grid__row">
                            <div class="grid__col grid__col--margin">
                                <label class="form__label">MESSAGE</label>
                               <textarea class="form-control form-control-xl radius-8 form__input" placeholder="Write your message"  name="message"></textarea>
                           </div>
                        </div>

                        <div class="grid__row grid__row--margin">
                            <div class="grid__col grid__col--margin">
                                <input type="submit" name="submit" class="button button--submit button--blue-bg" id="submit" value="SUBMIT" />  
                            </div>
                        </div>

                    </div>
                </div>
            </form>

        </div> <!-- End of Grid -->
        


<?php include('admin_masterpage/admin_footer.php'); ?>