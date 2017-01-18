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
	register_post_type( 'ncc-lessons', $args );

}

//Create the Lesson Category Taxonomy
add_action( 'init', 'create_lesson_taxonomy' );
function create_lesson_taxonomy() {
	register_taxonomy(
		'lesson-category',
		'ncc-lessons',
		array(
			'label' => 'Lesson Category',
			'rewrite' => array( 'slug' => 'lesson-category' ),
			'hierarchical' => true,
		)
	);
}
