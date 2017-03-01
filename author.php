<?php
/**
 * The template for displaying the author pages.
 *
 * Learn more: https://codex.wordpress.org/Author_Templates
 *
 * @package understrap
 */

get_header();
$container   = get_theme_mod( 'understrap_container_type' );
$sidebar_pos = get_theme_mod( 'understrap_sidebar_position' );
?>


<div class="wrapper" id="author-wrapper">

	<div class="<?php echo esc_html( $container ); ?>" id="content" tabindex="-1">

		<div class="row">

			<!-- Do the left sidebar check -->
			<?php get_template_part( 'global-templates/left-sidebar-check', 'none' ); ?>

			<main class="site-main" id="main">

				<header class="page-header author-header">

					<?php
					$curauth = ( isset( $_GET['author_name'] ) ) ? get_user_by( 'slug',
						$author_name ) : get_userdata( intval( $author ) );
					?>

					<h1><?php echo esc_html( $curauth->nickname ); ?><?php esc_html_e( '\'s Lessons', 'understrap' ); ?></h1>
					<hr>

				</header><!-- .page-header -->
<?php 

$current_user_id = get_current_user_id();

$args = array(
    'post_type'         =>  'lessons',
    'posts_per_page'    =>  10,
    'author'            =>  $current_user_id,
	);

$new_query = new WP_Query($args);

if ($new_query->have_posts()) {
    while ($new_query->have_posts()) {
        $new_query->the_post();
?>
        <div class = "mb-3">
			<a rel="bookmark" href="<?php the_permalink() ?>"
			   title="Permanent Link: <?php the_title(); ?>">
				<h5><?php the_title(); ?></h5></a>
				<?php archive_post_byline (); ?> <?php esc_html_e( 'in',
			'understrap' ); ?> <?php the_terms( $post->ID, 'lesson-category', '', ', ' ); ?>
				<p><?php the_excerpt(); ?></p>
		</div>
<?php

    }

} else {
	get_template_part( 'loop-templates/content', 'none' );
    echo 'This author doesn\' have any published lessons.';
}

wp_reset_postdata();

?>

			</main><!-- #main -->

			<!-- The pagination component -->
			<?php understrap_pagination(); ?>

		</div><!-- #primary -->

		<!-- Do the right sidebar check -->
		<?php if ( 'right' === $sidebar_pos || 'both' === $sidebar_pos ) : ?>

			<?php get_sidebar( 'right' ); ?>

		<?php endif; ?>

	</div> <!-- .row -->

</div><!-- Container end -->

</div><!-- Wrapper end -->

<?php get_footer(); ?>
