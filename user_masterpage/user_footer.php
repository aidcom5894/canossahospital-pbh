

  <footer class="d-footer">
  <div class="row align-items-center justify-content-between">
    <div class="col-auto">
        <p>Copyright &copy;  <?php echo date('Y');?>Canossa Hospital All Rights Reserved.</p>
    </div>
    <div class="col-auto">
      <p class="mb-0">Developed by <span class="text-primary-600"><a href="https://www.aidcom.in/" target="_blank"> Aidcom</a></span></p>
    </div>
  </div>
</footer>
</main>

<?php if ($showAlert): ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            title: '<?php echo $alertTitle; ?>',
            text: '<?php echo $alertText; ?>',
            icon: '<?php echo $alertIcon; ?>',
            confirmButtonColor: '<?php echo $btnColor; ?>',
            confirmButtonText: '<?php echo $btnText; ?>',
        }).then(() => {
            window.location.href = '<?php echo $alertRedirect; ?>';
        });
    });
</script>


<?php endif; ?>
  
  <!-- jQuery library js -->
  <script src="assets/js/lib/jquery-3.7.1.min.js"></script>
  <!-- Bootstrap js -->
  <script src="assets/js/lib/bootstrap.bundle.min.js"></script>
  <!-- Apex Chart js -->
  <script src="assets/js/lib/apexcharts.min.js"></script>
  <!-- Data Table js -->
  <script src="assets/js/lib/dataTables.min.js"></script>
  <!-- Iconify Font js -->
  <script src="assets/js/lib/iconify-icon.min.js"></script>
  <!-- jQuery UI js -->
  <script src="assets/js/lib/jquery-ui.min.js"></script>
  <!-- Vector Map js -->
  <script src="assets/js/lib/jquery-jvectormap-2.0.5.min.js"></script>
  <script src="assets/js/lib/jquery-jvectormap-world-mill-en.js"></script>
  <!-- Popup js -->
  <script src="assets/js/lib/magnifc-popup.min.js"></script>
  <!-- Slick Slider js -->
  <script src="assets/js/lib/slick.min.js"></script>
  <!-- prism js -->
  <script src="assets/js/lib/prism.js"></script>
  <!-- file upload js -->
  <script src="assets/js/lib/file-upload.js"></script>
  <!-- audioplayer -->
  <script src="assets/js/lib/audioplayer.js"></script>
  
  <!-- main js -->
  <script src="assets/js/app.js"></script>

<!-- <script src="assets/js/homeOneChart.js"></script> -->

</body>
</html>