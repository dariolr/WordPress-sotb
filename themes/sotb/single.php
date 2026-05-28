<?php
/**
 * Single Post Template
 *
 * @package sotb
 */

get_header();

if ( have_posts() ) :
	the_post();

	$thumb_id  = get_post_thumbnail_id();
	$thumb_url = $thumb_id ? wp_get_attachment_image_url( $thumb_id, 'sotb-hero' ) : '';
	$author    = get_the_author();
	$date      = get_the_date( 'd F Y' );
	$cats      = get_the_category();
	$cat_name  = ! empty( $cats ) ? esc_html( $cats[0]->name ) : 'News';
?>

<!-- SINGLE HERO -->
<header class="single-hero" aria-labelledby="post-title">
	<div
		class="single-hero-bg"
		<?php if ( $thumb_url ) : ?>
		style="background-image: url('<?php echo esc_url( $thumb_url ); ?>');"
		role="img"
		aria-label="<?php echo esc_attr( get_the_title() ); ?>"
		<?php endif; ?>
	></div>

	<div class="container single-hero-content">
		<!-- Breadcrumb -->
		<nav class="breadcrumb" aria-label="Breadcrumb" style="margin-bottom:1rem;">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a>
			<span class="breadcrumb-sep" aria-hidden="true">›</span>
			<a href="<?php echo esc_url( home_url( '/news/' ) ); ?>">News</a>
			<span class="breadcrumb-sep" aria-hidden="true">›</span>
			<span aria-current="page"><?php echo esc_html( wp_trim_words( get_the_title(), 6, '…' ) ); ?></span>
		</nav>

		<span class="card-category" style="margin-bottom:.75rem;"><?php echo $cat_name; ?></span>

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
				$tag_names = array_map( fn( $t ) => '#' . $t->name, array_slice( $tags, 0, 3 ) );
				echo esc_html( implode( '  ', $tag_names ) );
				?>
			</span>
			<?php endif; ?>
		</div>
	</div>
</header>

<!-- POST CONTENT -->
<main class="single-content" id="main-content">
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

		</div>
	</div>
</main>

<?php
endif;
get_footer();
?>
