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
				<h3>Lesson Categories</h3>
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
<hr>
<div class = "newLessons">
	 <div class = "row">
	 	<div class = "col-sm-12">
			<h3>Newest Lessons</h3>
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
	                <div class = "categoryList"><?php echo get_the_term_list( $post->ID, 'lesson-category', ' ' ); ?></div>
            	</div>
              </div>

            <?php endwhile; ?>
    </div>
</div>