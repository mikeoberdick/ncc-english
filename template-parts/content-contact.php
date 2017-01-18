<?php while ( have_posts() ) : the_post(); ?>

	<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

		<header class="entry-header">

			<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

		</header><!-- .entry-header -->

			<div class="entry-content">

				<?php the_content(); ?>

			</div><!-- .entry-content -->

				<div>
			
					<?php if( function_exists( 'ninja_forms_display_form' ) ){ ninja_forms_display_form( 1 ); } ?>

				<div>

	</article><!-- #post-## -->

<?php endwhile; // end of the loop ?>
