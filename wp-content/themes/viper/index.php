<?php get_header(); ?>

			<?php
							
								if ( of_get_option('homepage_layout') == 'standard' ) {
									$homelayout = 'standard';
								} else {
									$homelayout = 'magten';
								}
							
								get_template_part( 'index', $homelayout );
							
							
			?>					

							
								
									
			<?php get_footer(); ?>