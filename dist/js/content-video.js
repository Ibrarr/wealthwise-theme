jQuery(document).ready((function(o){var t=!1;o(".share").on("click",(function(n){n.stopPropagation(),t||(o(".share-tooltip").fadeIn(),t=!0)})),o(document).on("click",(function(){t&&(o(".share-tooltip").fadeOut(),t=!1)})),o(".share-tooltip a").on("click",(function(n){n.stopPropagation(),o(".share-tooltip").fadeOut(),t=!1}))}));