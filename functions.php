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
add_action( 'init', 'create_lesson_cat_taxonomy' );
function create_lesson_cat_taxonomy() {

	$labels = array(
		'add_new_item' => 'Add New Lesson Category',
		'view_item' => 'View Lesson Category',
		'edit_item' => 'Edit Lesson Category',
		'update_item' => 'Update Lesson Category',
	);

	$args = array(
		'label' => 'Lesson Categories',
		'rewrite' => array( 'slug' => 'lesson-category' ),
		'labels'            => $labels,
	);

	register_taxonomy( 'lesson-category', array( 'lessons' ), $args );
}

//Create the Lesson Category Taxonomy
add_action( 'init', 'create_lesson_tags_taxonomy' );
function create_lesson_tags_taxonomy() {

	$labels = array(
		'add_new_item' => 'Add New Lesson Tag',
		'view_item' => 'View Lesson Tag',
		'edit_item' => 'Edit Lesson Tag',
		'update_item' => 'Update Lesson Tag',
	);

	$args = array(
		'label' => 'Lesson Tags',
		'rewrite' => array( 'slug' => 'lesson-tag' ),
		'labels'            => $labels,
	);

	register_taxonomy( 'lesson-tag', array( 'lessons' ), $args );
}

// Add custom lesson category taxonomy as a widget

// First we create a function
function list_cats_custom_taxonomy( $atts ) {

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
echo '<h3>Lesson Categories</h3><p>Use the lesson categories below to quickly jump to the archives and find a lesson.</p><ul id = "sidebarCategories">';
echo wp_list_categories($args);
echo '</ul>';
}

// Add a shortcode that executes our function
add_shortcode( 'ct_cats', 'list_cats_custom_taxonomy' );



//Custom lesson tag taxonomy as a widget

// First we create a function
function list_tags_custom_taxonomy( $atts ) {

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
echo '<h3>Lesson Tags</h3><p>Use the lesson tags below to find a lesson.</p><ul id = "sidebarTags">';
echo wp_list_categories($args);
echo '</ul>';
}

// Add a shortcode that executes our function
add_shortcode( 'ct_tags', 'list_tags_custom_taxonomy' );



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

//hook when user registers
add_action( 'user_register', 'ncc_registration_save', 10, 1 );

function ncc_registration_save( $user_id ) {

    // insert meta that user not logged in first time
    update_user_meta($user_id, 'prefix_first_login', '1');

}

// hook when user logs in
add_action('wp_login', 'ncc_first_login', 10, 2);

function ncc_first_login($user_login, $user) {

    $user_id = $user->ID;
    // getting prev. saved meta
    $first_login = get_user_meta($user_id, 'prefix_first_login', true);
    // if first time login
    if( $first_login == '1' ) {
        // update meta after first login
        update_user_meta($user_id, 'prefix_first_login', '0');
        // redirect to given URL
        wp_redirect( '/submit-a-lesson' );
        exit;
    }
}

// Hide the admin toolbar for subscribers
add_action('admin_init', 'disable_admin_bar');

function disable_admin_bar() {
    if (current_user_can('subscriber')) {
        show_admin_bar(false);
    }
}

//Modified understrap_posted_on template tag

if ( ! function_exists( 'ncc_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function ncc_posted_on() {
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() )
	);

	$posted_on = sprintf(
		esc_html_x( 'Posted on %s', 'post date', 'understrap' ),
		'<span>' . $time_string . '</span>'
	);

	$byline = sprintf(
		esc_html_x( 'by %s', 'post author', 'understrap' ),
		'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
	);

	echo '<span class="posted-on">' . $posted_on . '</span><span class="byline"> ' . $byline . '</span>';

}
endif;

//Modified understrap_entry_footer template tag

if ( ! function_exists( 'ncc_entry_footer' ) ) :
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function ncc_entry_footer() {

// Category Links
$categories_list = get_the_term_list( $post->ID, 'lesson-category', '<span>', ', ', '</span>' );
if ( ! $categories_list == '0' ) {
	printf( '<div class="cat-links">' . __( 'Posted in %1$s', 'understrap' ) . '</div>', $categories_list );
	}

// Tag Links
$tags_list = get_the_term_list( $post->ID, 'lesson-tags', '<span>', ', ', '</span>' );
if ( ! $tags_list == '0' ) {
	printf( '<div class="tag-links">' . __( 'Tagged with %1$s', 'understrap' ) . '</div>', $tags_list );
	}

if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
echo '<span class="comments-link">';
comments_popup_link( __( 'Leave a comment', 'understrap' ), __( '1 Comment', 'understrap' ), __( '% Comments', 'understrap' ) );
echo '</span>';
}

}
endif;

if ( ! function_exists( 'all_excerpts_get_more_link' ) ) {
	/**
	 * Adds a custom read more link to all excerpts, manually or automatically generated
	 *
	 * @param string $post_excerpt Posts's excerpt.
	 *
	 * @return string
	 */
	function all_excerpts_get_more_link( $post_excerpt ) {

		return $post_excerpt . ' [...]<p><a class="btn btn-secondary understrap-read-more-link" href="' . get_permalink( get_the_ID() ) . '">' . __( 'View Lesson',
		'understrap' ) . '</a></p>';
	}
}
add_filter( 'wp_trim_excerpt', 'all_excerpts_get_more_link' );

function ncc_custom_excerpt_length( $length ) {
    return 20;
}
add_filter( 'excerpt_length', 'ncc_custom_excerpt_length', 999 );
