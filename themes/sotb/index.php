<?php
/**
 * Index — Fallback Template
 *
 * @package sotb
 */

get_header();
?>

<section class="page-hero">
	<div class="container">
		<h1><?php bloginfo( 'name' ); ?></h1>
		<p style="color:var(--color-muted);margin-top:.75rem;"><?php bloginfo( 'description' ); ?></p>
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
				<span class="empty-state-icon">🏐</span>
				<h3>Nessun contenuto trovato</h3>
				<p>Non sono stati trovati articoli. Torna a trovarci presto!</p>
			</div>

		<?php endif; ?>

	</div>
</main>

<?php get_footer(); ?>
