<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package understrap
 */

$the_theme = wp_get_theme();
$container = get_theme_mod( 'understrap_container_type' );
?>

<div id="js-heightControl" style="height: 0;">&nbsp;</div>

<?php get_sidebar( 'footerfull' ); ?>

<div class="wrapper" id="wrapper-footer">

	<div class="<?php echo esc_html( $container ); ?>">

		<div class="row">

			<div class="col-md-12">

				<footer class="site-footer" id="colophon">

					<div class="site-info">
						<div>&copy; <?php echo date('Y'); ?> <?php echo bloginfo('name'); ?> <span class="sep"> | </span> Website by <a href = "http://www.designs4theweb.com">Designs 4 The Web</a></div>
					</div><!-- .site-info -->

				</footer><!-- #colophon -->

			</div><!--col end -->

		</div><!-- row end -->

	</div><!-- container end -->

</div><!-- wrapper end -->

</div><!-- #page -->

<?php wp_footer(); ?>

<script>
jQuery(document).ready(function() {
	jQuery('#js-heightControl').css('height', jQuery(window).height() - jQuery('html').height() +'px');
});
</script>

</body>

</html>
