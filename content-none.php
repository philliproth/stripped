<?php
/* Nothing found template when there is no content at all
 */
?>

<section >
	<h1 class="page-title"><?php _e( 'Nothing Found', 'stripped' ); ?></h1>

	<div>

		<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?> <!-- Show message if user is allowed to post -->

			<p><?php printf( __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'stripped' ), esc_url( admin_url( 'post-new.php' ) ) ); ?></p>

		<?php elseif ( is_search() ) : ?> <!-- Show message if user searched and nothing is found -->

			<p><?php _e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'stripped' ); ?></p>
			<?php get_search_form(); ?>

		<?php else : ?> <!-- Show message if user is lost -->

			<p><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'stripped' ); ?></p>
			<?php get_search_form(); ?>

		<?php endif; ?>

	</div>
</section>
