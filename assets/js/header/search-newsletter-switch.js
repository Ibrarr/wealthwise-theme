jQuery(document).ready(function ($) {
    $(".secondary-menu #newsletter").click(function () {
        $(".secondary-menu .search").slideUp(function () {
            $(".secondary-menu .newsletter-form").slideDown(function () {
                $(".secondary-menu #newsletter").fadeOut(function () {
                    $(".secondary-menu #search").css("display", "block").fadeIn();
                });
            });
        });
    });

    $(".secondary-menu #search").click(function () {
        $(".secondary-menu .newsletter-form").slideUp(function () {
            $(".secondary-menu .search").slideDown(function () {
                $(".secondary-menu #search").fadeOut(function () {
                    $(".secondary-menu #newsletter").css("display", "block").fadeIn();
                });
            });
        });
    });
});
