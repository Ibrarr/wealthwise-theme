jQuery(document).ready(function($) {
    // Create the overlay element
    $('body').append('<div class="popup-overlay"></div>');

    // CSS styles for the overlay
    $('.popup-overlay').css({
        'position': 'fixed',
        'top': '0',
        'left': '0',
        'width': '100%',
        'height': '100%',
        'background': 'rgba(0, 0, 0, 0.5)',
        'z-index': '99',
        'display': 'none'
    });

    // Show popup and overlay
    $('.register button').click(function(event) {
        event.stopPropagation();
        $('.event-registration-popup').fadeIn();
        $('.popup-overlay').fadeIn(); // Show overlay
        $('body').toggleClass('no-scroll no-click');
    });

    // Close popup and hide overlay
    $('.event-registration-popup .close, .popup-overlay').click(function(event) {
        event.stopPropagation();
        $('.event-registration-popup').fadeOut();
        $('.popup-overlay').fadeOut(); // Hide overlay
        $('body').removeClass('no-scroll no-click');
    });

    // Close popup on outside click
    $(document).click(function(event) {
        if (!$(event.target).closest('.register button').length && !$(event.target).closest('.event-registration-popup').length) {
            $('.event-registration-popup').fadeOut();
            $('.popup-overlay').fadeOut(); // Hide overlay
            $('body').removeClass('no-scroll no-click');
        }
    });
});
