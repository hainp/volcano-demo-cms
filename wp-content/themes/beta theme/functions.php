
<?php // Register custom navigation walker
    //require_once('wp_bootstrap_navwalker.php');
    require_once ('inc/nav.php');
?>
<?php
	
	// Add RSS links to <head> section
	automatic_feed_links();
	
	// Load jQuery
	if ( !is_admin() ) {
	   wp_deregister_script('jquery');
	   wp_register_script('jquery', ("http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"), false);
	   wp_enqueue_script('jquery');
	}
	
	// Clean up the <head>
	function removeHeadLinks() {
    	remove_action('wp_head', 'rsd_link');
    	remove_action('wp_head', 'wlwmanifest_link');
    }
    add_action('init', 'removeHeadLinks');
    remove_action('wp_head', 'wp_generator');
    
	// Declare sidebar widget zone
    if (function_exists('register_sidebar')) {
    	register_sidebar(array(
    		'name' => 'Right Sidebar',
    		'id'   => 'right-sidebar',
    		'description'   => 'These are widgets for the sidebar.',
    		'before_widget' => '<div class="panel panel-danger">
        <div class="panel-heading">',
    		'after_widget'  => '</div></div>',
    		'before_title'  => '<h3 class="panel-title">',
    		'after_title'   => '</h3>
        </div>
        <div class="panel-body">'
    	));
    }

?>


<?php
/* Theme setup */
add_action( 'after_setup_theme', 'wpt_setup' );
    if ( ! function_exists( 'wpt_setup' ) ):
        function wpt_setup() { 
            register_nav_menu( 'primary', __( 'Primary navigation', 'wptuts' ) );
        } endif;
?>



<?php
function wpt_register_js() {
    wp_register_script('jquery.bootstrap.min', get_template_directory_uri() . '/js/bootstrap.min.js', 'jquery');
    wp_enqueue_script('jquery.bootstrap.min');
}
add_action( 'init', 'wpt_register_js' );
function wpt_register_css() {
    wp_register_style( 'bootstrap.min', get_template_directory_uri() . '/css/bootstrap.min.css' );
    wp_enqueue_style( 'bootstrap.min' );
}
add_action( 'wp_enqueue_scripts', 'wpt_register_css' );
 ?>

<?php
//limit title(), show title
function limit_title($numberlimit){
$tit = the_title('','',FALSE);
echo substr($tit, 0, $numberlimit);
if (strlen($tit) > $numberlimit) echo " ...";
}?>


<?php //check isset thumbnails in Wordpress <3.0
if (function_exists('add_theme_support')){
add_theme_support('post-thumbnails');
}
?>

<?php 
//excerpt de hien thi link
function new_excerpt_more($more){
    global $post;
    return "<a class='more-link' href='".get_permalink($post->ID)."'> ...</a>";}
    add_filter('excerpt_more','new_excerpt_more');

?>