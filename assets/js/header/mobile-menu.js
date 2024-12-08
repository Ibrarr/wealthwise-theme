jQuery(document).ready(function($) {
    $('.top-menu .main-menu .hamburger').on('click', function() {
        $('.mobile-menu').css({
            display: 'block'
        }).animate({
            left: '0'
        }, 300);
    });

    $('.mobile-menu .content .cross').on('click', function() {
        let windowWidth = $(window).width();
        let leftValue = windowWidth < 768 ? '-100vw' : '-390px';

        $('.mobile-menu').animate({
            left: leftValue
        }, 300, function() {
            $(this).css({
                display: 'none'
            });
        });
    });
});
