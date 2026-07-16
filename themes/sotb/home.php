<?php
/**
 * Blog Home Template
 * Used by WordPress when News is configured as the posts page.
 *
 * @package sotb
 */

get_header();

/**
 * @var WP_Post $post
 */
global $post;
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
			Storie, interviste e aggiornamenti dal mondo degli sport da spiaggia — beach volley, footvolley e non solo.
		</p>
	</div>
</section>

<!-- NEWS SECTION -->
<section class="section news-list-section" aria-label="Lista news">
	<div class="container">

		<?php if ( have_posts() ) : ?>

			<div class="interviews-grid">
				<?php
				while ( have_posts() ) {
					the_post();
					sotb_render_post_card( $post );
				}
				?>
			</div>

			<nav class="sotb-pagination" aria-label="Navigazione pagine">
				<?php
				echo paginate_links( array(
					'prev_text' => '&#8592; Precedente',
					'next_text' => 'Successivo &#8594;',
					'type'      => 'list',
				) );
				?>
			</nav>

		<?php else : ?>

			<div class="empty-state sotb-fade-in">
				<span class="empty-state-icon" aria-hidden="true"><?php echo sotb_get_ball_image_html( 'empty-state-ball', 'eager' ); ?></span>
				<h3>Prossimamente</h3>
				<p>Le news arriveranno presto. Torna a trovarci — grandi storie dal mondo degli sport da spiaggia ti aspettano!</p>
				<div style="margin-top:1.75rem;">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn-secondary">← Torna alla home</a>
				</div>
			</div>

		<?php endif; ?>

	</div>
</section>

<?php get_footer(); ?>
