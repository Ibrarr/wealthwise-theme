jQuery(document).ready(function($) {
    $('.top-menu .main-menu .hamburger').on('click', function(event) {
        event.stopPropagation();
        // Open the mobile menu
        $('.mobile-menu').css({
            display: 'block'
        }).animate({
            left: '0'
        }, 300);

        // Add a class to the body to prevent scrolling and interactions
        $('body').addClass('no-scroll no-click');
    });

    $('.mobile-menu .content .cross').on('click', function(event) {
        event.stopPropagation();
        let windowWidth = $(window).width();
        let leftValue = windowWidth < 768 ? '-100vw' : '-390px';

        // Close the mobile menu
        $('.mobile-menu').animate({
            left: leftValue
        }, 300, function() {
            $(this).css({
                display: 'none'
            });
        });

        // Remove the class from the body to allow scrolling and interactions
        $('body').removeClass('no-scroll no-click');
    });

    // Close the menu when clicking outside of it
    $(document).on('click', function(event) {
        event.stopPropagation();
        if (!$(event.target).closest('.mobile-menu, .hamburger').length) {
            let windowWidth = $(window).width();
            let leftValue = windowWidth < 768 ? '-100vw' : '-390px';

            $('.mobile-menu').animate({
                left: leftValue
            }, 300, function() {
                $(this).css({
                    display: 'none'
                });
            });

            $('body').removeClass('no-scroll no-click');
        }
    });
});