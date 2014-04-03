<?php get_header();  ?>

<div id="main">
	<div class="container">
		
		<div class="row">
			<div class="col-md-4 content" >
				<div class="post">
					

					<?php //hien thi noi dung cot 1
					$games = new WP_Query('showposts=15&cat=35');
					while ($games->have_posts()) : $games->the_post(); ?>
					<div class="panel panel-default">
						<a href="<?php the_permalink();?>"><?php the_post_thumbnail(array(358,250));?></a>
						<div class="panel-heading">
							<h3 class="panel-title" >

								<h4><?php the_title() ;?></h4></h3>
							</div>
							<div class="panel-body">
								<?php the_excerpt();?>
							</div>
							<p><a href="<?php the_permalink();?>"><button type="button" class="btn btn-success">Read More →</button></a></p>


							<div class="panel-footer">
								<p><span class="glyphicon glyphicon-tags"> <?php the_category(' '); echo " |";?></span>
									<span class="glyphicon glyphicon-envelope"> <?php echo " "; comments_popup_link('0','1','>2','comment_link'); echo " |";?></span>
									<span class="glyphicon glyphicon-time"> <?php the_time('F j, Y');?></span>
								</p>
							</div>					
						</div>
						<?php endwhile; 
						wp_reset_postdata();?>
					</div>
				</div> <!-- end content 1-->

				<!-- begin content 2 -->
				<div class="col-md-4 content" >	
					<div class="post">
								<?php //hien thi noi dung cot 2
								$apps = new WP_Query('showposts=15&cat=36');
								while ($apps->have_posts()) : $apps->the_post(); ?>
								<div class="panel panel-default">
									<a href="<?php the_permalink();?>"><?php the_post_thumbnail(array(358,250));?></a>
									<div class="panel-heading">
										<h3 class="panel-title" >

											<h4><?php the_title() ;?></h4></h3>
										</div>
										<div class="panel-body">
											<?php the_excerpt();?>
										</div>
										 <p><a href="<?php the_permalink();?>"><button type="button" class="btn btn-success">Read More →</button></a></p>



										<div class="panel-footer">
											<p><span class="glyphicon glyphicon-tags"> <?php the_category(' '); echo " |";?></span>
												<span class="glyphicon glyphicon-envelope"> <?php echo " "; comments_popup_link('0','1','>2','comment_link'); echo " |";?></span>
												<span class="glyphicon glyphicon-time"> <?php the_time('F j, Y');?></span>
											</p>
										</div>					
									</div>
									<?php endwhile; 
									wp_reset_postdata();?>
								</div> <!-- end post -->

							</div> <!-- end content 2 -->	


							<?php get_sidebar(); ?>

							<?php get_footer(); ?>