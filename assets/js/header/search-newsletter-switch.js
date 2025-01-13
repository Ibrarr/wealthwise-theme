jQuery(document).ready(function ($) {
    $(".secondary-menu #newsletter").click(function () {
        $(".search-newsletter-switch .search-menu").slideUp(function () {
            $(".search-newsletter-switch .newsletter-form").slideDown(function () {
                $(".secondary-menu #newsletter").fadeOut(function () {
                    $(".secondary-menu #search").css("display", "block").fadeIn();
                });
            });
        });
    });

    $(".secondary-menu #search").click(function () {
        $(".search-newsletter-switch .newsletter-form").slideUp(function () {
            $(".search-newsletter-switch .search-menu").slideDown(function () {
                $(".secondary-menu #search").fadeOut(function () {
                    $(".secondary-menu #newsletter").css("display", "block").fadeIn();
                });
            });
        });
    });

});
