<?php
/**
 * Admin page: Scuole & Location
 *
 * Interfaccia riservata agli Amministratori WordPress per popolare le
 * tabelle "scuole" e "location" del database dell'app/web app (database
 * separato da quello di WordPress). La pagina qui è solo il "guscio"
 * (accesso ristretto via ruolo WP + HTML/CSS/JS); le chiamate di lettura e
 * scrittura vengono fatte via fetch() direttamente dal browser verso le API
 * PHP già esistenti in _php/php_sotb/ (admin_scuole.php, admin_locations.php),
 * senza duplicare le credenziali del database in WordPress.
 *
 * @package sotb
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function sotb_register_scuole_location_admin_page() {
	add_menu_page(
		__( 'Scuole & Location', 'sotb' ),
		__( 'Scuole & Location', 'sotb' ),
		'manage_options',
		'sotb-scuole-location',
		'sotb_render_scuole_location_admin_page',
		'dashicons-location-alt',
		26
	);
}
add_action( 'admin_menu', 'sotb_register_scuole_location_admin_page' );

function sotb_enqueue_scuole_location_admin_assets( string $hook ): void {
	if ( 'toplevel_page_sotb-scuole-location' !== $hook ) {
		return;
	}

	$version = wp_get_theme()->get( 'Version' );

	wp_enqueue_style(
		'sotb-admin-scuole-location',
		get_template_directory_uri() . '/assets/css/admin-scuole-location.css',
		array(),
		$version
	);

	wp_enqueue_script(
		'sotb-admin-scuole-location',
		get_template_directory_uri() . '/assets/js/admin-scuole-location.js',
		array(),
		$version,
		true
	);

	wp_localize_script(
		'sotb-admin-scuole-location',
		'sotbAdminConfig',
		array(
			// Stesso "token" condiviso già usato dalla web app/app Flutter
			// per queste API (vedi admin_locations.php, _isAdminQuery in
			// search_locations_delegate.dart). Non è un vero login, ma qui
			// la pagina è comunque protetta dal ruolo Amministratore di WP.
			'apiBase' => 'https://sonsofthebeach.it/sotb/php/',
			'token'   => 'dddd',
		)
	);
}
add_action( 'admin_enqueue_scripts', 'sotb_enqueue_scuole_location_admin_assets' );

function sotb_render_scuole_location_admin_page(): void {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( esc_html__( 'Non hai i permessi per accedere a questa pagina.', 'sotb' ) );
	}
	?>
	<div class="wrap sotb-admin-wrap">
		<h1><?php esc_html_e( 'Scuole & Location', 'sotb' ); ?></h1>
		<p>
			<?php esc_html_e( 'Gestisci le schede di scuole/circoli e location mostrate nella app e nella web app Sons of the Beach.', 'sotb' ); ?>
		</p>

		<h2 class="nav-tab-wrapper sotb-admin-tabs">
			<a href="#" class="nav-tab nav-tab-active" data-tab="scuole">
				<?php esc_html_e( 'Scuole', 'sotb' ); ?>
			</a>
			<a href="#" class="nav-tab" data-tab="location">
				<?php esc_html_e( 'Location', 'sotb' ); ?>
			</a>
		</h2>

		<div id="sotb-tab-scuole" class="sotb-admin-tab-panel" data-entity="scuole" data-endpoint="admin_scuole.php">
			<div class="sotb-admin-toolbar">
				<button type="button" class="button button-primary sotb-add-new">
					<?php esc_html_e( '+ Aggiungi scuola', 'sotb' ); ?>
				</button>
			</div>
			<div class="sotb-admin-notice" hidden></div>
			<table class="wp-list-table widefat fixed striped sotb-admin-table">
				<thead>
					<tr>
						<th><?php esc_html_e( 'Nome', 'sotb' ); ?></th>
						<th><?php esc_html_e( 'Città', 'sotb' ); ?></th>
						<th><?php esc_html_e( 'Booking online', 'sotb' ); ?></th>
						<th><?php esc_html_e( 'Attiva', 'sotb' ); ?></th>
						<th><?php esc_html_e( 'Azioni', 'sotb' ); ?></th>
					</tr>
				</thead>
				<tbody class="sotb-admin-tbody">
					<tr><td colspan="5"><?php esc_html_e( 'Caricamento…', 'sotb' ); ?></td></tr>
				</tbody>
			</table>
		</div>

		<div id="sotb-tab-location" class="sotb-admin-tab-panel" data-entity="location" data-endpoint="admin_locations.php" hidden>
			<div class="sotb-admin-toolbar">
				<button type="button" class="button button-primary sotb-add-new">
					<?php esc_html_e( '+ Aggiungi location', 'sotb' ); ?>
				</button>
			</div>
			<div class="sotb-admin-notice" hidden></div>
			<table class="wp-list-table widefat fixed striped sotb-admin-table">
				<thead>
					<tr>
						<th><?php esc_html_e( 'Nome', 'sotb' ); ?></th>
						<th><?php esc_html_e( 'Città', 'sotb' ); ?></th>
						<th><?php esc_html_e( 'Booking online', 'sotb' ); ?></th>
						<th><?php esc_html_e( 'Attiva', 'sotb' ); ?></th>
						<th><?php esc_html_e( 'Azioni', 'sotb' ); ?></th>
					</tr>
				</thead>
				<tbody class="sotb-admin-tbody">
					<tr><td colspan="5"><?php esc_html_e( 'Caricamento…', 'sotb' ); ?></td></tr>
				</tbody>
			</table>
		</div>

		<!-- Form modale, condiviso da entrambe le tab -->
		<div id="sotb-admin-modal" class="sotb-admin-modal" hidden>
			<div class="sotb-admin-modal-box">
				<button type="button" class="sotb-admin-modal-close" aria-label="<?php esc_attr_e( 'Chiudi', 'sotb' ); ?>">&times;</button>
				<h2 class="sotb-admin-modal-title"></h2>
				<form class="sotb-admin-form" enctype="multipart/form-data">
					<input type="hidden" name="id" value="">

					<table class="form-table">
						<tr>
							<th><label><?php esc_html_e( 'Nome', 'sotb' ); ?> *</label></th>
							<td><input type="text" name="nome" required class="regular-text"></td>
						</tr>
						<tr>
							<th><label><?php esc_html_e( 'Indirizzo', 'sotb' ); ?></label></th>
							<td><input type="text" name="indirizzo" class="regular-text"></td>
						</tr>
						<tr>
							<th><label><?php esc_html_e( 'Città', 'sotb' ); ?></label></th>
							<td><input type="text" name="citta" class="regular-text"></td>
						</tr>
						<tr>
							<th><label><?php esc_html_e( 'Coordinate GPS', 'sotb' ); ?></label></th>
							<td>
								<input type="number" step="any" name="latitudine" placeholder="Latitudine" style="width:48%;">
								<input type="number" step="any" name="longitudine" placeholder="Longitudine" style="width:48%;">
								<p class="description">
									<?php esc_html_e( 'Suggerimento: cerca l\'indirizzo su Google Maps, tasto destro sul punto → copia le coordinate.', 'sotb' ); ?>
								</p>
							</td>
						</tr>
						<tr>
							<th><label><?php esc_html_e( 'Telefono', 'sotb' ); ?></label></th>
							<td><input type="text" name="telefono" class="regular-text"></td>
						</tr>
						<tr>
							<th><label><?php esc_html_e( 'WhatsApp', 'sotb' ); ?></label></th>
							<td><input type="text" name="whatsapp" class="regular-text"></td>
						</tr>
						<tr>
							<th><label><?php esc_html_e( 'Email', 'sotb' ); ?></label></th>
							<td><input type="email" name="email" class="regular-text"></td>
						</tr>
						<tr>
							<th><label><?php esc_html_e( 'Sito web', 'sotb' ); ?></label></th>
							<td><input type="url" name="sitoweb" class="regular-text" placeholder="https://"></td>
						</tr>
						<tr>
							<th><label><?php esc_html_e( 'Prenotazione campi online', 'sotb' ); ?></label></th>
							<td><input type="url" name="booking" class="regular-text" placeholder="https://"></td>
						</tr>
						<tr>
							<th><label><?php esc_html_e( 'Store online', 'sotb' ); ?></label></th>
							<td><input type="url" name="ecommerce" class="regular-text" placeholder="https://"></td>
						</tr>
						<tr class="sotb-field-scuole-only">
							<th><label><?php esc_html_e( 'App propria (link store)', 'sotb' ); ?></label></th>
							<td><input type="url" name="app" class="regular-text" placeholder="https://"></td>
						</tr>
						<tr>
							<th><label><?php esc_html_e( 'Titolo "chi siamo"', 'sotb' ); ?></label></th>
							<td><input type="text" name="titolo_chi_siamo" class="regular-text"></td>
						</tr>
						<tr>
							<th><label><?php esc_html_e( 'Descrizione', 'sotb' ); ?></label></th>
							<td><textarea name="descrizione" rows="4" class="large-text"></textarea></td>
						</tr>
						<tr>
							<th><label><?php esc_html_e( 'Foto principale', 'sotb' ); ?></label></th>
							<td>
								<input type="file" name="immagine" accept="image/*">
								<img class="sotb-admin-preview" data-field="immagine" hidden alt="">
							</td>
						</tr>
						<tr>
							<th><label><?php esc_html_e( 'Logo/icona', 'sotb' ); ?></label></th>
							<td>
								<input type="file" name="icona" accept="image/*">
								<img class="sotb-admin-preview" data-field="icona" hidden alt="">
							</td>
						</tr>
						<tr>
							<th><label><?php esc_html_e( 'In evidenza', 'sotb' ); ?></label></th>
							<td><label><input type="checkbox" name="in_evidenza" value="1"> <?php esc_html_e( 'Mostra tra le location in evidenza', 'sotb' ); ?></label></td>
						</tr>
						<tr>
							<th><label><?php esc_html_e( 'Attiva', 'sotb' ); ?></label></th>
							<td><label><input type="checkbox" name="abilita" value="1" checked> <?php esc_html_e( 'Visibile nella app/web app', 'sotb' ); ?></label></td>
						</tr>
					</table>

					<p class="submit">
						<button type="submit" class="button button-primary"><?php esc_html_e( 'Salva', 'sotb' ); ?></button>
						<button type="button" class="button sotb-admin-modal-cancel"><?php esc_html_e( 'Annulla', 'sotb' ); ?></button>
					</p>
				</form>
			</div>
		</div>
	</div>
	<?php
}
