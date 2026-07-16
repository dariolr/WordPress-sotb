<?php
/**
 * Index — Fallback Template
 *
 * @package sotb
 */

get_header();

/**
 * @var WP_Query $wp_query
 * @var WP_Post  $post
 */
global $wp_query, $post;
?>

<section class="page-hero">
	<div class="container">
		<?php if ( is_tag() ) : ?>
			<h1><?php echo esc_html( '#' . single_tag_title( '', false ) ); ?></h1>
			<p style="color:var(--color-muted);margin-top:.75rem;">
				<?php
				printf(
					/* translators: %d: number of posts found */
					esc_html( _n( '%d articolo trovato', '%d articoli trovati', $wp_query->found_posts, 'sotb' ) ),
					(int) $wp_query->found_posts
				);
				?>
			</p>
		<?php elseif ( is_tax( 'sport' ) ) : ?>
			<h1><?php echo esc_html( single_term_title( '', false ) ); ?></h1>
			<p style="color:var(--color-muted);margin-top:.75rem;">
				<?php
				printf(
					/* translators: %d: number of posts found */
					esc_html( _n( '%d articolo trovato', '%d articoli trovati', $wp_query->found_posts, 'sotb' ) ),
					(int) $wp_query->found_posts
				);
				?>
			</p>
		<?php else : ?>
			<h1><?php bloginfo( 'name' ); ?></h1>
			<p style="color:var(--color-muted);margin-top:.75rem;"><?php bloginfo( 'description' ); ?></p>
		<?php endif; ?>
	</div>
</section>

<main class="section section--dark" id="main-content">
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
					'prev_text' => '← Precedente',
					'next_text' => 'Successivo →',
					'type'      => 'list',
				) );
				?>
			</nav>

		<?php else : ?>

			<div class="empty-state">
				<span class="empty-state-icon" aria-hidden="true"><?php echo sotb_get_ball_image_html( 'empty-state-ball', 'eager' ); ?></span>
				<h3>Nessun contenuto trovato</h3>
				<p>Non sono stati trovati articoli. Torna a trovarci presto!</p>
			</div>

		<?php endif; ?>

	</div>
</main>

<?php get_footer(); ?>
