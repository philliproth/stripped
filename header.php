<?php
/**
 * Header Template
 */
?>
<!DOCTYPE html>
<?php
/* Place this inside the html tag if you want to show language attributes:
<?php language_attributes(); ?>
*/
?>
<html>
<head>

 <title><?php bloginfo('name'); // show blog name from settings ?></title>
 
 <?php wp_head(); // this is for enqueing scripts from functions.php and from plugins ?>
 
</head>
<?php
/* Place this inside the body tag if you want to show body classes:
<?php body_class(); ?>
*/
?>
<body>

	<header>
		<h1><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); // show blog name from settings?></a></h1>
		<p><?php echo get_bloginfo ( 'description' ); // show blog description from settings ?></p>
	</header>
    
    <nav>
    	<ul>
    		<?php // implements custom menu from functions.php
 				wp_nav_menu( array( 'walker' 			=> new Nav_Menu(),
									'items_wrap'        => '%3$s',
									'container'     	=> 'false',
									'theme_location'  	=> 'primary',
						 			) );
			?>
        </ul>
    </nav>

	<div> <!-- CONTENT -->