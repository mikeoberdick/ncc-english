<div>
	<img id = "hp_hero" src = "<?php the_field('hero_image'); ?>" alt = "Norwalk Community College English Department" title = "Norwalk Community College English Department"/>
</div>
	
	<?php while ( have_posts() ) : the_post(); ?>
		
		<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

				<div class="entry-content">

					<?php the_content(); ?>

				</div><!-- .entry-content -->

		</article><!-- #post-## -->

	<?php endwhile; // end of the loop ?>

<div class = "lessonCategories">
	<div class = "row">
		 	<div class = "col-sm-12">
				<h3 class = "header_bg"><span>Lesson Categories</span></h3>
			</div>

		<?php

		$terms = get_terms( array( 
	    	'taxonomy' => 'lesson-category',
	    	'hide_empty'   => 0
				) );


		
			if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
	    			foreach ( $terms as $term ) {
	    				$term_link = get_term_link( $term );
	        			echo '<div class = "col-sm-6 col-lg-4"><a href="' . esc_url( $term_link ) . '"><div class = "lesson_cat" style = "background-image: url(' . get_field('lesson_category_image', $term) . '); background-size: cover; background-repeat: no-repeat;">' . $term->name . '</div></div></a>';
	    			}
				}

				?>
		</div>
</div>

<div class = "newLessons">
	 <div class = "row">
	 	<div class = "col-sm-12">
			<h3 class = "header_bg"><span>Newest Lessons</span></h3>
		</div>

            <?php
                $args = array(
                'post_type' => 'lessons',
                'posts_per_page' => '3',
                );
                
                $wp_query = new WP_Query( $args );
                
                // The Loop
                while ( $wp_query->have_posts() ) : $wp_query->the_post(); ?>

              <div class = "col-sm-6 col-lg-4">
              	<div class = "hp_lesson">
	                <div class = "lessonTitle"><a href = "<?php the_permalink(); ?>"><h3><?php the_title(); ?></h3></a></div>
	                <p><?php the_excerpt(); ?></p>
            	</div>
              </div>

            <?php endwhile; ?>
    </div>
</div>

<div class = "authors">
	 <div class = "row">
	 	<div class = "col-sm-12">
			<h3 class = "header_bg"><span>Top Contributors</span></h3>
		</div>
<?php

$allUsers = get_users('orderby=post_count&order=DESC&number=4');
$users = array();

// Remove admins from the list
foreach($allUsers as $currentUser)
	{
		if(!in_array( 'admin', $currentUser->roles )) {
			$users[] = $currentUser;
		}
	}

	foreach($users as $user)
		{
	?>
	<div class = "col-md-3">
<a href="<?php echo get_author_posts_url( $user->ID ); ?>">
	<div class="author">
	
		<div class="authorAvatar">
			<?php echo get_avatar( $user->user_email, '128' ); ?>
		</div>
		
		<div class="authorInfo">
			<h2 class="authorName"><?php echo $user->display_name; ?></h2>
		</div>
	</div>
</a>
</div>

<?php
	}
?>

</div>
</div>
</div>