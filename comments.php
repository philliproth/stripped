<?php
/**
 * Comments Template
 */
if ( post_password_required() ) { // check if password is required
	return;
}
?>


	<?php if ( have_comments() ) : // if we have comments, list them ?> 
			<?php
				printf( _nx( 'One comment for &ldquo;%2$s&rdquo;', '%1$s comments for &ldquo;%2$s&rdquo;', get_comments_number(), 'comments title', 'stripped' ),
					number_format_i18n( get_comments_number() ), get_the_title() );
	?>

		<div>
			<?php wp_list_comments( 'type=comment&callback=strippedtheme_comment' ); //custom stripped comments in functions.php?>
		</div>


	<?php endif;?>
    
    

	<?php
	
		// If comments are closed leave a little note
		
		if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
	?>
		<?php _e( 'Comments are closed.', 'stripped' ); ?>
	<?php endif; ?>

	<?php comment_form($args, $post_id); ?>

