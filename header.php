<!DOCTYPE html>
<html <?php language_attributes(); ?> <?php ww_schema_type(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="wrapper" class="hfeed">
    <header id="header" role="banner">
        <div class="container px-4">
            <div class="top-menu">
                <div class="main-menu">
                    <div class="hamburger"><?php echo file_get_contents( WW_TEMPLATE_DIR . '/assets/images/icons/hamburger.svg' ) ?></div>
                </div>
                <div class="logo">
                    <a href="/"><?php echo file_get_contents( WW_TEMPLATE_DIR . '/assets/images/logos/logo.svg' ) ?></a>
                </div>
                <div class="search"><?php echo file_get_contents( WW_TEMPLATE_DIR . '/assets/images/icons/search.svg' ) ?></div>
            </div>
            <div class="bottom-menu">
                <nav id="nav" role="navigation" itemscope
                     itemtype="https://schema.org/SiteNavigationElement">
		            <?php wp_nav_menu( array(
			            'theme_location' => 'main-menu',
		            ) ); ?>
                </nav>
            </div>
            <div class="mobile-menu">
                <div class="content">
                    <div class="cross"><?php echo file_get_contents( WW_TEMPLATE_DIR . '/assets/images/icons/menu-cross.svg' ) ?></div>

                    <nav id="nav" role="navigation" itemscope
                         itemtype="https://schema.org/SiteNavigationElement">
		                <?php wp_nav_menu( array(
			                'theme_location' => 'main-menu',
		                ) ); ?>
                    </nav>

                    <div class="secondary-menu">
                        <a href="/contact-us">Contact us</a>
                        <a href="/about-us">About us</a>
                        <span id="search">Search <?php echo file_get_contents( WW_TEMPLATE_DIR . '/assets/images/icons/down-arrow.svg' ) ?></span>
                        <span id="newsletter">Newsletter Signup <?php echo file_get_contents( WW_TEMPLATE_DIR . '/assets/images/icons/down-arrow.svg' ) ?></span>
                        <div class="search-newsletter-switch">
                            <div class="newsletter-form">
                                <p>Newsletter sign-up</p>
		                        <?php echo do_shortcode( '[gravityform id="' . get_field( 'newsletter_form', 'option' ) . '" title="false" description="false" ajax="true"]' ); ?>
                            </div>
                            <div class="search">
                                <br>
                                <div class="search-box">
                                    <span>Search</span>
                                    <div class="icon"><?php echo file_get_contents( WW_TEMPLATE_DIR . '/assets/images/icons/search.svg' ) ?></div>
                                </div>
                                <div class="sponsor">
                                    <span>Sponsored by:</span>
                                    <img src="<?php the_field( 'sponsor_logo', 'option' ); ?>" alt="sponsor-logo">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <div class="search-popup">
        <div class="container px-4">
            <div class="row">
                <div class="col-lg-6 offset-lg-2">
                    <div class="search">
                        <span>Search</span>
                        <form action="/" method="get">
                            <input type="text" name="s" id="search" value="<?php the_search_query(); ?>" />
                            <input type="image" src="<?php echo get_template_directory_uri() . '/assets/images/icons/search.svg'; ?>" alt="Search" />
                        </form>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="sponsor">
                        <span>Sponsored by:</span>
                        <img src="<?php the_field( 'sponsor_logo', 'option' ); ?>" alt="sponsor-logo">
                    </div>
                </div>
                <div class="close"><?php echo file_get_contents( WW_TEMPLATE_DIR . '/assets/images/icons/menu-cross.svg' ) ?></div>
            </div>
        </div>
    </div>
    <main id="content" role="main">