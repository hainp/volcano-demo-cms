<?php 

function ketchupthemes_wp_title($title,$sep){
    /*
     * Print the <title> tag based on what is being viewed.
     */
    global $page, $paged;

   // Add the site name.
    $title .= get_bloginfo( 'name' );

    // Add the site description for the home/front page.
    $site_description = get_bloginfo( 'description', 'display' );
    if ( $site_description && ( is_home() || is_front_page() ) )
        $title = "$title $sep $site_description";

    // Add a page number if necessary.
    if ( $paged >= 2 || $page >= 2 )
        
        $title = "$title $sep " . sprintf( __( 'Page %s', 'chineserestaurant' ), max( $paged, $page ) );
        
        return $title;
}
add_filter( 'wp_title', 'ketchupthemes_wp_title', 10, 2 );
    
function ketchupthemes_loadScriptsForIE(){
        $scripts = '<!--[if lt IE 9]>
         <script src="'.get_template_directory_uri().'/js/html5shiv.js"></script>
         <![endif]-->';
       echo $scripts;
    }
    add_action('load_ie_scripts','ketchupthemes_loadScriptsForIE');
	
	//Load Scripts
	function ketchupthemes_load_scripts() {
    $url = get_template_directory_uri().'/';
		wp_enqueue_script('bootstrap', $url.'js/bootstrap.min.js',array('jquery'),'',true);

	
	if ( is_singular() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );

	}
	add_action('wp_enqueue_scripts', 'ketchupthemes_load_scripts');
    
    // Load Theme Textdomain
function ketchupthemes_theme_setup(){
        add_editor_style( 'style.css' );
        // Load Background
        $ketchupthemes_background_args = array(
        'default-color' => '',
        'default-image' => ''
        );
        add_theme_support( 'custom-background', $ketchupthemes_background_args );
        
        //Load Header
        $ketchupthemes_header_defaults = array(
        'default-image'          => '',
        'random-default'         => false,
        'width'                  => '585',
        'height'                 => '988',
        'flex-height'            => false,
        'flex-width'             => false,
        'default-text-color'     => '',
        'header-text'            => false,
        'uploads'                => true,
        'wp-head-callback'       => '',
        'admin-head-callback'    => '',
        'admin-preview-callback' => '',
        );
        add_theme_support( 'custom-header', $ketchupthemes_header_defaults );
        // Add RSS links to <head> section
        add_theme_support( 'automatic-feed-links' );
        // Thumbnail Sizes
        add_theme_support( 'post-thumbnails' );
        
        // Theme's Custom Menus
        register_nav_menu( 'primary', 'Main Menu' );
    
        
        load_theme_textdomain('chineserestaurant', get_template_directory() . '/languages');
        
    }
    add_action('after_setup_theme', 'ketchupthemes_theme_setup');
    
	//Load styles
	function ketchupthemes_load_styles()
	{ 
        
		$src = get_template_directory_uri();
	
		if(!is_admin())
		{   
            $styleUri = get_stylesheet_uri();
			wp_enqueue_style( 'bootstrap', $src . '/css/bootstrap.min.css','','','all' );
			wp_enqueue_style( 'bootstrap-theme', $src . '/css/bootstrap-theme.min.css','','','all' );
			wp_enqueue_style( 'style', $styleUri,'','','all' );
			
	
		} 
	}	
	add_action('wp_enqueue_scripts', 'ketchupthemes_load_styles');
	
	
	// Set $content_width
	if ( ! isset( $content_width ) )
	$content_width = 575;
	
	//Widgets
	function ketchupthemes_widgets_init() {
	
	register_sidebar(array(
		'name' => __('Sidebar', 'chineserestaurant' ),
		'id'   => 'sidebar',
		'description' => __('This is the widgetized sidebar.', 'chineserestaurant' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3>',
		'after_title'   => '</h3>'
	));
	}
	add_action( 'widgets_init', 'ketchupthemes_widgets_init' );
	
	
// Register Custom Navigation Walker
require_once('wp_bootstrap_navwalker.php');
/**Add a simple metabox***/
/***
* 
* 
*/
function ketchupthemes_pricefield_add_custom_box() {

    $screens = array( 'post');

    foreach ( $screens as $screen ) {

        add_meta_box(
            'pricefield_id',
            __( 'Price Fields', 'chineserestaurant' ),
            'ketchupthemes_pricefield_inner_custom_box',
            $screen
        );
    }
}
add_action( 'add_meta_boxes', 'ketchupthemes_pricefield_add_custom_box' );
/**Print the box content**/
function ketchupthemes_pricefield_inner_custom_box( $post ) {

  // Add an nonce field so we can check for it later.
  wp_nonce_field( 'ketchupthemes_pricefield_inner_custom_box', 'ketchupthemes_pricefield_inner_custom_box_nonce' );

  /*
   * Use get_post_meta() to retrieve an existing value
   * from the database and use the value for the form.
   */
  $value = get_post_meta( $post->ID, 'ketchupthemes_price', true );

  echo '<label for="pricefield_new_field">';
       _e( "Add a price", 'chineserestaurant' );
  echo '</label> ';
  echo '<input type="text" id="pricefield_new_field" name="pricefield_new_field" value="' . esc_attr( $value ) . '" size="25" />';
}
function ketchupthemes_pricefield_save_postdata( $post_id ) {

  /*
   * We need to verify this came from the our screen and with proper authorization,
   * because save_post can be triggered at other times.
   */

  // Check if our nonce is set.
  if ( ! isset( $_POST['ketchupthemes_pricefield_inner_custom_box_nonce'] ) )
    return $post_id;

  $nonce = $_POST['ketchupthemes_pricefield_inner_custom_box_nonce'];

  // Verify that the nonce is valid.
  if ( ! wp_verify_nonce( $nonce, 'ketchupthemes_pricefield_inner_custom_box' ) )
      return $post_id;

  // If this is an autosave, our form has not been submitted, so we don't want to do anything.
  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
      return $post_id;

  // Check the user's permissions.
  if ( 'page' == $_POST['post_type'] ) {

    if ( ! current_user_can( 'edit_page', $post_id ) )
        return $post_id;
  
  } else {

    if ( ! current_user_can( 'edit_post', $post_id ) )
        return $post_id;
  }

  /* OK, its safe for us to save the data now. */

  // Sanitize user input.
  $mydata = sanitize_text_field( $_POST['pricefield_new_field'] );

  // Update the meta field in the database.
  update_post_meta( $post_id, 'ketchupthemes_price', $mydata );
}
add_action( 'save_post', 'ketchupthemes_pricefield_save_postdata' );
/***OPTIONS PAGE***/
/**
* 
*/
function ketchupthemes_admin_scripts() {
$url = get_template_directory_uri().'/';
wp_enqueue_script('media-upload');
wp_enqueue_script('thickbox');
wp_enqueue_script('my-upload', $url.'js/upload_image_favicon.js', array('jquery','media-upload','thickbox'));
}
function ketchupthemes_admin_styles() {
wp_enqueue_style('thickbox');
$url = get_template_directory_uri().'/';
wp_enqueue_style('upgradeStyle',$url.'/css/ketchup-upg-style.css','','all');
}
 
if (isset($_GET['page']) && $_GET['page'] == 'settings') {
add_action('admin_enqueue_scripts', 'ketchupthemes_admin_scripts');
add_action('admin_enqueue_scripts', 'ketchupthemes_admin_styles');
}
//register settings
function ketchupthemes_theme_settings_init(){
    register_setting( 'chinese_theme_settings', 'chinese_theme_settings','settings_sanitize_and_validate' );
}
    function settings_sanitize_and_validate($input){
        /*Validation*/
        if(!isset($input['fav_upload'])){ $input['fav_upload'] = '';}
        if(!isset($input['badge_text'])){ $input['badge_text'] = '';}
        if(!isset($input['badge_url'])){ $input['badge_url']='';}
        $favUrl = $input['fav_upload'];
        $badgeUrl = $input['badge_url'];
        if (filter_var($favUrl, FILTER_VALIDATE_URL)) {
            $input['fav_upload'] = $favUrl;
            }
            else {
            $input['fav_upload'] = '';
            }
        
          if (filter_var($badgeUrl, FILTER_VALIDATE_URL)) {
            $input['badge_url'] = $badgeUrl;
            }
            else {
            $input['badge_url'] = '';
            }
            
        return $input;
        
    }
//add settings page to menu
function add_settings_page() {

add_theme_page(__('Theme Settings','chineserestaurant'),__('Theme Settings','chineserestaurant'),'edit_theme_options', 'settings', 'ketchupthemes_theme_settings_page');
}

//add actions
add_action( 'admin_init', 'ketchupthemes_theme_settings_init' );
add_action( 'admin_menu', 'add_settings_page' );

//start settings page
function ketchupthemes_theme_settings_page() {

if ( ! isset( $_REQUEST['updated'] ) )
$_REQUEST['updated'] = false;

?>

<div>

<div id="icon-options-general"></div>
<h2><?php _e( 'Theme Settings','chineserestaurant' ) //your admin panel title ?></h2>
<?php
//show saved options message
if ( false !== $_REQUEST['updated'] ) : ?>
<div><p><strong><?php _e( 'Options saved','chineserestaurant' ); ?></strong></p></div>
<?php endif; ?>

<form method="post" action="options.php">

<?php settings_fields( 'chinese_theme_settings' ); ?>
<?php $options = get_option( 'chinese_theme_settings' ); ?>

<table>
<!--Option 1:Custom Favicon-->

<tr valign="top">
<th scope="row"><?php _e('Upload Favicon','chineserestaurant');?> </th>
<td><label for="upload_image">
<?php printf("<input id='upload_image' type='text' size='36' name='chinese_theme_settings[fav_upload]' value='%s' />",esc_attr( $options['fav_upload'] ) ); ?>
<input id="theme_settings_fav_upload_button" type="button" value="Upload Image" />
<br /><?php _e('Enter a url or upload the favicon image','chineserestaurant');?> 
</label></td>
</tr>

<tr valign="top">
<th scope="row"><?php _e('Call To Action Button Text','chineserestaurant');?> </th>
 <td><label for="badge_text">
    <?php printf("<input id='badge_text' type='text' size='36' name='chinese_theme_settings[badge_text]' value='%s' />",esc_attr( $options['badge_text'] ) ); ?>
    <br /><?php _e('Enter a call to action word-phrase.','restaurante');?> 
    </label></td>
</tr>

 <!--Badge Url -->
    <tr valign="top">
    <th scope="row"><?php _e('Badge URL','restaurante');?> </th>
    <td><label for="badge_url">
    <?php printf("<input id='badge_url' type='text' size='36' name='chinese_theme_settings[badge_url]' value='%s' />",esc_attr( $options['badge_url'] ) ); ?>
    <br /><?php _e('Enter the badge URL.','restaurante');?> 
    </label></td>
    </tr>

</table>

<p><input name="submit" id="submit" value="Save Changes" type="submit"></p>
</form>
<div class="premium">
<p>
The <b>premium version</b> of the theme includes advanced options that allow the creation of a professional and very functional website:
</p>
<ul>
<li>- Allows to activate a slideshow in homepage to display the posts included in it. </li>
<li>- Allows to upload your own custom logo                                                </li>
<li>- Allows to integrate the website with Google Analytics to follow the statistics of website.</li>
<li>- Allows to activate social profiles such as facebook, twitter, google+ etc.                     </li>
</ul>
<p>The premium version of our theme is GPL v2 or later compatible.</p>
<a class="upgradeLink" target="_blank" href="<?php echo esc_url( __( 'http://www.ketchupthemes.com/premium', 'chineserestaurant' ) ); ?>">Upgrade Now</a>
</div>

</div><!-- END wrap -->

<?php
}