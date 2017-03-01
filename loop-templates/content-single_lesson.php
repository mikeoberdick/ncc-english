<?php
/**
 * Single post partial template.
 *
 * @package understrap
 */

?>
<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

<div class = "row">
	<div class = "col-sm-9">

	<header class="entry-header">

		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
		<hr>

		<div class="entry-meta">

			<?php ncc_posted_on(); ?>

		</div><!-- .entry-meta -->

	</header><!-- .entry-header -->
</div>

<div class = "col-sm-3 lesson_download">
		<div>
			<?php if( get_field('file_upload') ): ?>
				<a id = "fileDownLoad" href = "<?php the_field('file_upload'); ?>" role = "button"><i class="fa fa-cloud-download" aria-hidden="true"></i> Download Lesson</a>
			<?php endif; ?>
		</div>
</div>
</div>

	<hr>


	<?php echo get_the_post_thumbnail( $post->ID, 'large' ); ?>

	<div class="entry-content">

		<?php the_content(); ?>

		<?php if( get_field('video_url') ): ?>
				<p>Associated Resource: <a href = "<?php the_field ('video_url'); ?>" target = "_blank">Video</a></p>
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
