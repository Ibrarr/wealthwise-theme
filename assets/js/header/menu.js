jQuery(document).ready(function($) {
    let lastScrollTop = 0;
    const header = $("header");
    const headerHeight = header.outerHeight();

    $(window).on("scroll", function () {
        const currentScrollTop = $(this).scrollTop();

        if (currentScrollTop > lastScrollTop) {
            header.stop().animate({ top: -headerHeight }, 300);
        } else {
            header.stop().animate({ top: 0 }, 300);
        }

        lastScrollTop = currentScrollTop;
    });
});