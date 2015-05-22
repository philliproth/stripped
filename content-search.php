<?php
/* Template for search results
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

		<?php the_title( sprintf( '<h2><a href="%s">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

	<div>
		<?php the_excerpt(); ?>
	</div>

	
	<?php edit_post_link( __( 'Edit', 'stripped' ), '<footer class="entry-footer"><span class="edit-link">', '</span></footer><!-- .entry-footer -->' ); ?>

</article><!-- #post-## -->
