<?php
/**
 * Template Name: Contatti
 *
 * @package sotb
 */

get_header();

$success_key = sotb_contact_notice_key( 'success' );
$error_key   = sotb_contact_notice_key( 'error' );
$success_msg = get_transient( $success_key );
$error_msg   = get_transient( $error_key );

if ( $success_msg ) {
	delete_transient( $success_key );
}
if ( $error_msg ) {
	delete_transient( $error_key );
}
?>

<!-- PAGE HERO -->
<section class="page-hero" aria-labelledby="contatti-heading">
	<div class="container">
		<nav class="breadcrumb" aria-label="Breadcrumb">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a>
			<span class="breadcrumb-sep" aria-hidden="true">›</span>
			<span aria-current="page">Contatti</span>
		</nav>
		<h1 id="contatti-heading">Contatti</h1>
		<p style="color:var(--color-muted);margin-top:.75rem;font-size:1rem;">
			Hai domande, proposte o vuoi collaborare con noi? Scrivici!
		</p>
	</div>
</section>

<!-- CONTATTI SECTION -->
<section class="section section--dark">
	<div class="container">
		<div class="contatti-grid">

			<!-- Left: Contact Info -->
			<div class="contact-info-block sotb-fade-in">
				<h3>Sons of the Beach</h3>

				<div class="contact-info-item">
					<span class="contact-info-icon" aria-hidden="true">🌐</span>
					<div>
						<div style="color:var(--color-muted);font-size:.75rem;text-transform:uppercase;letter-spacing:.08em;font-weight:600;margin-bottom:.2rem;">Sito web</div>
						<a href="https://sonsofthebeach.it" style="color:var(--color-accent);">sonsofthebeach.it</a>
					</div>
				</div>

				<div class="contact-info-item">
					<span class="contact-info-icon contact-info-ball" aria-hidden="true"><?php echo sotb_get_ball_image_html( 'contact-ball' ); ?></span>
					<div>
						<div style="color:var(--color-muted);font-size:.75rem;text-transform:uppercase;letter-spacing:.08em;font-weight:600;margin-bottom:.2rem;">Tornei</div>
						<a href="https://tornei.sonsofthebeach.it" target="_blank" rel="noopener noreferrer" style="color:var(--color-accent);">tornei.sonsofthebeach.it</a>
					</div>
				</div>

				<div class="contact-info-item">
					<span class="contact-info-icon" aria-hidden="true">✉️</span>
					<div>
						<div style="color:var(--color-muted);font-size:.75rem;text-transform:uppercase;letter-spacing:.08em;font-weight:600;margin-bottom:.2rem;">Email</div>
						<a href="mailto:info@sonsofthebeach.it" style="color:var(--color-accent);">info@sonsofthebeach.it</a>
					</div>
				</div>

				<div style="margin-top:1.75rem;">
					<p style="font-size:.8rem;color:var(--color-muted);text-transform:uppercase;letter-spacing:.08em;font-weight:600;margin-bottom:.85rem;">Seguici</p>
					<div class="contact-social-links">
						<!-- Instagram -->
						<a href="https://www.instagram.com/sonsofthebeach" class="contact-social-link" aria-label="Instagram" target="_blank" rel="noopener noreferrer">
							<svg viewBox="0 0 24 24" aria-hidden="true">
								<path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
							</svg>
						</a>
						<!-- Facebook -->
						<a href="https://www.facebook.com/share/1DM4zaQ4Z6/" class="contact-social-link" aria-label="Facebook" target="_blank" rel="noopener noreferrer">
							<svg viewBox="0 0 24 24" aria-hidden="true">
								<path d="M22.675 0h-21.35c-.732 0-1.325.593-1.325 1.325v21.351c0 .731.593 1.324 1.325 1.324h11.495v-9.294h-3.128v-3.622h3.128v-2.671c0-3.1 1.893-4.788 4.659-4.788 1.325 0 2.463.099 2.795.143v3.24h-1.918c-1.504 0-1.795.715-1.795 1.763v2.313h3.587l-.467 3.622h-3.12v9.294h6.116c.73 0 1.323-.593 1.323-1.324v-21.351c0-.732-.593-1.325-1.325-1.325z"/>
							</svg>
						</a>
						<!-- TikTok -->
						<a href="https://www.tiktok.com/@sons.of.the_beach" class="contact-social-link" aria-label="TikTok" target="_blank" rel="noopener noreferrer">
							<svg viewBox="0 0 24 24" aria-hidden="true">
								<path d="M16.6 5.82s.51.5 0 0A4.278 4.278 0 0 1 15.54 3h-3.09v12.4a2.592 2.592 0 0 1-2.59 2.5c-1.42 0-2.6-1.16-2.6-2.6 0-1.72 1.66-3.01 3.37-2.48V9.66c-3.45-.46-6.47 2.22-6.47 5.64 0 3.33 2.76 5.7 5.69 5.7 3.14 0 5.69-2.55 5.69-5.7V9.01a7.35 7.35 0 0 0 4.3 1.38V7.3s-1.88.09-3.24-1.48z"/>
							</svg>
						</a>
						<!-- YouTube -->
						<a href="https://youtube.com/@sonsofthebeach?si=ppYqCrPpy4aLxTEN" class="contact-social-link" aria-label="YouTube" target="_blank" rel="noopener noreferrer">
							<svg viewBox="0 0 24 24" aria-hidden="true">
								<path d="M23.495 6.205a3.007 3.007 0 0 0-2.088-2.088c-1.87-.501-9.396-.501-9.396-.501s-7.507-.01-9.396.501A3.007 3.007 0 0 0 .527 6.205a31.247 31.247 0 0 0-.522 5.805 31.247 31.247 0 0 0 .522 5.783 3.007 3.007 0 0 0 2.088 2.088c1.868.502 9.396.502 9.396.502s7.506 0 9.396-.502a3.007 3.007 0 0 0 2.088-2.088 31.247 31.247 0 0 0 .5-5.783 31.247 31.247 0 0 0-.5-5.805zM9.609 15.601V8.408l6.264 3.602z"/>
							</svg>
						</a>
						<!-- Spotify -->
						<a href="https://open.spotify.com/user/31mrkenphuxwjy2ftggqolmnnlgq" class="contact-social-link" aria-label="Spotify" target="_blank" rel="noopener noreferrer">
							<svg viewBox="0 0 24 24" aria-hidden="true">
								<path d="M12 0C5.4 0 0 5.4 0 12s5.4 12 12 12 12-5.4 12-12S18.66 0 12 0zm5.521 17.34c-.24.359-.66.48-1.021.24-2.82-1.74-6.36-2.101-10.561-1.141-.418.122-.779-.179-.899-.539-.12-.421.18-.78.54-.9 4.56-1.021 8.52-.6 11.64 1.32.42.18.479.659.301 1.02zm1.44-3.3c-.301.42-.841.6-1.262.3-3.239-1.98-8.159-2.58-11.939-1.38-.479.12-1.02-.12-1.14-.6-.12-.48.12-1.021.6-1.141 4.32-1.32 9.719-.66 13.379 1.621.361.181.54.78.36 1.2zm.12-3.36C15.24 8.4 8.82 8.16 5.16 9.301c-.6.179-1.2-.181-1.38-.721-.18-.601.18-1.2.72-1.381 4.26-1.26 11.28-1.02 15.72 1.621.539.3.719 1.02.42 1.56-.299.421-1.02.599-1.559.3z"/>
							</svg>
						</a>
					</div>
				</div>
			</div>

			<!-- Right: Contact Form -->
			<div class="contact-form-block sotb-fade-in">
				<h3>Inviaci un messaggio</h3>

				<?php if ( $success_msg ) : ?>
					<div class="form-success" role="alert">
						<strong>✓</strong> <?php echo esc_html( $success_msg ); ?>
					</div>
				<?php endif; ?>

				<?php if ( $error_msg ) : ?>
					<div class="form-error-msg" role="alert">
						<strong>⚠</strong> <?php echo esc_html( $error_msg ); ?>
					</div>
				<?php endif; ?>

				<form
					method="post"
					action="<?php echo esc_url( get_permalink() ); ?>"
					novalidate
					aria-label="Modulo di contatto"
				>
					<?php wp_nonce_field( 'sotb_contact_action', 'sotb_contact_nonce' ); ?>
					<input type="hidden" name="sotb_submitted_at" value="<?php echo esc_attr( time() ); ?>">
					<div class="sotb-hp-field" aria-hidden="true">
						<label for="sotb_website">Sito web</label>
						<input
							type="text"
							id="sotb_website"
							name="sotb_website"
							tabindex="-1"
							autocomplete="off"
						>
					</div>

					<div class="form-group">
						<label for="sotb_nome">Nome <span aria-hidden="true" style="color:var(--color-accent);">*</span></label>
						<input
							type="text"
							id="sotb_nome"
							name="sotb_nome"
							class="form-control"
							placeholder="Il tuo nome"
							required
							autocomplete="name"
							value="<?php echo isset( $_POST['sotb_nome'] ) ? esc_attr( sanitize_text_field( wp_unslash( $_POST['sotb_nome'] ) ) ) : ''; ?>"
						>
					</div>

					<div class="form-group">
						<label for="sotb_email">Email <span aria-hidden="true" style="color:var(--color-accent);">*</span></label>
						<input
							type="email"
							id="sotb_email"
							name="sotb_email"
							class="form-control"
							placeholder="tua@email.it"
							required
							autocomplete="email"
							value="<?php echo isset( $_POST['sotb_email'] ) ? esc_attr( sanitize_email( wp_unslash( $_POST['sotb_email'] ) ) ) : ''; ?>"
						>
					</div>

					<div class="form-group">
						<label for="sotb_messaggio">Messaggio <span aria-hidden="true" style="color:var(--color-accent);">*</span></label>
						<textarea
							id="sotb_messaggio"
							name="sotb_messaggio"
							class="form-control"
							placeholder="Scrivi il tuo messaggio..."
							required
							rows="6"
						><?php echo isset( $_POST['sotb_messaggio'] ) ? esc_textarea( sanitize_textarea_field( wp_unslash( $_POST['sotb_messaggio'] ) ) ) : ''; ?></textarea>
					</div>

					<button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;">
						Invia messaggio
						<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
					</button>

					<p style="font-size:.75rem;color:var(--color-muted);margin-top:.85rem;text-align:center;">
						I campi contrassegnati con * sono obbligatori.
					</p>
				</form>
			</div>

		</div>
	</div>
</section>

<?php get_footer(); ?>
