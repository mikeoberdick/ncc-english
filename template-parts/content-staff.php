<?php while ( have_posts() ) : the_post(); ?>

	<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">

		<header class="entry-header">

			<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
			<hr>

		</header><!-- .entry-header -->

			<div class="entry-content">

				<?php the_content(); ?>

				<?php

				// check if the repeater field has rows of data
				if( have_rows('staff_member') ):

					$i = 0;

				 	// loop through the rows of data
				    while ( have_rows('staff_member') ) : the_row(); ?>

				    <?php

						if($i % 4 == 0) { ?> 
        					<div class="row d-flex">
   						<?php
   							}

   							?>

						<div class = "col-md-3 mb-4">
					        <img class = "staff_headshot mb-3" src = "<?php the_sub_field('headshot'); ?>">
					        <h3 class = "staff_name"><?php the_sub_field('name'); ?></h3>
					        <p class = "staff_bio"><?php the_sub_field('bio'); ?></p>
					        <a class = "staff_email" href = "mailto:<?php the_sub_field('e-mail_address'); ?>"><i class="fa fa-envelope" aria-hidden="true"></i><?php the_sub_field('e-mail_address'); ?></a>
					        <p class = "staff_phone"><i class="fa fa-phone" aria-hidden="true"></i><?php the_sub_field('phone_number'); ?></p>
					        </div>

				        <?php 
				    $i++;
    				if($i != 0 && $i % 4 == 0) { ?> 
       				</div><!-- end of row -->
    				<?php
    				}

				    endwhile;

				else :

				    // no rows found

				endif;

				?>

				</div>

				</div>

			</div><!-- .entry-content -->

	</article><!-- #post-## -->

<?php endwhile; // end of the loop ?>