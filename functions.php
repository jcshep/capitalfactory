<?php


// Airtable Key
// patvsDl2DOi1a14vQ.2947477e39a5777c5b49482b7e0b2f60c009561b8ffc3c014aba6478f6bf24ce



// Theme the TinyMCE editor
add_editor_style('editor-style.css');



// Custom CSS for the login page
function wpfme_loginCSS() {
	echo '<link rel="stylesheet" type="text/css" href="'.get_bloginfo('template_directory').'/wp-login.css"/>';
}
add_action('login_head', 'wpfme_loginCSS');




// Remove the admin bar from the front end
add_filter( 'show_admin_bar', '__return_false' );




// Enable featured images
function custom_theme_setup() {
	add_theme_support( 'post-thumbnails' );
}
add_action( 'after_setup_theme', 'custom_theme_setup' );



// Customise the footer in admin area
function wpfme_footer_admin () {
	echo 'CMS by Maven Creative';
}
add_filter('admin_footer_text', 'wpfme_footer_admin');



// Default menu description
function enable_menu_description_by_default() {
    add_filter('default_hidden_meta_boxes', function ($hidden, $screen) {
        if ($screen->id === 'nav-menus') {
            $hidden = array_diff($hidden, ['menu-item-description']); // Remove 'menu-item-description' from hidden fields
        }
        return $hidden;
    }, 10, 2);
}
add_action('admin_init', 'enable_menu_description_by_default');




// Add custom menus
register_nav_menus( array(
	'primary' => __( 'Primary Navigation', 'wpfme' ),
	'overlay' => __( 'Overlay Navigation', 'wpfme' ),
) );




//Custom excerpt length
function wpfme_custom_excerpt_length( $length ) {
	//the amount of words to return
	return 20;
}
add_filter( 'excerpt_length', 'wpfme_custom_excerpt_length');




//Create a permalink after the excerpt
function wpfme_replace_excerpt($content) {
	return str_replace('[...]',
		'<a class="readmore" href="'. get_permalink() .'">Continue Reading</a>',
		$content
	);
}
add_filter('the_excerpt', 'wpfme_replace_excerpt');





// Remove the version number of WP
remove_action('wp_head', 'wp_generator');






//Add favicon
add_action('admin_head','favicon');
function favicon(){
	echo '<link rel="shortcut icon" href="',get_template_directory_uri(),'/favicon.ico" />',"\n";
}





//Remove some extraneous wordpress links
remove_action( 'wp_head', 'feed_links', 2 );
remove_action( 'wp_head', 'feed_links_extra', 3 );
remove_action( 'wp_head', 'rsd_link');
remove_action( 'wp_head', 'wlwmanifest_link');
remove_action( 'wp_head', 'index_rel_link');
remove_action( 'wp_head', 'parent_post_rel_link');
remove_action( 'wp_head', 'start_post_rel_link');
remove_action( 'wp_head', 'adjacent_posts_rel_link');
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );
remove_action( 'wp_head', 'wp_generator');
remove_action( 'wp_head', 'profile');
remove_action( 'wp_head', 'rel_canonical');
remove_action( 'admin_print_styles', 'print_emoji_styles' );
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );



// Manage scripts 
function manage_scripts() {
	
	// Jquery
	wp_deregister_script('jquery');
	wp_register_script('jquery', get_template_directory_uri() . '/js/jquery.min.js');
	wp_enqueue_script('jquery');


	// Slick
	wp_register_style('slick-theme', get_template_directory_uri() . '/js/slick/slick-theme.css');
	wp_enqueue_style('slick-theme');
	wp_register_style('slick-style', get_template_directory_uri() . '/js/slick/slick.css');
	wp_enqueue_style('slick-style');	
	wp_register_script('slick-js', get_template_directory_uri() . '/js/slick/slick.js', array('jquery'));
	wp_enqueue_script('slick-js');

	// Bootstrap
	wp_register_script('bootstrap', get_template_directory_uri() . '/js/bootstrap.min.js', array('jquery'));
	wp_enqueue_script('bootstrap');

	// Popper
	wp_register_script('popper', get_template_directory_uri() . '/js/popper.min.js', array('jquery'));
	wp_enqueue_script('popper');

	// Theme JS
	wp_register_script('theme', get_template_directory_uri() . '/js/theme.js', array('jquery'));
	wp_enqueue_script('theme');

	// Theme CSS
	wp_register_style('fonts', get_template_directory_uri() . '/fonts/fonts.css');
	wp_enqueue_style('fonts');

	// Theme CSS
	wp_register_style('style', get_template_directory_uri() . '/style.css');
	wp_enqueue_style('style');

	// Media Queries CSS
	wp_register_style('media-queries', get_template_directory_uri() . '/media-queries.css');
	wp_enqueue_style('media-queries');

	// Google Fonts
	// wp_register_style('google-fonts', '###');
	// wp_enqueue_style('google-fonts');

	// Fontawesome CSS
	// wp_register_style('font-awesome', get_template_directory_uri() . '/css/fontawesome/css/all.min.css');
	// wp_enqueue_style('font-awesome');



	// Load more posts JS
	if (is_home() || is_category()) {
	  wp_register_script('loadPosts', get_template_directory_uri() . '/blog/loadPosts.js?cache='.time());
	  wp_enqueue_script('loadPosts');
	}

  //Menu
  wp_register_script('menu-js', get_template_directory_uri() . '/js/Menu.js?cache='.time());
  wp_enqueue_script('menu-js');


  //Nav
  wp_register_script('body-scroll-lock-js', get_template_directory_uri() . '/js/body-scroll-lock.js');
  wp_enqueue_script('body-scroll-lock-js');

  wp_register_script('nav-js', get_template_directory_uri() . '/js/nav.js?cache='.time(), 'body-scroll-lock-js');
  wp_enqueue_script('nav-js');
	

	

} 

add_action( 'wp_enqueue_scripts', 'manage_scripts', 1000); 



// Disable Editor
function disable_editor_for_all_post_types() {
    $post_types = get_post_types(); // Get all registered post types.

    foreach ($post_types as $post_type) {
        // Remove support for the editor.
        remove_post_type_support($post_type, 'editor');
    }
}
add_action('init', 'disable_editor_for_all_post_types');




// Get first embedded image function
function first_image() {
	global $post, $posts;
	$first_img = '';
	ob_start();
	ob_end_clean();

	if ( get_the_post_thumbnail($post->ID) ) {

		$img = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'large' );
		$first_img = $img[0];

	} else {
		$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
		$first_img = $matches [1] [0];
	}


  if(empty($first_img)){ //Defines a default image
  	return NULL;
  }	
  	return $first_img;
}



// Custom admin logo
function admin_logo() { 
	?>
	<style type="text/css">
	body.login div#login h1 a {
		background: url(<?php echo get_stylesheet_directory_uri(); ?>/img/footer-logo.png) no-repeat center center;
		background-size:contain;
		padding-bottom: 0;
		width:200px;
		height: 200px;
	}
</style>
<?php 
}

add_action( 'login_enqueue_scripts', 'admin_logo' );


// Custom Post Types
include('custom-post-types.php');





// Add class to Button
add_filter( 'gform_submit_button', 'add_custom_css_classes', 10, 2 );
function add_custom_css_classes( $button, $form ) {
    $dom = new DOMDocument();
    $dom->loadHTML( '<?xml encoding="utf-8" ?>' . $button );
    $input = $dom->getElementsByTagName( 'input' )->item(0);
    $classes = $input->getAttribute( 'class' );
    $classes .= " btn btn-outline-dark gform_button";
    $input->setAttribute( 'class', $classes );
    return $dom->saveHtml( $input );
}








// Collapse ACF Page Builder
add_action('acf/input/admin_head', 'my_acf_input_admin_head');
function my_acf_input_admin_head() {
?>
<script type="text/javascript">
jQuery(function(){
  jQuery('.acf-input .layout').addClass('-collapsed');
  jQuery('#aioseo-settings').addClass('closed');
});
</script>
<?php } 







//Adding the Open Graph in the Language Attributes
function add_opengraph_doctype( $output ) {
        return $output . ' xmlns:og="http://opengraphprotocol.org/schema/" xmlns:fb="http://www.facebook.com/2008/fbml"';
    }
add_filter('language_attributes', 'add_opengraph_doctype');
 
//Lets add Open Graph Meta Info
function insert_og_in_head() {
    global $post;

    if ( !is_singular())
        return;

    $title = get_the_title();
    $description = '';
    $permalink = get_permalink();
    $image = "https://sampadocs.com/wp-content/themes/sampa/images/logo.png";

    if(get_field('og_title'))
      $title = get_field('og_title');

    if(get_field('og_image'))
      $image = get_field('og_image');

    if(get_field('og_description'))
      $description = get_field('og_description');

    if(has_post_thumbnail( $post->ID ))
      $image = has_post_thumbnail( $post->ID );

    echo '<meta property="og:title" content="' . $title . '"/>';
    echo '<meta property="og:type" content="article"/>';
    echo '<meta property="og:url" content="' . $permalink . '"/>';
    echo '<meta property="og:description" content="'. $description .'" />';
    echo '<meta property="og:site_name" content="'.get_bloginfo( 'name' ).'"/>';
    echo '<meta property="og:image" content="' . $image . '"/>';

    
}

add_action( 'wp_head', 'insert_og_in_head', 5 );








function get_thumbnail_data($id) {
  $data = wp_get_attachment_image_src( get_post_thumbnail_id($id), 'full', false, '' );
  $thumb_id = get_post_thumbnail_id( $id );
  $alt = get_post_meta($thumb_id, '_wp_attachment_image_alt', true);  
  if (!empty(get_post_thumbnail_id($id))) {
    return array(
      'url' => $data[0],
      'width' => $data[1],
      'height' => $data[2],
      'alt' => $alt
    );
  } else {
    return false;
  }
}


global $blogID;
$blogID = 10;





function add_reference_link_to_flexible_content($title, $field, $layout, $i) {
    // Define preview images for each layout
    $preview_images = [
        'hero' => get_template_directory_uri().'/img/hero-preview.jpg'        
    ];

    // Check if the layout has a preview image
    if (isset($preview_images[$layout['name']])) {
        $image_url = $preview_images[$layout['name']];

        // Add a "Reference" link that opens the image in a modal
        $title .= ' <a href="#" class="acf-reference-link" data-image="' . esc_url($image_url) . '" style="font-size: 0.9em; color: #0073aa; text-decoration: underline;">Reference</a>';
    }

    return $title;
}
add_filter('acf/fields/flexible_content/layout_title', 'add_reference_link_to_flexible_content', 10, 4);





function add_page_background_color_body_class($classes) {
    // Check if ACF is active and the page_background_color field exists
    if (function_exists('get_field')) {
        // Get the value of the ACF dropdown field
        $background_color = 'bg-color-'.strtolower(get_field('page_background_color'));

        // If the field has a value, add it as a class
        if ($background_color) {
            $classes[] = sanitize_html_class($background_color); // Sanitize the class name
        }
    }

    return $classes;
}
add_filter('body_class', 'add_page_background_color_body_class');





function enqueue_acf_admin_scripts() {
    wp_enqueue_script('acf-admin-custom', get_template_directory_uri() . '/js/acf-admin-custom.js', ['jquery'], null, true);
    wp_enqueue_style('acf-admin-custom-styles', get_template_directory_uri() . '/css/acf-admin-custom.css');
}
add_action('admin_enqueue_scripts', 'enqueue_acf_admin_scripts');



function my_acf_google_map_api( $api ) {
  $api['key'] = 'AIzaSyBBNxicqCP6SRJwzNfnimhbQHBX2rarwAE';
  return $api;
}
add_filter( 'acf/fields/google_map/api', 'my_acf_google_map_api' );


//get menu array
function get_nav_menu_items_hierarchical($location, $args = []) {
  $locations = get_nav_menu_locations();

  if (!isset($locations[$location])) {
    return [];
  }
  $object = wp_get_nav_menu_object( $locations[$location] );
  $array_menu = wp_get_nav_menu_items( $object->name, $args); 
  $menu = array();
  foreach ($array_menu as $m) {
    if (empty($m->menu_item_parent)) {
      $menu[$m->ID] = array();
      $menu[$m->ID]['ID'] = $m->ID;
      $menu[$m->ID]['object_id'] = $m->object_id;
      $menu[$m->ID]['title'] = $m->title;
      $menu[$m->ID]['url'] = $m->url;
      $menu[$m->ID]['text'] = $m->description;
      $menu[$m->ID]['target'] = $m->target;
      $menu[$m->ID]['children'] = array();
    }
  }
  $submenu = array();
  foreach ($array_menu as $m) {
    if ($m->menu_item_parent) {
      $submenu[$m->ID] = array();
      $submenu[$m->ID]['ID'] = $m->ID;
      $submenu[$m->ID]['object_id'] = $m->object_id;
      $submenu[$m->ID]['title'] = $m->title;
      $submenu[$m->ID]['text'] = $m->description;
      $submenu[$m->ID]['url'] = $m->url;
      $submenu[$m->ID]['target'] = $m->target;
      $menu[$m->menu_item_parent]['children'][$m->ID] = $submenu[$m->ID];
    }
  }
  return $menu;
}

if( function_exists('acf_add_options_page') ) {

    acf_add_options_page(array(
        'page_title'    => 'Theme General Settings',
        'menu_title'    => 'Theme Settings',
        'menu_slug'     => 'theme-general-settings',
        'capability'    => 'edit_posts',
        'redirect'      => false
    ));

    // acf_add_options_sub_page(array(
    //     'page_title'    => 'Theme Header Settings',
    //     'menu_title'    => 'Header',
    //     'parent_slug'   => 'theme-general-settings',
    // ));

    // acf_add_options_sub_page(array(
    //     'page_title'    => 'Theme Footer Settings',
    //     'menu_title'    => 'Footer',
    //     'parent_slug'   => 'theme-general-settings',
    // ));

}