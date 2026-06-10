/******/ (function() { // webpackBootstrap
/*!*****************************************!*\
  !*** ./assets/js/content-blog/share.js ***!
  \*****************************************/
jQuery(document).ready(function ($) {
  var tooltipVisible = false;
  $('.share').on('click', function (e) {
    e.stopPropagation(); // Prevent event bubbling
    if (!tooltipVisible) {
      $('.share-tooltip').fadeIn();
      tooltipVisible = true;
    }
  });
  $(document).on('click', function () {
    if (tooltipVisible) {
      $('.share-tooltip').fadeOut();
      tooltipVisible = false;
    }
  });
  $('.share-tooltip a').on('click', function (e) {
    e.stopPropagation();
    $('.share-tooltip').fadeOut();
    tooltipVisible = false;
  });
});
/******/ })()
;