<?php
/**
 * Comments Template
 *
 * @package sotb
 */

if ( post_password_required() ) {
	return;
}
?>

<section class="comments-section" id="comments">

	<?php if ( have_comments() ) : ?>
		<h2 class="comments-title">
			<?php
			printf(
				/* translators: %s: number of comments */
				esc_html( _n( '%s commento', '%s commenti', get_comments_number(), 'sotb' ) ),
				esc_html( number_format_i18n( get_comments_number() ) )
			);
			?>
		</h2>

		<ol class="comment-list">
			<?php
			wp_list_comments( array(
				'style'       => 'ol',
				'short_ping'  => true,
				'avatar_size' => 44,
				'callback'    => 'sotb_render_comment',
			) );
			?>
		</ol>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
			<nav class="sotb-pagination comment-pagination" aria-label="<?php esc_attr_e( 'Navigazione commenti', 'sotb' ); ?>">
				<?php paginate_comments_links(); ?>
			</nav>
		<?php endif; ?>
	<?php endif; ?>

	<?php if ( ! comments_open() && get_comments_number() ) : ?>
		<p class="comments-closed-note">I commenti sono chiusi.</p>
	<?php endif; ?>

	<?php
	$sotb_commenter    = wp_get_current_commenter();
	$sotb_req          = get_option( 'require_name_email' );
	$sotb_html_req     = ( $sotb_req ) ? ' required' : '';

	comment_form( array(
		'title_reply'          => have_comments() ? __( 'Lascia un commento', 'sotb' ) : __( 'Lascia il primo commento', 'sotb' ),
		'class_form'           => 'sotb-comment-form',
		'class_submit'         => 'btn btn-primary',
		'comment_field'        => '<div class="form-group comment-form-comment"><label for="comment" class="screen-reader-text">' . __( 'Commento', 'sotb' ) . '</label><textarea class="form-control" id="comment" name="comment" rows="5" placeholder="' . esc_attr__( 'Scrivi il tuo commento…', 'sotb' ) . '" required></textarea></div>',
		'fields'               => array(
			'author'         => '<div class="form-group comment-form-author"><label for="author">' . __( 'Nome', 'sotb' ) . '</label><input class="form-control" id="author" name="author" type="text" value="' . esc_attr( $sotb_commenter['comment_author'] ) . '" placeholder="' . esc_attr__( 'Il tuo nome', 'sotb' ) . '"' . $sotb_html_req . '></div>',
			'email'          => '<div class="form-group comment-form-email"><label for="email">' . __( 'Email', 'sotb' ) . '</label><input class="form-control" id="email" name="email" type="email" value="' . esc_attr( $sotb_commenter['comment_author_email'] ) . '" placeholder="' . esc_attr__( 'La tua email (non pubblicata)', 'sotb' ) . '"' . $sotb_html_req . '></div>',
			'sotb_c_website' => '<p class="sotb-hp-field" aria-hidden="true"><label for="sotb_c_website">Sito web</label><input type="text" name="sotb_c_website" id="sotb_c_website" value="" tabindex="-1" autocomplete="off"></p><input type="hidden" name="sotb_c_time" value="' . time() . '">',
		),
	) );
	?>

</section>
