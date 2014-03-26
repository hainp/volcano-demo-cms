<?php 
// Generate the Tab Slide settings page
if ( !class_exists('Tab_Slide_Settings') ) {	
	class Tab_Slide_Settings {
		public function __construct() {
			global $tab_slide;
			add_action('admin_notices', array(&$this, 'tab_slide_admin_notice'));
			add_action('admin_init',  array(&$this,'tab_slide_admin_notice_ignore'));
		}
		public function tab_slide_admin_notice() {
			if (isset($_GET['page']) && $_GET['page'] == 'tab-slide') {			
				global $current_user ;
				$user_id = $current_user->ID;
				if ( ! get_user_meta($user_id, 'tab_slide_admin_notice') ) {
					echo '<div class="updated"><p>';
					printf(__('Do you want multiple instances, premium support and more? Check out <a href="http://store.zoranc.co/downloads/tab-slide-pro/" class="button-primary" title="Tab Slide Pro" target="_blank">TAB SLIDE PRO</a> right now!<a href="%1$s" style="float:right;">Dismiss</a>'), "?page=tab-slide&tab_slide_admin_notice_ignore=1");
					echo "</p></div>";
				}
			}
		}
		public function tab_slide_admin_notice_ignore() {
			global $current_user;
			$user_id = $current_user->ID;
			if ( isset($_GET['tab_slide_admin_notice_ignore']) && '1' === $_GET['tab_slide_admin_notice_ignore'] ) {
				$time = time();
			  add_user_meta($user_id, 'tab_slide_admin_notice', $time, true);
			}
		}
		/**
		 * Generate the radio option html
		 *
		 * @params string $option, $class, $value
		 * @return html element
		 */
		function get_radio( $option, $class, $value ) {
			global $tab_slide;
			?><input type="radio" class="<?php echo $class;?>" name="<?php  echo $tab_slide->get_plugin_option_fullname($option) ?>" value="<?php echo $value ?>" <?php if($tab_slide->get_plugin_option($option) == $value) echo 'checked="yes"'; ?> />
		<?php
		}
		/**
		 * Generate the checkbox option html
		 *
		 * @params string $option, $class, $value, $checked
		 * @return html element
		 */
		function get_checkbox( $option, $class, $value ) {
			global $tab_slide;
			?>
			<input type="hidden" name="<?php  echo $tab_slide->get_plugin_option_fullname($option) ?>" value='0' />
			<input type="checkbox" class="<?php echo $class; ?>" name="<?php  echo $tab_slide->get_plugin_option_fullname($option) ?>" id="<?php echo $option ?>" value="<?php echo $value ?>" <?php checked($tab_slide->get_plugin_option($option)); ?>/>
		<?php
		}
		/**
		 * Generate the text input option html
		 *
		 * @params string $option, $class, $value, $checked
		 * @return html element
		 */
		function get_input( $option, $class, $max_length, $size, $type = false ) {
			global $tab_slide;
			$value = $tab_slide->get_plugin_option($option);
			if ($type) {
				settype($value, $type);
			}
			?><input class="<?php echo $class;?>" name="<?php echo $tab_slide->get_plugin_option_fullname($option) ?>" value="<?php echo $value ?>" id="<?php echo $option ?>" maxlength="<?php echo $max_length ?>" size="<?php echo $size ?>" />
		<?php
		}
		function tab_slide_ouput_string($string) {
		    $string = str_replace('&', '&amp;', $string);
		    $string = str_replace('"', '&quot;', $string);
		    $string = str_replace("'", '&#39;', $string);
		    $string = str_replace('<', '&lt;', $string);
		    $string = str_replace('>', '&gt;', $string);
		    return $string;
		} // end function tab_slide_output_string
		function directoryToArray($directory, $recursive) {
		    $array_items = array();
		    if ($handle = opendir($directory)) {
			while (false !== ($file = readdir($handle))) {
			    if ($file != "." && $file != "..") {
				if (is_dir($directory. "/" . $file)) {
				    if($recursive) {
				        $array_items = array_merge($array_items, directoryToArray($directory. "/" . $file, $recursive));
				    }
				    $file = $directory . "/" . $file;
				    $array_items[] = preg_replace("/\/\//si", "/", $file);
				} else {
				    $file = $directory . "/" . $file;
				    $array_items[] = preg_replace("/\/\//si", "/", $file);
				}
			    }
			}
			closedir($handle);
		    }
		    return $array_items;
		}
		function tab_slide_options_page() {
			global $tab_slide;
			?>
<div class="wrap">
				<a id="overlay" class="hidden" href="javascript:void(0);" title="Close"></a>
				<div class="tabslide-icon">
				</div>
				<h2>Tab Slide
				</h2>
				<div id="help">
					<a href="http://store.zoranc.co/downloads/tab-slide-pro/" class="button-primary" target="_blank">GO PRO</a>
					<a href="#" class="instance_menu_item" >Help</a>
					<a href="#" class="instance_menu_item about" >About</a>
				</div>
				<div class="subsubsub">
						<a class="general current" href="javascript:void(0)">General </a>
						<a href="javascript:void(0)" class="advanced">Advanced</a>
				</div>
				<?php $msg = null;
					if( array_key_exists( 'updated', $_GET ) && $_GET['updated']=='true' ) { 
						$msg = __('Settings Saved', 'tab_slide');
						$this->generate_instance_css();
					}
				?>
				<?php do_action('save_tab_slide_settings'); ?>
				<form action="options.php" method="post">
					<?php settings_fields( $tab_slide->options_group ); ?>
					<?php $this->get_form_content(); ?>
					<input type="hidden" name="<?php echo $tab_slide->get_plugin_option_fullname('version') ?>" value="<?php echo ($tab_slide->get_plugin_option('version')) ?>" />
					<input type="submit" class="button-primary" value="<?php _e('Save Changes', 'tab-slide') ?>" />
				</form>
			</div>
		<?php
		}
		/* 
		 * Adds Settings page for Tab Slide.
		 */
		function get_form_content() {
			global $tab_slide; ?>
			<div id="general">
				<table class="form-table">
				<tr valign="top">
					<th scope="row"><strong><?php _e('Startup Settings', 'tab-slide') ?></strong>
					</th>
					<td>
						<p>
							<label for="tab_slide_position">
								<?php _e('', 'tab-slide'); ?>
								<?php $this->get_radio('tab_slide_position', '', 'left' ); ?>Left
								<?php $this->get_radio('tab_slide_position', '', 'right'); ?>Right
							</label>
							<label for="show_on_load" class='newline'>
								<?php $this->get_checkbox('show_on_load', 'show_on_load', 1); ?>
								<?php _e('Start in open tab slide view', 'tab-slide') ?>
							</label> 
							<span class="description hidden"><?php _e('Determines whether the tab slide content is initially shown when the page is loaded.', 'tab-slide') ?></span>
						</p>
						<div id='timer'>
							<label for="enable_timer">
								<?php $this->get_checkbox ('enable_timer', 'enable_timer', 1); ?>
								<?php _e('Enable Autohide Timer', 'tab-slide') ?>
							</label>	
							<span id='autohide' class="<?php 
								$timer = $tab_slide->get_plugin_option('enable_timer');
								if ($timer == true) {echo 'shown';} else {echo 'hidden';}
								?>">		
								<label for="timer">
									<?php _e(':', 'tab-slide') ?>
								</label>
								<?php $this->get_input ( 'timer', '', '6', '5', 'float'); ?>seconds
							</span>
						</div>
						
					</td>
				</tr>

				<tr valign="top">
					<th scope="row"><strong><?php _e('Slide Content Settings', 'tab-slide') ?></strong>
					</th>
					<td>
						<p>
							<div class="css_only">
								<label for="borders">
									<?php _e('Use Borders:', 'tab-slide') ?>
								</label>
								<?php $this->get_radio ( 'borders' , 'no_borders', 0); ?>No
								<?php $this->get_radio ( 'borders' , 'yes_borders', 1); ?>Yes
								<span class="border_size">										
									<label for="border_size">
										<?php _e('-> Offset closed slide by:', 'tab-slide') ?>
									</label>
									<?php $this->get_input ( 'border_size', 'border_size', 4, 4, 'int'); ?>px
								</span>
							</div><div></div>
							<label for="open_width">
								<?php _e('Slide width:', 'tab-slide') ?>
							</label>
							<?php $this->get_input ( 'open_width', '', 5, 2); ?>
								
							<label for="open_height">
								<?php _e('Slide height:', 'tab-slide') ?>
							</label>
							<?php $this->get_input ( 'open_height', '', 5, 2); ?>
							
							<label for="window_unit">
								<?php $this->get_radio ( 'window_unit', '', 'px'); ?>px
								<?php $this->get_radio ( 'window_unit', '', '%'); ?>%
							</label> 
							<div class="peripheral">
								<label for="open_top">
									<?php _e('Vertical position from top:', 'tab-slide') ?>
								</label>
								<?php $this->get_input ( 'open_top', '', 5, 1, 'int'); ?>%
							</div>
							<span class="description hidden"><?php _e('The size and vertical positioning settings.<br /> Width and Height values can be dealt with either in percentages or pixels.', 'tab-slide') ?></span>
						</p>
						<p>
							<label for="template_pick">
								<?php _e('Template:', 'tab-slide') ?>
							</label>
							<input type=hidden name="<?php echo $tab_slide->get_plugin_option_fullname('template_pick') ?>"  value="<?php  echo $tab_slide->get_plugin_option('template_pick') ?>" id="template_pick" size="90">
								<select name="template_select" value="<?php  echo $tab_slide->get_plugin_option('template_pick') ?>" id='template_select'>	
									<option id='subscribe' value='Subscribe'>Subscribe</option>
									<option id='wplogin' value='WPLogin'>WPLogin</option>
									<option id='widget' value='Widget'>Widget</option>
									<option id='post' value='Post'>Post</option>
									<option id='iframe' value='iFrame'>iFrame</option>
									<option id='picture' value='Picture'>Picture</option>
									<option id='video' value='Video'>Video</option>
									<option id='custom' value='Custom'>Custom</option>
								</select>
							</input>

						</p>
						<div id="Widget">
							<span class="description hidden"><?php _e('Tab Slide Widget Area Enabled.', 'tab-slide') ?></span>
						</div>
						<div id="Post">
							<label for="post">
								<?php _e('Post ID: ', 'tab-slide') ?>
							</label>
							<?php $this->get_input ( 'post_id', '', '', 2); ?>
							<span class="description hidden"><?php _e('example: 2', 'tab-slide') ?></span>
						</div>
						<div id="iFrame">
							<label for="iframe_url">
								<?php _e('iFrame Url: ', 'tab-slide') ?>
							</label>
							<?php $this->get_input ( 'iframe_url', '', '', ''); ?>
							<span class="description hidden"><?php _e('example: http://www.google.com/', 'tab-slide') ?></span>
						</div>
						<div id="Picture">
							<label for="picture_url">
								<?php _e('Picture Url: ', 'tab-slide') ?>
							</label>
							<?php $this->get_input ( 'picture_url', '', '', ''); ?>
							<span class="description hidden"><?php _e('example: http://www.google.com/picture.jpg', 'tab-slide') ?></span>
						</div>
						<div id="Video">
							<label for="video_url">
								<?php _e('Video Url: ', 'tab-slide') ?>
							</label>
							<?php $this->get_input ( 'video_url', '', '', ''); ?>
							<span class="description hidden"><?php _e('example: http://www.youtube.com/v/9yl_XPkcTl4 <br/ >Note: Video URL format', 'tab-slide') ?></span>
						</div>
						<div id="Custom">
							<label for="window_url">
								<?php _e('Window Url Path:', 'tab-slide') ?>
							</label>
							<?php $this->get_input ( 'window_url', '', '', ''); ?>
							<div class="description"><?php _e('<b>IMPORTANT NOTE:</b> Place your custom templates in your child theme directry to avoid the custom templates from being overwritten on tab slide plugin updates', 'tab-slide') ?></div>
						</div>
					</td>
				</tr>
				<?php 
					$themes=$this->directoryToArray( TAB_SLIDE_ROOT . '/themes', false); 
				?>
				<tr valign="top" class="peripheral">
					<th scope="row"><strong><?php _e('Background Settings', 'tab-slide') ?></strong></th>
					<td>
						<p>
							<label for="background">
								<?php _e('Background (Path or Color):', 'tab-slide') ?>
							</label>
							<?php $this->get_input ( 'background', '', '', 58); ?>	
							<span class="description hidden"><?php _e('You can use the color picker or simply use the image location eg. http://www.yoursite.com/background.jpg', 'tab-slide') ?></span>
							<div id="bgcolorpicker"></div>
						</p>
						<p>
							<label for="opacity">
								<?php _e('Opacity:', 'tab-slide') ?>
							</label>
								
							<input type="range"  min="0" max="100" name="<?php echo $tab_slide->get_plugin_option_fullname('opacity') ?>" value="<?php  echo $tab_slide->get_plugin_option('opacity') ?>" id="opacity" maxlength="<?php if($tab_slide->get_plugin_option('window_unit') == '%') echo '3'; else echo '5'; ?>" size="2" />
							<span id="range"><?php  echo $tab_slide->get_plugin_option('opacity') ?></span>
							<span class="description hidden"><?php _e('The background opacity.<br />  Any value between 0 (transparent) and 100 (opaque)', 'tab-slide') ?></span>
						</p>
					</td>
				</tr>	
				
				<tr valign="top" class="peripheral">
					<th scope="row"><strong><?php _e('TAB Settings', 'tab-slide') ?></strong></th>
					<td>
						<p>
							<label for="tab_top">
								<?php _e('Position from top:', 'tab-slide') ?>
							</label>
							<?php $this->get_input( 'tab_top', '', 3, 2, 'int' ); ?>%
							<span class="description hidden"><?php _e('Vertical tab position relative to slide content height.<br /> Use any value between 0 (top of slide) and 100 (bottom of slide)', 'tab-slide') ?></span>
						</p>
						<p class="peripheral">
							<label for="tab_height">
								<?php _e('Vertical TAB Size:', 'tab-slide') ?>
							</label>
							<?php $this->get_input ( 'tab_height', '', '', 3, 'int'); ?>px
						</p>
						<p class="peripheral">
							<label for="tab_width">
								<?php _e('Horizontal TAB Size:', 'tab-slide') ?>
							</label>
							<?php $this->get_input ( 'tab_width', '', '', 3, 'int'); ?>px	
						</p>
					</td>
				</tr>
				<tr valign="top" class="peripheral">
					<th scope="row"><strong><?php _e('Font Settings', 'tab-slide') ?></strong></th>
					<td>
						<p>
							<label for="font_family">
								<?php _e('Font:', 'tab-slide') ?>
							</label>
							<?php $this->get_input ( 'font_family', '', '', 30); ?>
						</p>
						<p>
							<label for="font_size">
								<?php _e('Font Size:', 'tab-slide') ?>
							</label>
							<?php $this->get_input ( 'font_size', '', '', 5); ?>
						</p>
						<p>
							<label for="font_color">
								<?php _e('Font Color:', 'tab-slide') ?>
							</label>
							<?php $this->get_input ( 'font_color', '', '', 5); ?>
							<div id="fontcolorpicker"></div>
						</p>
					</td>
					</tr>
						
						
				<tr valign="top">
					<th scope="row"><strong><?php _e('Tab Slide Style', 'tab-slide') ?></strong></th>
					<td>		
						<p>
							<label for="cssonly">
								<?php _e('CSS Only Mode:', 'tab-slide') ?>
							</label>
							<?php $this->get_radio ( 'cssonly', 'cssonly', 1); ?>Yes
							<?php $this->get_radio ( 'cssonly', 'integratedcss', 0); ?>No
							<div id="edit_css" class="css_only">
								<textarea name="<?php echo $tab_slide->get_plugin_option_fullname('css') ?>" rows="10" cols="60" class="" id="edit_css_text"><?php echo $tab_slide->get_plugin_option('css') ?> </textarea>
							</div>
							<span class="description hidden"><?php _e('You can switch to css only mode and use cssonly.css to set up your tab slide.', 'tab-slide') ?></span>
							<span class="description hidden"><?php _e('Note: If in CSS only mode, make sure you fill out the remaining settings that you will be using in your css as they are necessary for calculations and such', 'tab-slide') ?></span>
						</p>
					</td>
				</tr>
				</table>
			</div>
			<div id="advanced">
				<table class="form-table">
				<tr valign="top">
					<th scope="row"><strong><?php _e('Visual Settings', 'tab-slide') ?></strong></th>
					<td>	
						<p>
							<label for="credentials">
								<?php _e('Show tabslide to:', 'tab-slide') ?>
									<div class='padding'>
									<?php $this->get_radio ( 'credentials', '', 'all'); ?>Everyone
									</div>
									<div class='padding'>
									<?php $this->get_radio ( 'credentials', '', 'auth'); ?>Only users that are logged in
									</div>
									<div class='padding'>
									<?php $this->get_radio ( 'credentials', '', 'unauth'); ?>Only visitors that are logged out
									</div>
							</label>
						</p>
						<p>
							<?php _e('Include tabslide on:', 'tab-slide' ) ?>
							<div class='padding'>
								<?php $this->get_radio ( 'list_pick', '', 'shortcode'); ?>
								<label for="shortcode">
									<?php _e('Use the <b>[tabslide]</b> shortcode.', 'tab-slide' ) ?>
								</label>
							</div>
							<div class='padding'>
								<?php $this->get_radio ( 'list_pick', '', 'all'); ?>		
								<label for="include_all">
									<?php _e( 'Include on all pages.', 'tab-slide' ) ?>
								</label>
							</div>
							<div class='padding'>
								<?php $this->get_radio ( 'list_pick', '', 'include'); ?>		
								<label for="include_list">
									<?php _e('Include only on page ID(s):', 'tab-slide') ?>
								</label>

								<?php $this->get_input ( 'include_list', '', '', ''); ?>		
							</div>
							<div class='padding'>
								<?php $this->get_radio ( 'list_pick', '', 'exclude'); ?>
								<label for="exclude_list">
									<?php _e('Exclude from page ID(s):', 'tab-slide') ?>
								</label>
								<?php $this->get_input ( 'exclude_list', '', '', ''); ?>	
								<span class="description hidden"><?php _e('example: 2, 3, 55', 'tab-slide') ?></span>
							</div>
							<div class='padding'>
							<label for="disable_pages">
								<?php _e('Disable pages:', 'tab-slide') ?>
							</label>
							<?php $this->get_input ( 'disabled_pages', '', '', ''); ?>	
							<span class="description hidden"><?php _e('example: template.php', 'tab-slide') ?></span>
							</div>
						</p>
						<p>
							<label for="animation_speed">
								<?php _e('Closing Speed:', 'tab-slide') ?>
							</label>
							<?php $this->get_input ( 'animation_speed', '', 6, 5, 'float'); ?>seconds
							<span class="description hidden"><?php _e('Set how long it takes for the tab to close.', 'tab-slide') ?>
						</p> 
					</td>
				</tr>	
				
				<tr valign="top">
					<th scope="row"><strong><?php _e('TAB Settings', 'tab-slide') ?></strong></th>
					<td>
						<p>
							<?php $this->get_radio ( 'tab_type', 'tab_image', 1); ?>
							<label for="tab_image">
								<?php _e('Tab Image', 'tab-slide') ?>
							</label>
						</p>
						<p class="tab_image_settings peripheral">
							<label for="tab_image">
								<?php _e('Image Path:', 'tab-slide') ?>
							</label>
							<?php $this->get_input ( 'tab_image', '', '', 20); ?>		
						</p>
						
						<p>
							<?php $this->get_radio ( 'tab_type', 'tab_title', 0); ?>
								<label for="tab_title_close">
									<?php _e('Tab Title', 'tab-slide') ?>
								</label>
								<div class='tab_title_settings'>
								<label for="tab_title_close">
									<?php _e('Closed View:', 'tab-slide') ?>
								</label>
								<?php $this->get_input ( 'tab_title_close', '', '', 5); ?>		
								<label for="tab_title_open">
									<?php _e('Opened View:', 'tab-slide') ?>
								</label>
								<?php $this->get_input ( 'tab_title_open', '', '', 5); ?>		
							</div>
						</p>
						<p class="tab_title_settings peripheral">
							<label for="tab_margin_open">
								<?php _e('OPEN Text Offset:', 'tab-slide') ?>
							</label>
							<?php $this->get_input ( 'tab_margin_open', '', '', 3, 'int'); ?>px
						</p>
						<p class="tab_title_settings peripheral">
							<label for="tab_margin_close">
								<?php _e('CLOSE Text Offset:', 'tab-slide') ?>
							</label>
							<?php $this->get_input ( 'tab_margin_close', '', '', 3, 'int'); ?>px	
						</p>
						<div class="tab_title_settings peripheral">
							<label for="tab_color">
								<?php _e('Color:', 'tab-slide') ?>
							</label>
							<?php $this->get_input ( 'tab_color', '', '', 8); ?>
							<span class="description hidden"><?php _e('Set the color of the tab as well as ALL the borders.', 'tab-slide') ?></span>
							<div id="tabcolorpicker"></div>
						</div>
						<p class="tab_title_settings peripheral">
							<label for="font_size">
								<?php _e('Tab Font Size:', 'tab-slide') ?>
							</label>
							<?php $this->get_input ( 'tab_font_size', '', '', 5); ?>
						</p>
					</td>
				</tr>									
				</table>
			</div>
			<div id="about" class="hidden">
			<div id="logo"></div>
			<a id="close_about" href="javascript:void(0);"></a>
			<div><h3>Thank you for using Tab Slide! </h3>
				<p><em>Please take a moment to <a class="button-secondary" href="http://wordpress.org/support/view/plugin-reviews/tab-slide?rate=5#postform" title="Rate" target="_blank">Rate</a>, Blog and spread the word to help support this plugin.</em></p>				
				<h5>Donate</h5>
				<pre><a href="https://blockchain.info/address/1HX5e9WPgi3RhsziV6Ja1a5b5AuUXYmSE4" title="Donate via bitCoin" target="_blank">Donate via bitCoin</a>
<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=ZYBTAH986982N" title="Donate via PayPal" target="_blank">Donate via PayPal</a></pre>
				<h5>Suggestions, Issues?</h5>
				<p>Check out the <a class="button-secondary" href='http://wordpress.org/tags/tab-slide' title="Tab Slide Forum" target="_blank">Tab Slide Forum</a> and post your questions there, as this way the rest of the WP community can benefit. </p>
				<h5>Do you want multiple instances? Premium Support?</h5>
				<center>Get <a href="http://store.zoranc.co/downloads/tab-slide-pro/" title="Purchase Tab Slide Pro" target="_blank" class="button-primary">TAB SLIDE PRO</a> right now!</center>
				
			</div>
	</div>
<div id="rate">
	<?php					
	  if (function_exists('get_transient')) {
		require_once( ABSPATH . 'wp-admin/includes/plugin-install.php' );
		// First, try to access the data, check the cache.
		if (false === ($api = get_transient('tab-slide'))) {
		  // The cache data doesn't exist or it's expired.
		  $api = plugins_api('plugin_information', array('slug' => stripslashes( 'tab-slide' ) ));
		  if ( !is_wp_error($api) ) {
			// cache isn't up to date, write this fresh information to it now to avoid the query for xx time.
			$myexpire = 60 * 15; // Cache data for 15 minutes
			set_transient('tab-slide', $api, $myexpire);
		  }
		}
		if ( !is_wp_error($api) ) {
		  $plugins_allowedtags = array('a' => array('href' => array(), 'title' => array(), 'target' => array()),
									   'abbr' => array('title' => array()), 'acronym' => array('title' => array()),
									   'code' => array(), 'pre' => array(), 'em' => array(), 'strong' => array(),
									   'div' => array(), 'p' => array(), 'ul' => array(), 'ol' => array(), 'li' => array(),
									   'h1' => array(), 'h2' => array(), 'h3' => array(), 'h4' => array(), 'h5' => array(), 'h6' => array(),
									   'img' => array('src' => array(), 'class' => array(), 'alt' => array()));
		  //Sanitize HTML
		  foreach ( (array)$api->sections as $section_name => $content )
			$api->sections[$section_name] = wp_kses($content, $plugins_allowedtags);
		  foreach ( array('version', 'author', 'requires', 'tested', 'homepage', 'last_updated', 'slug') as $key )
			$api->$key = wp_kses($api->$key, $plugins_allowedtags);
		  if ( ! empty($api->last_updated) ) {
			echo sprintf(__('Last updated: %s', 'tab-slide'),$api->last_updated);
			echo '.';
		  } ?>
	<?php if ( ! empty($api->rating) ) : ?>
	<div class="star-holder" title="<?php echo $this->tab_slide_ouput_string(sprintf(__('(Average rating based on %s ratings)', 'tab-slide'),number_format_i18n($api->num_ratings))); ?>">
	  <div class="star star-rating" style="width: <?php echo $this->tab_slide_ouput_string($api->rating) ?>px"></div>
	  <div class="star star5"></div>
	  <div class="star star4"></div>
	  <div class="star star3"></div>
	  <div class="star star2"></div>
	  <div class="star star1"></div><span></span>
	</div>
	<small><?php echo sprintf(__('(%s ratings)', 'tab-slide'),number_format_i18n($api->num_ratings)); ?></small>
	<?php endif;
		} // if ( !is_wp_error($api)
	  }// end if (function_exists('get_transient'
	?>
	<input type="button" class="button-secondary" value="Review Plugin" onClick="window.open('http://wordpress.org/support/view/plugin-reviews/tab-slide?rate=5#postform')" />
<div id="share">
					<a href="http://www.addthis.com/bookmark.php"
        class="addthis_button"
       addthis:url="http://wordpress.org/extend/plugins/tab-slide/" addthis:title="Tab Slide WordPress Plugin" addthis:description="An awesome sliding shelf wordpress plugin for your website."></a> 
				<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=xa-511334722499daaa"></script>
	</div>
</div>
			<?php
		}
	}
} 
