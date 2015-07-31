<?php
/**
 * Page Template
 */
?>
<?php
/*
If you want them nasty classes add this to you article tag:
id="post-<?php the_ID(); ?>" <?php post_class(); ?
*/

?>

<article>

    <a href="<?php the_permalink() ?>"><?php the_title( '<h1>', '</h1>' ); ?></a>
    
    <?php _e('Author','stripped'); ?>: <a href="<?php the_author_url(); ?>"><?php the_author(); ?></a>

		<?php the_content(); ?>
		
	<?php edit_post_link( __( 'Edit', 'stripped' ), '<footer class="entry-footer"><span class="edit-link">', '</span></footer><!-- .entry-footer -->' ); ?>

</article><!-- #post-## -->
