<footer class="sotb-footer" role="contentinfo">
	<div class="container">

		<div class="footer-top">

			<!-- Logo -->
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="footer-logo" aria-label="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?> — Home">
				<?php echo sotb_get_logo_html( 'footer' ); ?>
			</a>

			<!-- Nav Links -->
			<nav class="footer-nav" aria-label="<?php esc_attr_e( 'Footer Navigation', 'sotb' ); ?>">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a>
				<a href="<?php echo esc_url( home_url( '/news/' ) ); ?>">News</a>
				<a href="<?php echo esc_url( home_url( '/tornei/' ) ); ?>">Tornei</a>
				<a href="<?php echo esc_url( home_url( '/contatti/' ) ); ?>">Contatti</a>
			</nav>

			<!-- Social Icons -->
			<div class="footer-social">
				<!-- Instagram -->
				<a href="#" class="footer-social-link" aria-label="Instagram" target="_blank" rel="noopener noreferrer">
					<svg viewBox="0 0 24 24" aria-hidden="true">
						<path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
					</svg>
				</a>
				<!-- YouTube -->
				<a href="#" class="footer-social-link" aria-label="YouTube" target="_blank" rel="noopener noreferrer">
					<svg viewBox="0 0 24 24" aria-hidden="true">
						<path d="M23.495 6.205a3.007 3.007 0 0 0-2.088-2.088c-1.87-.501-9.396-.501-9.396-.501s-7.507-.01-9.396.501A3.007 3.007 0 0 0 .527 6.205a31.247 31.247 0 0 0-.522 5.805 31.247 31.247 0 0 0 .522 5.783 3.007 3.007 0 0 0 2.088 2.088c1.868.502 9.396.502 9.396.502s7.506 0 9.396-.502a3.007 3.007 0 0 0 2.088-2.088 31.247 31.247 0 0 0 .5-5.783 31.247 31.247 0 0 0-.5-5.805zM9.609 15.601V8.408l6.264 3.602z"/>
					</svg>
				</a>
			</div>

		</div>

		<div class="footer-bottom">
			<p>&copy; <?php echo date( 'Y' ); ?> <?php bloginfo( 'name' ); ?> &mdash; Tutti i diritti riservati &nbsp;|&nbsp; <a href="<?php echo esc_url( home_url( '/contatti/' ) ); ?>">Contatti</a></p>
		</div>

	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
