jQuery(document).ready(function($) {
    // Mobile menu functionality
    $('.top-menu .main-menu .hamburger').on('click', function(event) {
        event.stopPropagation();
        $('.mobile-menu').css({
            display: 'block'
        }).animate({
            left: '0'
        }, 300);

        $('body').addClass('no-scroll no-click');
    });

    $('.mobile-menu .content .cross').on('click', function(event) {
        event.stopPropagation();
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
    });

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

    // Search functionality in the mobile menu
    $('header .mobile-menu .content .secondary-menu .search-newsletter-switch .search .search-box').click(function(event) {
        event.stopPropagation();

        // Close the mobile menu
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

        // Slide down the search popup
        $('.search-popup').slideDown();
        $('body').addClass('no-scroll no-click');
    });

    $('.search-popup .container .row .close').click(function(event) {
        event.stopPropagation();
        $('.search-popup').slideUp();
        $('body').removeClass('no-scroll no-click');
    });

    $(document).click(function(event) {
        if (!$(event.target).closest('.search-popup, header .mobile-menu .content .secondary-menu .search-newsletter-switch .search .search-box').length) {
            $('.search-popup').slideUp();
            $('body').removeClass('no-scroll no-click');
        }
    });
});