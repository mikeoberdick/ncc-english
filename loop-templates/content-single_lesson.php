<?php
/**
 * Single post partial template.
 *
 * @package understrap
 */

?>
<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

	<header class="entry-header">

		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

		<div class="entry-meta">

			<?php ncc_posted_on(); ?>

		</div><!-- .entry-meta -->

	</header><!-- .entry-header -->

	<hr>


	<?php echo get_the_post_thumbnail( $post->ID, 'large' ); ?>

	<div class="entry-content">

		<?php the_content(); ?>

		<?php if( get_field('file_upload') ): ?>
			<a id = "fileDownLoad" href = "<?php the_field('file_upload'); ?>" role = "button">Download Lesson</a>
		<?php endif; ?>

		<?php
		wp_link_pages( array(
			'before' => '<div class="page-links">' . __( 'Pages:', 'understrap' ),
			'after'  => '</div>',
		) );
		?>

	</div><!-- .entry-content -->

	<footer class="entry-footer">

		<?php ncc_entry_footer(); ?>

	</footer><!-- .entry-footer -->

</article><!-- #post-## -->
