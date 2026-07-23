<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<link rel="icon" type="image/png" sizes="32x32" href="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/img/favicon-32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/img/favicon-16.png">
	<link rel="apple-touch-icon" sizes="180x180" href="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/img/apple-touch-icon.png">
	<?php
	// Open Graph / Twitter Card
	$og_title       = is_singular() ? get_the_title() . ' — Sons of the Beach' : 'Sons of the Beach';
	$og_description = is_singular() ? wp_strip_all_tags( get_the_excerpt() ) : 'La voce autentica degli sport da spiaggia italiani. News, tornei e tutto il beach volley, footvolley e non solo.';
	$og_url         = is_singular() ? get_permalink() : home_url( '/' );
	$og_image        = get_template_directory_uri() . '/assets/img/og-image.png';
	$og_image_width  = 1200;
	$og_image_height = 630;
	if ( is_singular() && has_post_thumbnail() ) {
		// Declared og:image:width/height must match the real image, or some
		// crawlers (notably Facebook's) discard the image instead of just
		// scaling it — so pull the actual dimensions of the thumbnail used,
		// rather than assuming every featured image is exactly 1200x630.
		$thumb = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large' );
		if ( $thumb ) {
			list( $og_image, $og_image_width, $og_image_height ) = $thumb;
		}
	}
	?>
	<meta property="og:type"        content="<?php echo is_singular() ? 'article' : 'website'; ?>">
	<meta property="og:site_name"   content="Sons of the Beach">
	<meta property="og:title"       content="<?php echo esc_attr( $og_title ); ?>">
	<meta property="og:description" content="<?php echo esc_attr( $og_description ); ?>">
	<meta property="og:url"         content="<?php echo esc_url( $og_url ); ?>">
	<meta property="og:image"       content="<?php echo esc_url( $og_image ); ?>">
	<meta property="og:image:width"  content="<?php echo (int) $og_image_width; ?>">
	<meta property="og:image:height" content="<?php echo (int) $og_image_height; ?>">
	<meta property="og:locale"      content="it_IT">
	<?php $fb_app_id = get_theme_mod( 'sotb_facebook_app_id', '' ); ?>
	<?php if ( $fb_app_id ) : ?>
	<meta property="fb:app_id" content="<?php echo esc_attr( $fb_app_id ); ?>">
	<?php endif; ?>
	<meta name="twitter:card"        content="summary_large_image">
	<meta name="twitter:title"       content="<?php echo esc_attr( $og_title ); ?>">
	<meta name="twitter:description" content="<?php echo esc_attr( $og_description ); ?>">
	<meta name="twitter:image"       content="<?php echo esc_url( $og_image ); ?>">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div class="nav-mobile-overlay" id="navOverlay" aria-hidden="true"></div>

<nav class="sotb-nav" role="navigation" aria-label="<?php esc_attr_e( 'Primary Navigation', 'sotb' ); ?>">
	<div class="nav-inner">

		<!-- Logo -->
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="nav-logo" aria-label="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?> — Home">
			<?php echo sotb_get_logo_html( 'nav' ); ?>
		</a>

		<?php
		wp_nav_menu( array(
			'theme_location' => 'primary',
			'menu_id'        => 'navLinks',
			'menu_class'     => 'nav-links',
			'container'      => false,
			'fallback_cb'    => 'sotb_primary_menu_fallback',
			'depth'          => 1,
			'items_wrap'     => '<ul id="%1$s" class="%2$s" role="menubar">%3$s</ul>',
		) );
		?>

		<!-- Hamburger Button -->
		<button class="nav-hamburger" id="navHamburger" aria-controls="navLinks" aria-expanded="false" aria-label="<?php esc_attr_e( 'Apri menu', 'sotb' ); ?>">
			<span></span>
			<span></span>
			<span></span>
		</button>

	</div>
</nav>
