/******/ (function() { // webpackBootstrap
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
/******/ })()
;