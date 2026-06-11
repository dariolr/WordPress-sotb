<?php
/**
 * Template Name: News
 * Page for listing news posts
 *
 * @package sotb
 */

get_header();

// Determine paged
$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

// Try to query posts in 'news' category first
$cat = get_category_by_slug( 'news' );

$query_args = array(
	'posts_per_page' => 9,
	'paged'          => $paged,
	'post_status'    => 'publish',
);

if ( $cat && ! is_wp_error( $cat ) ) {
	$query_args['cat'] = $cat->term_id;
}

$posts_query = new WP_Query( $query_args );

// If category-filtered query returns nothing, fall back to all posts
if ( ! $posts_query->have_posts() && $cat ) {
	$posts_query = new WP_Query( array(
		'posts_per_page' => 9,
		'paged'          => $paged,
		'post_status'    => 'publish',
	) );
}

?>

<!-- PAGE HERO -->
<section class="page-hero news-hero" aria-labelledby="news-heading">
	<div class="container">
		<nav class="breadcrumb" aria-label="Breadcrumb">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a>
			<span class="breadcrumb-sep" aria-hidden="true">›</span>
			<span aria-current="page">News</span>
		</nav>
		<h1 id="news-heading">News</h1>
		<p style="color:var(--color-muted);margin-top:.75rem;font-size:1rem;">
			Storie, interviste e aggiornamenti dal mondo del beach volley italiano.
		</p>
	</div>
</section>

<!-- NEWS SECTION -->
<section class="section news-list-section" aria-label="Lista news">
	<div class="container">

		<?php if ( $posts_query->have_posts() ) : ?>

			<div class="interviews-grid">
				<?php
				while ( $posts_query->have_posts() ) {
					$posts_query->the_post();
					sotb_render_post_card( $posts_query->post );
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
				'total'     => $posts_query->max_num_pages,
				'prev_text' => '&#8592; Precedente',
				'next_text' => 'Successivo &#8594;',
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
				<span class="empty-state-icon" aria-hidden="true">
					<?php echo sotb_get_ball_image_html( 'empty-state-ball', 'eager' ); ?>
				</span>
				<h3>Prossimamente</h3>
				<p>Le news arriveranno presto. Torna a trovarci — grandi storie dal mondo del beach volley italiano ti aspettano!</p>
				<div style="margin-top:1.75rem;">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn-secondary">← Torna alla home</a>
				</div>
			</div>

		<?php endif; ?>

	</div>
</section>

<?php get_footer(); ?>
