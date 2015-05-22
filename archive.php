<?php
// Archive Template

get_header(); ?>


		<?php if ( have_posts() ) : ?>

				<?php
					the_archive_title( '<h2>', '</h2>' ); // show archive title
					the_archive_description( '<div>', '</div>' ); //show archive decription
				?>


			<!-- THE LOOP -->

			<?php
				while ( have_posts() ) : the_post();
					
					get_template_part( 'content', get_post_format() ); // list the posts in category
					
					
				endwhile;

				the_posts_pagination( array(			// show post navigation
					'prev_text'          => __( 'Previous page', 'stripped' ),
					'next_text'          => __( 'Next page', 'stripped' ),
					'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'stripped' ) . ' </span>',
				) );

				else :
				get_template_part( 'content', 'none' ); // if nothing is in the category get content-none.php
				endif;
			?>


<?php get_footer(); ?>
