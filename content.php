<?php
/**
 * Default Content Template
 */
/*
Put this inside the article Tag if you want to show id and classes:
id="post-<?php the_ID(); ?>" <?php post_class(); ?> 
*/
?>
<article>
				<?php
					if ( is_single() ) : // if it´s a single post put the title in h1 tags
					the_title( '<h1>', '</h1>' ); 
					else : // if not put
					the_title( sprintf( '<h2><a href="%s">', esc_url( get_permalink() ) ), '</a></h2>' ); // the title in h2 tags with the permalink
					endif;
				?>
                
                
                <?php 
					$category = get_the_category(); 
					if($category[0]){
					echo '<a href="'.get_category_link($category[0]->term_id ).'">'.$category[0]->cat_name.'</a>'; // Link first category
					}
				?>
                
                <?php echo get_the_date(); // show date when posted ?>
                
				<?php the_content(); //show the content ?>		
                
				<p><?php echo (__( 'Written by', 'stripped' ))?> <?php the_author_posts_link(); // show link that refers to the author ?></p>
				<p><?php the_author_meta('description'); //display the authors description ?></p>
				<p><?php echo (__( 'Website:', 'stripped' ))?> <a href="<?php the_author_meta('user_url');?>"><?php the_author_meta('user_url'); //display the authors website ?></a></p>
                
                             
                
				<?php edit_post_link( __( 'Edit', 'stripped' ), '<span>', '</span>' ); // show edit link when logged in ?>

			</article>
