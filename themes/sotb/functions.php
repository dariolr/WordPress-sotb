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

	// Main stylesheet (includes Google Fonts @import)
	wp_enqueue_style(
		'sotb-style',
		get_stylesheet_uri(),
		array(),
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
   CONTACT FORM HANDLER
   ============================================================ */
function sotb_handle_contact_form() {
	if (
		! isset( $_POST['sotb_contact_nonce'] )
		|| ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['sotb_contact_nonce'] ) ), 'sotb_contact_action' )
	) {
		return;
	}

	if ( empty( $_POST['sotb_nome'] ) || empty( $_POST['sotb_email'] ) || empty( $_POST['sotb_messaggio'] ) ) {
		set_transient( 'sotb_contact_error', 'Compila tutti i campi richiesti.', 60 );
		return;
	}

	$nome      = sanitize_text_field( wp_unslash( $_POST['sotb_nome'] ) );
	$email     = sanitize_email( wp_unslash( $_POST['sotb_email'] ) );
	$messaggio = sanitize_textarea_field( wp_unslash( $_POST['sotb_messaggio'] ) );

	if ( ! is_email( $email ) ) {
		set_transient( 'sotb_contact_error', 'Inserisci un indirizzo email valido.', 60 );
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
		set_transient( 'sotb_contact_success', 'Messaggio inviato! Ti risponderemo al più presto.', 60 );
	} else {
		set_transient( 'sotb_contact_error', "Si è verificato un errore. Riprova più tardi.", 60 );
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
		return '<img src="' . esc_url( $logo_url ) . '" alt="' . $alt . '" height="' . $height . '" width="auto" loading="lazy">';
	}

	// Fallback text
	return '<span class="' . ( 'nav' === $size ? 'nav-logo-text' : 'footer-logo-text' ) . '">Sons of <span>the Beach</span></span>';
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
			<div class="card-image">
				<div class="card-image-placeholder">🏐</div>
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
		<div class="card-image">
			<?php if ( $thumb_id ) : ?>
				<a href="<?php echo esc_url( $permalink ); ?>" tabindex="-1" aria-hidden="true">
					<?php echo wp_get_attachment_image( $thumb_id, 'sotb-card', false, array( 'alt' => esc_attr( $title ) ) ); ?>
				</a>
			<?php else : ?>
				<a href="<?php echo esc_url( $permalink ); ?>" tabindex="-1" aria-hidden="true">
					<div class="card-image-placeholder">🏐</div>
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
