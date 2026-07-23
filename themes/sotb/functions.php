<?php
/**
 * Sons of the Beach — Theme Functions
 *
 * @package sotb
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once get_template_directory() . '/admin-scuole-location.php';

/**
 * Sezione Tornei temporaneamente disabilitata (non eliminata): mettere a
 * true per far ricomparire la voce di menu, i riferimenti in homepage, il
 * blocco in Contatti e la pagina /tornei/ stessa.
 */
define( 'SOTB_TORNEI_ENABLED', false );

/**
 * Nasconde la voce "Tornei" anche quando in Aspetto → Menu è assegnato un
 * menu vero e proprio (non il fallback PHP di sotb_primary_menu_fallback/
 * sotb_footer_menu_fallback, che coprono solo il caso senza menu salvato).
 */
function sotb_maybe_hide_tornei_menu_item( array $items ): array {
	if ( SOTB_TORNEI_ENABLED ) {
		return $items;
	}

	return array_values(
		array_filter(
			$items,
			static function ( $item ) {
				return false === strpos( $item->url, '/tornei/' );
			}
		)
	);
}
add_filter( 'wp_nav_menu_objects', 'sotb_maybe_hide_tornei_menu_item' );

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
   MOBILE → APP REDIRECT
   Sends mobile visitors landing on the homepage straight to the
   deployed Flutter web app instead of the WordPress front page.
   ============================================================ */
function sotb_maybe_redirect_mobile_to_app() {
	// Only the homepage: article/page links shared and opened on mobile
	// should keep working in the browser (the app has no deep-linking
	// for individual posts yet).
	if ( ! is_front_page() ) {
		return;
	}

	if ( is_admin() || wp_doing_ajax() || wp_doing_cron() || is_feed() ) {
		return;
	}

	if ( defined( 'REST_REQUEST' ) && REST_REQUEST ) {
		return;
	}

	// Never redirect the app itself, in case rewrite rules ever route
	// that path through WordPress.
	if ( 0 === strpos( $_SERVER['REQUEST_URI'] ?? '', '/sotb/app' ) ) {
		return;
	}

	// Escape hatch: ?sito=1 lets a mobile visitor stay on the WP site
	// (e.g. to read it in the browser) for the rest of the session.
	if ( isset( $_GET['sito'] ) ) {
		setcookie( 'sotb_no_app_redirect', '1', time() + DAY_IN_SECONDS, '/' );
		return;
	}

	if ( isset( $_COOKIE['sotb_no_app_redirect'] ) ) {
		return;
	}

	if ( ! wp_is_mobile() ) {
		return;
	}

	// Don't redirect search engine / social-preview crawlers: they need
	// to keep indexing and scraping the actual WordPress homepage.
	$user_agent = $_SERVER['HTTP_USER_AGENT'] ?? '';
	if ( preg_match( '/bot|crawl|spider|slurp|facebookexternalhit|whatsapp|telegrambot|preview/i', $user_agent ) ) {
		return;
	}

	// The redirect depends on the User-Agent, so tell caches/CDNs not to
	// serve this response to a different kind of visitor.
	header( 'Vary: User-Agent' );
	wp_redirect( 'https://www.sonsofthebeach.it/sotb/app', 302 );
	exit;
}
add_action( 'template_redirect', 'sotb_maybe_redirect_mobile_to_app' );

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
   TASSONOMIA "SPORT"
   ============================================================
   Sons of the Beach copre più sport da spiaggia (beach volley,
   footvolley, ecc.). Ogni news può essere etichettata con uno o
   più sport, indipendentemente dalla categoria (che resta usata
   per il tipo di contenuto, es. "News", "Interviste").
   Nuove discipline si aggiungono da wp-admin → Sport, senza codice.
   ============================================================ */
function sotb_register_sport_taxonomy() {
	register_taxonomy(
		'sport',
		'post',
		array(
			'labels'            => array(
				'name'          => __( 'Sport', 'sotb' ),
				'singular_name' => __( 'Sport', 'sotb' ),
				'search_items'  => __( 'Cerca Sport', 'sotb' ),
				'all_items'     => __( 'Tutti gli Sport', 'sotb' ),
				'edit_item'     => __( 'Modifica Sport', 'sotb' ),
				'update_item'   => __( 'Aggiorna Sport', 'sotb' ),
				'add_new_item'  => __( 'Aggiungi nuovo Sport', 'sotb' ),
				'new_item_name' => __( 'Nome nuovo Sport', 'sotb' ),
				'menu_name'     => __( 'Sport', 'sotb' ),
			),
			'hierarchical'      => true,
			'public'            => true,
			'show_ui'           => true,
			'show_admin_column' => true,
			'show_in_rest'      => true,
			'query_var'         => true,
			'rewrite'           => array( 'slug' => 'sport' ),
		)
	);
}
add_action( 'init', 'sotb_register_sport_taxonomy' );

/**
 * Le rewrite rules di WordPress non si aggiornano da sole quando si
 * registra una tassonomia con uno slug personalizzato via codice: senza
 * un flush, i link /sport/<slug>/ restano 404 finché qualcuno non salva
 * manualmente Impostazioni → Permalink in wp-admin. Lo facciamo qui in
 * automatico, una sola volta (flush è costoso, non va fatto ad ogni
 * richiesta).
 */
function sotb_maybe_flush_sport_rewrite_rules() {
	if ( ! get_option( 'sotb_sport_rewrite_flushed' ) ) {
		flush_rewrite_rules();
		update_option( 'sotb_sport_rewrite_flushed', 1 );
	}
}
add_action( 'init', 'sotb_maybe_flush_sport_rewrite_rules', 20 );

/**
 * Crea i termini di default alla prima esecuzione, se non esistono già.
 * Da wp-admin → Articoli → Sport si possono aggiungere altre discipline in qualsiasi momento.
 */
function sotb_seed_default_sports() {
	if ( get_option( 'sotb_sports_seeded' ) ) {
		return;
	}
	foreach ( array( 'Beach Volley', 'Footvolley' ) as $sport_name ) {
		if ( ! term_exists( $sport_name, 'sport' ) ) {
			wp_insert_term( $sport_name, 'sport' );
		}
	}
	update_option( 'sotb_sports_seeded', 1 );
}
add_action( 'init', 'sotb_seed_default_sports', 20 );

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

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
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
/**
 * @param string[] $classes
 * @return string[]
 */
function sotb_body_classes( array $classes ): array {
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
		<?php if ( SOTB_TORNEI_ENABLED ) : ?>
		<a href="<?php echo esc_url( home_url( '/tornei/' ) ); ?>" role="menuitem"
		   <?php if ( is_page( 'tornei' ) ) echo 'class="current-menu-item" aria-current="page"'; ?>>
			Tornei
		</a>
		<?php endif; ?>
		<a href="<?php echo esc_url( home_url( '/contatti/' ) ); ?>" role="menuitem"
		   <?php if ( is_page( 'contatti' ) ) echo 'class="current-menu-item" aria-current="page"'; ?>>
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
		<?php if ( SOTB_TORNEI_ENABLED ) : ?>
		<a href="<?php echo esc_url( home_url( '/tornei/' ) ); ?>">Tornei</a>
		<?php endif; ?>
		<a href="<?php echo esc_url( home_url( '/contatti/' ) ); ?>">Contatti</a>
	</nav>
	<?php
}

function sotb_nav_menu_link_attributes( array $atts, WP_Post $menu_item, stdClass $args ): array {
	if ( isset( $args->theme_location ) && 'primary' === $args->theme_location ) {
		$atts['role'] = 'menuitem';
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
   MEDIA CREDIT (overlay sulle immagini)
   ============================================================ */

/** Aggiunge il campo "Credit" alla libreria media */
function sotb_attachment_credit_fields( array $form_fields, WP_Post $post ): array {
	$form_fields['sotb_image_credit'] = array(
		'label' => __( 'Credits', 'sotb' ),
		'input' => 'text',
		'value' => get_post_meta( $post->ID, '_sotb_image_credit', true ),
		'helps' => __( 'Crediti fotografici (es. "Foto: FIVB")', 'sotb' ),
	);
	return $form_fields;
}
add_filter( 'attachment_fields_to_edit', 'sotb_attachment_credit_fields', 10, 2 );

/** Salva il campo Credit */
function sotb_attachment_credit_save( array $post, array $attachment ): array {
	if ( isset( $attachment['sotb_image_credit'] ) ) {
		update_post_meta( $post['ID'], '_sotb_image_credit', sanitize_text_field( $attachment['sotb_image_credit'] ) );
	}
	return $post;
}
add_filter( 'attachment_fields_to_save', 'sotb_attachment_credit_save', 10, 2 );

/** Recupera l'HTML del credit overlay */
function sotb_get_attachment_credit_html( int $attachment_id ): string {
	$credit = get_post_meta( $attachment_id, '_sotb_image_credit', true );

	if ( ! $credit ) {
		return '';
	}

	return '<span class="sotb-image-credit">' . esc_html( $credit ) . '</span>';
}

/* ============================================================
   MEDIA CAPTION
   ============================================================ */

function sotb_get_attachment_caption_html( int $attachment_id, string $class = '' ): string {
	$caption = wp_get_attachment_caption( $attachment_id );

	if ( ! $caption ) {
		return '';
	}

	$classes = trim( 'sotb-photo-caption ' . $class );

	return '<figcaption class="' . esc_attr( $classes ) . '">' . wp_kses_post( $caption ) . '</figcaption>';
}

/** Aggiunge credit overlay alle immagini nei contenuti degli articoli */
function sotb_add_credit_overlay_to_post_images( string $content ): string {
	// is_singular( 'post' ) è vero solo quando WordPress sta renderizzando la
	// pagina dell'articolo nel front-end classico: le richieste REST (usate
	// dalla web app Flutter per leggere content.rendered) non impostano mai
	// quella condizione, quindi senza questo OR i crediti non arrivavano mai
	// all'app.
	$is_rest_request = defined( 'REST_REQUEST' ) && REST_REQUEST;
	if ( is_admin() || ( ! is_singular( 'post' ) && ! $is_rest_request ) || false === strpos( $content, 'wp-image-' ) ) {
		return $content;
	}

	// Aggiunge credit overlay a TUTTE le immagini con wp-image-N, dentro o fuori figure
	$content = preg_replace_callback(
		'/(<img\b[^>]*class="[^"]*\bwp-image-(\d+)\b[^"]*"[^>]*>)/is',
		function ( array $matches ): string {
			$credit = sotb_get_attachment_credit_html( absint( $matches[2] ) );
			if ( ! $credit ) {
				return $matches[0];
			}
			return $matches[1] . $credit;
		},
		$content
	);

	return $content;
}
add_filter( 'the_content', 'sotb_add_credit_overlay_to_post_images', 25 );

function sotb_add_media_library_captions_to_post_images( string $content ): string {
	if ( is_admin() || ! is_singular( 'post' ) || false === strpos( $content, 'wp-image-' ) ) {
		return $content;
	}

	$content = preg_replace_callback(
		'/(<figure\b[^>]*class="[^"]*\bwp-block-image\b[^"]*"[^>]*>)(.*?)(<\/figure>)/is',
		function ( array $matches ): string {
			if ( false !== stripos( $matches[2], '<figcaption' ) ) {
				return $matches[0];
			}

			if ( ! preg_match( '/\bwp-image-(\d+)\b/', $matches[2], $image_match ) ) {
				return $matches[0];
			}

			$caption = sotb_get_attachment_caption_html( absint( $image_match[1] ), 'post-image-caption' );

			if ( ! $caption ) {
				return $matches[0];
			}

			return $matches[1] . $matches[2] . $caption . $matches[3];
		},
		$content
	);

	$parts = preg_split( '/(<figure\b.*?<\/figure>)/is', $content, -1, PREG_SPLIT_DELIM_CAPTURE );

	if ( is_array( $parts ) ) {
		foreach ( $parts as $index => $part ) {
			if ( 1 === $index % 2 ) {
				continue;
			}

			$parts[ $index ] = preg_replace_callback(
				'/(<p>\s*)?(<img\b[^>]*class="[^"]*\bwp-image-(\d+)\b[^"]*"[^>]*>)(\s*<\/p>)?/is',
				function ( array $matches ): string {
					$caption = sotb_get_attachment_caption_html( absint( $matches[3] ), 'post-image-caption' );

					if ( ! $caption ) {
						return $matches[0];
					}

					return '<figure class="sotb-captioned-image">' . $matches[2] . $caption . '</figure>';
				},
				$part
			);
		}

		$content = implode( '', $parts );
	}

	return $content;
}
add_filter( 'the_content', 'sotb_add_media_library_captions_to_post_images', 20 );

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
	$author     = get_the_author_meta( 'display_name', $post->post_author );
	$thumb_id   = get_post_thumbnail_id( $post );
	$categories = get_the_category( $post->ID );
	$cat_name   = ( ! empty( $categories ) ) ? esc_html( $categories[0]->name ) : 'News';
	$sports     = get_the_terms( $post->ID, 'sport' );
	$sports     = is_array( $sports ) ? $sports : array();
	?>
	<article class="card sotb-fade-in">
		<div class="card-top-border"></div>
		<div class="card-image<?php echo $thumb_id ? '' : ' card-image--ball'; ?>">
			<?php if ( $thumb_id ) : ?>
				<a href="<?php echo esc_url( $permalink ); ?>" tabindex="-1" aria-hidden="true">
					<?php echo wp_get_attachment_image( $thumb_id, 'sotb-card', false, array( 'alt' => esc_attr( $title ) ) ); ?>
				</a>
				<?php echo sotb_get_attachment_credit_html( $thumb_id ); ?>
			<?php else : ?>
				<a href="<?php echo esc_url( $permalink ); ?>" tabindex="-1" aria-hidden="true">
					<div class="card-image-placeholder"><?php echo sotb_get_ball_image_html( 'card-placeholder-ball', 'eager' ); ?></div>
				</a>
			<?php endif; ?>
		</div>
		<div class="card-body">
			<div class="card-badges">
				<span class="card-category"><?php echo $cat_name; ?></span>
				<?php foreach ( $sports as $sport ) : ?>
					<a href="<?php echo esc_url( get_term_link( $sport ) ); ?>" class="card-sport-badge"><?php echo esc_html( $sport->name ); ?></a>
				<?php endforeach; ?>
			</div>
			<h3 class="card-title"><a href="<?php echo esc_url( $permalink ); ?>"><?php echo esc_html( $title ); ?></a></h3>
			<?php if ( $excerpt ) : ?>
				<p class="card-excerpt"><?php echo esc_html( $excerpt ); ?></p>
			<?php endif; ?>
			<div class="card-meta">
				<span class="card-meta-info">
					<?php if ( $author ) : ?>
						<span class="card-author">
							<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
							<?php echo esc_html( $author ); ?>
						</span>
					<?php endif; ?>
					<span class="card-date">
						<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
						<?php echo esc_html( $date ); ?>
					</span>
				</span>
				<a href="<?php echo esc_url( $permalink ); ?>" class="card-read-more">
					Leggi <span aria-hidden="true">→</span>
				</a>
			</div>
		</div>
	</article>
	<?php
}

/* ============================================================
   YOUTUBE — CUSTOMIZER SETTINGS
   ============================================================
   Aspetto → Personalizza → Video YouTube: API Key + Channel ID
   (Google Cloud Console). La sezione "Ultimi Video" in home mostra
   automaticamente gli ultimi caricamenti del canale.
   ============================================================ */
function sotb_customize_register( WP_Customize_Manager $wp_customize ) {
	$wp_customize->add_section(
		'sotb_youtube_section',
		array(
			'title'       => __( 'Video YouTube', 'sotb' ),
			'priority'    => 160,
			'description' => __( 'Configura la sezione "Ultimi Video" della home, alimentata dalla YouTube Data API.', 'sotb' ),
		)
	);

	$wp_customize->add_setting(
		'sotb_youtube_api_key',
		array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'sotb_youtube_api_key',
		array(
			'type'        => 'text',
			'section'     => 'sotb_youtube_section',
			'label'       => __( 'YouTube Data API Key', 'sotb' ),
			'description' => __( 'Da Google Cloud Console (YouTube Data API v3). Se impostata insieme al Channel ID, mostra automaticamente gli ultimi video del canale.', 'sotb' ),
		)
	);

	$wp_customize->add_setting(
		'sotb_youtube_channel_id',
		array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'sotb_youtube_channel_id',
		array(
			'type'        => 'text',
			'section'     => 'sotb_youtube_section',
			'label'       => __( 'Channel ID (UC...)', 'sotb' ),
			'description' => __( 'Su YouTube Studio: Impostazioni → Canale → Info di base.', 'sotb' ),
		)
	);

	$wp_customize->add_section(
		'sotb_social_section',
		array(
			'title'       => __( 'Social / SEO', 'sotb' ),
			'priority'    => 165,
			'description' => __( 'Impostazioni usate nei meta tag Open Graph (condivisione su Facebook/WhatsApp).', 'sotb' ),
		)
	);

	$wp_customize->add_setting(
		'sotb_facebook_app_id',
		array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'sotb_facebook_app_id',
		array(
			'type'        => 'text',
			'section'     => 'sotb_social_section',
			'label'       => __( 'Facebook App ID', 'sotb' ),
			'description' => __( 'Da developers.facebook.com (crea una "App" gratuita di tipo Business). Risolve l\'avviso "fb:app_id mancante" nel Facebook Sharing Debugger; non è richiesto perché le anteprime funzionino.', 'sotb' ),
		)
	);
}
add_action( 'customize_register', 'sotb_customize_register' );

/**
 * Restituisce l'elenco degli ultimi video del canale, interrogando
 * la YouTube Data API (risultato cachato). Restituisce un array vuoto
 * se API Key/Channel ID non sono configurati o la chiamata fallisce.
 *
 * @return array<int, array{id: string, title: string, thumbnail: string, url: string}>
 */
/** Strips decorative emoji (e.g. a channel prefixing titles with 🎙️) from
 * video titles pulled from YouTube, so cards show clean text only. */
function sotb_strip_emoji( string $text ): string {
	$stripped = preg_replace(
		'/[\x{1F1E6}-\x{1F1FF}\x{1F300}-\x{1FAFF}\x{2600}-\x{27BF}\x{2190}-\x{21FF}\x{2B00}-\x{2BFF}\x{FE0F}\x{200D}]/u',
		'',
		$text
	);
	return trim( $stripped ?? $text );
}

/** Cache key shared by every caller, regardless of the requested $max, so
 * there's a single, predictable entry to refresh/purge. */
function sotb_youtube_cache_key(): string {
	return 'sotb_yt_api_' . md5(
		get_theme_mod( 'sotb_youtube_api_key', '' ) . get_theme_mod( 'sotb_youtube_channel_id', '' )
	);
}

function sotb_get_youtube_videos( int $max = 6 ): array {
	$api_key    = get_theme_mod( 'sotb_youtube_api_key', '' );
	$channel_id = get_theme_mod( 'sotb_youtube_channel_id', '' );

	if ( ! $api_key || ! $channel_id ) {
		return array();
	}

	// One shared cache entry (fetching a generous batch of videos) instead
	// of one per requested $max: a single, predictable key to purge, and
	// fewer YouTube API calls overall.
	$fetch_count   = 20;
	$transient_key = sotb_youtube_cache_key();
	$cached        = get_transient( $transient_key );

	if ( false === $cached ) {
		$uploads_playlist = 'UU' . substr( $channel_id, 2 );
		$request_url      = add_query_arg(
			array(
				'part'       => 'snippet',
				'playlistId' => $uploads_playlist,
				'maxResults' => $fetch_count,
				'key'        => $api_key,
			),
			'https://www.googleapis.com/youtube/v3/playlistItems'
		);

		$response = wp_remote_get( $request_url, array( 'timeout' => 8 ) );
		$videos   = array();

		if ( ! is_wp_error( $response ) && 200 === wp_remote_retrieve_response_code( $response ) ) {
			$body = json_decode( wp_remote_retrieve_body( $response ), true );
			foreach ( $body['items'] ?? array() as $item ) {
				$snippet = $item['snippet'] ?? null;
				$vid     = $snippet['resourceId']['videoId'] ?? '';
				if ( ! $snippet || ! $vid ) {
					continue;
				}
				$videos[] = array(
					'id'        => $vid,
					// Some uploads are titled with a decorative leading emoji
					// (e.g. 🎙️ for podcast-style episodes) that renders as an
					// oversized icon in the card; stripped here at the source
					// so it never reaches the site or the app.
					'title'     => sotb_strip_emoji( $snippet['title'] ?? '' ),
					'thumbnail' => $snippet['thumbnails']['high']['url'] ?? $snippet['thumbnails']['default']['url'] ?? '',
					'url'       => 'https://www.youtube.com/watch?v=' . $vid,
				);
			}
		}

		if ( $videos ) {
			// Short cache: keeps the section fresh soon after a new upload
			// without hammering the YouTube API on every page view (quota
			// cost is 1 unit per refresh, well within the daily allowance).
			set_transient( $transient_key, $videos, 10 * MINUTE_IN_SECONDS );
		}

		$cached = $videos;
	}

	return array_slice( $cached, 0, $max );
}

/* ============================================================
   YOUTUBE — REFRESH MANUALE DELLA CACHE
   Visita .../?sotb_refresh_videos=dddd subito dopo aver pubblicato
   un nuovo video per vederlo comparire senza aspettare i 10 minuti
   di cache naturale.
   ============================================================ */
function sotb_maybe_refresh_youtube_cache() {
	if ( ( $_GET['sotb_refresh_videos'] ?? '' ) !== 'dddd' ) {
		return;
	}

	delete_transient( sotb_youtube_cache_key() );
	wp_safe_redirect( remove_query_arg( 'sotb_refresh_videos' ) );
	exit;
}
add_action( 'template_redirect', 'sotb_maybe_refresh_youtube_cache' );

/* ============================================================
   REST API — VIDEO ENDPOINT (per la app Flutter)
   ============================================================
   GET /wp-json/sotb/v1/videos — restituisce gli ultimi video del
   canale YouTube già cachati lato server. Nessuna API key esposta
   al client: la app chiama solo questo endpoint pubblico in lettura.
   ============================================================ */
function sotb_register_rest_routes() {
	register_rest_route(
		'sotb/v1',
		'/videos',
		array(
			'methods'             => WP_REST_Server::READABLE,
			'permission_callback' => '__return_true',
			'args'                => array(
				'max' => array(
					'default'           => 6,
					'sanitize_callback' => 'absint',
				),
			),
			'callback'            => function ( WP_REST_Request $request ) {
				$max = max( 1, min( 20, (int) $request->get_param( 'max' ) ) );
				return rest_ensure_response( sotb_get_youtube_videos( $max ) );
			},
		)
	);
}
add_action( 'rest_api_init', 'sotb_register_rest_routes' );

/* ============================================================
   HELPER: VIDEO CARD HTML
   ============================================================ */
function sotb_render_video_card( array $video ): void {
	?>
	<article class="card video-card sotb-fade-in">
		<div class="card-top-border"></div>
		<a class="card-image video-card-thumb" href="<?php echo esc_url( $video['url'] ); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php echo esc_attr( $video['title'] ); ?>">
			<img src="<?php echo esc_url( $video['thumbnail'] ); ?>" alt="<?php echo esc_attr( $video['title'] ); ?>" loading="lazy">
			<span class="video-play-icon" aria-hidden="true">
				<svg width="22" height="22" viewBox="0 0 24 24" fill="currentColor"><path d="M8 5v14l11-7z"/></svg>
			</span>
		</a>
		<div class="card-body">
			<span class="card-category">YouTube</span>
			<h3 class="card-title">
				<a href="<?php echo esc_url( $video['url'] ); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html( $video['title'] ); ?></a>
			</h3>
		</div>
	</article>
	<?php
}

/* ============================================================
   ANTISPAM COMMENTI (honeypot + tempo minimo di compilazione)
   Prima linea di difesa, prima ancora di Antispam Bee.
   ============================================================ */
function sotb_comment_honeypot_check( array $commentdata ): array {
	if ( ! empty( $_POST['sotb_c_website'] ) ) {
		wp_die( esc_html__( 'Richiesta non valida.', 'sotb' ) );
	}

	$submitted_at = isset( $_POST['sotb_c_time'] ) ? absint( $_POST['sotb_c_time'] ) : 0;
	if ( ! $submitted_at || ( time() - $submitted_at ) < 3 ) {
		wp_die( esc_html__( 'Richiesta troppo veloce, riprova.', 'sotb' ) );
	}

	return $commentdata;
}
add_filter( 'preprocess_comment', 'sotb_comment_honeypot_check' );

/* ============================================================
   HELPER: COMMENT HTML (callback per wp_list_comments)
   ============================================================ */
function sotb_render_comment( WP_Comment $comment, array $args, int $depth ): void {
	$tag = ( 'div' === $args['style'] ) ? 'div' : 'li';
	?>
	<<?php echo esc_html( $tag ); ?> id="comment-<?php comment_ID(); ?>" <?php comment_class( 'sotb-comment' ); ?>>
		<article class="sotb-comment-body">
			<div class="sotb-comment-avatar">
				<?php echo get_avatar( $comment, $args['avatar_size'] ); ?>
			</div>
			<div class="sotb-comment-content">
				<div class="sotb-comment-meta">
					<span class="sotb-comment-author"><?php comment_author(); ?></span>
					<span class="sotb-comment-date">
						<a href="<?php echo esc_url( get_comment_link( $comment, $args ) ); ?>">
							<?php echo esc_html( get_comment_date( 'd M Y', $comment ) ); ?>
						</a>
					</span>
				</div>

				<?php if ( '0' === $comment->comment_approved ) : ?>
					<p class="sotb-comment-awaiting-moderation"><?php esc_html_e( 'Il tuo commento è in attesa di moderazione.', 'sotb' ); ?></p>
				<?php endif; ?>

				<div class="sotb-comment-text">
					<?php comment_text(); ?>
				</div>

				<?php
				comment_reply_link(
					array_merge(
						$args,
						array(
							'reply_text' => __( 'Rispondi', 'sotb' ),
							'depth'      => $depth,
							'max_depth'  => $args['max_depth'],
							'before'     => '<div class="sotb-comment-reply">',
							'after'      => '</div>',
						)
					)
				);
				?>
			</div>
		</article>
	<?php
}
