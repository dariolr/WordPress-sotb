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
	$og_description = is_singular() ? wp_strip_all_tags( get_the_excerpt() ) : 'La voce autentica dello sport da spiaggia. News, tornei e tutto il beach volley italiano.';
	$og_url         = is_singular() ? get_permalink() : home_url( '/' );
	$og_image       = get_template_directory_uri() . '/assets/img/og-image.png';
	if ( is_singular() && has_post_thumbnail() ) {
		$og_image = get_the_post_thumbnail_url( null, 'large' );
	}
	?>
	<meta property="og:type"        content="<?php echo is_singular() ? 'article' : 'website'; ?>">
	<meta property="og:site_name"   content="Sons of the Beach">
	<meta property="og:title"       content="<?php echo esc_attr( $og_title ); ?>">
	<meta property="og:description" content="<?php echo esc_attr( $og_description ); ?>">
	<meta property="og:url"         content="<?php echo esc_url( $og_url ); ?>">
	<meta property="og:image"       content="<?php echo esc_url( $og_image ); ?>">
	<meta property="og:image:width"  content="1200">
	<meta property="og:image:height" content="630">
	<meta property="og:locale"      content="it_IT">
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

		<!-- Desktop Nav Links -->
		<div class="nav-links" id="navLinks" role="menubar">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" role="menuitem"
			   <?php if ( is_front_page() ) echo 'class="current-menu-item" aria-current="page"'; ?>>
				Home
			</a>
			<a href="<?php echo esc_url( home_url( '/news/' ) ); ?>" role="menuitem"
			   <?php if ( is_page( 'news' ) || ( is_single() && in_category( 'news' ) ) ) echo 'class="current-menu-item" aria-current="page"'; ?>>
				News
			</a>
			<a href="<?php echo esc_url( home_url( '/tornei/' ) ); ?>" role="menuitem"
			   <?php if ( is_page( 'tornei' ) ) echo 'class="current-menu-item" aria-current="page"'; ?>>
				Tornei
			</a>
			<a href="<?php echo esc_url( home_url( '/contatti/' ) ); ?>" class="nav-cta" role="menuitem"
			   <?php if ( is_page( 'contatti' ) ) echo 'aria-current="page"'; ?>>
				Contatti
			</a>
		</div>

		<!-- Hamburger Button -->
		<button class="nav-hamburger" id="navHamburger" aria-controls="navLinks" aria-expanded="false" aria-label="<?php esc_attr_e( 'Apri menu', 'sotb' ); ?>">
			<span></span>
			<span></span>
			<span></span>
		</button>

	</div>
</nav>
