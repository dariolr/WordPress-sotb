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
		<svg viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
			<defs>
				<radialGradient id="hbg" cx="38%" cy="32%" r="65%">
					<stop offset="0%"   stop-color="#EDD9A3"/>
					<stop offset="52%"  stop-color="#D4B483"/>
					<stop offset="100%" stop-color="#9E7C45"/>
				</radialGradient>
				<radialGradient id="hbg2" cx="50%" cy="50%" r="50%">
					<stop offset="0%"   stop-color="rgba(255,255,255,0)"/>
					<stop offset="85%"  stop-color="rgba(0,0,0,0)"/>
					<stop offset="100%" stop-color="rgba(0,0,0,0.22)"/>
				</radialGradient>
				<clipPath id="hbc"><circle cx="100" cy="100" r="96"/></clipPath>
			</defs>
			<!-- Ball body -->
			<circle cx="100" cy="100" r="96" fill="url(#hbg)"/>
			<!-- Seam lines — volleyball 3-panel pattern -->
			<path d="M8,100 C22,42 178,42 192,100"   stroke="#7B5C28" stroke-width="3.5" fill="none" stroke-linecap="round" clip-path="url(#hbc)"/>
			<path d="M8,100 C22,158 178,158 192,100"  stroke="#7B5C28" stroke-width="3.5" fill="none" stroke-linecap="round" clip-path="url(#hbc)"/>
			<path d="M100,4   C66,30 134,170 100,196" stroke="#7B5C28" stroke-width="3.5" fill="none" stroke-linecap="round" clip-path="url(#hbc)"/>
			<!-- Edge shadow -->
			<circle cx="100" cy="100" r="96" fill="url(#hbg2)"/>
			<!-- Rim -->
			<circle cx="100" cy="100" r="96" stroke="#9E7C45" stroke-width="1.5" fill="none"/>
			<!-- Highlight -->
			<ellipse cx="72" cy="62" rx="22" ry="14" fill="rgba(255,255,255,0.18)" transform="rotate(-25 72 62)"/>
		</svg>
	</div>

	<div class="container">
		<div class="hero-content sotb-fade-in">
			<span class="section-kicker" aria-label="Beach Volley, Sport da Spiaggia, Lifestyle">
				<svg class="kicker-ball" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
					<defs>
						<radialGradient id="kbg" cx="38%" cy="32%" r="65%">
							<stop offset="0%"   stop-color="#EDD9A3"/>
							<stop offset="55%"  stop-color="#D4B483"/>
							<stop offset="100%" stop-color="#9E7C45"/>
						</radialGradient>
						<clipPath id="kbc"><circle cx="10" cy="10" r="9"/></clipPath>
					</defs>
					<circle cx="10" cy="10" r="9" fill="url(#kbg)"/>
					<path d="M1,10 C2.5,4.5 17.5,4.5 19,10"  stroke="#7B5C28" stroke-width="1.2" fill="none" stroke-linecap="round" clip-path="url(#kbc)"/>
					<path d="M1,10 C2.5,15.5 17.5,15.5 19,10" stroke="#7B5C28" stroke-width="1.2" fill="none" stroke-linecap="round" clip-path="url(#kbc)"/>
					<path d="M10,1 C7,4 13,16 10,19" stroke="#7B5C28" stroke-width="1.2" fill="none" stroke-linecap="round" clip-path="url(#kbc)"/>
					<circle cx="10" cy="10" r="9" stroke="#9E7C45" stroke-width="0.8" fill="none"/>
				</svg>
				Beach Volley &nbsp;•&nbsp; Sport da Spiaggia &nbsp;•&nbsp; Lifestyle
			</span>

			<h1 id="hero-heading">La voce autentica dello sport da spiaggia</h1>

			<p class="hero-sub">
				Sons of the Beach è il media di riferimento per il beach volley italiano: interviste ai protagonisti,
				aggiornamenti dai tornei e tutto ciò che accade sulla sabbia.
			</p>

			<div class="btn-group">
				<a href="<?php echo esc_url( home_url( '/interviste/' ) ); ?>" class="btn btn-primary">
					Leggi le interviste
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
			<h2 id="mission-heading">Tutto il mondo del beach volley</h2>
			<p>Tre pilastri per raccontare lo sport da spiaggia in tutte le sue sfaccettature.</p>
		</header>

		<div class="pillars-grid">
			<div class="pillar-card sotb-fade-in">
				<span class="pillar-icon" aria-hidden="true">
					<!-- Beach Volleyball SVG -->
					<svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
						<defs>
							<radialGradient id="pb1" cx="38%" cy="32%" r="65%">
								<stop offset="0%"   stop-color="#EDD9A3"/>
								<stop offset="55%"  stop-color="#D4B483"/>
								<stop offset="100%" stop-color="#9E7C45"/>
							</radialGradient>
							<clipPath id="pc1"><circle cx="24" cy="24" r="22"/></clipPath>
						</defs>
						<circle cx="24" cy="24" r="22" fill="url(#pb1)"/>
						<path d="M2,24 C5.5,10 42.5,10 46,24"  stroke="#7B5C28" stroke-width="2" fill="none" stroke-linecap="round" clip-path="url(#pc1)"/>
						<path d="M2,24 C5.5,38 42.5,38 46,24"  stroke="#7B5C28" stroke-width="2" fill="none" stroke-linecap="round" clip-path="url(#pc1)"/>
						<path d="M24,2 C16,10 32,38 24,46"     stroke="#7B5C28" stroke-width="2" fill="none" stroke-linecap="round" clip-path="url(#pc1)"/>
						<circle cx="24" cy="24" r="22" stroke="#9E7C45" stroke-width="1" fill="none"/>
						<ellipse cx="18" cy="15" rx="5" ry="3.5" fill="rgba(255,255,255,0.22)" transform="rotate(-25 18 15)"/>
					</svg>
				</span>
				<h3>Beach Volley</h3>
				<p>Il mondo del beach volley italiano raccontato da chi lo vive ogni giorno sulla sabbia.</p>
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
				<h3>Interviste</h3>
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
     ULTIME INTERVISTE
     ============================================================ -->
<section class="section section--dark" aria-labelledby="interviews-heading">
	<div class="container">
		<header class="section-header sotb-fade-in">
			<span class="section-kicker">Dal blog</span>
			<h2 id="interviews-heading">Ultime Interviste</h2>
			<p>Le ultime storie raccontate da Sons of the Beach.</p>
		</header>

		<?php
		// Query last 3 posts
		$recent_posts = new WP_Query( array(
			'posts_per_page'      => 3,
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
				<a href="<?php echo esc_url( home_url( '/interviste/' ) ); ?>" class="btn btn-secondary">
					Tutte le interviste →
				</a>
			</div>
		<?php endif; ?>

	</div>
</section>

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
