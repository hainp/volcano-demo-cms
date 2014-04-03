<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo('charset'); ?>" />
	
	<?php if (is_search()) { ?>
	   <meta name="robots" content="noindex, nofollow" /> 
	<?php } ?>

	<title>
		   <?php
		      if (function_exists('is_tag') && is_tag()) {
		         single_tag_title("Tag Archive for &quot;"); echo '&quot; - '; }
		      elseif (is_archive()) {
		         wp_title(''); echo ' Archive - '; }
		      elseif (is_search()) {
		         echo 'Search for &quot;'.wp_specialchars($s).'&quot; - '; }
		      elseif (!(is_404()) && (is_single()) || (is_page())) {
		         wp_title(''); echo ' - '; }
		      elseif (is_404()) {
		         echo 'Not Found - '; }
		      if (is_home()) {
		         bloginfo('name'); echo ' - '; bloginfo('description'); }
		      else {
		          bloginfo('name'); }
		      if ($paged>1) {
		         echo ' - page '. $paged; }
		   ?>
	</title>
	 <!--Chèn CSS và JS cần thiết--> 
        <link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo('stylesheet_url'); ?>" /> 
        <link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo('template_directory');?>/css/bootstrap.min.css" /> 
        <link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo('template_directory');?>/css/bootstrap-responsive.min.css" /> 
        <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">

	<link rel="shortcut icon" href="/favicon.ico">
	
	<!-- jQuery -->
	<script type="text/javascript" src='<?php echo bloginfo('template_directory');?>/js/jquery-2.1.0.min.js'></script>
	<!-- Bootstrap JavaScript -->
	<script type="text/javascript" src="<?php echo bloginfo('template_directory');?>/js/bootstrap.min.js"></script>
	
	
	
	<?php if ( is_singular() ) wp_enqueue_script('comment-reply'); ?>

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>

	<nav class="navbar navbar-inverse" role="navigation">
		<!-- Brand and toggle get grouped for better mobile display -->
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="http://volcano.vn/">VOLCANO.VN</a>
		</div>
		
		<!-- Collect the nav links, forms, and other content for toggling -->
		<div class="collapse navbar-collapse navbar-ex1-collapse">
			<ul class="nav navbar-nav">
				<li class="active"><a href="#">Home</a></li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">Reviews<b class="caret"></b></a>
					<ul class="dropdown-menu">
						<li><a href="#">Car Tech</a></li>
						<li><a href="#">Cell Phones</a></li>
						<li><a href="#">Desktops</a></li>
						<li><a href="#">Laptops</a></li>
						<li><a href="#">Tablets</a></li>
						<li><a href="#">Games Consoles</a></li>
					</ul>
				</li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">News<b class="caret"></b></a>
					<ul class="dropdown-menu">
						<li><a href="#">Apple</a></li>
						<li><a href="#">Microsoft</a></li>
						<li><a href="#">LG</a></li>
						<li><a href="#">Samsung</a></li>
						<li><a href="#">Sony</a></li>
						<li><a href="#">Amazon</a></li>
					</ul>
				</li>
				<li><a href="#">Shop</a></li>
			</ul>
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