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
});