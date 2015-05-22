<?php
/**
 * Main Template
 */

get_header(); ?>


		<?php if ( have_posts() ) : ?>

			<?php if ( is_home() && ! is_front_page() ) : ?>
				<?php single_post_title(); ?>
			<?php endif; ?>
            
            

			<?php
				while ( have_posts() ) : the_post();
					get_template_part( 'content', get_post_format() );
				endwhile;

				the_posts_pagination( array(
					'prev_text'          => __( 'Previous page', 'stripped' ),
					'next_text'          => __( 'Next page', 'stripped' ),
					'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'stripped' ) . ' </span>',
				) );

				else :
					get_template_part( 'content', 'none' );

				endif;
			?>

<?php get_footer(); ?>
