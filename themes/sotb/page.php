<?php
/**
 * Default Page Template
 *
 * @package sotb
 */

get_header();

if ( have_posts() ) :
	the_post();
?>

<!-- PAGE HERO -->
<section class="page-hero" aria-labelledby="page-title">
	<div class="container">
		<nav class="breadcrumb" aria-label="Breadcrumb">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a>
			<span class="breadcrumb-sep" aria-hidden="true">›</span>
			<span aria-current="page"><?php the_title(); ?></span>
		</nav>
		<h1 id="page-title"><?php the_title(); ?></h1>
	</div>
</section>

<!-- PAGE CONTENT -->
<main class="section section--dark" id="main-content">
	<div class="container--narrow">
		<div class="post-body">
			<?php the_content(); ?>
		</div>
	</div>
</main>

<?php
endif;
get_footer();
?>
