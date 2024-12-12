jQuery(document).ready(function($) {
    let lastScrollTop = 0;
    const header = $("header");
    const headerHeight = header.outerHeight();

    $(window).on("scroll", function () {
        const currentScrollTop = $(this).scrollTop();

        if (currentScrollTop === 0) {
            header.removeClass("active").stop().animate({ top: 0 }, 300);
        } else if (currentScrollTop > lastScrollTop) {
            header.removeClass("active").stop().animate({ top: -headerHeight }, 300);
        } else {
            header.addClass("active").stop().animate({ top: 0 }, 300);
        }

        lastScrollTop = currentScrollTop;
    });
});

jQuery(document).ready(function($) {
    $('.top-menu .search').click(function(event) {
        event.stopPropagation();
        $('.search-popup').slideToggle();
        $('body').toggleClass('no-scroll no-click');
    });

    $('.search-popup .container .row .close').click(function(event) {
        event.stopPropagation();
        $('.search-popup').slideUp();
        $('body').removeClass('no-scroll no-click');
    });

    $(document).click(function(event) {
        if (!$(event.target).closest('.top-menu .search').length && !$(event.target).closest('.search-popup').length) {
            $('.search-popup').slideUp();
            $('body').removeClass('no-scroll no-click');
        }
    });
});