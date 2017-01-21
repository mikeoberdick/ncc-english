<?php
function understrap_remove_scripts() {
    wp_dequeue_style( 'understrap-styles' );
    wp_deregister_style( 'understrap-styles' );

    wp_dequeue_script( 'understrap-scripts' );
    wp_deregister_script( 'understrap-scripts' );

    // Removes the parent themes stylesheet and scripts from inc/enqueue.php
}
add_action( 'wp_enqueue_scripts', 'understrap_remove_scripts', 20 );

add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function theme_enqueue_styles() {

	// Get the theme data
	$the_theme = wp_get_theme();

    wp_enqueue_style( 'child-understrap-styles', get_stylesheet_directory_uri() . '/css/child-theme.min.css', array(), $the_theme->get( 'Version' ) );
    wp_enqueue_script( 'child-understrap-scripts', get_stylesheet_directory_uri() . '/js/child-theme.min.js', array(), $the_theme->get( 'Version' ), true );
}

//Create the Lesson Custom Post Type
add_action( 'init', 'lesson_post_type', 0 );
function lesson_post_type() {

// Set UI labels for Custom Post Type
	$labels = array(
		'name'                => 'Lessons',
		'singular_name'       => 'Lesson',
		'menu_name'           => 'Lessons',
		'parent_item_colon'   => 'Parent Lesson',
		'all_items'           => 'All Lessons',
		'view_item'           => 'View Lesson',
		'add_new_item'        => 'Add New Lesson',
		'add_new'             => 'Add New',
		'edit_item'           => 'Edit Lesson',
		'update_item'         => 'Update Lesson',
		'search_items'        => 'Search Lessons',
		'not_found'           => 'No Lesson Found',
		'not_found_in_trash'  => 'No Lesson Found in Trash',
	);
	
// Set other options for Custom Post Type
	$args = array(
		'label'               => 'Lesson',
		'description'         => 'Lesson',
		'labels'              => $labels,
		// Features this CPT supports in Post Editor
		'supports'            => array( 'title', 'editor', 'author', 'thumbnail' ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 5,
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'page',
	);
	
	// Registering your Custom Post Type
	register_post_type( 'lessons', $args );

}

//Create the Lesson Category Taxonomy
add_action( 'init', 'create_lesson_taxonomy' );
function create_lesson_taxonomy() {
	register_taxonomy(
		'lesson-category',
		'lessons',
		array(
			'label' => 'Lesson Category',
			'rewrite' => array( 'slug' => 'lesson-category' ),
			'hierarchical' => true,
		)
	);
}

// Add custom taxonomy as a widget

// First we create a function
function list_terms_custom_taxonomy( $atts ) {

// Inside the function we extract custom taxonomy parameter of our shortcode

	extract( shortcode_atts( array(
		'custom_taxonomy' => '',
	), $atts ) );

// arguments for function wp_list_categories
$args = array( 
taxonomy => $custom_taxonomy,
title_li => ''
);

// We output the HTML
echo '<h3>Lesson Categories</h3><p>Use the lesson categories below to quickly jump to the archives and find a lesson.</p><ul>';
echo wp_list_categories($args);
echo '</ul>';
}

// Add a shortcode that executes our function
add_shortcode( 'ct_terms', 'list_terms_custom_taxonomy' );

//Allow Text widgets to execute shortcodes
add_filter('widget_text', 'do_shortcode');

// Front End Posting Form

/**
 * Back-end creation of new candidate post
 * @uses Advanced Custom Fields Pro
 */

add_filter('acf/pre_save_post' , 'tsm_do_pre_save_post' );
function tsm_do_pre_save_post( $post_id ) {

	// Bail if not logged in or not able to post
	if ( ! ( is_user_logged_in() || current_user_can('publish_posts') ) ) {
		return;
	}

	// check if this is to be a new post
	if( $post_id != 'new' ) {
		return $post_id;
	}

	// Create a new post
	$post = array(
		'post_type'     => 'lessons', // Your post type ( post, page, custom post type )
		'post_status'   => 'draft', // (publish, draft, private, etc.)
		'post_title'    => wp_strip_all_tags($_POST['acf']['field_54dfc93e35ec4']), // Post Title ACF field key
		'post_content'  => $_POST['acf']['field_54dfc94e35ec5'], // Post Content ACF field key
	);

	// insert the post
	$post_id = wp_insert_post( $post );

	// Save the fields to the post
	do_action( 'acf/save_post' , $post_id );

	return $post_id;

}

/**
 * Save ACF image field to post Featured Image
 * @uses Advanced Custom Fields Pro
 */
add_action( 'acf/save_post', 'tsm_save_image_field_to_featured_image', 10 );
function tsm_save_image_field_to_featured_image( $post_id ) {

	// Bail if not logged in or not able to post
	if ( ! ( is_user_logged_in() || current_user_can('publish_posts') ) ) {
		return;
	}

	// Bail early if no ACF data
	if( empty($_POST['acf']) ) {
		return;
	}

	// ACF image field key
	$image = $_POST['acf']['field_54dfcd4278d63'];

	// Bail if image field is empty
	if ( empty($image) ) {
		return;
	}

	// Add the value which is the image ID to the _thumbnail_id meta data for the current post
	add_post_meta( $post_id, '_thumbnail_id', $image );

}
