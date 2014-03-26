<?php $chinese_options = get_option( 'chinese_theme_settings' ); global $options;?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
    <?php if($chinese_options['fav_upload']):?>
    <link rel="icon" href="<?php echo(esc_url($chinese_options['fav_upload'])); ?>" type="image/x-icon">
    <?php endif; ?> 
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />	
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php do_action('load_ie_scripts');?>
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<div id="ktWrapper">
	<div class="container" id="logo">
		<div class="row">
			<div class="col-md-12"> 
				<h1><a href="<?php echo esc_url(home_url()); ?>">
				<?php echo get_bloginfo('name'); ?>
				</a></h1>
				<h2><?php bloginfo('description'); ?></h2>
			</div>
		</div>
	</div>
	<div id="ktTopNav">
		<div class="container">
			<div class="navbar navbar-default" role="navigation">
					<div class="container-fluid">
					  <div class="navbar-header">
						<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
						  <span class="sr-only">Toggle navigation</span>
						  <span class="icon-bar"></span>
						  <span class="icon-bar"></span>
						  <span class="icon-bar"></span>
						</button>
						
					  </div>
					  <div class="navbar-collapse collapse">
						<?php
									wp_nav_menu( array(
										'theme_location'    => 'primary',
										'depth'             => 2,
										'container'         => 'div',
										'container_class'   => 'collapse navbar-collapse navbar-ex1-collapse',
										'menu_class'        => 'nav navbar-nav navbar-right',
										'fallback_cb'       => 'wp_bootstrap_navwalker::fallback',
										'walker'            => new wp_bootstrap_navwalker())
									);
								?>
					  </div><!--/.nav-collapse -->
					</div><!--/.container-fluid -->
				</div>
		</div>
	</div>
	