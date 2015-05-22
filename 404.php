<?php
// 404 Page not found Template
get_header(); ?>


		<h2><?php _e( 'Oops! That page can&rsquo;t be found.', 'stripped' ); ?></h2>

		<div>
			<p><?php _e( 'It looks like nothing was found here. Try a search!', 'stripped' ); ?></p>
			<?php get_search_form(); ?>

		</div>

<?php get_footer(); ?>
