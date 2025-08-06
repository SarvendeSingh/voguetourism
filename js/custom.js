$(document).ready(function() {
    // Function to handle scroll event
    $(window).scroll(function() {
        // Check if scroll position is greater than 100px
        if ($(this).scrollTop() > 100) {
            // Add 'fixed' class to main-header
            $('.main-header').addClass('fixed');
        } else {
            // Remove 'fixed' class when scroll position is less than 100px
            $('.main-header').removeClass('fixed');
        }
    });
});