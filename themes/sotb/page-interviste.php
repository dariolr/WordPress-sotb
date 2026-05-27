<?php
/**
 * Template Name: Interviste
 * Page for listing interview posts
 *
 * @package sotb
 */

get_header();

// Determine paged
$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

// Try to query posts in 'interviste' category first
$cat = get_category_by_slug( 'interviste' );

$query_args = array(
	'posts_per_page' => 9,
	'paged'          => $paged,
	'post_status'    => 'publish',
);

if ( $cat && ! is_wp_error( $cat ) ) {
	$query_args['cat'] = $cat->term_id;
}

$interviews = new WP_Query( $query_args );

// If category-filtered query returns nothing, fall back to all posts
if ( ! $interviews->have_posts() && $cat ) {
	$query_args_fallback = array(
		'posts_per_page' => 9,
		'paged'          => $paged,
		'post_status'    => 'publish',
	);
	$interviews = new WP_Query( $query_args_fallback );
}

?>

<!-- PAGE HERO -->
<section class="page-hero" aria-labelledby="interviste-heading">
	<div class="container">
		<nav class="breadcrumb" aria-label="Breadcrumb">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a>
			<span class="breadcrumb-sep" aria-hidden="true">›</span>
			<span aria-current="page">Interviste</span>
		</nav>
		<h1 id="interviste-heading">Interviste</h1>
		<p style="color:var(--color-muted);margin-top:.75rem;font-size:1rem;">
			Faccia a faccia con i protagonisti del beach volley italiano.
		</p>
	</div>
</section>

<!-- INTERVIEWS SECTION -->
<section class="section section--dark" aria-label="Lista interviste">
	<div class="container">

		<?php if ( $interviews->have_posts() ) : ?>

			<div class="interviews-grid">
				<?php
				while ( $interviews->have_posts() ) {
					$interviews->the_post();
					sotb_render_post_card( $interviews->post );
				}
				wp_reset_postdata();
				?>
			</div>

			<!-- Pagination -->
			<?php
			$pagination = paginate_links( array(
				'base'      => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
				'format'    => '?paged=%#%',
				'current'   => max( 1, $paged ),
				'total'     => $interviews->max_num_pages,
				'prev_text' => '&#8592; Prev',
				'next_text' => 'Next &#8594;',
				'type'      => 'list',
			) );

			if ( $pagination ) :
			?>
			<nav class="sotb-pagination" aria-label="Navigazione pagine">
				<?php echo $pagination; ?>
			</nav>
			<?php endif; ?>

		<?php else : ?>

			<!-- Empty state -->
			<div class="empty-state sotb-fade-in">
				<span class="empty-state-icon" aria-hidden="true">🏐</span>
				<h3>Prossimamente</h3>
				<p>Le interviste arriveranno presto. Torna a trovarci — grandi storie dal mondo del beach volley italiano ti aspettano!</p>
				<div style="margin-top:1.75rem;">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn-secondary">← Torna alla home</a>
				</div>
			</div>

		<?php endif; ?>

	</div>
</section>

<?php get_footer(); ?>
