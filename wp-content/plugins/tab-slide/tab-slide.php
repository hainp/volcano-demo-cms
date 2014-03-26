<?php
defined( 'ABSPATH' ) OR exit;
/*
Plugin Name: Tab Slide
Plugin URI: http://store.zoranc.co/downloads/tab-slide-pro/
Description: Easy to use, yet powerful and a highly customizable sliding shelf for your site! Slide your target content/widgets into and out of the visible page. The content can contain forms, widgets, videos, pictures, posts, menu options, comments, logins, sign-ups, popoup ads etc. The settings page appears in the Dashboard settings menu, where you can set all your tab slide options such as page source, size, positioning, autohide, opacity and much more. No coding skills are required to implement this functionality on your WordPress site. 
Version: 2.0.0
Author: Zoran C.
Author URI: http://zoranc.co/
License: GPL2
*/
// Define contants
define( 'TAB_SLIDE_VERSION' , '2.0.0' );
define( 'TAB_SLIDE_ROOT' , dirname(__FILE__) );
define( 'TAB_SLIDE_FILE_PATH' , TAB_SLIDE_ROOT . '/' . basename(__FILE__) );
define( 'TAB_SLIDE_URL' , plugins_url(plugin_basename(dirname(__FILE__)).'/') );
define( 'TAB_SLIDE_SETTINGS_PAGE' , 'options-general.php?page=tab-slide' );

// Include necessary files, including the path in which to search to avoid conflicts
include_once( TAB_SLIDE_ROOT . '/php/upgrade.php' );

//$plugin = plugin_basename(__FILE__);

register_uninstall_hook( __FILE__, array( 'tab_slide', 'uninstall_plugin' ) );

// Core class
class Tab_Slide {
	// Unique identifier added as a prefix to all options
	var $options_group = 'tab_slide_';

	// Following plugin options are written to the wp database upon plugin activation
	var $plugin_options = array();
	/*
	 * Initialize the core of the plugin
	 */
	public function __construct() {
		load_plugin_textdomain( 'tab-slide', null, TAB_SLIDE_ROOT . '/languages/' );
		$this->plugin_options = json_decode(file_get_contents(TAB_SLIDE_ROOT . '/themes/default-light.json'), true);
		$this->load_options();
		if(is_admin()) {
			add_filter( 'plugin_action_links',     array( &$this, 'tab_slide_settings_link'), 10, 2 );
			add_action( 'admin_init',              array( &$this, 'admin_init' ) );
			add_action( 'admin_enqueue_scripts',   array( &$this, 'add_admin_scripts'));
			add_action( 'init',                    array( &$this, 'admin_menu_init' ) );
			add_action( 'save_tab_slide_settings', array( &$this, 'generate_instance_css' ));			
		} else {
			add_action( 'wp',                    array( &$this, 'check_instance' ), 10 );
		}
		add_action( 'widgets_init',            array( &$this, 'tab_slide_widgets_init' ));
	}
	public function activate_tab_slide () {
	}
	public function deactivate_tab_slide( ) {
	}
	public static function uninstall_plugin() {
		global $tab_slide;
		$tab_slide->delete_options($tab_slide->plugin_options);
		delete_metadata( 'user', 0, 'tab_slide_admin_notice', 0, true );
	}
	/*
	 * Loads options for the plugin.
	 * If option doesn't exist in database, it is added
	 *
	 * Note: default values are stored in the $this->plugin_options array
	 * Note: a prefix unique to the plugin is appended to all the options. Prefix is stored in $this->options_group 
	 */
	public function load_options() {
		$new_options = array();
		foreach($this->plugin_options as $option => $value) {
			$name = $this->get_plugin_option_fullname($option);
			$return = get_option($name);
			if($return === false) {
				add_option($name, $value);
				$new_array[$option] = $value;
				if ( $name == $this->get_plugin_option_fullname('css') )
					$this->generate_instance_css();
			} else {
				$new_array[$option] = $return;
			}
		}

		$this->plugin_options = $new_array;
	}
	/*
	 * Appends the option prefix and returns the full name of the option as it is stored in the wp_options db
	 */
	public function get_plugin_option_fullname ( $name ) {
		return $this->options_group . $name;
	}
	/**
	 * get_plugin_option ()
	 *
	 * Returns option for the plugin specified by $name, e.g. show_on_load
	 * Note: The plugin option prefix does not need to be included in $name 
	 * @param string name of the option
	 * @return option|null if not found
	 */
	public function get_plugin_option ( $name ) {
		if (is_array($this->plugin_options) && $option = $this->plugin_options[$name])
			return $option;
		else 
			return null;
	}
	/**
	 * Updates option for the plugin specified by $name, e.g. show_on_load
	 *
	 * Note: The plugin option prefix does not need to be included in $name 
	 * 
	 * @param string name of the option
	 * @param string value to be set
	 *
	 */
	public function update_plugin_option( $name, $new_value ) {
		if( is_array($this->plugin_options) /*&& !empty( $this->plugin_options[$name] )*/ ) {
			$this->plugin_options[$name] = $new_value;
			update_option( $this->get_plugin_option_fullname( $name ), $new_value );
		}
	}
	/**
	 * Delete all options for the plugin
	 *
	 * @param array my_options of the option
	 *
	 */
	public function delete_options ($my_options) {
		if (!is_string($my_options)){
			foreach (array_keys($my_options) as $value) {
				
				$name = $this->get_plugin_option_fullname($value);
					delete_option($name);	
			}
		}
	}
	/**
	 * Generate CSS based on $this->plugin_options provided
	 * NOTE: stored in the 'css' index of database instance option array
	 */
	public function generate_instance_css() {
		$instance = $this->plugin_options;
		if ( $instance['cssonly'] == 0 || $instance['css'] == "" ) {
			ob_start();
			require('php/css.php');
			$css = ob_get_clean();
			if ($instance['css'] == "")				
				$this->update_plugin_option( 'css', $css );
		} else {
			$css = $instance['css'];
		}
		file_put_contents(TAB_SLIDE_ROOT . '/ts.css', $css, LOCK_EX); // Save it
		return true;
	}
	/**
	 * Append the Settings link to the Tab Slide Settings page on the main plugins page
	 */
	public function tab_slide_settings_link($links, $file ) {
		static $this_plugin;
		if (!$this_plugin) {
			$this_plugin = plugin_basename(__FILE__);
		}
		// check to make sure we are on the correct plugin
		if ($file == $this_plugin) {
			$settings_link = '<a href="options-general.php?page=tab-slide">Settings</a>'; 
			array_unshift($links, $settings_link); 
		}
		return $links; 
	}
	/**
	 * Register the settings and check the version on each admin init 
	 */
	public function admin_init() {
	    foreach($this->plugin_options as $option => $value) {
	    	register_setting($this->options_group, $this->get_plugin_option_fullname($option));
	    }
	    	    
	    // Upgrade if need be
	    $tab_prev_version = $this->get_plugin_option('version');
	    if ( version_compare( $tab_prev_version, TAB_SLIDE_VERSION, '<' ) ) tab_slide_upgrade($tab_prev_version);
	}
	/**
	 * Enqueue dashboard scripts and styles on the tab slide settings page 
	 */
	public function add_admin_scripts() {
		if (is_admin()) {
			if (array_key_exists ( 'page' , $_REQUEST ) && $_REQUEST['page'] == 'tab-slide') {
				wp_enqueue_style( 'tab-slide-settings', TAB_SLIDE_URL . '/css/settings.css' );
				wp_enqueue_script('jquery');
				wp_enqueue_style( 'farbtastic' );
				wp_enqueue_script( 'farbtastic' );
				wp_enqueue_script( 'tab-slide-settings', TAB_SLIDE_URL . '/js/settings.js' );
				wp_localize_script('tab-slide-settings', 'j_options', $this->plugin_options);
				wp_localize_script( 'tab-slide-settings', 'PostAjax', array(
					'ajaxurl' => admin_url( 'admin-ajax.php' ),
					'postNonce' => wp_create_nonce( 'tabslide-post-nonce' ))
				);
			}
		}
	}
	function admin_menu_init() {
		if(is_admin()) {			
			//Add the necessary pages for the plugin 
			add_action('admin_menu', array(&$this, 'add_menu_items'));
		}
	}
	public function add_menu_items ( ) {
		 // Add Top-level Admin Menu
		 include_once( TAB_SLIDE_ROOT . '/php/settings.php' );
		 $this->settings = new Tab_Slide_Settings();
		 add_options_page('Tab Slide', 'Tab Slide', 'manage_options', 'tab-slide',  array(&$this->settings , 'tab_slide_options_page'));
	}
	public function tab_slide_widgets_init() {
		// Enable the Tab Slide Widget Area if template_pick set to Widget
		if ( 'Widget' == $this->get_plugin_option('template_pick') ) {
			register_sidebar( array(
				'name' => 'Tab Slide',
				'id' => 'tab-slide',
				'description' => 'The tab slide widget area',
				'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
				'after_widget' => '</div>',
				'before_title' => '<h3 class="widget-title">',
				'after_title' => '</h3>',
			) );
		}
  }
  /**
   * check through instance options to see whether tab slide should be loaded or not 
   */
	public function check_instance() {
		do_action( 'tab_slide_check_instance' );
		$show_instance = false;
		$check_through_arrays = $this->check_through_arrays();
		// check  whether to show instance based on credentials
		switch ( $this->plugin_options['credentials'] ) {
			case "all":
				if ( $check_through_arrays )
					$show_instance = true;
				break;
			case "auth":
				if ( is_user_logged_in() && $check_through_arrays )
					$show_instance = true;
				break;
			case "unauth":
				if ( !is_user_logged_in() && $check_through_arrays )
					$show_instance = true;
				break;
		}
		$show_instance = apply_filters( 'tab_slide_show_instance', $show_instance, $this->plugin_options, $GLOBALS['pagenow']);
		if ($show_instance && $this->plugin_options['list_pick'] == 'shortcode' ) {
			add_shortcode( 'tabslide', array( &$this, 'shortcode_handler' ) );
		} else if ($show_instance) {
      add_filter( 'the_content', array( &$this, 'append_html_from_template'), 1);
      add_action( 'wp_enqueue_scripts', array( &$this, 'load_front_end_scripts' ));
      add_action( 'wp_enqueue_scripts', array( &$this, 'load_front_end_styles' ));
      add_shortcode( 'tabslide', array( &$this, 'clear_shortcode_handler' ) );
		} else {
			add_shortcode( 'tabslide', array( &$this, 'clear_shortcode_handler' ) );
		}
	}
  /**
  * Test the include/exclude arrays from the advanced section to determine whether tab slide is loaded 
  */
	public function check_through_arrays() {
		$show_instance = false;		
		$current_page_id = get_the_ID();

		$exclude_array = $this->plugin_options['exclude_list'] == "" ? -1 : array_map('trim',explode(",", $this->plugin_options['exclude_list']));
		$include_array = $this->plugin_options['include_list'] == "" ? -1 : array_map('trim',explode(",", $this->plugin_options['include_list']));
		$disabled_pages_array = $this->plugin_options['disabled_pages'] == "" ? -1 : array_map('trim',explode(",", $this->plugin_options['disabled_pages']));

		if($this->plugin_options['list_pick'] == 'exclude' && !in_array( $GLOBALS['pagenow'], $disabled_pages_array )) {
			$show_instance = !in_array($current_page_id, $exclude_array);
		} else if($this->plugin_options['list_pick'] == 'include' && !in_array( $GLOBALS['pagenow'], $disabled_pages_array )){
			$show_instance =  in_array($current_page_id, $include_array);
		} else if ($this->plugin_options['list_pick'] == 'all'  && !in_array( $GLOBALS['pagenow'], $disabled_pages_array ) ){
			$show_instance = true;
		} else if ($this->plugin_options['list_pick'] == 'shortcode'){
			$show_instance = true;
		}
		return $show_instance;
	}
  /**
  * Append the generated tab slide include html to the content
  */
  public function append_html_from_template($content) {
	  	$html = $this->load_html_from_template();
	  	$content .= $html;
	    remove_filter( 'the_content', array(&$this, 'append_html_from_template'));
	    return $content;
	}
  /**
  * Generated tab slide include html based on the selected template
  */
	public function load_html_from_template() {
		do_action('tab_slide_widget_areas_active_instances', $this->plugin_options);
		$url = $this->plugin_options['window_url'];
		if (substr($url, 0, 7) == 'http://') {
			$url = substr($url, strlen(get_site_url()));
		} else {
			$template_extract = explode('tab-slide', $url);
			$template = $template_extract[1];
			$url = TAB_SLIDE_ROOT . $template;
		}
		$url = apply_filters('tab_slide_url', $url, $this->plugin_options);
		$instance = $this->plugin_options;
		$html = "<div id='tab_slide_include' style='display: none'>";
		ob_start();
		include_once( $url );
		$html .= ob_get_clean();
		$html .= "</div>";
		$html = apply_filters('tab_slide_include_container_html', $html, $this->plugin_options);
		return $html;
	}
  /**
  * Shortcode handler function displays the generated html and loads the scripts and styles in the footer
  */
	public function shortcode_handler() {
		do_action('tab_slide_shortcode', $this->plugin_options);
		add_action( 'wp_footer', array( &$this, 'load_front_end_scripts' ));
	    add_action( 'wp_footer', array( &$this, 'load_front_end_styles' ));
		echo $this->load_html_from_template();
	}
  /**
  * Shortcode handler function displays nothing when check credentials or similar checks don't pass
  */
	public function clear_shortcode_handler(){
	}
    public function load_front_end_styles() {
	  	// CSS
		$myStyleUrl = TAB_SLIDE_URL . 'ts.css';
		wp_register_style('tab_slide_StyleSheet', $myStyleUrl);
		wp_enqueue_style( 'tab_slide_StyleSheet');
	}
	public function load_front_end_scripts() {
		//json
		$j_options = $this->plugin_options;
		$j_options['site_url'] = site_url();
		$json_str = json_encode($j_options);		
		$params = array(
			'j_options' => $json_str
		);
		
		wp_enqueue_script('jquery');	
		//JS TAB-SLIDE frontend
		wp_register_script('tab_slide_script', ( TAB_SLIDE_URL . 'js/tab_slide.js'), false); 
		wp_enqueue_script('tab_slide_script');
		wp_localize_script('tab_slide_script', 'j_options', $params);
		
		do_action('tab_slide_front_end_scripts', $params,'tab_slide_script', 'tab_slide_StyleSheet');
	}
} // END: class tab_slide

/**
 * Create new instance of the tab_slide object
 */
global $tab_slide;
$tab_slide = new Tab_Slide();

// Hook to perform action when plugin activated
register_activation_hook( TAB_SLIDE_FILE_PATH, array(&$tab_slide, 'activate_tab_slide'));

/**
 * tab_pro_loaded()
 * Allow dependent plugins and core actions to attach themselves in a safe way
 */
function tab_slide_loaded() {
	do_action( 'tab_slide_loaded' );
}
add_action( 'plugins_loaded', 'tab_slide_loaded', 10 );
