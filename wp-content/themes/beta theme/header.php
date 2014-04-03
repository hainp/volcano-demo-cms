<!DOCTYPE html> 
<html <?php language_attributes(); ?>> 
<head> 
<meta charset="<?php bloginfo('charset'); ?>" /> 
<!--Thiết lập title--> 
<title><?php wp_title('|',true,'right'); ?><?php bloginfo('name'); ?></title> 
<link rel="profile" href="http://gmpg.org/xgn/11" /> 
<!--Chèn CSS và JS cần thiết--> 
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo('stylesheet_url'); ?>" /> 

<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo('template_directory');?>/css/bootstrap.min.css" /> 
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo('template_directory');?>/css/bootstrap-responsive.min.css" /> 
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo('template_directory');?>/style.css" /> 

<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
<link rel="shortcut icon" href="/favicon.ico">

<!-- jQuery -->
<script type="text/javascript" src='<?php echo bloginfo('template_directory');?>/js/jquery-2.1.0.min.js'></script>
<!-- Bootstrap JavaScript -->
<script type="text/javascript" src="<?php echo bloginfo('template_directory');?>/js/bootstrap.min.js"></script>
<?php if ( is_singular() ) wp_enqueue_script('comment-reply'); ?>
<?php wp_head();?>

</head><!-- /head -->

<body <?php body_class(); ?>>
<nav class="navbar navbar-inverse" role="navigation">
<!-- Mobile display -->
<div class="navbar-header">
	<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
		<span class="sr-only">Toggle navigation</span>
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
	</button>
</div>
<a class="navbar-brand" href="<?php bloginfo('url')?>"><?php bloginfo('name')?></a>
<p><?php bloginfo('description'); ?></p>

<!-- Collect the nav links for toggling -->
<div class="collapse navbar-collapse navbar-ex1-collapse">
	<?php /* Primary navigation */
	wp_nav_menu( array(
		'menu'=> "Menu Pages",
		'container_class' => 'collapse navbar-collapse navbar-ex1-collapse',
		'menu_class'      => 'nav navbar-nav',
		'menu_id'         => 'main-menu',
		'walker'          => new Cwd_wp_bootstrapwp_Walker_Nav_Menu()
		) );
		?>
		
		<form class="navbar-form navbar-right" role="search">
			<div class="form-group">
				<input type="text" class="form-control" placeholder="Search">
			</div>
			<button type="submit" class="btn btn-default">Search</button>
		</form>

		<ul class="nav navbar-nav navbar-right">
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">Log in | Join<b class="caret"></b></a>
				<ul class="dropdown-menu">
					<li><a href="#">Log in</a></li>
					<li><a href="#">Join </a></li>
				</ul>
			</li>

		</ul>
	</div><!-- /.navbar-collapse -->
</nav>  	<!-- ket thuc header -->