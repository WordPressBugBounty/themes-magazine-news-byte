<?php
/**
 * About page
 */

/**
 * Sets up the Appearance Subpage
 *
 * @since 1.0
 * @access public
 * @return void
 */
function magnb_add_appearance_subpage() {

	add_theme_page(
		magnb_abouttag( 'label' ), // Page Title
		magnb_abouttag( 'label' ), // Menu Title
		'edit_theme_options', // capability
		magnb_abouttag( 'slug' ) . '-welcome', // menu-slug
		'magnb_appearance_subpage', // function name
		1 // position
		);

	add_action( 'admin_enqueue_scripts', 'magnb_admin_enqueue_about_styles' );

}
/* Add the admin setup function to the 'admin_menu' hook. */
add_action( 'admin_menu', 'magnb_add_appearance_subpage' );

/**
 * Enqueue CSS
 *
 * @since 1.0
 * @access public
 * @return void
 */
function magnb_admin_enqueue_about_styles( $hook ) {
	$slug = magnb_abouttag( 'slug' );
	if ( $hook === "appearance_page_{$slug}-welcome" ) {
		wp_enqueue_style( 'hoot-admin-about', hoot_data()->incuri . 'admin/css/about.css', array(),  hoot_data()->hoot_version );
		wp_enqueue_script( 'hoot-admin-about', hoot_data()->incuri . 'admin/js/about.js', array( 'jquery' ),  hoot_data()->hoot_version, true );
	}
}

/**
 * Display the Appearance Subpage
 *
 * @since 1.0
 * @access public
 * @return void
 */
function magnb_appearance_subpage() {
	$slug = magnb_abouttag( 'slug' );
	$themename = magnb_abouttag( 'name' );
	$themelabel = magnb_abouttag( 'label' );
	$version = magnb_abouttag( 'vers' );
	$screenshot = magnb_abouttag( 'shot' );

	$hasupsell = apply_filters( 'magnb_load_upsell', true );
	$default_tabs = array( 'qstart', 'plugins' );
	if ( $hasupsell ) $default_tabs[] = 'upsell';
	$availabletabs = apply_filters( 'magnb_about_load_tabs', $default_tabs );
	if ( ! is_array( $availabletabs ) ) $availabletabs = $default_tabs;
	$activetab = !empty( $_GET['tab'] ) && in_array( $_GET['tab'], $availabletabs ) ? $_GET['tab'] : ( $hasupsell ? 'upsell' : 'qstart' );
	?>
	<div class="wrap">

		<h1 class="hoot-about-title"><?php
			/* Translators: 1 is the theme name */
			printf( esc_html__( 'About %1$s', 'magazine-news-byte' ), $themelabel );
			?></h1>

		<div id="hoot-about-sub" class="hoot-about-sub">
			<div class="hoot-about-ss"><?php if ( !empty( $screenshot ) ) echo '<img src="' . esc_url( $screenshot ) . '">'; ?></div>
			<div class="hoot-about-text">
				<p class="hoot-about-intro"><?php 
					/* Translators: 1 is the theme name */
					printf( esc_html__( '%1$s is a multipurpose highly flexible WordPress theme built on a SEO friendly framework with fast loading speed. It comes with multiple Theme Customizer options, various blog layouts, WooCommerce support etc among many other features.', 'magazine-news-byte' ), $themename );
					?></p>
				<p class="hoot-about-textlinks">
					<?php if ( $hasupsell ) : ?>
					<a class="button button-primary" href="https://wphoot.com/themes/magazine-news-byte/" target="_blank"><span class="dashicons dashicons-dashboard"></span> <?php esc_html_e( 'View Premium', 'magazine-news-byte' ) ?></a>
					<?php endif; ?>
					<a class="button" href="https://demo.wphoot.com/JNES@SLUG/" target="_blank"><span class="dashicons dashicons-welcome-view-site"></span> <?php esc_html_e( 'View Demo', 'magazine-news-byte' ) ?></a>
					<a class="button" href="https://wphoot.com/support/magazine-news-byte/" target="_blank"><span class="dashicons dashicons-editor-aligncenter"></span> <?php esc_html_e( 'Documentation', 'magazine-news-byte' ) ?></a>
					<a class="button" href="https://wphoot.com/support/" target="_blank"><span class="dashicons dashicons-sos"></span> <?php esc_html_e( 'Get Support', 'magazine-news-byte' ) ?></a>
					<a class="button" href="https://wordpress.org/support/theme/JNES@SLUG/reviews/#new-post" target="_blank"><span class="dashicons dashicons-thumbs-up"></span> <?php esc_html_e( 'Rate Us', 'magazine-news-byte' ) ?></a>
				</p>
				<?php do_action( 'magnb_theme_after_about_textlinks', $slug ); ?>
			</div>
			<div class="clear"></div>
		</div><!-- .hoot-about-sub -->

		<div class="hoot-abouttabs">

			<h2 id="nav-tabs" class="nav-tab-wrapper">
				<?php if ( $hasupsell ) : ?>
				<span class="nav-tab nav-upsell <?php if ( $activetab === 'upsell' ) echo 'nav-tab-active'; ?>" data-tabid="upsell"><?php esc_html_e( 'Premium Options', 'magazine-news-byte' ) ?></span>
				<?php endif; ?>
				<span class="nav-tab nav-qstart <?php if ( $activetab === 'qstart' ) echo 'nav-tab-active'; ?>" data-tabid="qstart"><?php esc_html_e( 'Quick Start Guide', 'magazine-news-byte' ) ?></span>
				<span class="nav-tab nav-plugins <?php if ( $activetab === 'plugins' ) echo 'nav-tab-active'; ?>" data-tabid="plugins"><?php esc_html_e( 'Theme Plugins', 'magazine-news-byte' ) ?></span>
				<?php do_action( 'magnb_about_tabs', $activetab ); ?>
			</h2>

			<?php if ( $hasupsell ) : ?>
			<div id="hoot-upsell" class="hoot-upsell hoot-tab <?php if ( $activetab == 'upsell' ) echo 'hoot-tab-active'; ?>">
				<h2 class="centered allcaps"><?php
					/* Translators: The %s are placeholders for HTML, so the order can't be changed. */
					printf( esc_html__( 'Do more with %2$s%1$s %3$sPremium%4$s%5$s', 'magazine-news-byte' ), $themename, '<span>', '<strong>', '</strong>', '</span>' );
					?></h2>
				<p class="hoot-tab-intro centered"><?php
					/* Translators: The %s are placeholders for HTML, so the order can't be changed. */
					printf( esc_html__( 'If you have enjoyed using %1$s, you are going to love %2$s%1$s Premium%3$s.%4$sIt is a robust upgrade to %1$s that gives you many useful features.', 'magazine-news-byte' ), $themename, '<strong>', '</strong>', '<br />' );
					?></p>
				<p class="hoot-tab-cta centered">
					<a class="button button-secondary secondary-cta" href="https://demo.wphoot.com/JNES@SLUG/" target="_blank"><span class="dashicons dashicons-welcome-view-site"></span> <?php esc_html_e( 'View Demo Site', 'magazine-news-byte' ) ?></a>
					<a class="button button-primary primary-cta" href="https://wphoot.com/themes/magazine-news-byte/" target="_blank"><span class="dashicons dashicons-dashboard"></span> <?php
						/* Translators: 1 is the theme name */
						printf( esc_html__( 'Buy %1$s Premium', 'magazine-news-byte' ), $themename );
						?></a>
				</p>
				<div class="hoot-tab-sub"><div class="hoot-tab-subinner">
					<?php magnb_tabsections( 'features' ); ?>
					<div class="tabsection hoot-tab-cta centered">
						<a class="button button-secondary secondary-cta" href="https://demo.wphoot.com/JNES@SLUG/" target="_blank"><span class="dashicons dashicons-welcome-view-site"></span> <?php esc_html_e( 'View Demo Site', 'magazine-news-byte' ) ?></a>
						<a class="button button-primary primary-cta" href="https://wphoot.com/themes/magazine-news-byte/" target="_blank"><span class="dashicons dashicons-dashboard"></span> <?php
							/* Translators: 1 is the theme name */
							printf( esc_html__( 'Buy %1$s Premium', 'magazine-news-byte' ), $themename );
							?></a>
					</div>
				</div></div><!-- .hoot-tab-sub -->
			</div><!-- #hoot-upsell -->
			<?php endif; ?>

			<div id="hoot-qstart" class="hoot-qstart hoot-tab <?php if ( $activetab == 'qstart' ) echo 'hoot-tab-active'; ?>">
				<h2 class="centered allcaps"><span class="dashicons dashicons-clock"></span> <?php esc_html_e( 'Quick Start Guide', 'magazine-news-byte' ); ?></h2>
				<p class="hoot-tab-intro centered"><?php
					/* Translators: The %s are placeholders for HTML, so the order can't be changed. */
					printf( esc_html__( 'Follow these steps to quickly start developing your site.%1$sTo read the full documentation, or to get support from one of our support ninjas, click the buttons below.', 'magazine-news-byte' ), '<br />' );
					?></p>
				<p class="hoot-tab-cta centered">
					<a class="button button-primary primary-cta" href="https://wphoot.com/support/magazine-news-byte/" target="_blank"><span class="dashicons dashicons-editor-aligncenter"></span> <?php esc_html_e( 'View Full Documentation', 'magazine-news-byte' ) ?></a>
					<a class="button button-secondary secondary-cta" href="https://wphoot.com/support/" target="_blank"><span class="dashicons dashicons-sos"></span> <?php esc_html_e( 'Get Support', 'magazine-news-byte' ) ?></a>
				</p>
				<div class="hoot-tab-sub hoot-qstart-sub"><div class="hoot-tab-subinner">
					<?php magnb_tabsections( 'quickstart' ); ?>
					<div class="tabsection hoot-tab-cta centered">
						<a class="button button-primary primary-cta" href="https://wphoot.com/support/magazine-news-byte/" target="_blank"><span class="dashicons dashicons-editor-aligncenter"></span> <?php esc_html_e( 'View Full Documentation', 'magazine-news-byte' ) ?></a>
						<a class="button button-secondary secondary-cta" href="https://wphoot.com/support/" target="_blank"><span class="dashicons dashicons-sos"></span> <?php esc_html_e( 'Get Support', 'magazine-news-byte' ) ?></a>
					</div>
				</div></div><!-- .hoot-tab-sub -->
			</div><!-- #hoot-qstart -->

			<div id="hoot-plugins" class="hoot-plugins hoot-tab <?php if ( $activetab == 'plugins' ) echo 'hoot-tab-active'; ?>">

				<div class="wp-list-table widefat plugin-install">
					<div id="the-list">

						<div class="plugin-card">
							<div class="plugin-card-top">
								<div class="name column-name">
									<h3><?php esc_html_e( 'HootKit', 'magazine-news-byte' ) ?><img src="https://s.w.org/plugins/geopattern-icon/hootkit.svg" class="plugin-icon" alt=""></h3>
								</div>
								<div class="action-links">
									<ul class="plugin-action-buttons">
										<li><?php
											if ( class_exists( 'HootKit' ) ) {
												echo '<button type="button" class="button button-disabled" disabled="disabled">' . esc_html( 'Active', 'magazine-news-byte' ) . '</button>';
											} else {
												echo '<a href="#" class="hoot-btn-processplugin button button-primary hoot-btn-smallmsg" data-plugin="hootkit">';
													if ( file_exists( WP_PLUGIN_DIR . '/hootkit/hootkit.php' ) )
														esc_html_e( 'Activate', 'magazine-news-byte' );
													else
														esc_html_e( 'Install', 'magazine-news-byte' );
												echo '</a>';
											}
										?></li>
										<li><?php
											/* Translators: The %s are placeholders for HTML, so the order can't be changed. */
											echo sprintf( esc_html__( '%1$sView Details%2$s', 'magazine-news-byte' ), '<a href="https://wordpress.org/plugins/hootkit/" target="_blank">', '</a>' );
										?></li>
									</ul>
								</div>
								<div class="desc column-description">
									<p><?php esc_html_e( 'This plugin adds widgets and sliders developed and styled specifically for the theme.', 'magazine-news-byte' ); ?></p>
									<p class="authors"><cite><?php
										/* Translators: The %s are placeholders for HTML, so the order can't be changed. */
										echo sprintf( esc_html__( 'By %1$swpHoot%2$s', 'magazine-news-byte' ), '<a href="https://wphoot.com">', '</a>' );
									?></cite></p>
								</div>
							</div>
						</div>

						<?php $import_config = apply_filters( 'hootimport_theme_config', array() ); // Hoot Import has been configured for active theme
						if ( ! empty( $import_config ) ) : ?>
						<div class="plugin-card">
							<div class="plugin-card-top">
								<div class="name column-name">
									<h3><?php esc_html_e( 'Hoot Import', 'magazine-news-byte' ) ?><img src="https://s.w.org/plugins/geopattern-icon/hoot-import.svg" class="plugin-icon" alt=""></h3>
								</div>
								<div class="action-links">
									<ul class="plugin-action-buttons">
										<li><?php
											if ( class_exists( 'HootImport' ) ) {
												echo '<button type="button" class="button button-disabled" disabled="disabled">' . esc_html( 'Active', 'magazine-news-byte' ) . '</button>';
											} else {
												echo '<a href="#" class="hoot-btn-processplugin button button-primary hoot-btn-smallmsg">';
													if ( file_exists( WP_PLUGIN_DIR . '/hoot-import/hoot-import.php' ) )
														esc_html_e( 'Activate', 'magazine-news-byte' );
													else
														esc_html_e( 'Install', 'magazine-news-byte' );
												echo '</a>';
											}
										?></li>
										<li><?php
											/* Translators: The %s are placeholders for HTML, so the order can't be changed. */
											echo sprintf( esc_html__( '%1$sView Details%2$s', 'magazine-news-byte' ), '<a href="https://wordpress.org/plugins/hoot-import/" target="_blank">', '</a>' );
										?></li>
									</ul>
								</div>
								<div class="desc column-description">
									<p><?php esc_html_e( 'This plugin helps you import the demo data to help you get familiar with the theme.', 'magazine-news-byte' ); ?></p>
									<p class="authors"><cite><?php
										/* Translators: The %s are placeholders for HTML, so the order can't be changed. */
										echo sprintf( esc_html__( 'By %1$swpHoot%2$s', 'magazine-news-byte' ), '<a href="https://wphoot.com">', '</a>' );
									?></cite></p>
								</div>
							</div>
						</div>
						<?php endif; ?>

					</div>
				</div>

			</div><!-- #hoot-plugins -->

			<?php do_action( 'magnb_about_tabcontent', $activetab ); ?>


		</div><!-- .hoot-abouttabs -->
		<a class="hoot-abouttheme-top" href="#hoot-about-sub"><span class="dashicons dashicons-arrow-up-alt"></span></a>
	</div><!-- .wrap -->
	<?php
}

/**
 * About Page displat Tab's content sections
 *
 * @since 1.0
 * @access public
 * @return mixed
 */
function magnb_tabsections( $string ) {
	if ( in_array( $string, array( 'features', 'quickstart' ) ) ) :
		$features = magnb_upstrings( $string );
		if ( !empty( $features ) && is_array( $features ) ) :
			foreach ( $features as $key => $feature ) :
				$style = empty( $feature['style'] ) ? 'std' : $feature['style'];
				?>
				<div class="tabsection <?php
					if ( $style == 'hero-top' || $style == 'hero-bottom' ) echo "tabsection-hero tabsection-{$style}";
					elseif ( $style == 'side' ) echo 'tabsection-sideinfo';
					elseif ( $style == 'aside' ) echo 'tabsection-asideinfo';
					else echo "tabsection-std";
					?>">

					<?php if ( $style == 'hero-top' || $style == 'hero-bottom' ) :
						if ( $style == 'hero-top' ) : ?>
							<h4 class="heading"><?php echo $feature['name']; ?><cite><span><?php esc_html_e( '* Premium Feature', 'magazine-news-byte' ) ?></span></cite></h4>
							<?php if ( !empty( $feature['desc'] ) ) echo '<div class="tabsection-hero-text">' . $feature['desc'] . '</div>'; ?>
						<?php endif; ?>
						<?php if ( !empty( $feature['img'] ) ) : ?>
							<div class="tabsection-hero-img">
								<img src="<?php echo esc_url( $feature['img'] ); ?>" />
							</div>
						<?php endif; ?>
						<?php if ( $style == 'hero-bottom' ) : ?>
							<h4 class="heading"><?php echo $feature['name']; ?><cite><span><?php esc_html_e( '* Premium Feature', 'magazine-news-byte' ) ?></span></cite></h4>
							<?php if ( !empty( $feature['desc'] ) ) echo '<div class="tabsection-hero-text">' . $feature['desc'] . '</div>'; ?>
						<?php endif; ?>

					<?php elseif ( $style == 'side' ) : ?>
						<div class="tabsection-side-wrap">
							<div class="tabsection-side-img">
								<img src="<?php echo esc_url( $feature['img'] ); ?>" />
							</div>
							<div class="tabsection-side-textblock">
								<?php if ( !empty( $feature['name'] ) ) : ?>
									<h4 class="heading"><?php echo $feature['name']; ?><cite><span><?php esc_html_e( '* Premium Feature', 'magazine-news-byte' ) ?></span></cite></h4>
								<?php endif; ?>
								<?php if ( !empty( $feature['desc'] ) ) echo '<div class="tabsection-side-text">' . $feature['desc'] . '</div>'; ?>
							</div>
							<div class="clear"></div>
						</div>

					<?php elseif ( $style == 'aside' ) : ?>
						<?php if ( !empty( $feature['blocks'] ) ) : ?>
							<div class="tabsection-aside-wrap">
							<?php foreach ( $feature['blocks'] as $key => $block ) {
								echo '<div class="tabsection-aside-block tabsection-aside-'.($key+1).'">';
									if ( !empty( $block['img'] ) ) : ?>
										<div class="tabsection-aside-img">
											<img src="<?php echo esc_url( $block['img'] ); ?>" />
										</div>
									<?php endif;
									if ( !empty( $block['name'] ) ) : ?>
										<h4 class="heading"><?php echo $block['name']; ?><cite><span><?php esc_html_e( '* Premium Feature', 'magazine-news-byte' ) ?></span></cite></h4>
									<?php endif;
									if ( !empty( $block['desc'] ) ) echo '<div class="tabsection-aside-text">' . $block['desc'] . '</div>';
								echo '</div>';
							} ?>
							<div class="clear"></div>
							</div>
						<?php endif; ?>

					<?php else : ?>
						<?php if ( $style != 'img-bottom' && !empty( $feature['img'] ) ) : ?>
							<div class="tabsection-std-img attop">
								<img src="<?php echo esc_url( $feature['img'] ); ?>" />
							</div>
						<?php endif; ?>
						<div class="tabsection-std-textblock <?php if ( $style == 'img-bottom' ) echo 'attop'; else echo 'atbottom'; ?>">
							<?php if ( !empty( $feature['name'] ) ) : ?>
								<div class="tabsection-std-heading"><h4 class="heading"><?php echo $feature['name']; ?><cite><span><?php esc_html_e( '* Premium Feature', 'magazine-news-byte' ) ?></span></cite></h4></div>
							<?php endif; ?>
							<?php if ( !empty( $feature['desc'] ) ) echo '<div class="tabsection-std-text">' . $feature['desc'] . '</div>'; ?>
							<div class="clear"></div>
						</div>
						<?php if ( $style == 'img-bottom' && !empty( $feature['img'] ) ) : ?>
							<div class="tabsection-std-img atbottom">
								<img src="<?php echo esc_url( $feature['img'] ); ?>" />
							</div>
						<?php endif; ?>
					<?php endif; ?>

				</div><!-- .tabsection -->
				<?php
			endforeach;
		endif;
	endif;
}

/**
 * About Page Strings
 *
 * @since 1.0
 * @access public
 * @return mixed
 */
function magnb_upstrings( $string ) {

	$features = $quickstart = array();
	$imagepath =  esc_url( hoot_data()->incuri . 'admin/images/' );
	$slug = magnb_abouttag( 'slug' );
	$themename = magnb_abouttag( 'name' );

	$features[] = array(
		/* Translators: The %s are placeholders for HTML, so the order can't be changed. */
		'name' => sprintf( esc_html__( 'Complete %1$sStyle %2$sCustomization%3$s', 'magazine-news-byte' ), '<br />', '<strong>', '</strong>' ),
		/* Translators: 1 is the theme name */
		'desc' => sprintf( esc_html__( 'Different looks and styles. Choose from an extensive range of customization features in %1$s Premium to setup your own unique front page. Give youe site the personality it deserves.', 'magazine-news-byte' ), $themename ),
		// 'img' => $imagepath . 'premium-style.jpg',
		'style' => 'hero-top',
		);

	$features[] = array(
		'name' => esc_html__( 'Custom Colors &amp; Backgrounds for Sections', 'magazine-news-byte' ),
		/* Translators: 1 is the theme name */
		'desc' => sprintf( esc_html__( '%1$s Premium lets you select custom colors and backgrounds for different sections of your site like header, footer, logo background, menu dropdown, content area, page title area etc.', 'magazine-news-byte' ), $themename ),
		'img' => $imagepath . 'premium-colors.jpg',
		);

	$features[] = array(
		/* Translators: The %s are placeholders for HTML, so the order can't be changed. */
		'name' => sprintf( esc_html__( 'Fonts and %1$sTypography Control%2$s', 'magazine-news-byte' ), '<span>', '</span>' ),
		'desc' => esc_html__( 'Assign different typography (fonts, text size, font color) to menu, topbar, logo, content headings, sidebar, footer etc.', 'magazine-news-byte' ),
		'img' => $imagepath . 'premium-typography.jpg',
		);

	$features[] = array(
		'name' => esc_html__( '600+ Google Fonts', 'magazine-news-byte' ),
		'desc' => esc_html__( "With the integrated Google Fonts library, you can find the fonts that match your site's personality, and there's over 600 options to choose from.", 'magazine-news-byte' ),
		'img' => $imagepath . 'premium-googlefonts.jpg',
		);

	$features[] = array(
		'name' => esc_html__( 'Unlimites Sliders, Unlimites Slides', 'magazine-news-byte' ),
		/* Translators: The %s are placeholders for HTML, so the order can't be changed. */
		'desc' => sprintf( esc_html__( '%1$s Premium allows you to create unlimited sliders with as many slides as you need using the awesome HootKit plugin.%2$s%3$sAdd as Shortcodes%4$sYou can use these sliders on your Frontpage, or add them anywhere using shortcodes - like in your Posts, Sidebars or Footer.', 'magazine-news-byte' ), $themename, '<hr>', '<h4>', '</h4>' ),
		'img' => $imagepath . 'premium-sliders.jpg',
		);

	$features[] = array(
		'name' => esc_html__( 'Image Carousels', 'magazine-news-byte' ),
		'desc' => esc_html__( 'Add carousel widgets to your post, in your sidebar, on your frontpage or in your footer. A simple drag and drop interface allows you to easily create and manage carousels.', 'magazine-news-byte' ),
		'img' => $imagepath . 'premium-carousels.jpg',
		);

	$features[] = array(
		/* Translators: The %s are placeholders for HTML, so the order can't be changed. */
		'name' => sprintf( esc_html__( 'Floating %1$s%2$s\'Sticky\' Header%3$s &amp; %2$s\'Goto Top\'%3$s button (optional)', 'magazine-news-byte' ), '<br>', '<span>', '</span>' ),
		/* Translators: The %s are placeholders for HTML, so the order can't be changed. */
		'desc' => sprintf( esc_html__( 'The floating header follows the user down your page as they scroll, which means they never have to scroll back up to access your navigation menu, improving user experience.%1$sOr, use the \'Goto Top\' button appears on the screen when users scroll down your page, giving them a quick way to go back to the top of the page.', 'magazine-news-byte' ), '<hr>' ),
		'img' => $imagepath . 'premium-header-top.jpg',
		);

	$features[] = array(
		/* Translators: The %s are placeholders for HTML, so the order can't be changed. */
		'name' => sprintf( esc_html__( 'One Page %1$sScrolling Website /%2$s %1$sLanding Page%2$s', 'magazine-news-byte' ), '<span>', '</span>' ),
		/* Translators: The %s are placeholders for HTML, so the order can't be changed. */
		'desc' => sprintf( esc_html__( 'Make One Page websites with menu items linking to different sections on the page. Watch the scroll animation kick in when a user clicks a menu item to jump to a page section.%1$sCreate different landing pages on your site. Change the menu for each page so that the menu items point to sections of the page being displayed.', 'magazine-news-byte' ), '<hr>' ),
		'img' => $imagepath . 'premium-scroller.jpg',
		'style' => 'side',
		);

	$features[] = array(
		/* Translators: The %s are placeholders for HTML, so the order can't be changed. */
		'name' => sprintf( esc_html__( 'Additional Blog Layouts (including pinterest %1$stype mosaic)%2$s', 'magazine-news-byte' ), '<span>', '</span>' ),
		/* Translators: 1 is the theme name */
		'desc' => sprintf( esc_html__( '%1$s Premium gives you the option to display your post archives in different layouts including a mosaic type layout similar to pinterest.', 'magazine-news-byte' ), $themename ),
		'img' => $imagepath . 'premium-blogstyles.jpg',
		);

	$features[] = array(
		'name' => esc_html__( 'Custom Widgets', 'magazine-news-byte' ),
		/* Translators: The %s are placeholders for HTML, so the order can't be changed. */
		'desc' => sprintf( esc_html__( 'Additional Hootkit Custom widgets crafted and designed specifically for %1$s Premium Theme to give you the flexibility of adding stylized content: %2$s Buttons, Carousel Sliders, Carousel Posts Slider, Contact Info, Icon Lists, Notices, Number Blocks, Tabs, Toggles and Vcards among others.', 'magazine-news-byte' ), $themename, '<hr>' ),
		'img' => $imagepath . 'premium-widgets.jpg',
		);

	$features[] = array(
		'name' => esc_html__( 'Menu Icons', 'magazine-news-byte' ),
		'desc' => esc_html__( 'Select from over 900 icons for your main navigation menu links.', 'magazine-news-byte' ),
		'img' => $imagepath . 'premium-menuicons.jpg',
		);

	$features[] = array(
		'name' => esc_html__( 'Premium Background Patterns (CC0)', 'magazine-news-byte' ),
		/* Translators: 1 is the theme name */
		'desc' => sprintf( esc_html__( '%1$s Premium comes with many additional premium background patterns. You can always upload your own background image/pattern to match your site design.', 'magazine-news-byte' ), $themename ),
		// 'img' => $imagepath . 'premium-backgrounds.jpg',
		);

	$features[] = array(
		/* Translators: The %s are placeholders for HTML, so the order can't be changed. */
		'name' => sprintf( esc_html__( 'Automatic Image Lightbox and %1$sWordPress Gallery%2$s', 'magazine-news-byte' ), '<span>', '</span>' ),
		/* Translators: The %s are placeholders for HTML, so the order can't be changed. */
		'desc' => sprintf( esc_html__( 'Automatically open image links on your site with the integrates lightbox in %1$s Premium.%2$sAutomatically convert standard WordPress galleries to beautiful lightbox gallery slider.', 'magazine-news-byte' ), $themename, '<hr>' ),
		'img' => $imagepath . 'premium-lightbox.jpg',
		);

	$features[] = array(
		/* Translators: The %s are placeholders for HTML, so the order can't be changed. */
		'name' => sprintf( esc_html__( 'Developers %1$slove {LESS}', 'magazine-news-byte' ), '<br />' ),
		/* Translators: 1 is the theme name */
		'desc' => sprintf( esc_html__( 'CSS is passe! Developers love the modularity and ease of using LESS, which is why %1$s Premium comes with properly organized LESS files for the main stylesheet.', 'magazine-news-byte' ), $themename ),
		'img' => $imagepath . 'premium-lesscss.jpg',
		);

	$features[] = array(
		'name' => esc_html__( 'Easy Import/Export', 'magazine-news-byte' ),
		'desc' => esc_html__( 'Moving to a new host? Or applying a new child theme? Easily import/export your customizer settings with just a few clicks - right from the backend.', 'magazine-news-byte' ),
		// 'img' => $imagepath . 'premium-import-export.jpg',
		);

	$features[] = array(
		'style' => 'aside',
		'blocks' => array(
			array(
				/* Translators: The %s are placeholders for HTML, so the order can't be changed. */
				'name' => sprintf( esc_html__( 'Custom Javascript &amp; %1$sGoogle Analytics%2$s', 'magazine-news-byte' ), '<span>', '</span>' ),
				'desc' => esc_html__( 'Easily insert any javascript snippet to your header without modifying the code files. This helps in adding scripts for Google Analytics, Adsense or any other custom code.', 'magazine-news-byte' ),
				// 'img' => $imagepath . 'premium-customjs.jpg',
				),
			array(
				/* Translators: The %s are placeholders for HTML, so the order can't be changed. */
				'name' => sprintf( esc_html__( 'Continued %1$sLifetime Updates', 'magazine-news-byte' ), '<br />' ),
				/* Translators: 1 is the theme name */
				'desc' => sprintf( esc_html__( 'You will help support the continued development of %1$s - ensuring it works with future versions of WordPress for years to come.', 'magazine-news-byte' ), $themename ),
				// 'img' => $imagepath . 'premium-updates.jpg',
				),
			),
		);

	$features[] = array(
		/* Translators: The %s are placeholders for HTML, so the order can't be changed. */
		'name' => esc_html__( 'Priority Support', 'magazine-news-byte' ),
		/* Translators: The %s are placeholders for HTML, so the order can't be changed. */
		'desc' => sprintf( esc_html__( 'Need help setting up %1$s? Upgrading to %1$s Premium gives you prioritized support. We have a growing support team ready to help you with your questions.%2$sNeed small modifications? If you are not a developer yourself, you can count on our support staff to help you with CSS snippets to get the look you are after. Best of all, your changes will persist across updates.', 'magazine-news-byte' ), $themename, '<hr>' ),
		'img' => $imagepath . 'premium-support.jpg',
		// 'style' => 'side',
		);



	$settinglink = admin_url( 'options-reading.php' );
	$addpagelink = admin_url( 'post-new.php?post_type=page' );
	$quickstart[] = array(
		'name' => esc_html__( 'Setup Frontpage and Blog Page', 'magazine-news-byte' ),
		/* Translators: The %s are placeholders for HTML, so the order can't be changed. */
		'desc' => sprintf( esc_html__( 'Users often want to create a landing Homepage/Frontpage to welcome their visitors, while a separate \'Blog\' page to list all their blog posts. To do this, follow these steps:%9$s%1$s
			%3$sIn your wp-admin area, click %11$sPages > Add New%12$s%4$s
			%3$sGive page a Title %7$s(lets call it "My Home Page")%8$s and %5$sPublish%6$s%4$s
			%3$sIn your wp-admin area, click %11$sPages > Add New%12$s%4$s
			%3$sGive page a Title %7$s(lets call it "My Blog")%8$s and %5$sPublish%6$s%4$s
			%3$sIn your wp-admin area, go to %10$sSettings > Reading%12$s%4$s
			%3$sSelect the %5$sStatic Page%6$s option.%4$s
			%3$sSelect the pages you created in Step 2 and 4 above.%4$s
			%3$s%5$sSave%6$s the Changes.%4$s
			%2$s', 'magazine-news-byte' ), '<ol>', '</ol>', '<li>', '</li>', '<strong>', '</strong>', '<em>', '</em>', '<br />',
										'<a href="' . esc_url( $settinglink ) . '">',
										'<a href="' . esc_url( $addpagelink ) . '">',
										'</a>'
				),
		'img' => $imagepath . 'qstart-staticpage.png',
		'style' => 'img-bottom',
		);

	$menulink = admin_url( 'nav-menus.php' );
	$quickstart[] = array(
		'name' => esc_html__( 'Setup Main Navigation Menu', 'magazine-news-byte' ),
		/* Translators: The %s are placeholders for HTML, so the order can't be changed. */
		'desc' => sprintf( esc_html__( '%1$s
			%3$sIn your wp-admin, go to %10$sAppearance > Menus%12$s%4$s
			%3$sClick on %5$screate a new menu%6$s link. %9$s%7$s(If you already have an existing menu, jump to Step 6)%8$s%4$s
			%3$sGive your menu a name and click %5$sCreate Menu%6$s%4$s
			%3$sNow add pages, categories, custom links etc to this menu.%4$s
			%3$sClick %5$sSave Menu%6$s%4$s
			%3$sClick %11$sManage Locations%12$s tab at the top%4$s
			%3$sSelect the menu you just created in the dropdown options.%4$s
			%3$sClick %5$sSave Changes%6$s%4$s
			%2$s%7$sTip: You can add "My Home Page" and "My Blog" pages created in above section to your menu.%8$s
			', 'magazine-news-byte' ), '<ol>', '</ol>', '<li>', '</li>', '<strong>', '</strong>', '<em>', '</em>', '<br />',
										'<a href="' . esc_url( $menulink ) . '">',
										'<a href="' . esc_url( $menulink ) . '?action=locations">',
										'</a>'
				),
		);

	$widgetslink = admin_url( 'widgets.php' );
	$customizelink = admin_url( 'customize.php' );
	$quickstart[] = array(
		'name' => esc_html__( 'Add Content to Frontpage', 'magazine-news-byte' ),
		/* Translators: The %s are placeholders for HTML, so the order can't be changed. */
		'desc' => sprintf( esc_html__( '%1$s
			%3$sIn your wp-admin, go to %10$sAppearance > Widgets%12$s%4$s
			%3$sAdd Widgets to the %5$sFrontpage Widget Areas%6$s%4$s
			%3$sYou can further manage Frontpage modules in your wp-admin by going to %11$sAppearance > Customizer%12$s and click %5$sFrontpage Modules%6$s section.%4$s
			%2$s
			%9$s%9$s
			%13$sExample: Display a full width slider%14$s
			To display a full width slider on your frontpage, set one of the Frontpage Module to full width in %11$sAppearance > Customizer > Frontpage Modules%12$s. Then add a %5$sHootKit Slider%6$s widget to this area from the %10$sWidgets%12$s screen.
			', 'magazine-news-byte' ), '<ol>', '</ol>', '<li>', '</li>', '<strong>', '</strong>', '<em>', '</em>', '<hr>',
										'<a href="' . esc_url( $widgetslink ) . '">',
										'<a href="' . esc_url( $customizelink ) . '">',
										'</a>', '<h4>', '</h4>'
				),
		'img' => $imagepath . 'qstart-fpmodule.png',
		'style' => 'img-bottom',
		);

	if ( ! class_exists( 'HootKit' ) ) {
		$quickstart[] = array(
			/* Translators: 1 is a line break */
			'name' => sprintf( esc_html__( 'Install%1$sHootKit plugin', 'magazine-news-byte' ), '<br />' )
					. '<small>' . esc_html__( '[ recommended ]', 'magazine-news-byte' ) . '</small>',
			/* Translators: 1 is the theme name */
			'desc' => sprintf( esc_html__( '%1$s works best with its companion plugin HootKit.', 'magazine-news-byte' ), $themename ) . '<hr><em>' . esc_html__( 'HootKit is a wpHoot plugin which adds various functionalities to the theme such as widgets and sliders which were developed and styled specifically for the theme.', 'magazine-news-byte' ) . '</em><hr /><a href="' . esc_url( admin_url( "themes.php?page={$slug}-welcome&tab=plugins" ) ) . '">' . esc_html__( 'Go to the Plugins tab to install HootKit', 'magazine-news-byte' ) . '</a>',
			);
	}

	$hootthemeimplink = ( ! class_exists( 'HootImport' ) ) ? '<a href="' . esc_url( admin_url( "themes.php?page={$slug}-welcome&tab=plugins" ) ) . '">' . esc_html__( 'Go to the Plugins tab to install Hoot Import plugin', 'magazine-news-byte' ) . '</a>' : '<a href="' . esc_url( admin_url( "themes.php?page=hoot-import" ) ) . '">' . esc_html__( 'Go to Hoot Import', 'magazine-news-byte' ) . '</a>';
	$quickstart[] = array(
		/* Translators: 1 is a line break */
		'name' => sprintf( esc_html__( 'Install%1$sDemo Content', 'magazine-news-byte' ), '<br />' )
				. '<small>' . esc_html__( '[ optional ]', 'magazine-news-byte' ) . '</small>',
		/* Translators: The %s are placeholders for HTML, so the order can't be changed. */
		'desc' => sprintf( esc_html__( 'Importing demo content is the easiest way to setup your theme and make it look like the %1$sDemo Site%2$s', 'magazine-news-byte' ), '<a href="https://demo.wphoot.com/JNES@SLUG/" target="_blank">', '</a>' )
			. '<hr />' . $hootthemeimplink,
		);


	return ( !empty( $$string ) ) ? $$string : '';


}