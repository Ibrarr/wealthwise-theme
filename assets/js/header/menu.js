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
