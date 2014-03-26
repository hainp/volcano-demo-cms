	<?php get_header(); ?>
	<div id="ktMain">
	<div class="container">
		<div class="row">
		  <div class="col-md-6">
		  <div class="row">
			<?php 

			  //Set the counter to 1
			  $i = 1;
			?>
			 <div class="col-md-4">
			<?php 
			  //Start the loop
			  if ( $wp_query->have_posts() ) : while ( $wp_query->have_posts() ) : $wp_query->the_post(); ?>

				  <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				   <div class="ktArticle">
					
					<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
					<?php if(has_post_thumbnail()) { 
						the_post_thumbnail();
						} else { ?> 
						<img class="attachment-post-thumbnail wp-post-image" src="<?php echo get_template_directory_uri(); ?>/img/noimage.png" alt="" />
						<?php } ?>
					</a>
					</div>	  
				  </div>
				
			  <?php 
			  // After 3 close the row div and open a new one
			  if($i % 1 == 0) {echo '</div><div class="col-md-4">';}

			  //End stuff
			  $i++; endwhile; endif;
				?>
			</div>
			<div class="clearfix"></div>
              
			<?php 
            $chinese_options = get_option( 'chinese_theme_settings' );
            if($chinese_options['badge_text'] != "" || $chinese_options['badge_url'] != ""){?>
            <div id="ktOrder-Online">
            <a href="<?php echo esc_url( __( $chinese_options['badge_url'], 'chineserestaurant' ) ); ?>" class="btn btn-danger"><?php printf( __( $chinese_options['badge_text'], 'chineserestaurant' )); ?></a> 
            </div>
            <?php } ?>

			</div>
			<div class="clearfix"></div>
			<div id="ktPagination">
				<div class="alignleft"><?php previous_posts_link(__( '&laquo; Newer posts', 'chineserestaurant' )) ?></div>
				<div class="alignright"><?php next_posts_link(__( 'Older posts &raquo;', 'chineserestaurant' )) ?></div>
			</div>
		  </div>
		  <?php get_sidebar(); ?>
		</div>
	</div>
	</div>
	<?php get_footer(); ?>   