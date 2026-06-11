<?php
/**
 * Sons of the Beach — Theme Functions
 *
 * @package sotb
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* ============================================================
   THEME SETUP
   ============================================================ */
function sotb_setup() {
	// Allow WordPress to manage the document title
	add_theme_support( 'title-tag' );

	// Enable post thumbnails / featured images
	add_theme_support( 'post-thumbnails' );

	// Register navigation menus
	register_nav_menus( array(
		'primary' => __( 'Primary Navigation', 'sotb' ),
		'footer'  => __( 'Footer Navigation', 'sotb' ),
	) );

	// HTML5 markup support
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
		'style',
		'script',
	) );

	// Responsive embed support
	add_theme_support( 'responsive-embeds' );

	// Wide alignment support for Gutenberg
	add_theme_support( 'align-wide' );

	// Custom logo
	add_theme_support( 'custom-logo', array(
		'height'      => 80,
		'width'       => 300,
		'flex-height' => true,
		'flex-width'  => true,
	) );

	// Editor color palette matching brand colors
	add_theme_support( 'editor-color-palette', array(
		array(
			'name'  => __( 'Primary Blue', 'sotb' ),
			'slug'  => 'primary',
			'color' => '#6670A6',
		),
		array(
			'name'  => __( 'Sandy Gold', 'sotb' ),
			'slug'  => 'accent',
			'color' => '#D4B483',
		),
		array(
			'name'  => __( 'Dark Background', 'sotb' ),
			'slug'  => 'background',
			'color' => '#12141E',
		),
		array(
			'name'  => __( 'Card Background', 'sotb' ),
			'slug'  => 'card',
			'color' => '#1C1F2E',
		),
		array(
			'name'  => __( 'Muted Text', 'sotb' ),
			'slug'  => 'muted',
			'color' => '#8589A0',
		),
	) );

	// Set content-width for embeds
	global $content_width;
	if ( ! isset( $content_width ) ) {
		$content_width = 800;
	}
}
add_action( 'after_setup_theme', 'sotb_setup' );

/* ============================================================
   THUMBNAIL SIZES
   ============================================================ */
function sotb_add_image_sizes() {
	// Card thumbnail (16:9)
	add_image_size( 'sotb-card', 600, 337, true );
	// Hero background
	add_image_size( 'sotb-hero', 1920, 700, true );
	// Single post header
	add_image_size( 'sotb-single', 1200, 630, true );
}
add_action( 'after_setup_theme', 'sotb_add_image_sizes' );

/* ============================================================
   ENQUEUE SCRIPTS & STYLES
   ============================================================ */
function sotb_enqueue_assets() {
	$version = wp_get_theme()->get( 'Version' );

	wp_enqueue_style(
		'sotb-fonts',
		'https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@600;700;800&family=Inter:wght@400;500;600;700&display=swap',
		array(),
		null
	);

	wp_enqueue_style(
		'sotb-style',
		get_stylesheet_uri(),
		array( 'sotb-fonts' ),
		$version
	);

	// Main JS
	wp_enqueue_script(
		'sotb-main',
		get_template_directory_uri() . '/assets/js/main.js',
		array(),
		$version,
		true
	);
}
add_action( 'wp_enqueue_scripts', 'sotb_enqueue_assets' );

/* ============================================================
   REGISTER SIDEBAR
   ============================================================ */
function sotb_register_sidebars() {
	register_sidebar( array(
		'name'          => __( 'Primary Sidebar', 'sotb' ),
		'id'            => 'primary-sidebar',
		'description'   => __( 'Add widgets here to appear in the sidebar.', 'sotb' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer Widget Area', 'sotb' ),
		'id'            => 'footer-sidebar',
		'description'   => __( 'Add widgets here to appear in the footer.', 'sotb' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );
}
add_action( 'widgets_init', 'sotb_register_sidebars' );

/* ============================================================
   EXCERPT LENGTH
   ============================================================ */
function sotb_excerpt_length( $length ) {
	return 20;
}
add_filter( 'excerpt_length', 'sotb_excerpt_length', 999 );

function sotb_excerpt_more( $more ) {
	return '&hellip;';
}
add_filter( 'excerpt_more', 'sotb_excerpt_more' );

/* ============================================================
   CUSTOM BODY CLASSES
   ============================================================ */
function sotb_body_classes( $classes ) {
	if ( is_singular() ) {
		$classes[] = 'sotb-singular';
	}
	if ( is_front_page() ) {
		$classes[] = 'sotb-front-page';
	}
	return $classes;
}
add_filter( 'body_class', 'sotb_body_classes' );

/* ============================================================
   NAVIGATION HELPERS
   ============================================================ */
function sotb_primary_menu_fallback( $args = null ): void {
	?>
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
	<?php
}

function sotb_footer_menu_fallback( $args = null ): void {
	?>
	<nav class="footer-nav" aria-label="<?php esc_attr_e( 'Footer Navigation', 'sotb' ); ?>">
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a>
		<a href="<?php echo esc_url( home_url( '/news/' ) ); ?>">News</a>
		<a href="<?php echo esc_url( home_url( '/tornei/' ) ); ?>">Tornei</a>
		<a href="<?php echo esc_url( home_url( '/contatti/' ) ); ?>">Contatti</a>
	</nav>
	<?php
}

function sotb_nav_menu_link_attributes( array $atts, WP_Post $menu_item, stdClass $args ): array {
	if ( isset( $args->theme_location ) && 'primary' === $args->theme_location ) {
		$atts['role'] = 'menuitem';

		if ( isset( $atts['href'] ) && false !== strpos( $atts['href'], '/contatti/' ) ) {
			$atts['class'] = isset( $atts['class'] ) ? $atts['class'] . ' nav-cta' : 'nav-cta';
		}
	}

	return $atts;
}
add_filter( 'nav_menu_link_attributes', 'sotb_nav_menu_link_attributes', 10, 3 );

function sotb_contact_notice_key( string $type ): string {
	$remote_addr = isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : '';
	$user_agent  = isset( $_SERVER['HTTP_USER_AGENT'] ) ? sanitize_text_field( wp_unslash( $_SERVER['HTTP_USER_AGENT'] ) ) : '';

	return 'sotb_contact_' . sanitize_key( $type ) . '_' . wp_hash( $remote_addr . '|' . $user_agent );
}

function sotb_set_contact_notice( string $type, string $message ): void {
	set_transient( sotb_contact_notice_key( $type ), $message, 60 );
}

/* ============================================================
   CONTACT FORM HANDLER
   ============================================================ */
function sotb_handle_contact_form() {
	if (
		! isset( $_POST['sotb_contact_nonce'] )
		|| ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['sotb_contact_nonce'] ) ), 'sotb_contact_action' )
	) {
		return;
	}

	if ( ! empty( $_POST['sotb_website'] ) ) {
		sotb_set_contact_notice( 'error', 'Si è verificato un errore. Riprova più tardi.' );
		return;
	}

	$submitted_at = isset( $_POST['sotb_submitted_at'] ) ? absint( $_POST['sotb_submitted_at'] ) : 0;
	if ( ! $submitted_at || time() - $submitted_at < 3 ) {
		sotb_set_contact_notice( 'error', 'Si è verificato un errore. Riprova più tardi.' );
		return;
	}

	if ( empty( $_POST['sotb_nome'] ) || empty( $_POST['sotb_email'] ) || empty( $_POST['sotb_messaggio'] ) ) {
		sotb_set_contact_notice( 'error', 'Compila tutti i campi richiesti.' );
		return;
	}

	$nome      = sanitize_text_field( wp_unslash( $_POST['sotb_nome'] ) );
	$email     = sanitize_email( wp_unslash( $_POST['sotb_email'] ) );
	$messaggio = sanitize_textarea_field( wp_unslash( $_POST['sotb_messaggio'] ) );

	if ( ! is_email( $email ) ) {
		sotb_set_contact_notice( 'error', 'Inserisci un indirizzo email valido.' );
		return;
	}

	$to      = get_option( 'admin_email' );
	$subject = 'Nuovo messaggio dal sito Sons of the Beach';
	$body    = "Nome: {$nome}\nEmail: {$email}\n\nMessaggio:\n{$messaggio}";
	$headers = array(
		'Content-Type: text/plain; charset=UTF-8',
		"Reply-To: {$nome} <{$email}>",
	);

	$sent = wp_mail( $to, $subject, $body, $headers );

	if ( $sent ) {
		sotb_set_contact_notice( 'success', 'Messaggio inviato! Ti risponderemo al più presto.' );
	} else {
		sotb_set_contact_notice( 'error', "Si è verificato un errore. Riprova più tardi." );
	}

	wp_safe_redirect( get_permalink() );
	exit;
}
add_action( 'init', 'sotb_handle_contact_form' );

/* ============================================================
   HELPER: GET LOGO HTML
   ============================================================ */
function sotb_get_logo_html( string $size = 'nav' ): string {
	$nav_logo  = get_template_directory_uri() . '/assets/img/logo-sotb-full-cropped.png';
	$foot_logo = get_template_directory_uri() . '/assets/img/logo-sotb-transparent.png';
	$logo_url  = ( 'nav' === $size ) ? $nav_logo : $foot_logo;
	$height    = ( 'nav' === $size ) ? '48' : '36';
	$alt       = esc_attr( get_bloginfo( 'name' ) );

	if ( file_exists( get_template_directory() . '/assets/img/logo-sotb-full-cropped.png' ) ) {
		return '<img src="' . esc_url( $logo_url ) . '" alt="' . $alt . '" height="' . esc_attr( $height ) . '" loading="lazy">';
	}

	// Fallback text
	return '<span class="' . ( 'nav' === $size ? 'nav-logo-text' : 'footer-logo-text' ) . '">Sons of <span>the Beach</span></span>';
}

function sotb_get_ball_image_html( string $class = 'sotb-ball-icon', string $loading = 'lazy' ): string {
	$classes  = trim( 'sotb-ball-icon ' . $class );
	$ball_url = get_template_directory_uri() . '/assets/img/beach-volley-hero.webp';

	return '<img class="' . esc_attr( $classes ) . '" src="' . esc_url( $ball_url ) . '" alt="" loading="' . esc_attr( $loading ) . '" decoding="async" aria-hidden="true">';
}

/* ============================================================
   HELPER: WAVE SVG DIVIDER
   ============================================================ */
function sotb_wave_divider( string $fill = '#1C1F2E', bool $flip = false ): void {
	$transform = $flip ? ' style="transform:scaleX(-1);"' : '';
	echo '<div class="wave-divider"' . $transform . '>';
	echo '<svg viewBox="0 0 1440 80" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">';
	echo '<path d="M0,40 C360,80 1080,0 1440,40 L1440,80 L0,80 Z" fill="' . esc_attr( $fill ) . '"/>';
	echo '</svg>';
	echo '</div>';
}

/* ============================================================
   HELPER: POST CARD HTML
   ============================================================ */
function sotb_render_post_card( WP_Post $post, bool $placeholder = false ): void {
	if ( $placeholder ) {
		?>
		<article class="card card-placeholder sotb-fade-in">
			<div class="card-top-border"></div>
			<div class="card-image card-image--ball">
				<div class="card-image-placeholder"><?php echo sotb_get_ball_image_html( 'card-placeholder-ball', 'eager' ); ?></div>
			</div>
			<div class="card-body">
				<span class="prossimamente-badge">Prossimamente</span>
				<h3 class="card-title">Intervista in arrivo</h3>
				<p class="card-excerpt">Il contenuto sarà disponibile a breve. Torna a trovarci!</p>
				<div class="card-meta">
					<span class="card-date">— presto —</span>
				</div>
			</div>
		</article>
		<?php
		return;
	}

	setup_postdata( $post );
	$permalink  = get_permalink( $post );
	$title      = get_the_title( $post );
	$excerpt    = get_the_excerpt( $post );
	$date       = get_the_date( 'd M Y', $post );
	$thumb_id   = get_post_thumbnail_id( $post );
	$categories = get_the_category( $post->ID );
	$cat_name   = ( ! empty( $categories ) ) ? esc_html( $categories[0]->name ) : 'News';
	?>
	<article class="card sotb-fade-in">
		<div class="card-top-border"></div>
		<div class="card-image<?php echo $thumb_id ? '' : ' card-image--ball'; ?>">
			<?php if ( $thumb_id ) : ?>
				<a href="<?php echo esc_url( $permalink ); ?>" tabindex="-1" aria-hidden="true">
					<?php echo wp_get_attachment_image( $thumb_id, 'sotb-card', false, array( 'alt' => esc_attr( $title ) ) ); ?>
				</a>
			<?php else : ?>
				<a href="<?php echo esc_url( $permalink ); ?>" tabindex="-1" aria-hidden="true">
					<div class="card-image-placeholder"><?php echo sotb_get_ball_image_html( 'card-placeholder-ball', 'eager' ); ?></div>
				</a>
			<?php endif; ?>
		</div>
		<div class="card-body">
			<span class="card-category"><?php echo $cat_name; ?></span>
			<h3 class="card-title"><a href="<?php echo esc_url( $permalink ); ?>"><?php echo esc_html( $title ); ?></a></h3>
			<?php if ( $excerpt ) : ?>
				<p class="card-excerpt"><?php echo esc_html( $excerpt ); ?></p>
			<?php endif; ?>
			<div class="card-meta">
				<span class="card-date">
					<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
					<?php echo esc_html( $date ); ?>
				</span>
				<a href="<?php echo esc_url( $permalink ); ?>" class="card-read-more">
					Leggi <span aria-hidden="true">→</span>
				</a>
			</div>
		</div>
	</article>
	<?php
}
