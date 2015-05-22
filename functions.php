<?php

// STRIPPED FUNCTIONS AND DEFINITIONS



// SETUP


// Stripped only works in WordPress 4.1 or later, so: 
if ( version_compare( $GLOBALS['wp_version'], '4.1-alpha', '<' ) ) {
	require get_template_directory() . '/inc/back-compat.php';
}

// Setup language support in Theme folder "languages"

if ( ! function_exists( 'stripped_setup' ) ) :
function stripped_setup() {
load_theme_textdomain( 'stripped', get_template_directory() . '/languages' ); 


// This theme uses wp_nav_menu()
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'stripped' ) // One Menu not enough? Copy and Ppaste these three lines if you need more!
	) );

// Output valid HTML5
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
	) );

//Enable Post Formats
	add_theme_support( 'post-formats', array(
		'aside', 'image', 'video', 'quote', 'link', 'gallery', 'status', 'audio', 'chat'
	) );

}

endif; 
add_action( 'after_setup_theme', 'stripped_setup' );


// Enable Thumbnails for Posts
add_theme_support('post-thumbnails');  

// // SETUP





// ADD! Style Script (style.css) and Comments Reply Script. You´ll probably need those!

function stripped_scripts() {

	//Main Stylesheet style.css	in your theme
	wp_enqueue_style( 'stripped-style', get_stylesheet_uri() );

	// Comments Script threaded wp-includes/js/comment-reply.min.js
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

}
add_action( 'wp_enqueue_scripts', 'stripped_scripts' );


// Remove id from style-script 

add_filter("style_loader_tag", function($tag){
    return str_replace("id='stripped-style-css' " ,'',  $tag);
});


// HEAD Dequeue scripts & Links from head

remove_action( 'wp_head', 'wp_shortlink_wp_head', 10, 0); // Displays the WP Shortlink
remove_action( 'wp_head', 'rel_canonical'); // Displays the Canonical Link
remove_action( 'wp_head', 'feed_links_extra', 3 ); // Displays the links to the extra feeds such as category feeds
remove_action( 'wp_head', 'feed_links', 2 ); // Displays the links to the general feeds: Post and Comment Feed
remove_action( 'wp_head', 'rsd_link' ); // Displays the link to the Really Simple Discovery service endpoint, EditURI link
remove_action( 'wp_head', 'wlwmanifest_link' ); // Displays the link to the Windows Live Writer manifest file.
remove_action( 'wp_head', 'index_rel_link' ); // Displays the index link
remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 ); // Displays the prev link
remove_action( 'wp_head', 'start_post_rel_link', 10, 0 ); // Displays the start link
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 ); // Displays relational links for the posts adjacent to the current post.
remove_action( 'wp_head', 'wp_generator' ); // Displays the XHTML generator that is generated on the wp_head hook, WP version


//Dequeue the Emoji scripts & styles from head

function disable_emoji_dequeue_script() {
    wp_dequeue_script( 'emoji' );
}
add_action( 'wp_print_scripts', 'disable_emoji_dequeue_script', 100 );
remove_action( 'wp_head', 'print_emoji_detection_script', 7 ); 
remove_action( 'wp_print_styles', 'print_emoji_styles' );


// Remove recent comments style, because of this: https://core.trac.wordpress.org/ticket/11928 we have to do this:

function my_remove_recent_comments_style() {
	global $wp_widget_factory;
	remove_action('wp_head', array($wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style'));
}
add_action('widgets_init', 'my_remove_recent_comments_style');



// MENU

// We create a custom menu walker for a simple ul/li-list


class Nav_Menu extends Walker {
    var $tree_type = array( 'post_type', 'taxonomy', 'custom' );
    var $db_fields = array( 'parent' => 'menu_item_parent', 'id' => 'db_id' );
    function start_lvl(&$output, $depth) {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<ul>\n"; // List open
    }
    function end_lvl(&$output, $depth) {
        $indent = str_repeat("\t", $depth);
        $output .= "$indent</ul>\n"; // List close
    }
    function start_el(&$output, $item, $depth, $args) {
        global $wp_query;
        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
        $class_names = $value = '';
        $classes = empty( $item->classes ) ? array() : (array) $item->classes;
        $classes = in_array( 'current-menu-item', $classes ) ? array( 'current-menu-item' ) : array(); // you can change the current-menu-item class to something different or leave it blank ''
        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
        $class_names = strlen( trim( $class_names ) ) > 0 ? ' class="' . esc_attr( $class_names ) . '"' : '';
        $id = apply_filters( 'nav_menu_item_id', '', $item, $args );
        $id = strlen( $id ) ? ' id="' . esc_attr( $id ) . '"' : '';
        $output .= $indent . '<li' . $id . $value . $class_names .'>'; //List item open
        $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
        $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
        $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
        $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
        $item_output = $args->before;
        $item_output .= '<a'. $attributes .'>'; // Link open
        $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
        $item_output .= '</a>'; // Link close
        $item_output .= $args->after;
        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }
    function end_el(&$output, $item, $depth) {
        $output .= "</li>\n"; // List item close
    }
}




// COMMENTS


// Remove classes from avatar; Gravatar needs class="avatar" to work properly so this has to stay

function change_avatar_css($class) {
$class = str_replace("photo", "", $class) ;
$class = str_replace("avatar-32", "", $class) ; //32 is the default avatar size
return $class;
}
add_filter('get_avatar','change_avatar_css');


// Remove comment classes with custom comment walker

function strippedtheme_comment($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment;
	extract($args, EXTR_SKIP);

	if ( 'div' == $args['style'] ) {
		$tag = 'div';
		$add_below = ''; //insert 'comment' for regular use
	} else {
		$tag = 'li';
		$add_below = ''; //insert 'div-comment' for regular use
	}
	?>
	<<?php echo $tag ?> <?php // comment_class( empty( $args['has_children'] ) ? '' : 'parent' ) ?>> <!-- add id comment-id with id="comment-<?php comment_ID() ?>" -->
	<?php if ( 'div' != $args['style'] ) : ?>
	<div> <!-- insert into the div tag: id="div-comment-<?php comment_ID() ?>" class="comment-body" -->
	<?php endif; ?>
	<div> <!-- insert into the div tag: class="comment-author vcard" -->
	<?php if ( $args['avatar_size'] != 0 ) echo get_avatar( $comment, $args['avatar_size'] ); ?>
	<?php printf( __( '<cite>%s</cite> <span>says:</span>' ), get_comment_author_link() ); // insert class="fn" into the cite tag; insert class="says" into the span?>
	</div>
	<?php if ( $comment->comment_approved == '0' ) : ?>
		<em><?php _e( 'Your comment is awaiting moderation.' ); // insert class="comment-awaiting-moderation" into the em tag?></em>
		<br />
	<?php endif; ?>

	<div><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ); ?>"> <!-- insert into the div class="comment-meta commentmetadata" -->
		<?php
			/* translators: 1: date, 2: time */
			printf( __('%1$s at %2$s'), get_comment_date(),  get_comment_time() ); ?></a><?php edit_comment_link( __( '(Edit)' ), '  ', '' );
		?>
	</div>

	<?php comment_text(); ?>

	<div> <!-- insert into div class="reply" -->
	<?php comment_reply_link( array_merge( $args, array( 'add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
	</div>
	<?php if ( 'div' != $args['style'] ) : ?>
	</div>
	<?php endif; ?>
<?php
}


//Comment form

function stripped_comments($arg) {
	$commenter = wp_get_current_commenter();
	$req = get_option( 'require_name_email' );
	$aria_req = ( $req ? " aria-required='true'" : '' ); // aria is for validation
	
	$arg['fields'] = $fields =  array(

  	'author' =>
   	 '<p><label for="author">' . __( 'Name', 'stripped' ) . '</label> ' . // default in <p>-tag: class="comment-form-author"
   	 ( $req ? '<span class="required">*</span>' : '' ) . // needed for validation
   	 '<input name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . //default in <input>-tag: id="author"
   	 '" size="30"' . $aria_req . ' /></p>',

  	'email' =>
  	  '<p><label for="email">' . __( 'Email', 'stripped' ) . '</label> ' . // default in <p>-tag: class="comment-form-email"
   	 ( $req ? '<span class="required">*</span>' : '' ) . // needed for validation
   	 '<input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . // default in <input>-tag: id="email"
   	 '" size="30"' . $aria_req . ' /></p>',

  	'url' =>
   	 '<p><label for="url">' . __( 'Website', 'stripped' ) . '</label>' . // default in <p>-tag: class="comment-form-url"
   	 '<input name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . // default in <input>-tag: id="url"
   	 '" size="30" /></p>',
	);;
	
	$arg['comment_field'] = '<p><label for="comment">' . _x( 'Comments', 'stripped' ) . '</label><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea></p>'; // default in <p>-tag: class="comment-form-comment"
	
	$arg['comment_notes_after'] = '<p>' . __( 'Text after the comment form', 'stripped' ) . '</p>'; // Use your own text
	
	
	//find additional $args here: http://codex.wordpress.org/Function_Reference/comment_form
	
    return $arg;  
	
	}
	 
add_filter('comment_form_defaults', 'stripped_comments');




// SIDEBAR in sidebar.php


function stripped_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Widget Area', 'stripped' ),
		'id'            => 'sidebar-1',
		'description'   => __( 'Add widgets here to appear in your sidebar.', 'stripped' ),

/* If you want dem nasty classes put this inside the aside tag:
id="%1$s" class="widget %2$s"
*/
		'before_widget' => '',
		'after_widget'  => '',
		'before_title'  => '<h2>',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'stripped_widgets_init' );




// GALLLERY custom output

remove_shortcode('gallery', 'gallery_shortcode');
add_shortcode('gallery', 'custom_gallery');

function custom_gallery($attr) {
	$post = get_post();
	static $instance = 0;
	$instance++;
	# hard-coding these values so that they can't be broken

	$attr['columns'] = 1;
	$attr['size'] = 'full';
	$attr['link'] = 'none';
	$attr['orderby'] = 'post__in';
	$attr['include'] = $attr['ids'];	
	
	#Allow plugins/themes to override the default gallery template.

	$output = apply_filters('post_gallery', '', $attr);
	if ( $output != '' )
		return $output;
	# We're trusting author input, so let's at least make sure it looks like a valid orderby statement
	if ( isset( $attr['orderby'] ) ) {
		$attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
		if ( !$attr['orderby'] )
			unset( $attr['orderby'] );
	}
	extract(shortcode_atts(array(
		'order'      => 'ASC',
		'orderby'    => 'menu_order ID',
		'id'         => $post->ID,
		'itemtag'    => 'div',
		'icontag'    => 'div',
		'captiontag' => 'p',
		'columns'    => 1,
		'size'       => 'thumbnail',
		'include'    => '',
		'exclude'    => ''
	), $attr));

	$id = intval($id);
	if ( 'RAND' == $order )
		$orderby = 'none';
	if ( !empty($include) ) {
		$_attachments = get_posts( array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
		$attachments = array();
		foreach ( $_attachments as $key => $val ) {
			$attachments[$val->ID] = $_attachments[$key];
		}
	} elseif ( !empty($exclude) ) {
		$attachments = get_children( array('post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
	} else {
		$attachments = get_children( array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
	}

	if ( empty($attachments) )
		return '';
	$gallery_style = $gallery_div = '';

	if ( apply_filters( 'use_default_gallery_style', true ) )
	$gallery_div = "<div id='homepage-gallery-wrap' class='gallery gallery-columns-1 gallery-size-full'>";
	$output = apply_filters( 'gallery_style', $gallery_style . "\n\t\t" . $gallery_div );	

	foreach ( $attachments as $id => $attachment ) {
		$link = wp_get_attachment_link($id, 'thumbnail', true, false);
		$output .= "<div class='homepage-gallery-item'>";
		$output .= "
			<div>
				$link
			</div>";

		if ( $captiontag && trim($attachment->post_excerpt) ) {
			$output .= "
				<p class='wp-caption-text homepage-gallery-caption'>
				" . wptexturize($attachment->post_excerpt) . "
				</p>";
		}
		$output .= "</div>";
	}
	$output .= "</div>\n";
	return $output;

}

