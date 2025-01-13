</main>
<footer id="footer" role="contentinfo">
    <div class="first">
        <div class="container px-4">
            <div class="row">
                <div class="col-12">
                    <div class="logo">
		                <?php echo file_get_contents( WW_TEMPLATE_DIR . '/assets/images/logos/logo.svg' ) ?>
                        <span>WEALTH WELL CONNECTED</span>
                    </div>
                </div>
                <div class="col-lg-8">
                    <p>Investment and wealth creation are inherently long-term endeavours and, at Wealthwise, we believe intelligent coverage of the space – and the professional relationships forged within it – should aspire to a similar timeframe. Wealthwise therefore exists to build constructive, durable connections between the wealth and asset management sectors – both in person and online.</p>
	                <div class="socials">
                        <a href="<?php the_field( 'linkedin', 'option' ); ?>" target="_blank">
	                        <?php echo file_get_contents( WW_TEMPLATE_DIR . '/assets/images/icons/linkedin-footer.svg' ) ?>
                        </a>
                        <a href="<?php the_field( 'youtube', 'option' ); ?>" target="_blank" class="insta">
			                <?php echo file_get_contents( WW_TEMPLATE_DIR . '/assets/images/icons/youtube-footer.svg' ) ?>
                        </a>
                        <a href="<?php the_field( 'instagram', 'option' ); ?>" target="_blank" class="insta">
			                <?php echo file_get_contents( WW_TEMPLATE_DIR . '/assets/images/icons/instagram-footer.svg' ) ?>
                        </a>
                    </div>
                </div>
                <div class="col-lg-2">
                    <span class="header">ARTICLES</span>
                    <nav id="nav" role="navigation" itemscope
                         itemtype="https://schema.org/SiteNavigationElement">
		                <?php wp_nav_menu( array(
			                'theme_location' => 'main-menu',
		                ) ); ?>
                        <a href="/word-to-the-wise/">Word to the wise</a>
                        <a href="/choice-words/">Choice words</a>
                    </nav>
                </div>
                <div class="col-lg-2">
                    <span class="header">GET IN TOUCH</span>
                    <div class="menu">
                        <a href="/contact-us">Contact us</a>
                        <a href="/about-us">About us</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="second">
        <div class="container px-4">
            <nav id="nav" role="navigation" itemscope
                 itemtype="https://schema.org/SiteNavigationElement">
		        <?php wp_nav_menu( array(
			        'theme_location' => 'footer-menu',
		        ) ); ?>
            </nav>
            <div class="text-owl">
                <p>Copyright © <?php echo date("Y"); ?> Wealthwise Media. All rights reserved.</p>
                <img src="<?php echo WW_TEMPLATE_URI . '/assets/images/gifs/owl-footer.gif'; ?>" alt="Owl Footer">
            </div>
        </div>
    </div>
</footer>
</div>
<?php wp_footer(); ?>
</body>
</html>