/******/ (function() { // webpackBootstrap
/*!***************************************!*\
  !*** ./assets/js/home/search-hero.js ***!
  \***************************************/
jQuery(document).ready(function ($) {
  $('.hero .right .search').click(function (event) {
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
    if (!$(event.target).closest('.hero .right .search').length && !$(event.target).closest('.search-popup').length) {
      $('.search-popup').slideUp();
      $('body').removeClass('no-scroll no-click');
    }
  });
});
/******/ })()
;