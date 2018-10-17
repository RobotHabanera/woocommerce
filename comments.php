<?php
/**
 * The template for displaying Comments.
 *
 * @package woondershop-pt
 */

?>
<?php if ( ! post_password_required() ) : ?>
	<div id="comments" class="comments  comments-post-<?php the_ID(); ?>">
		<?php if ( have_comments() || comments_open() || pings_open() ) : ?>

			<?php if ( have_comments() ) : ?>
				<h2 class="comments__heading"><?php esc_html_e( 'Comments' , 'woondershop-pt' ); ?></h2>
			<?php endif ?>

			<?php if ( have_comments() ) : ?>

				<div class="comments__container">
					<?php wp_list_comments( array( 'callback' => 'WoonderShopHelpers::custom_comment', 'avatar_size' => '75' ) ); ?>
				</div>

				<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through. ?>
					<nav id="comment-nav-below" class="text-xs-center  text-uppercase" role="navigation">
						<h3 class="assistive-text"><?php esc_html_e( 'Comment Navigation' , 'woondershop-pt' ); ?></h3>
						<div class="nav-previous  pull-left"><?php previous_comments_link( esc_html__( '&larr; Older Comments' , 'woondershop-pt' ) ); ?></div>
						<div class="nav-next  pull-right"><?php next_comments_link( esc_html__( 'Newer Comments &rarr;' , 'woondershop-pt' ) ); ?></div>
					</nav>
				<?php endif; ?>

				<?php
				// If there are no comments and comments are closed, let's leave a note.
				// But we only want the note on posts and pages that had comments in the first place.
				if ( ! comments_open() && get_comments_number() ) :
				?>
					<p class="nocomments"><?php esc_html_e( 'Comments for this post are closed.', 'woondershop-pt' ); ?></p>
				<?php
				endif;
				?>

			<?php endif; // 'Have comments' check end. ?>

			<?php
				$woondershop_commenter = wp_get_current_commenter();
				$woondershop_req       = get_option( 'require_name_email' );
				$woondershop_req_html  = $woondershop_req ? '<span class="required theme-clr">*</span>' : '';
				$woondershop_req_aria  = $woondershop_req ? ' aria-required="true" required' : '';
				$woondershop_consent   = empty( $woondershop_commenter['comment_author_email'] ) ? '' : ' checked="checked"';

				// The author field has a opening row div and the url field has the closing one, so that all three fields are in the same row.
				$woondershop_fields    = array(
					'author' => sprintf( '<div class="row"><div class="col-xs-12  col-lg-4  form-group"><label class="screen-reader-text" for="author">%1$s%2$s</label><input id="author" name="author" type="text" value="%3$s" placeholder="' . esc_html__( 'Name' , 'woondershop-pt' ) . ' *" class="form-control" %4$s /></div>',
						esc_html__( 'First and Last name', 'woondershop-pt' ),
						$woondershop_req_html,
						esc_attr( $woondershop_commenter['comment_author'] ),
						$woondershop_req_aria
					),
					'email'  => sprintf( '<div class="col-xs-12  col-lg-4  form-group"><label class="screen-reader-text" for="email">%1$s%2$s</label><input id="email" name="email" type="email" value="%3$s" placeholder="' . esc_html__( 'E-mail' , 'woondershop-pt' ) . ' *" class="form-control" %4$s /></div>',
						esc_html__( 'E-mail Address', 'woondershop-pt' ),
						$woondershop_req_html,
						esc_attr( $woondershop_commenter['comment_author_email'] ),
						$woondershop_req_aria
					),
					'url'    => sprintf( '<div class="col-xs-12  col-lg-4  form-group"><label class="screen-reader-text" for="url">%1$s</label><input id="url" name="url" type="url" value="%2$s" placeholder="' . esc_html__( 'Website' , 'woondershop-pt' ) . '" class="form-control" /></div></div>',
						esc_html__( 'Website', 'woondershop-pt' ),
						esc_attr( $woondershop_commenter['comment_author_url'] )
					),
					'cookies' => sprintf( '<p class="comment-form-cookies-consent"><input id="wp-comment-cookies-consent" name="wp-comment-cookies-consent" type="checkbox" value="yes" %1$s /> <label for="wp-comment-cookies-consent">%2$s</label></p>',
						$woondershop_consent,
						esc_html__( 'Save my name, email, and website in this browser for the next time I comment.', 'woondershop-pt' )
					),
				);

				$woondershop_comments_args = array(
					'fields'        => $woondershop_fields,
					'id_submit'     => 'comments-submit-button',
					'class_submit'  => 'submit  btn  btn-secondary',
					'comment_field' => sprintf( '<div class="row"><div class="col-12  form-group"><label for="comment" class="screen-reader-text">%1$s%2$s</label><textarea id="comment" name="comment" class="form-control" placeholder="' . esc_html__( 'New Comment' , 'woondershop-pt' ) . ' *" rows="5" aria-required="true"></textarea></div></div>',
						esc_html_x( 'Your comment', 'noun', 'woondershop-pt' ),
						$woondershop_req_html
					),
					'title_reply'   => '',
				);

				?>

				<h2 class="comments__heading"><?php esc_html_e( 'Leave a Comment' , 'woondershop-pt' ); ?></h2>

				<?php
				// See: https://developer.wordpress.org/reference/functions/comment_form/.
				comment_form( $woondershop_comments_args );

		else : ?>
		<div class="comments__closed">
			<?php esc_html_e( 'Comments for this post are closed.' , 'woondershop-pt' ); ?>
		</div>
	<?php
		endif;
	?>

	</div>
<?php endif; ?>
