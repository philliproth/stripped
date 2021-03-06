<?php
// Search Result Template

get_header(); ?>

		<?php if ( have_posts() ) : ?>
				<h2><?php printf( __( 'Search Results for: %s', 'stripped' ), get_search_query() ); ?></h2>

			<?php
			while ( have_posts() ) : the_post(); ?>
				<?php
				get_template_part( 'content', 'search' ); // display content search template
			endwhile;
		      else :
			     get_template_part( 'content', 'none' ); // if there is no post get content none template
		      endif;
            ?>


<?php get_footer(); ?>