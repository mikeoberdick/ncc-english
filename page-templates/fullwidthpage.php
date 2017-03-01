<?php
/**
 * Template Name: Full Width Page
 *
 * Template for displaying a page without sidebar even if a sidebar widget is published.
 *
 * @package understrap
 */

get_header();
$container = get_theme_mod( 'understrap_container_type' );
?>

<div class="wrapper" id="full-width-page-wrapper">

	<div class="<?php echo esc_html( $container ); ?>" id="content">

		<div class="row">

			<div class="col-md-12 content-area" id="primary">

				<main class="site-main" id="main" role="main">

					<?php

					if( is_page( 'homepage' ) ) {
      					get_template_part( 'template-parts/content', 'home' );
    				}

					elseif( is_page( 'staff-directory' ) ) {
					    get_template_part( 'template-parts/content', 'staff' );
					}

					elseif( is_page( 'contact' ) ) {
					    get_template_part( 'template-parts/content', 'contact' );
					}

					else {
					   get_template_part( 'loop-templates/content', 'page' );
					}

					?>

						<?php
						// If comments are open or we have at least one comment, load up the comment template.
						if ( comments_open() || get_comments_number() ) :

							comments_template();

						endif;
						?>

				</main><!-- #main -->

			</div><!-- #primary -->

		</div><!-- .row end -->

	</div><!-- Container end -->

</div><!-- Wrapper end -->

<?php get_footer(); ?>
