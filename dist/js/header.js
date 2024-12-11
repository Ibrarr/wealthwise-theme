/******/ (function() { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./assets/js/header/menu.js":
/*!**********************************!*\
  !*** ./assets/js/header/menu.js ***!
  \**********************************/
/***/ (function() {

jQuery(document).ready(function ($) {
  var lastScrollTop = 0;
  var header = $("header");
  var headerHeight = header.outerHeight();
  $(window).on("scroll", function () {
    var currentScrollTop = $(this).scrollTop();
    if (currentScrollTop === 0) {
      header.removeClass("active").stop().animate({
        top: 0
      }, 300);
    } else if (currentScrollTop > lastScrollTop) {
      header.removeClass("active").stop().animate({
        top: -headerHeight
      }, 300);
    } else {
      header.addClass("active").stop().animate({
        top: 0
      }, 300);
    }
    lastScrollTop = currentScrollTop;
  });
});

/***/ }),

/***/ "./assets/js/header/mobile-menu.js":
/*!*****************************************!*\
  !*** ./assets/js/header/mobile-menu.js ***!
  \*****************************************/
/***/ (function() {

jQuery(document).ready(function ($) {
  $('.top-menu .main-menu .hamburger').on('click', function () {
    // Open the mobile menu
    $('.mobile-menu').css({
      display: 'block'
    }).animate({
      left: '0'
    }, 300);

    // Add a class to the body to prevent scrolling and interactions
    $('body').addClass('no-scroll no-click');
  });
  $('.mobile-menu .content .cross').on('click', function () {
    var windowWidth = $(window).width();
    var leftValue = windowWidth < 768 ? '-100vw' : '-390px';

    // Close the mobile menu
    $('.mobile-menu').animate({
      left: leftValue
    }, 300, function () {
      $(this).css({
        display: 'none'
      });
    });

    // Remove the class from the body to allow scrolling and interactions
    $('body').removeClass('no-scroll no-click');
  });

  // Close the menu when clicking outside of it
  $(document).on('click', function (event) {
    if (!$(event.target).closest('.mobile-menu, .hamburger').length) {
      var windowWidth = $(window).width();
      var leftValue = windowWidth < 768 ? '-100vw' : '-390px';
      $('.mobile-menu').animate({
        left: leftValue
      }, 300, function () {
        $(this).css({
          display: 'none'
        });
      });
      $('body').removeClass('no-scroll no-click');
    }
  });
});

/***/ }),

/***/ "./assets/js/header/search-newsletter-switch.js":
/*!******************************************************!*\
  !*** ./assets/js/header/search-newsletter-switch.js ***!
  \******************************************************/
/***/ (function() {

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

/***/ }),

/***/ "./assets/css/app.scss":
/*!*****************************!*\
  !*** ./assets/css/app.scss ***!
  \*****************************/
/***/ (function(__unused_webpack_module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = __webpack_modules__;
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/chunk loaded */
/******/ 	!function() {
/******/ 		var deferred = [];
/******/ 		__webpack_require__.O = function(result, chunkIds, fn, priority) {
/******/ 			if(chunkIds) {
/******/ 				priority = priority || 0;
/******/ 				for(var i = deferred.length; i > 0 && deferred[i - 1][2] > priority; i--) deferred[i] = deferred[i - 1];
/******/ 				deferred[i] = [chunkIds, fn, priority];
/******/ 				return;
/******/ 			}
/******/ 			var notFulfilled = Infinity;
/******/ 			for (var i = 0; i < deferred.length; i++) {
/******/ 				var chunkIds = deferred[i][0];
/******/ 				var fn = deferred[i][1];
/******/ 				var priority = deferred[i][2];
/******/ 				var fulfilled = true;
/******/ 				for (var j = 0; j < chunkIds.length; j++) {
/******/ 					if ((priority & 1 === 0 || notFulfilled >= priority) && Object.keys(__webpack_require__.O).every(function(key) { return __webpack_require__.O[key](chunkIds[j]); })) {
/******/ 						chunkIds.splice(j--, 1);
/******/ 					} else {
/******/ 						fulfilled = false;
/******/ 						if(priority < notFulfilled) notFulfilled = priority;
/******/ 					}
/******/ 				}
/******/ 				if(fulfilled) {
/******/ 					deferred.splice(i--, 1)
/******/ 					var r = fn();
/******/ 					if (r !== undefined) result = r;
/******/ 				}
/******/ 			}
/******/ 			return result;
/******/ 		};
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	!function() {
/******/ 		__webpack_require__.o = function(obj, prop) { return Object.prototype.hasOwnProperty.call(obj, prop); }
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	!function() {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = function(exports) {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	}();
/******/ 	
/******/ 	/* webpack/runtime/jsonp chunk loading */
/******/ 	!function() {
/******/ 		// no baseURI
/******/ 		
/******/ 		// object to store loaded and loading chunks
/******/ 		// undefined = chunk not loaded, null = chunk preloaded/prefetched
/******/ 		// [resolve, reject, Promise] = chunk loading, 0 = chunk loaded
/******/ 		var installedChunks = {
/******/ 			"/js/header": 0,
/******/ 			"css/app": 0
/******/ 		};
/******/ 		
/******/ 		// no chunk on demand loading
/******/ 		
/******/ 		// no prefetching
/******/ 		
/******/ 		// no preloaded
/******/ 		
/******/ 		// no HMR
/******/ 		
/******/ 		// no HMR manifest
/******/ 		
/******/ 		__webpack_require__.O.j = function(chunkId) { return installedChunks[chunkId] === 0; };
/******/ 		
/******/ 		// install a JSONP callback for chunk loading
/******/ 		var webpackJsonpCallback = function(parentChunkLoadingFunction, data) {
/******/ 			var chunkIds = data[0];
/******/ 			var moreModules = data[1];
/******/ 			var runtime = data[2];
/******/ 			// add "moreModules" to the modules object,
/******/ 			// then flag all "chunkIds" as loaded and fire callback
/******/ 			var moduleId, chunkId, i = 0;
/******/ 			if(chunkIds.some(function(id) { return installedChunks[id] !== 0; })) {
/******/ 				for(moduleId in moreModules) {
/******/ 					if(__webpack_require__.o(moreModules, moduleId)) {
/******/ 						__webpack_require__.m[moduleId] = moreModules[moduleId];
/******/ 					}
/******/ 				}
/******/ 				if(runtime) var result = runtime(__webpack_require__);
/******/ 			}
/******/ 			if(parentChunkLoadingFunction) parentChunkLoadingFunction(data);
/******/ 			for(;i < chunkIds.length; i++) {
/******/ 				chunkId = chunkIds[i];
/******/ 				if(__webpack_require__.o(installedChunks, chunkId) && installedChunks[chunkId]) {
/******/ 					installedChunks[chunkId][0]();
/******/ 				}
/******/ 				installedChunks[chunkId] = 0;
/******/ 			}
/******/ 			return __webpack_require__.O(result);
/******/ 		}
/******/ 		
/******/ 		var chunkLoadingGlobal = self["webpackChunkwealthwise"] = self["webpackChunkwealthwise"] || [];
/******/ 		chunkLoadingGlobal.forEach(webpackJsonpCallback.bind(null, 0));
/******/ 		chunkLoadingGlobal.push = webpackJsonpCallback.bind(null, chunkLoadingGlobal.push.bind(chunkLoadingGlobal));
/******/ 	}();
/******/ 	
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module depends on other loaded chunks and execution need to be delayed
/******/ 	__webpack_require__.O(undefined, ["css/app"], function() { return __webpack_require__("./assets/js/header/menu.js"); })
/******/ 	__webpack_require__.O(undefined, ["css/app"], function() { return __webpack_require__("./assets/js/header/mobile-menu.js"); })
/******/ 	__webpack_require__.O(undefined, ["css/app"], function() { return __webpack_require__("./assets/js/header/search-newsletter-switch.js"); })
/******/ 	var __webpack_exports__ = __webpack_require__.O(undefined, ["css/app"], function() { return __webpack_require__("./assets/css/app.scss"); })
/******/ 	__webpack_exports__ = __webpack_require__.O(__webpack_exports__);
/******/ 	
/******/ })()
;