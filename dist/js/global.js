jQuery(document).ready((function(e){e(".search.inline").length&&(e(".search.inline").click((function(o){o.stopPropagation(),e(".search-popup").slideToggle(),e("body").toggleClass("no-scroll no-click")})),e(".search-popup .container .row .close").click((function(o){o.stopPropagation(),e(".search-popup").slideUp(),e("body").removeClass("no-scroll no-click")})),e(document).click((function(o){e(o.target).closest(".search.inline").length||e(o.target).closest(".search-popup").length||(e(".search-popup").slideUp(),e("body").removeClass("no-scroll no-click"))})))})),jQuery(document).ready((function(e){if(e(".newsletter-popup").length){var o=e(".newsletter-popup"),n="newsletter_popup_shown";(function(e){for(var o=e+"=",n=document.cookie.split(";"),t=0;t<n.length;t++){for(var c=n[t];" "===c.charAt(0);)c=c.substring(1,c.length);if(0===c.indexOf(o))return c.substring(o.length,c.length)}return null})(n)||setTimeout((function(){e("body").append('<div class="popup-overlay"></div>'),e(".popup-overlay").css({position:"fixed",top:"0",left:"0",width:"100%",height:"100%",background:"rgba(0, 0, 0, 0.5)","z-index":"99",display:"none"}).fadeIn(400),o.fadeIn(400),e("body").addClass("no-scroll no-click")}),2e4),e(".newsletter-popup .close").on("click",(function(e){e.preventDefault(),t()})),e(document).on("click",(function(e){o.is(e.target)||0!==o.has(e.target).length||t()}))}function t(){o.fadeOut(400,(function(){e(".popup-overlay").fadeOut(400,(function(){e(".popup-overlay").remove()})),function(e,o,n){var t="";if(n){var c=new Date;c.setTime(c.getTime()+24*n*60*60*1e3),t="; expires="+c.toUTCString()}document.cookie=e+"="+(o||"")+t+"; path=/"}(n,"true",365),e("body").removeClass("no-scroll no-click")}))}}));