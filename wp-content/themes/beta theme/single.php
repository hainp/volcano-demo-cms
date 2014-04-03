	

<?php get_header();  ?>

<div id="main">
	<div class="container">
		<div class="row">
			<div class="col-md-12 content" >
				<div class="post">
					<div class="panel panel-default">
						
						<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
						<a href="<?php the_permalink();?>"><?php the_post_thumbnail(array(1139,550));?></a>
						<div <?php post_class() ?> id="post-<?php the_ID(); ?>">

							<div class="panel-heading">
								<h3 class="panel-title" >
									<h2><?php the_title(); ?></h2></h3>
								</div>
								<div class="info"><?php include (TEMPLATEPATH . '/inc/meta.php' ); ?></div>

								<div class="entry">
									<div class="panel-body">
										<?php the_content(); ?>
									</div>



									<?php wp_link_pages(array('before' => 'Pages: ', 'next_or_number' => 'number')); ?>

									<?php the_tags( 'Tags: ', ', ', ''); ?>

								</div>



							</div>

					</div>
					<?php edit_post_link('Edit this entry','','.'); ?>

						<?php endwhile; endif; ?>
				</div>
				<?php comments_template(); ?>
			</div></div></div></div>


			<?php get_footer(); ?>