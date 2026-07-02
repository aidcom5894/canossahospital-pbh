<?php
header("Cache-Control: no-cache, no-store, must-revalidate"); 

// मोबाइल व्यू, रिस्पॉन्सिवनेस और हेडर स्क्रिप्ट्स के लिए आपके डैशबोर्ड हेडर को शामिल करना जरूरी है
include('user_masterpage/user_dashboard_header.php');

// error_reporting(E_ALL);
// ini_set('display_errors', 1);

if (isset($_GET['id']) && !empty($_GET['id'])) {
    // SQL Injection से बचने के लिए ID को सुरक्षित करें
    $delete_id = mysqli_real_escape_string($conn, $_GET['id']);

    // 🌟 FIX: 'avatar' की जगह 'image' कॉलम को सिलेक्ट किया गया है
    $imgQuery = "SELECT image FROM news_events WHERE id = '$delete_id' LIMIT 1";
    $imgResult = mysqli_query($conn, $imgQuery);
    
    if (mysqli_num_rows($imgResult) > 0) {
        $row = mysqli_fetch_assoc($imgResult);
        // 🌟 FIX: यहाँ भी 'image' से डेटा निकाला गया है
        $imagePath = $row['image'];

        // अगर इमेज का पाथ डेटाबेस में मौजूद है, तो उसे सर्वर के फोल्डर से डिलीट करें
        if (!empty($imagePath)) {
            $filename = basename($imagePath);
            $targetFile = __DIR__ . "/gallery/" . $filename;
            
            if (file_exists($targetFile)) {
                unlink($targetFile); // सर्वर से फाइल डिलीट
            }
        }
    }

    // 2. डेटाबेस से रिकॉर्ड डिलीट करें
    $deleteQuery = "DELETE FROM news_events WHERE id = '$delete_id'";
    $delete = mysqli_query($conn, $deleteQuery);

    if ($delete) {
        // ठीक उसी तरह का बड़ा और परफेक्ट SweetAlert जैसा आपके news_events के सबमिट में था
        echo "
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: 'Deleted!',
                    text: 'Your record has been deleted successfully.',
                    icon: 'success',
                    iconColor: '#ef4444',
                    confirmButtonColor: '#0284c7',
                    confirmButtonText: 'Ok',
                    timer: 2500,
                    timerProgressBar: true
                }).then((result) => {
                    window.location.href = 'ui_news_event';
                });
            });
        </script>";
        exit();
    } else {
        echo "<script>alert('Error deleting record: " . mysqli_error($conn) . "'); window.location.href='ui_news_event';</script>";
        exit();
    }
} else {
    // अगर बिना ID के कोई आए तो वापस भेजें
    header("Location: ui_news_event");
    exit();
}
?>