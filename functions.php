<?php

// Define Globals
define( 'WW_THEME_PREFIX', 'ww' );
define( 'WW_TEMPLATE_URI', get_template_directory_uri() );
define( 'WW_TEMPLATE_DIR', get_template_directory() );
define( 'WW_INC_PATH', WW_TEMPLATE_DIR . '/inc' );

define( 'DISALLOW_FILE_EDIT', true );

// Actions
require WW_INC_PATH . '/actions.php';

// Filters
require WW_INC_PATH . '/filters.php';

// Remove Functions
require WW_INC_PATH . '/remove.php';

// Style and Scripts
require WW_INC_PATH . '/styles-scripts.php';

// Template Functions
require WW_INC_PATH . '/template-functions.php';

// Custom Post Types
require WW_INC_PATH . '/custom-post-types.php';

// Custom Taxonomies
require WW_INC_PATH . '/custom-taxonomies.php';

// ACF
require WW_INC_PATH . '/acf.php';

// Shortcodes
require WW_INC_PATH . '/shortcodes.php';

// Ajax Calls
require WW_INC_PATH . '/ajax-calls.php';