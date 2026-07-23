<?php
/**
 * Template Name: Tornei
 * I tornei organizzati da Sons of the Beach
 *
 * @package sotb
 */

if ( ! SOTB_TORNEI_ENABLED ) {
	wp_safe_redirect( home_url( '/' ) );
	exit;
}

get_header();
?>

<!-- PAGE HERO -->
<section class="page-hero" aria-labelledby="tornei-heading">
	<div class="container">
		<nav class="breadcrumb" aria-label="Breadcrumb">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a>
			<span class="breadcrumb-sep" aria-hidden="true">›</span>
			<span aria-current="page">Tornei</span>
		</nav>
		<h1 id="tornei-heading">I nostri tornei</h1>
		<p style="color:var(--color-muted);margin-top:.75rem;font-size:1rem;">
			Sons of the Beach organizza tornei di beach volley per ogni livello: dal circuito amatoriale fino alle competizioni open.
		</p>
	</div>
</section>

<!-- INTRO -->
<section class="section section--dark" aria-labelledby="tornei-intro-heading">
	<div class="container">

		<header class="section-header sotb-fade-in">
			<span class="section-kicker">Organizziamo noi</span>
			<h2 id="tornei-intro-heading">Beach volley da vivere, non solo da guardare</h2>
			<p>Dai tornei di quartiere ai circuiti regionali, Sons of the Beach porta la competizione sulla sabbia con format pensati per divertire e far crescere ogni atleta.</p>
		</header>

		<!-- Feature cards -->
		<div class="pillars-grid" style="margin-top:3rem;">

			<div class="pillar-card sotb-fade-in">
				<span class="pillar-icon" aria-hidden="true">
					<!-- Calendar SVG -->
					<svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
						<rect x="5" y="9" width="38" height="34" rx="4" fill="#1C1F2E" stroke="#6670A6" stroke-width="2"/>
						<rect x="5" y="9" width="38" height="11" rx="4" fill="#6670A6"/>
						<rect x="5" y="16" width="38" height="4" fill="#6670A6"/>
						<line x1="15" y1="5" x2="15" y2="14" stroke="#D4B483" stroke-width="2.5" stroke-linecap="round"/>
						<line x1="33" y1="5" x2="33" y2="14" stroke="#D4B483" stroke-width="2.5" stroke-linecap="round"/>
						<rect x="11" y="26" width="6" height="6" rx="1" fill="#D4B483" opacity="0.8"/>
						<rect x="21" y="26" width="6" height="6" rx="1" fill="#D4B483" opacity="0.5"/>
						<rect x="31" y="26" width="6" height="6" rx="1" fill="#D4B483" opacity="0.5"/>
						<rect x="11" y="35" width="6" height="4" rx="1" fill="#D4B483" opacity="0.4"/>
						<rect x="21" y="35" width="6" height="4" rx="1" fill="#D4B483" opacity="0.4"/>
					</svg>
				</span>
				<h3>Calendario stagionale</h3>
				<p>Una stagione strutturata con tappe progressive: iscriviti a una o segui tutto il circuito.</p>
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
				<h3>Circuito classifiche</h3>
				<p>Ogni torneo assegna punti al ranking ufficiale. Scala la classifica e qualificati alle finali.</p>
			</div>

			<div class="pillar-card sotb-fade-in">
				<span class="pillar-icon" aria-hidden="true">
					<!-- People/Team SVG -->
					<svg viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
						<circle cx="17" cy="15" r="7" fill="#6670A6" stroke="#4E5A94" stroke-width="1.5"/>
						<circle cx="31" cy="15" r="7" fill="#6670A6" stroke="#4E5A94" stroke-width="1.5"/>
						<path d="M4,42 C4,33.2 9.9,26 17,26" stroke="#D4B483" stroke-width="2.5" fill="none" stroke-linecap="round"/>
						<path d="M44,42 C44,33.2 38.1,26 31,26" stroke="#D4B483" stroke-width="2.5" fill="none" stroke-linecap="round"/>
						<path d="M17,26 C17,26 20,24 24,24 C28,24 31,26 31,26 C38.1,26 44,33.2 44,42 L4,42 C4,33.2 9.9,26 17,26 Z" fill="#6670A6" opacity="0.3"/>
						<ellipse cx="24" cy="13" rx="4" ry="2" fill="rgba(255,255,255,0.15)"/>
					</svg>
				</span>
				<h3>Per ogni livello</h3>
				<p>Categorie open, amatoriale e under: un posto per chi vuole crescere e per chi vuole vincere.</p>
			</div>

		</div>

		<!-- CTA to platform -->
		<div class="tornei-portal-card sotb-fade-in" style="margin-top:4rem;">
			<h2 style="margin-top:0;">Iscriviti ai prossimi tornei</h2>
			<p>Controlla le date, sfoglia il calendario e registra la tua coppia direttamente sulla piattaforma ufficiale.</p>
			<a
				href="https://tornei.sonsofthebeach.it"
				class="btn btn-primary"
				target="_blank"
				rel="noopener noreferrer"
				style="font-size:1rem; padding:.9rem 2.25rem; margin-inline:auto;"
			>
				Iscriviti su tornei.sonsofthebeach.it
				<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
			</a>
		</div>

	</div>
</section>

<?php get_footer(); ?>
