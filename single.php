<?php

// Single posts and attachements template

get_header(); ?>

		<?php
		while ( have_posts() ) : the_post();
			get_template_part( 'content', get_post_format() );
			
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

			the_post_navigation( array(
				'next_text' => '<span>' . __( 'Next Post: ', 'stripped' ) . '</span> ' .
					'<span>%title</span>',
				'prev_text' => '<span>' . __( 'Previous Post: ', 'stripped' ) . '</span> ' .
					'<span>%title</span>',
			) );

		endwhile;
		?>
        
        


<?php get_footer(); ?>
