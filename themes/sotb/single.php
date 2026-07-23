<?php
/**
 * Single Post Template
 *
 * @package sotb
 */

get_header();

if ( have_posts() ) :
	the_post();

	$thumb_id = get_post_thumbnail_id();
	$author   = get_the_author();
	$date     = get_the_date( 'd F Y' );
	$cats     = get_the_category();
	$cat_name = ! empty( $cats ) ? esc_html( $cats[0]->name ) : 'News';
	$sports   = get_the_terms( get_the_ID(), 'sport' );
	$sports   = is_array( $sports ) ? $sports : array();
?>

<?php if ( $thumb_id ) : ?>
	<section class="single-featured-media" aria-label="Immagine in evidenza">
		<div class="container">
			<figure class="single-featured-frame">
				<div class="single-featured-image-wrap">
				<?php
				echo wp_get_attachment_image(
					$thumb_id,
					'full',
					false,
					array(
						'class'    => 'single-featured-image',
						'loading'  => 'eager',
						'decoding' => 'async',
						'sizes'    => '(min-width: 1200px) 1100px, calc(100vw - 40px)',
					)
				);
				?>
				<?php echo sotb_get_attachment_credit_html( $thumb_id ); ?>
				</div>
				<?php echo sotb_get_attachment_caption_html( $thumb_id, 'single-featured-caption' ); ?>
			</figure>
		</div>
	</section>
<?php endif; ?>

<!-- SINGLE HERO -->
<header class="single-hero" aria-labelledby="post-title">
	<div class="container single-hero-content">
		<!-- Breadcrumb -->
		<nav class="breadcrumb" aria-label="Breadcrumb" style="margin-bottom:1rem;">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a>
			<span class="breadcrumb-sep" aria-hidden="true">›</span>
			<a href="<?php echo esc_url( home_url( '/news/' ) ); ?>">News</a>
			<span class="breadcrumb-sep" aria-hidden="true">›</span>
			<span aria-current="page"><?php echo esc_html( wp_trim_words( get_the_title(), 6, '…' ) ); ?></span>
		</nav>

		<div class="card-badges" style="margin-bottom:.75rem;">
			<span class="card-category"><?php echo $cat_name; ?></span>
			<?php foreach ( $sports as $sport ) : ?>
				<a href="<?php echo esc_url( get_term_link( $sport ) ); ?>" class="card-sport-badge"><?php echo esc_html( $sport->name ); ?></a>
			<?php endforeach; ?>
		</div>

		<h1 id="post-title"><?php the_title(); ?></h1>

		<div class="single-meta">
			<span>
				<svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
				<?php echo esc_html( $author ); ?>
			</span>
			<span>
				<svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
				<?php echo esc_html( $date ); ?>
			</span>
			<?php if ( get_the_tags() ) : ?>
			<span>
				<?php
				$tags = get_the_tags();
				$tag_links = array_map(
					fn( $t ) => '<a href="' . esc_url( get_tag_link( $t->term_id ) ) . '">#' . esc_html( $t->name ) . '</a>',
					$tags
				);
				echo implode( '  ', $tag_links ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				?>
			</span>
			<?php endif; ?>
		</div>

		<?php
		$share_url   = get_permalink();
		$share_title = get_the_title();
		?>
		<div class="share-row" role="group" aria-label="Condividi questo articolo">
			<a
				class="share-link"
				aria-label="Condividi su WhatsApp"
				title="Condividi su WhatsApp"
				target="_blank"
				rel="noopener noreferrer"
				href="https://wa.me/?text=<?php echo rawurlencode( $share_title . ' ' . $share_url ); ?>"
			>
				<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91c0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21h.01c5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.816 9.816 0 0 0 12.04 2zm5.8 14.02c-.24.68-1.4 1.32-1.93 1.36-.5.05-1.02.24-3.4-.75-2.87-1.19-4.72-4.14-4.86-4.33-.14-.19-1.17-1.55-1.17-2.97 0-1.4.73-2.09.99-2.38.26-.28.57-.35.76-.35.19 0 .38 0 .55.01.18.01.42-.07.65.5.24.58.81 2.01.88 2.16.07.14.12.31.02.5-.1.19-.15.31-.29.48-.14.17-.3.37-.43.5-.14.14-.29.29-.13.57.17.28.75 1.24 1.61 2.01 1.11 1 2.05 1.3 2.33 1.45.28.14.44.12.6-.07.17-.19.71-.83.9-1.11.19-.28.38-.24.63-.14.26.09 1.64.77 1.92.91.28.14.47.21.53.33.07.12.07.71-.17 1.39z"/></svg>
			</a>
			<a
				class="share-link"
				aria-label="Condividi su Facebook"
				title="Condividi su Facebook"
				target="_blank"
				rel="noopener noreferrer"
				href="https://www.facebook.com/sharer/sharer.php?u=<?php echo rawurlencode( $share_url ); ?>"
			>
				<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M22.675 0h-21.35c-.732 0-1.325.593-1.325 1.325v21.351c0 .731.593 1.324 1.325 1.324h11.495v-9.294h-3.128v-3.622h3.128v-2.671c0-3.1 1.893-4.788 4.659-4.788 1.325 0 2.463.099 2.795.143v3.24h-1.918c-1.504 0-1.795.715-1.795 1.763v2.313h3.587l-.467 3.622h-3.12v9.294h6.116c.73 0 1.323-.593 1.323-1.324v-21.351c0-.732-.593-1.325-1.325-1.325z"/></svg>
			</a>
			<a
				class="share-link"
				aria-label="Condividi su X"
				title="Condividi su X"
				target="_blank"
				rel="noopener noreferrer"
				href="https://twitter.com/intent/tweet?url=<?php echo rawurlencode( $share_url ); ?>&text=<?php echo rawurlencode( $share_title ); ?>"
			>
				<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
			</a>
			<button
				type="button"
				class="share-link share-copy-link"
				aria-label="Copia link articolo"
				title="Copia link articolo"
				data-share-url="<?php echo esc_url( $share_url ); ?>"
			>
				<svg viewBox="0 0 24 24" aria-hidden="true"><path d="M16 1H4c-1.1 0-2 .9-2 2v14h2V3h12V1zm3 4H8c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h11c1.1 0 2-.9 2-2V7c0-1.1-.9-2-2-2zm0 16H8V7h11v14z"/></svg>
			</button>
		</div>
	</div>
</header>

<!-- POST CONTENT -->
<main class="single-content editorial-single-content" id="main-content">
	<div class="container">
		<div class="post-body">

			<a href="<?php echo esc_url( home_url( '/news/' ) ); ?>" class="back-link">
				<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
				Torna alle news
			</a>

			<div class="post-content">
				<?php the_content(); ?>
			</div>

			<!-- Post footer -->
			<footer style="margin-top:3rem; padding-top:2rem; border-top:1px solid var(--color-border);">
				<div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:1rem;">
					<a href="<?php echo esc_url( home_url( '/news/' ) ); ?>" class="back-link">
						<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
						Tutte le news
					</a>
					<?php
					$prev = get_previous_post();
					$next = get_next_post();
					?>
					<div style="display:flex; gap:1rem; flex-wrap:wrap;">
						<?php if ( $prev ) : ?>
						<a href="<?php echo esc_url( get_permalink( $prev ) ); ?>" class="btn btn-secondary" style="font-size:.8rem; padding:.55rem 1rem;">
							← <?php echo esc_html( wp_trim_words( get_the_title( $prev ), 4, '…' ) ); ?>
						</a>
						<?php endif; ?>
						<?php if ( $next ) : ?>
						<a href="<?php echo esc_url( get_permalink( $next ) ); ?>" class="btn btn-secondary" style="font-size:.8rem; padding:.55rem 1rem;">
							<?php echo esc_html( wp_trim_words( get_the_title( $next ), 4, '…' ) ); ?> →
						</a>
						<?php endif; ?>
					</div>
				</div>
			</footer>

			<?php if ( comments_open() || get_comments_number() ) : ?>
				<div class="sotb-comments">
					<?php comments_template(); ?>
				</div>
			<?php endif; ?>

		</div>
	</div>
</main>

<?php
endif;
get_footer();
?>
