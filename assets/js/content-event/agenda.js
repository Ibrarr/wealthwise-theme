jQuery(document).ready(function($) {
    $('.accordion h5').click(function() {
        const $accordion = $(this).parent();
        const $content = $accordion.find('.accordion-content');
        const $allAccordions = $('.accordion-content');

        const isActive = $accordion.hasClass('active');

        $allAccordions.slideUp();
        $('.accordion').removeClass('active');
        $('.accordion h5 .open').hide();
        $('.accordion h5 .closed').show();

        if (!isActive) {
            $content.slideDown();
            $accordion.addClass('active');
            $(this).find('.open').show();
            $(this).find('.closed').hide();
        }
    });

    $('.accordion').first().addClass('active');
    $('.accordion .accordion-content').first().show();
    $('.accordion h5 .open').first().show();
    $('.accordion h5 .closed').first().hide();
});
