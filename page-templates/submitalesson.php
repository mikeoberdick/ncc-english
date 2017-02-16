<?php
/**
 * Template Name: Submit A Lesson
 *
 * Template for displaying the page for front end posting of a lesson.
 *
 * @package understrap
 */

/**
 * Add required acf_form_head() function to head of page
 * @uses Advanced Custom Fields Pro
 */

add_action( 'get_header', 'tsm_do_acf_form_head', 1 );
function tsm_do_acf_form_head() {
	// Bail if not logged in or not able to post
	if ( ! ( is_user_logged_in() || current_user_can('publish_posts') ) ) {
		return;
	}
	acf_form_head();
}

/**
 * Deregister the admin styles outputted when using acf_form
 */

add_action( 'wp_print_styles', 'tsm_deregister_admin_styles', 999 );
function tsm_deregister_admin_styles() {
	// Bail if not logged in or not able to post
	if ( ! ( is_user_logged_in() || current_user_can('publish_posts') ) ) {
		return;
	}
	wp_deregister_style( 'wp-admin' );
}

get_header();
$container = get_theme_mod( 'understrap_container_type' );
?>

<div class="wrapper" id="full-width-page-wrapper">

	<div class="<?php echo esc_html( $container ); ?>" id="content">

		<div class="row">

			<div class="col-md-12 content-area" id="primary">

				<main class="site-main" id="main" role="main">

					<header class="entry-header">

						<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

					</header><!-- .entry-header -->

					<?php while ( have_posts() ) : the_post(); ?>
		
						<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

							<div class="entry-content">

								<?php the_content(); ?>

							</div><!-- .entry-content -->

						</article><!-- #post-## -->

				<?php endwhile; // end of the loop ?>

					<?php

					// Show login form if not logged in or able to post
						if ( ! ( is_user_logged_in()|| current_user_can('publish_posts') ) ) {
							echo '<h1 class = "mb-4">Whoops...</h1><p id = "restrictedMessage" class = "mb-4">You must be a registered user to post a lesson.  Please login below.';
							echo wp_login_form ( array( 'echo' => 0 ) );
					        return;
						}

						$new_post = array(
							'post_id'            => 'new', // Create a new post
							// PUT IN YOUR OWN FIELD GROUP ID(s)
							'field_groups'       => array(67,64), // Create post field group ID(s)
							'form'               => true,
							'return'             => '%post_url%', // Redirect to new post url
							'html_before_fields' => '',
							'html_after_fields'  => '',
							'submit_value'       => 'Submit Lesson',
							'updated_message'    => 'Saved!'
						);
						acf_form( $new_post );

					?>

				</main><!-- #main -->

			</div><!-- #primary -->

		</div><!-- .row end -->

	</div><!-- Container end -->

</div><!-- Wrapper end -->

<?php get_footer(); ?>
