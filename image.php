<?php
/* Image attachement template
 */

get_header(); ?>

			<?php
				// Start the loop.
				while ( have_posts() ) : the_post();
			?>

				<article>
                
					<?php previous_image_link( false, __( 'Previous Image', 'stripped' ) ); ?> <?php next_image_link( false, __( 'Next Image', 'stripped' ) ); ?>
					<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

                        
							<?php	$image_size = apply_filters( 'stripped_attachment_size', 'large' );
								echo wp_get_attachment_image( get_the_ID(), $image_size );
							?>

							<?php if ( has_excerpt() ) : ?>
									<?php the_excerpt(); ?>
							<?php endif; ?>


						<?php
							the_content();
							wp_link_pages( array(
								'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'stripped' ) . '</span>',
								'after'       => '</div>',
								'link_before' => '<span>',
								'link_after'  => '</span>',
								'pagelink'    => '<span class="screen-reader-text">' . __( 'Page', 'stripped' ) . ' </span>%',
								'separator'   => '<span class="screen-reader-text">, </span>',
							) );
						?>

				</article><!-- #post-## -->

				<?php
					// If comments are open or we have at least one comment, load up the comment template
					if ( comments_open() || get_comments_number() ) :
						comments_template();
					endif;

					// Previous/next post navigation.
					the_post_navigation( array(
						'prev_text' => _x( '<span class="meta-nav">Published in</span> <span>%title</span>', 'Parent post link', 'stripped' ),
					) );

				// End the loop.
				endwhile;
			?>

<?php get_footer(); ?>
