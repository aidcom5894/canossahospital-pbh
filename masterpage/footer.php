



</div></div>

    <script src="medikit/js/jquery-3.3.1.min.js"></script>
    <script src="medikit/js/Chart.min.js"></script>
    <script src="medikit/js/chartjs-plugin-style.min.js"></script>
    <script src="medikit/js/charts-custom-dashboard.js"></script>
    <script src="medikit/js/moment.min.js"></script>
    <script src="medikit/js/calendar.js"></script>
    <script src="medikit/js/swiper.min.js"></script>
    <script src="medikit/js/select2.min.js"></script>
    <script src="medikit/js/jquery.scrollbar.js"></script>
    <script src="medikit/js/jquery.countdown.min.js"></script>
    <script src="medikit/js/daterangepicker.min.js"></script>
    <script src="medikit/js/ion.rangeSlider.min.js"></script>
    <script src="medikit/js/jquery.dashboard-custom.js"></script>




<script>
$(document).ready(function() {
    // 1. Dropdown Toggle Fix (Profile, Notifications, Quicklinks)
    $('.content-header__dropdown-activate').on('click', function(e) {
        e.stopPropagation();
        var dropdownId = $(this).attr('data-dropdown');
        var $targetDropdown = $('#' + dropdownId);

        // Baaki sabhi dropdowns ko band karo pehle
        $('.dropdown-menu--header').not($targetDropdown).removeClass('active').hide();

        // Is waale ko toggle karo
        if ($targetDropdown.is(':visible')) {
            $targetDropdown.removeClass('active').hide();
        } else {
            $targetDropdown.addClass('active').show();
        }
    });

    // 2. Dashboard Specific Content Dropdowns (Like 'Edit your options')
    $('.has-dropdown').on('click', function(e) {
        e.stopPropagation();
        var dropdownId = $(this).attr('data-dropdown');
        $('#' + dropdownId).toggle();
    });

    // 3. Poore page par kahin bhi click ho to khule huye dropdowns band ho jayein
    $(document).on('click', function() {
        $('.dropdown-menu--header').removeClass('active').hide();
        $('.dropdown-menu--content').hide();
    });

    // 4. Mobile Burger Menu Fix (For Responsive Devices)
    $('.mobile-menu').on('click', function() {
        $('#sidebar').toggleClass('sidebar--open');
    });
    
    $('.sidebar-resize').on('click', function() {
        $('#sidebar').toggleClass('sidebar--collapsed');
        $('#content').toggleClass('content--expanded');
    });
});
</script>

<script>
$(document).ready(function() {
    // Mobile Burger Menu Fix
    $('.mobile-menu').on('click', function() {
        $('#sidebar').toggleClass('sidebar--open'); // original medikit template standard sidebar toggler class
    });
    
    $('.sidebar-resize').on('click', function() {
        $('#sidebar').toggleClass('sidebar--collapsed');
        $('#content').toggleClass('content--expanded');
    });
});
</script>


</body>
</html>
