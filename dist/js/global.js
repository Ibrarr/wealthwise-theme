/******/ (function() { // webpackBootstrap
// This entry needs to be wrapped in an IIFE because it needs to be isolated against other entry modules.
!function() {
/*!************************************!*\
  !*** ./assets/js/global/search.js ***!
  \************************************/
jQuery(document).ready(function ($) {
  if ($('.search.inline').length) {
    $('.search.inline').click(function (event) {
      event.stopPropagation();
      $('.search-popup').slideToggle();
      $('body').toggleClass('no-scroll no-click');
    });
    $('.search-popup .container .row .close').click(function (event) {
      event.stopPropagation();
      $('.search-popup').slideUp();
      $('body').removeClass('no-scroll no-click');
    });
    $(document).click(function (event) {
      if (!$(event.target).closest('.search.inline').length && !$(event.target).closest('.search-popup').length) {
        $('.search-popup').slideUp();
        $('body').removeClass('no-scroll no-click');
      }
    });
  }
});
}();
// This entry needs to be wrapped in an IIFE because it needs to be isolated against other entry modules.
!function() {
/*!******************************************!*\
  !*** ./assets/js/global/signup-popup.js ***!
  \******************************************/
jQuery(document).ready(function ($) {
  // Check if the .newsletter-popup element exists
  if (!$('.newsletter-popup').length) {
    return; // Exit if .newsletter-popup does not exist
  }

  // Function to set a cookie
  function setCookie(name, value, days) {
    var expires = "";
    if (days) {
      var date = new Date();
      date.setTime(date.getTime() + days * 24 * 60 * 60 * 1000);
      expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + (value || "") + expires + "; path=/";
  }

  // Function to get a cookie
  function getCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
      var c = ca[i];
      while (c.charAt(0) === ' ') c = c.substring(1, c.length);
      if (c.indexOf(nameEQ) === 0) return c.substring(nameEQ.length, c.length);
    }
    return null;
  }

  // Popup selector
  var $popup = $('.newsletter-popup');
  var popupCookieName = 'newsletter_popup_shown';

  // Function to show popup with fade-in effect
  function showPopup() {
    if (!getCookie(popupCookieName)) {
      setTimeout(function () {
        // Append and fade in overlay
        $('body').append('<div class="popup-overlay"></div>');
        $('.popup-overlay').css({
          'position': 'fixed',
          'top': '0',
          'left': '0',
          'width': '100%',
          'height': '100%',
          'background': 'rgba(0, 0, 0, 0.5)',
          'z-index': '99',
          'display': 'none'
        }).fadeIn(400);

        // Fade in popup and add body classes
        $popup.fadeIn(400);
        $('body').addClass('no-scroll no-click');
      }, 20000); // 20-second delay
    }
  }

  // Function to hide popup and overlay, and set cookie
  function hidePopup() {
    $popup.fadeOut(400, function () {
      $('.popup-overlay').fadeOut(400, function () {
        $('.popup-overlay').remove();
      });
      setCookie(popupCookieName, 'true', 365); // Set cookie for 1 year
      $('body').removeClass('no-scroll no-click');
    });
  }

  // Show popup initially if cookie isn't set
  showPopup();

  // Close button click event
  $('.newsletter-popup .close').on('click', function (e) {
    e.preventDefault();
    hidePopup();
  });

  // Click outside popup to close it
  $(document).on('click', function (e) {
    if (!$popup.is(e.target) && $popup.has(e.target).length === 0) {
      hidePopup();
    }
  });
});
}();
/******/ })()
;