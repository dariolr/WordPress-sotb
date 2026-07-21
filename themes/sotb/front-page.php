<?php
/**
 * Front Page Template — Sons of the Beach
 *
 * @package sotb
 */

get_header();
?>

<!-- ============================================================
     HERO
     ============================================================ -->
<section class="hero" aria-labelledby="hero-heading">
	<div class="hero-bg" aria-hidden="true"></div>

	<!-- Decorative volleyball — right side of hero -->
	<div class="hero-ball" aria-hidden="true">
		<img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/img/beach-volley-hero.webp" alt="" loading="eager">
	</div>

	<div class="container">
		<div class="hero-content sotb-fade-in">
			<span class="section-kicker" aria-label="Beach Volley, Sport da Spiaggia, Lifestyle">
				<img class="kicker-ball" src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/img/beach-volley-hero.webp" alt="" aria-hidden="true">
				NEWS &nbsp;•&nbsp; INTERVISTE &nbsp;•&nbsp; PODCAST &nbsp;•&nbsp; VIDEO	
			</span>

			<h1 id="hero-heading">Il media degli sport da spiaggia</h1>

			<p class="hero-sub">
				Ogni giorno raccontiamo i protagonisti, gli eventi e le storie che nascono sulla sabbia. Beach volley, footvolley, beach tennis, FootTable e molto altro, con articoli, video, podcast e contenuti esclusivi..
			</p>

			<div class="btn-group">
				<a href="<?php echo esc_url( home_url( '/news/' ) ); ?>" class="btn btn-primary">
					Leggi le news
				</a>
				<a href="https://tornei.sonsofthebeach.it" class="btn btn-secondary" target="_blank" rel="noopener noreferrer">
					Scopri i tornei
					<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
				</a>
			</div>
		</div>
	</div>

	<!-- Wave SVG Divider -->
	<div class="hero-wave" aria-hidden="true">
		<svg viewBox="0 0 1440 80" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
			<path d="M0,40 C240,80 480,0 720,40 C960,80 1200,0 1440,40 L1440,80 L0,80 Z" fill="#1C1F2E"/>
		</svg>
	</div>
</section>

<!-- ============================================================
     MISSION / PILLARS
     ============================================================ -->
<section class="section section--card" aria-labelledby="mission-heading">
	<div class="container">
		<header class="section-header sotb-fade-in">
			<span class="section-kicker">La nostra missione</span>
			<h2 id="mission-heading">Tutto il mondo degli sport da spiaggia</h2>
			<p>Tre pilastri per raccontare beach volley, footvolley e le altre discipline sulla sabbia in tutte le loro sfaccettature.</p>
		</header>

		<div class="pillars-grid">
			<div class="pillar-card sotb-fade-in">
				<span class="pillar-icon" aria-hidden="true">
					<img src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/img/beach-volley-hero.webp" alt="">
				</span>
				<h3>Beach Volley</h3>
				<p>Il nostro sport di punta, raccontato da chi lo vive ogni giorno sulla sabbia — ma non l'unico di cui parliamo.</p>
			</div>

			<div class="pillar-card sotb-fade-in">
				<span class="pillar-icon" aria-hidden="true">
					<!-- Microphone SVG -->
					<svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
						<rect x="16" y="4" width="16" height="24" rx="8" fill="#6670A6" stroke="#4E5A94" stroke-width="1.5"/>
						<path d="M10,24 C10,31.2 16.3,37 24,37 C31.7,37 38,31.2 38,24" stroke="#D4B483" stroke-width="2.5" fill="none" stroke-linecap="round"/>
						<line x1="24" y1="37" x2="24" y2="44" stroke="#D4B483" stroke-width="2.5" stroke-linecap="round"/>
						<line x1="16" y1="44" x2="32" y2="44" stroke="#D4B483" stroke-width="2.5" stroke-linecap="round"/>
						<line x1="20" y1="13" x2="28" y2="13" stroke="rgba(255,255,255,0.35)" stroke-width="1.5" stroke-linecap="round"/>
						<line x1="20" y1="18" x2="28" y2="18" stroke="rgba(255,255,255,0.35)" stroke-width="1.5" stroke-linecap="round"/>
					</svg>
				</span>
				<h3>News</h3>
				<p>Faccia a faccia con i campioni, i tecnici e le storie che non trovi altrove.</p>
			</div>

			<div class="pillar-card sotb-fade-in">
				<span class="pillar-icon" aria-hidden="true">
					<!-- Trophy SVG -->
					<svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M14,6 L34,6 L31,26 C31,30.4 27.9,34 24,34 C20.1,34 17,30.4 17,26 Z" fill="#D4B483" stroke="#9E7C45" stroke-width="1.5" stroke-linejoin="round"/>
						<path d="M14,10 C14,10 6,10 6,17 C6,22 10,24 14,23" stroke="#9E7C45" stroke-width="2" fill="none" stroke-linecap="round"/>
						<path d="M34,10 C34,10 42,10 42,17 C42,22 38,24 34,23" stroke="#9E7C45" stroke-width="2" fill="none" stroke-linecap="round"/>
						<line x1="24" y1="34" x2="24" y2="40" stroke="#9E7C45" stroke-width="2" stroke-linecap="round"/>
						<rect x="15" y="40" width="18" height="4" rx="2" fill="#D4B483" stroke="#9E7C45" stroke-width="1.5"/>
						<path d="M19,16 L22,14 L24,10 L26,14 L29,16 L26,18 L24,22 L22,18 Z" fill="rgba(255,255,255,0.45)" stroke="rgba(255,255,255,0.2)" stroke-width="0.5"/>
					</svg>
				</span>
				<h3>Tornei</h3>
				<p>Calendario, risultati e classifiche aggiornate in tempo reale su tutti i circuiti.</p>
			</div>
		</div>
	</div>
</section>

<!-- Wave between sections -->
<div aria-hidden="true">
	<svg viewBox="0 0 1440 60" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" style="display:block;width:100%;background:#1C1F2E;">
		<path d="M0,0 C360,60 1080,0 1440,30 L1440,60 L0,60 Z" fill="#12141E"/>
	</svg>
</div>

<!-- ============================================================
     ULTIME NEWS
     ============================================================ -->
<section class="section section--dark" aria-labelledby="interviews-heading">
	<div class="container">
		<header class="section-header sotb-fade-in">
			<span class="section-kicker">Dal blog</span>
			<h2 id="interviews-heading">Ultime News</h2>
			<p>Le ultime storie raccontate da Sons of the Beach.</p>
		</header>

		<?php
		// Query last 6 posts
		$recent_posts = new WP_Query( array(
			'posts_per_page'      => 6,
			'post_status'         => 'publish',
			'ignore_sticky_posts' => true,
			'no_found_rows'       => true,
		) );

		$has_posts = $recent_posts->have_posts();
		?>

		<div class="interviews-grid">
			<?php
			if ( $has_posts ) {
				while ( $recent_posts->have_posts() ) {
					$recent_posts->the_post();
					sotb_render_post_card( $recent_posts->post );
				}
				wp_reset_postdata();
			} else {
				// Show 3 placeholder cards
				$dummy = new WP_Post( (object) array( 'ID' => 0 ) );
				for ( $i = 0; $i < 3; $i++ ) {
					sotb_render_post_card( $dummy, true );
				}
			}
			?>
		</div>

		<?php if ( $has_posts ) : ?>
			<div style="text-align:center; margin-top:2.5rem;" class="sotb-fade-in">
				<a href="<?php echo esc_url( home_url( '/news/' ) ); ?>" class="btn btn-secondary">
					Tutte le news →
				</a>
			</div>
		<?php endif; ?>

	</div>
</section>

<?php
$sotb_videos = sotb_get_youtube_videos( 6 );
if ( ! empty( $sotb_videos ) ) :
	?>
	<!-- Wave between sections -->
	<div aria-hidden="true">
		<svg viewBox="0 0 1440 60" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" style="display:block;width:100%;background:#12141E;">
			<path d="M0,30 C480,60 960,0 1440,30 L1440,60 L0,60 Z" fill="#1C1F2E"/>
		</svg>
	</div>

	<!-- ============================================================
	     VIDEO YOUTUBE
	     ============================================================ -->
	<section class="section section--card" aria-labelledby="video-heading">
		<div class="container">
			<header class="section-header sotb-fade-in">
				<span class="section-kicker">Dal canale YouTube</span>
				<h2 id="video-heading">Ultimi Video</h2>
				<p>Highlights, interviste e contenuti esclusivi direttamente dal nostro canale.</p>
			</header>

			<div class="video-grid">
				<?php foreach ( $sotb_videos as $sotb_video ) : sotb_render_video_card( $sotb_video ); endforeach; ?>
			</div>

			<div style="text-align:center; margin-top:2.5rem;" class="sotb-fade-in">
				<a href="https://youtube.com/@sonsofthebeach?si=ppYqCrPpy4aLxTEN" class="btn btn-secondary" target="_blank" rel="noopener noreferrer">
					Vai al canale YouTube →
				</a>
			</div>
		</div>
	</section>
<?php endif; ?>

<!-- ============================================================
     CTA TORNEI
     ============================================================ -->

<!-- Wave into CTA -->
<div aria-hidden="true">
	<svg viewBox="0 0 1440 60" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" style="display:block;width:100%;background:#12141E;">
		<path d="M0,30 C480,60 960,0 1440,30 L1440,60 L0,60 Z" fill="#1C1F2E"/>
	</svg>
</div>

<section class="cta-section" aria-labelledby="cta-tornei-heading">
	<div class="container">
		<div class="sotb-fade-in">
			<span class="section-kicker">I nostri tornei</span>
			<h2 id="cta-tornei-heading">Beach volley organizzato da noi</h2>
			<p>Sons of the Beach organizza tornei per ogni livello — dal circuito amatoriale alle competizioni open. Iscriviti alla prossima tappa e porta la tua coppia sulla sabbia.</p>
			<div class="btn-group" style="justify-content:center;">
				<a href="<?php echo esc_url( home_url( '/tornei/' ) ); ?>" class="btn btn-primary">
					Scopri i tornei
				</a>
				<a
					href="https://tornei.sonsofthebeach.it"
					class="btn btn-secondary"
					target="_blank"
					rel="noopener noreferrer"
				>
					Iscriviti ora
					<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
				</a>
			</div>
		</div>
	</div>
</section>

<?php get_footer(); ?>
