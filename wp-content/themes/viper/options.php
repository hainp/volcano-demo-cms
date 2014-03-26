<?php
/**
 * A unique identifier is defined to store the options in the database and reference them from the theme.
 * By default it uses the theme name, in lowercase and without spaces, but this can be changed if needed.
 * If the identifier changes, it'll appear as if the options have been reset.
 * 
 */

function optionsframework_option_name() {
	// This gets the theme name from the stylesheet (lowercase and without spaces)
	$themename = 'viper';
	
	$optionsframework_settings = get_option('optionsframework');
	$optionsframework_settings['id'] = $themename;
	update_option('optionsframework', $optionsframework_settings);
}

/**
 * Defines an array of options that will be used to generate the settings page and be saved in the database.
 * When creating the "id" fields, make sure to use all lowercase and no spaces.
 *  
 */

function optionsframework_options() {
	
	// Test data
	$magpro_slider_start = array("false" => __("No", 'viper' ),"true" => __("Yes", 'viper' ));
	$homecat_array = array("hori" => __("Horizontal Layout", 'viper' ),"verti" => __("Vertical Layout", 'viper' ));
	
	// Pull all the categories into an array
	$options_categories = array();  
	$options_categories_obj = get_categories();
	foreach ($options_categories_obj as $category) {
    	$options_categories[$category->cat_ID] = $category->cat_name;
	}
	
	// Pull all the pages into an array
	$options_pages = array();  
	$options_pages_obj = get_pages('sort_column=post_parent,menu_order');
	$options_pages[''] = __("Select a page:", 'viper' );
	foreach ($options_pages_obj as $page) {
    	$options_pages[$page->ID] = $page->post_title;
	}
		
	// If using image radio buttons, define a directory path
	$imagepath =  get_template_directory_uri(). '/admin/images/';
		
	$options = array();
		
		
							
	$options[] = array( "name" => "country1",
						"type" => "innertabopen");	

		$options[] = array( "name" => __("Select a Skin", 'viper' ),
							"type" => "groupcontaineropen");	

				$options[] = array( "name" => __("Select a Skin", 'viper' ),
										"desc" => __("Please note that default and viper skins are same if you are using viper theme. If you are using a child theme then default skin will be child theme.", 'viper' ),
										"id" => "skin_style",
										"type" => "images",
										"std" => "default",
										"options" => array(
											'viper' => $imagepath . 'viper.png',
											'blue' => $imagepath . 'blue.png',
											'black' => $imagepath . 'black.png',
											'grngy' => $imagepath . 'grngy.png',
											'kopr' => $imagepath . 'kopr.png',
											'marn' => $imagepath . 'marn.png',
											'gree' => $imagepath . 'gree.png',
											'pink' => $imagepath . 'pink.png',
											'blbr' => $imagepath . 'blbr.png',
											'brwgrn' => $imagepath . 'brwgrn.png',
											'pnkr' => $imagepath . 'pnkr.png',
											'green' => $imagepath . 'green.png',
											'default' => $imagepath . 'default.png')
										);						

										
		$options[] = array( "type" => "groupcontainerclose");



		$options[] = array( "name" => __("Logo Settings", 'viper' ),
							"type" => "groupcontaineropen");	

				$options[] = array( "name" => __("Upload Logo", 'viper' ),
									"desc" => __("Upload your logo here. max width 450px, It will replace the blog title and description.", 'viper' ),
									"id" => "header_logo",
									"type" => "proupgrade");	
										
		$options[] = array( "type" => "groupcontainerclose");	
		

		$options[] = array( "name" => __("Adsense Settings", 'viper' ),
							"type" => "groupcontaineropen");	

					$options[] = array( "name" => __("Google Adsense ID", 'viper' ),
										"desc" => __("Enter your full adsense id. Ex : pub-1234567890", 'viper' ),
										"id" => "google_adsense_id",
										"std" => "",
										"type" => "proupgrade");		
										
		$options[] = array( "type" => "groupcontainerclose");	
		
		$options[] = array( "name" => __("Single Page Settings", 'viper' ),
							"type" => "groupcontaineropen");
							
					$options[] = array( "name" => __("Show Featured Image?", 'viper' ),
										"desc" => __("Select yes if you want to show featured image as header.", 'viper' ),
										"id" => "show_featured_image_single",
										"std" => "false",
										"type" => "select",
										"class" => "mini", //mini, tiny, small
										"options" => $magpro_slider_start);	
										
					$options[] = array( "name" => __("Show Ratings?", 'viper' ),
										"desc" => __("Select yes if you want to show ratings under post title.", 'viper' ),
										"id" => "show_rat_on_single",
										"std" => "true",
										"type" => "select",
										"class" => "mini", //mini, tiny, small
										"options" => $magpro_slider_start);										
										
					$options[] = array( "name" => __("Show Posted by and Date?", 'viper' ),
										"desc" => __("Select yes if you want to show Posted by and Date under post title.", 'viper' ),
										"id" => "show_pd_on_single",
										"std" => "true",
										"type" => "select",
										"class" => "mini", //mini, tiny, small
										"options" => $magpro_slider_start);											
										
					$options[] = array( "name" => __("Show Categories and Tags?", 'viper' ),
										"desc" => __("Select yes if you want to show categories under post title.", 'viper' ),
										"id" => "show_cats_on_single",
										"std" => "true",
										"type" => "select",
										"class" => "mini", //mini, tiny, small
										"options" => $magpro_slider_start);	
										
										
					$options[] = array( "name" => __("Show Social Share Buttons?", 'viper' ),
										"desc" => __("Select yes if you want to show social buttons under post title.", 'viper' ),
										"id" => "show_socialbuts_on_single",
										"std" => "true",
										"type" => "proupgrade",
										"options" => $magpro_slider_start);																	

					$options[] = array( "name" => __("Show Author Bio", 'viper' ),
										"desc" => __("Select yes if you want to show Author Bio Box on single post page.", 'viper' ),
										"id" => "show_author_bio",
										"std" => "true",
										"type" => "select",
										"class" => "mini", //mini, tiny, small
										"options" => $magpro_slider_start);	
										
					$options[] = array( "name" => __("Show RSS Box", 'viper' ),
										"desc" => __("Select yes if you want to show RSS box on single post page.", 'viper' ),
										"id" => "show_rss_box",
										"std" => "true",
										"type" => "select",
										"class" => "mini", //mini, tiny, small
										"options" => $magpro_slider_start);			
										
					$options[] = array( "name" => __("Show Next/Previous Box", 'viper' ),
										"desc" => __("Select yes if you want to show Next/Previous box on single post page.", 'viper' ),
										"id" => "show_np_box",
										"std" => "true",
										"type" => "select",
										"class" => "mini", //mini, tiny, small
										"options" => $magpro_slider_start);	
										
					$options[] = array( "name" => __("Show Related Posts Box", 'viper' ),
										"desc" => __("Select yes if you want to show Next/Previous box on single post page.", 'viper' ),
										"id" => "show_related_box",
										"std" => "true",
										"type" => "proupgrade",
										"options" => $magpro_slider_start);																																								
										
		$options[] = array( "type" => "groupcontainerclose");	
		

	$options[] = array( "type" => "innertabclose");	


	$options[] = array( "name" => "country2",
						"type" => "innertabopen");	
						
		$options[] = array( "name" => __("Social Settings", 'viper' ),
							"type" => "groupcontaineropen");	

					$options[] = array( "name" => __("Twitter", 'viper' ),
										"desc" => __("Enter your twitter id. Do not enter the twitter url, Enter only the id.", 'viper' ),
										"id" => "twitter_id",
										"std" => "",
										"type" => "text");

					$options[] = array( "name" => __("Redditt", 'viper' ),
										"desc" => __("Enter your reddit url", 'viper' ),
										"id" => "redit_id",
										"std" => "",
										"type" => "text");

					$options[] = array( "name" => __("Delicious", 'viper' ),
										"desc" => __("Enter your delicious url", 'viper' ),
										"id" => "delicious_id",
										"std" => "",
										"type" => "text");

					$options[] = array( "name" => __("Technorati", 'viper' ),
										"desc" => __("Enter your technorati url", 'viper' ),
										"id" => "technorati_id",
										"std" => "",
										"type" => "text");

					$options[] = array( "name" => __("Facebook", 'viper' ),
										"desc" => __("Enter your facebook url", 'viper' ),
										"id" => "facebook_id",
										"std" => "",
										"type" => "text");

					$options[] = array( "name" => __("Stumble", 'viper' ),
										"desc" => __("Enter your stumbleupon url", 'viper' ),
										"id" => "stumble_id",
										"std" => "",
										"type" => "text");

					$options[] = array( "name" => __("Youtube", 'viper' ),
										"desc" => __("Enter your youtube url", 'viper' ),
										"id" => "youtube_id",
										"std" => "",
										"type" => "text");

					$options[] = array( "name" => __("Flickr", 'viper' ),
										"desc" => __("Enter your flickr url", 'viper' ),
										"id" => "flickr_id",
										"std" => "",
										"type" => "text");

					$options[] = array( "name" => __("LinkedIn", 'viper' ),
										"desc" => __("Enter your linkedin url", 'viper' ),
										"id" => "linkedin_id",
										"std" => "",
										"type" => "text");

					$options[] = array( "name" => __("Google", 'viper' ),
										"desc" => __("Enter your google url", 'viper' ),
										"id" => "google_id",
										"std" => "",
										"type" => "text");

							
		$options[] = array( "type" => "groupcontainerclose");											
														
	$options[] = array( "type" => "innertabclose");
	
	
	$options[] = array( "name" => "country3",
						"type" => "innertabopen");	

		$options[] = array( "name" => __("Slider Settings", 'viper' ),
							"type" => "groupcontaineropen");	

					$options[] = array( "name" => __("Select Category", 'viper' ),
										"desc" => __("Posts from this category will be shown in the slider.", 'viper' ),
										"id" => "magpro_slidercat",
										"std" => "true",
										"type" => "select",
										"options" => $options_categories);
					
					$options[] = array( "name" => __("Show slider on homepage", 'viper' ),
										"desc" => __("Select yes if you want to show slider on homepage.", 'viper' ),
										"id" => "show_magpro_slider_home",
										"std" => "true",
										"type" => "select",
										"class" => "mini", //mini, tiny, small
										"options" => $magpro_slider_start);
										
					$options[] = array( "name" => __("Show slider on Single post page", 'viper' ),
										"desc" => __("Select yes if you want to show slider on Single post page.", 'viper' ),
										"id" => "show_magpro_slider_single",
										"std" => "false",
										"type" => "select",
										"class" => "mini", //mini, tiny, small
										"options" => $magpro_slider_start);	
										
					$options[] = array( "name" => __("Show slider on Pages", 'viper' ),
										"desc" => __("Select yes if you want to show slider on Pages.", 'viper' ),
										"id" => "show_magpro_slider_page",
										"std" => "false",
										"type" => "select",
										"class" => "mini", //mini, tiny, small
										"options" => $magpro_slider_start);	
										
					$options[] = array( "name" => __("Show slider on Category Pages", 'viper' ),
										"desc" => __("Select yes if you want to show slider on Category Pages.", 'viper' ),
										"id" => "show_magpro_slider_archive",
										"std" => "false",
										"type" => "select",
										"class" => "mini", //mini, tiny, small
										"options" => $magpro_slider_start);																														
					
										
					$options[] = array( "name" => __("How many slides?", 'viper' ),
										"desc" => __("Enter a number. Ex: 5 or 7", 'viper' ),
										"id" => "magpro_slidernumposts",
										"std" => "5",
										"class" => "mini",
										"type" => "text");										

					$options[] = array( "name" => __("Select slider or header", 'viper' ),
										"desc" => __("Select wilto if you want to use slider else select custom header.", 'viper' ),
										"id" => "show_magpro_slider_typey",
										"std" => "cheader",
										"type" => "images",
										"options" => array(
											'wilto' => $imagepath . 'wilto.png',																							
											'cheader' => $imagepath . 'cheader.png')
										);


										
		$options[] = array( "type" => "groupcontainerclose");	
		
		$options[] = array( "name" => __("Sliders Available in PRO Version", 'viper' ),
							"type" => "groupcontaineropen");	

					$options[] = array( "name" => __("Upgrade now for these Sliders", 'viper' ),
										"desc" => __("Available in PRO", 'viper' ),
										"id" => "magpro_slider_upgrade",
										"std" => "anything",
										"type" => "proimages",
										"options" => array(
											'nivo' => $imagepath . 'nivo.png',
											'camera' => $imagepath . 'camera.png',
											'piecemaker' => $imagepath . 'piecemaker.png',
											'accordian' => $imagepath . 'accordian.png',
											'boutique' => $imagepath . 'boutique.png',	
											'videoboutique' => $imagepath . 'boutiquevid.png',	
											'ken' => $imagepath . 'ken.png',
											'ruby' => $imagepath . 'ruby.png',	
											'wilto' => $imagepath . 'wilto.png',																							
											'wiltovideo' => $imagepath . 'wiltovid.png')
										);				

										
		$options[] = array( "type" => "groupcontainerclose");								
						
	$options[] = array( "type" => "innertabclose");	
	
								

	$options[] = array( "name" => "country4",
						"type" => "innertabopen");
						
		$options[] = array( "name" => __("Layout Settings", 'viper' ),
							"type" => "groupcontaineropen");	

					$options[] = array( "name" => __("Select a homepage layout", 'viper' ),
										"desc" => __("Images for layout.", 'viper' ),
										"id" => "homepage_layout",
										"std" => "magten",
										"type" => "images",
										"options" => array(
											'magten' => $imagepath . 'magten.png',
											'standard' => $imagepath . 'standard.png')
										);					

										
		$options[] = array( "type" => "groupcontainerclose");		
		
		$options[] = array( "name" => __("Layouts Available in PRO", 'viper' ),
							"type" => "groupcontaineropen");	

					$options[] = array( "name" => __("Upgrade now for these layouts.", 'viper' ),
										"desc" => __("UpGrade Now.", 'viper' ),
										"id" => "homepage_layout_upgrade",
										"std" => "",
										"type" => "proimages",
										"options" => array(
											'magpro' => $imagepath . 'magpro.png',
											'magvideo' => $imagepath . 'magvid.png',											
											'maglite' => $imagepath . 'maglite.png',
											'mag' => $imagepath . 'mag.png',
											'magthree' => $imagepath . 'magthree.png',
											'magfour' => $imagepath . 'magfour.png',
											'magfive' => $imagepath . 'magfive.png',
											'magsix' => $imagepath . 'magsix.png',
											'magseven' => $imagepath . 'magseven.png',
											'mageight' => $imagepath . 'mageight.png',
											'standard' => $imagepath . 'standard.png')
										);					

										
		$options[] = array( "type" => "groupcontainerclose");								
						
	$options[] = array( "type" => "innertabclose");	
	
	$options[] = array( "name" => "country6",
						"type" => "innertabopen");

		$options[] = array( "name" => __("MagPro Settings", 'viper' ),
							"type" => "tabheading");

	
		
		$options[] = array( "name" => __("Recent Posts", 'viper' ),
							"type" => "groupcontaineropen");	


					$options[] = array( "name" => __("How Many Recent Posts?", 'viper' ),
										"desc" => __("Enter a number like 7 or 10", 'viper' ),
										"id" => "magpro_recent_posts_num",
										"std" => "10",
										"type" => "proupgrade");
										
		$options[] = array( "type" => "groupcontainerclose");			
		
		$options[] = array( "name" => __("Video Settings", 'viper' ),
							"type" => "groupcontaineropen");	

					$options[] = array( "name" => __("Show Videos", 'viper' ),
										"desc" => __("Select yes if you want to show videos.", 'viper' ),
										"id" => "magpro_show_videos",
										"std" => "false",
										"type" => "proupgrade",
										"options" => $magpro_slider_start);

					$options[] = array( "name" => __("Select a Category", 'viper' ),
										"desc" => __("For posts in this category, You need to create a custom field called video and enter the url to video in its value field", 'viper' ),
										"id" => "magpro_show_videos_cat",
										"type" => "proupgrade",
										"options" => $options_categories);


					$options[] = array( "name" => __("How many Videos", 'viper' ),
										"desc" => __("How many Videos would you like to show.", 'viper' ),
										"id" => "magpro_show_videos_num",
										"std" => "3",
										"type" => "proupgrade");
										
		$options[] = array( "type" => "groupcontainerclose");	
		
		$options[] = array( "name" => __("Top Rated/Most Popular", 'viper' ),
							"type" => "groupcontaineropen");	

					$options[] = array( "name" => __("Show Top Rated/Most popular box ?", 'viper' ),
										"desc" => __("Select yes or no", 'viper' ),
										"id" => "magpro_show_mostbox",
										"std" => "false",
										"type" => "proupgrade",
										"options" => $magpro_slider_start);


					$options[] = array( "name" => __("How many Posts", 'viper' ),
										"desc" => __("How many posts would you like to show.", 'viper' ),
										"id" => "magpro_show_mostboxnum",
										"std" => "10",
										"type" => "proupgrade");
										
		$options[] = array( "type" => "groupcontainerclose");	
		
		$options[] = array( "name" => __("Gallery", 'viper' ),
							"type" => "groupcontaineropen");	

					$options[] = array( "name" => __("Show Gallery?", 'viper' ),
										"desc" => __("Select yes or no", 'viper' ),
										"id" => "magpro_show_gallery",
										"std" => "false",
										"type" => "proupgrade",
										"options" => $magpro_slider_start);

					$options[] = array( "name" => __("Which Gallery?", 'viper' ),
										"desc" => __("Enter the gallery ID", 'viper' ),
										"id" => "magpro_galid",
										"std" => "",
										"type" => "proupgrade");


					$options[] = array( "name" => __("How many Images?", 'viper' ),
										"desc" => __("Enter the number of images you would like to show", 'viper' ),
										"id" => "magpro_galnum",
										"std" => "10",
										"type" => "proupgrade");
										
		$options[] = array( "type" => "groupcontainerclose");	
		
		$options[] = array( "name" => __("Category Boxes", 'viper' ),
							"type" => "groupcontaineropen");	

					$options[] = array( "name" => __("Show Category Boxes", 'viper' ),
										"desc" => __("Select yes or no", 'viper' ),
										"id" => "magpro_show_catbox",
										"std" => "false",
										"type" => "proupgrade",
										"options" => $magpro_slider_start);

					$options[] = array( "name" => __("Which Layout", 'viper' ),
										"desc" => __("Select horizontal or vertical", 'viper' ),
										"id" => "magpro_show_catbox_which",
										"std" => "hori",
										"type" => "proupgrade",
										"options" => $homecat_array);


					$options[] = array( "name" => __("Which Categories?", 'viper' ),
										"desc" => __("Enter the category ID's seperated by comma. Ex : 1, 7, 20", 'viper' ),
										"id" => "magpro_catbox_id",
										"std" => "",
										"type" => "proupgrade");
										
					$options[] = array( "name" => __("How many posts per box?", 'viper' ),
										"desc" => __("Enter a number. Ex : 1, 7, 20", 'viper' ),
										"id" => "magpro_catbox_num",
										"std" => "7",
										"type" => "proupgrade");										
										
		$options[] = array( "type" => "groupcontainerclose");						
		
									
						
	$options[] = array( "type" => "innertabclose");		


	$options[] = array( "name" => "country12",
						"type" => "innertabopen");
		
		$options[] = array( "name" => __("Video Mag Settings", 'viper' ),
							"type" => "tabheading");
		
						
	
		
		$options[] = array( "name" => __("Recent Tab Settings", 'viper' ),
							"type" => "groupcontaineropen");	
										
					$options[] = array( "name" => __("Show Recent Videos Tab?", 'viper' ),
										"desc" => __("Select yes if you want to show Recent Videos tab in the homepage", 'viper' ),
										"id" => "video_mag_recent",
										"std" => "true",
										"type" => "proupgrade",
										"options" => $magpro_slider_start);	

					$options[] = array( "name" => __("How many posts?", 'viper' ),
										"desc" => __("Enter a number. Ex : 1, 7, 20", 'viper' ),
										"id" => "video_mag_recent_num",
										"std" => "7",
										"type" => "proupgrade");

					$options[] = array( "name" => __("Select the Layout Type", 'viper' ),
										"desc" => __("Images for layout.", 'viper' ),
										"id" => "video_mag_recent_layout",
										"std" => "vidrecentone",
										"type" => "proupgrade",
										"options" => array(
											'vidrecentone' => $imagepath . 'vidone.png',
											'vidrecenttwo' => $imagepath . 'vidtwo.png',
											'vidrecentthree' => $imagepath . 'vidthree.png',
											'vidrecentfour' => $imagepath . 'vidfour.png')
										);																								
										
		$options[] = array( "type" => "groupcontainerclose");	
		
		$options[] = array( "name" => __("Top Rated Settings", 'viper' ),
							"type" => "groupcontaineropen");	
										
					$options[] = array( "name" => __("Show Top Rated Videos Tab?", 'viper' ),
										"desc" => __("Select yes if you want to show Top Rated Videos tab in the homepage", 'viper' ),
										"id" => "video_mag_toprated",
										"std" => "true",
										"type" => "proupgrade",
										"options" => $magpro_slider_start);	

					$options[] = array( "name" => __("How many posts?", 'viper' ),
										"desc" => __("Enter a number. Ex : 1, 7, 20", 'viper' ),
										"id" => "video_mag_toprated_num",
										"std" => "7",
										"type" => "proupgrade");

					$options[] = array( "name" => __("Select the Layout Type", 'viper' ),
										"desc" => __("Images for layout.", 'viper' ),
										"id" => "video_mag_toprated_layout",
										"std" => "vidtopratedone",
										"type" => "proupgrade",
										"options" => array(
											'vidtopratedone' => $imagepath . 'vidone.png',
											'vidtopratedtwo' => $imagepath . 'vidtwo.png',
											'vidtopratedthree' => $imagepath . 'vidthree.png',
											'vidtopratedfour' => $imagepath . 'vidfour.png')
										);																								
										
		$options[] = array( "type" => "groupcontainerclose");		
		
		$options[] = array( "name" => __("Most Popular Settings", 'viper' ),
							"type" => "groupcontaineropen");	
										
					$options[] = array( "name" => __("Show Top Rated Videos Tab?", 'viper' ),
										"desc" => __("Select yes if you want to show Top Rated Videos tab in the homepage", 'viper' ),
										"id" => "video_mag_most",
										"std" => "true",
										"type" => "proupgrade",
										"options" => $magpro_slider_start);	

					$options[] = array( "name" => __("How many posts?", 'viper' ),
										"desc" => __("Enter a number. Ex : 1, 7, 20", 'viper' ),
										"id" => "video_mag_most_num",
										"std" => "7",
										"type" => "proupgrade");

					$options[] = array( "name" => __("Select the Layout Type", 'viper' ),
										"desc" => __("Images for layout.", 'viper' ),
										"id" => "video_mag_most_layout",
										"std" => "vidmostone",
										"type" => "proupgrade",
										"options" => array(
											'vidmostone' => $imagepath . 'vidone.png',
											'vidmosttwo' => $imagepath . 'vidtwo.png',
											'vidmostthree' => $imagepath . 'vidthree.png',
											'vidmostfour' => $imagepath . 'vidfour.png')
										);																							
										
		$options[] = array( "type" => "groupcontainerclose");			
		
		$options[] = array( "name" => __("Favourite Tab Settings", 'viper' ),
							"type" => "groupcontaineropen");	
										
					$options[] = array( "name" => __("Show Favourite Videos Tab?", 'viper' ),
										"desc" => __("Select yes if you want to show Favourite Videos tab in the homepage", 'viper' ),
										"id" => "video_mag_fav",
										"std" => "true",
										"type" => "proupgrade",
										"options" => $magpro_slider_start);	
										
					$options[] = array( "name" => __("Select Category", 'viper' ),
										"desc" => __("Posts from this category will be shown in the Favourites tab.", 'viper' ),
										"id" => "video_mag_fav_cat",
										"std" => "true",
										"type" => "proupgrade",
										"options" => $options_categories);

					$options[] = array( "name" => __("How many posts?", 'viper' ),
										"desc" => __("Enter a number. Ex : 1, 7, 20", 'viper' ),
										"id" => "video_mag_fav_num",
										"std" => "7",
										"type" => "proupgrade");

					$options[] = array( "name" => __("Select the Layout Type", 'viper' ),
										"desc" => __("Images for layout.", 'viper' ),
										"id" => "video_mag_fav_layout",
										"std" => "vidfavone",
										"type" => "proupgrade",
										"options" => array(
											'vidfavone' => $imagepath . 'vidone.png',
											'vidfavtwo' => $imagepath . 'vidtwo.png',
											'vidfavthree' => $imagepath . 'vidthree.png',
											'vidfavfour' => $imagepath . 'vidfour.png')
										);																					
										
		$options[] = array( "type" => "groupcontainerclose");		
									
		$options[] = array( "name" => __("Category Boxes", 'viper' ),
							"type" => "groupcontaineropen");	

					$options[] = array( "name" => __("Show Category Boxes", 'viper' ),
										"desc" => __("Select yes or no", 'viper' ),
										"id" => "video_mag_show_catbox",
										"std" => "false",
										"type" => "proupgrade",
										"options" => $magpro_slider_start);

					$options[] = array( "name" => __("Which Categories?", 'viper' ),
										"desc" => __("Enter the category ID's seperated by comma. Ex : 1, 7, 20", 'viper' ),
										"id" => "video_mag_catbox_id",
										"std" => "",
										"type" => "proupgrade");
										
					$options[] = array( "name" => __("How many posts per box?", 'viper' ),
										"desc" => __("Enter a number. Ex : 1, 7, 20", 'viper' ),
										"id" => "video_mag_catbox_num",
										"std" => "2",
										"type" => "proupgrade");										
										
		$options[] = array( "type" => "groupcontainerclose");		

						
	$options[] = array( "type" => "innertabclose");	
	
	$options[] = array( "name" => "country17",
						"type" => "innertabopen");
						
		$options[] = array( "name" => __("MagSeven Settings", 'viper' ),
							"type" => "tabheading");
		
		
		$options[] = array( "name" => __("Recent Posts Settings", 'viper' ),
							"type" => "groupcontaineropen");	

					$options[] = array( "name" => __("Show Ratings?", 'viper' ),
										"desc" => __("Select yes if you want to show ratings", 'viper' ),
										"id" => "show_ratings_magseven",
										"std" => "true",
										"type" => "proupgrade",
										"options" => $magpro_slider_start);	
										
					$options[] = array( "name" => __("Show Thumbnail?", 'viper' ),
										"desc" => __("Select yes if you want to show thumbnail in the post", 'viper' ),
										"id" => "show_postthumbnail_magseven",
										"std" => "true",
										"type" => "proupgrade",
										"options" => $magpro_slider_start);																			

										
		$options[] = array( "type" => "groupcontainerclose");	
		
		$options[] = array( "name" => __("Category Box Settings", 'viper' ),
							"type" => "groupcontaineropen");	

					$options[] = array( "name" => __("Show Ratings?", 'viper' ),
										"desc" => __("Select yes if you want to show ratings", 'viper' ),
										"id" => "show_ratings_magseven_cat",
										"std" => "true",
										"type" => "proupgrade",
										"options" => $magpro_slider_start);	
										
					$options[] = array( "name" => __("Which categories in left sidebar?", 'viper' ),
										"desc" => __("Enter the category ID's seperated by comma. Ex : 1, 7, 20", 'viper' ),
										"id" => "magseven_catbox_id",
										"std" => "",
										"type" => "proupgrade");	
										
					$options[] = array( "name" => __("How many Posts per Category?", 'viper' ),
										"desc" => __("Enter the number of posts per category you would like to show", 'viper' ),
										"id" => "magseven_catbox_num",
										"std" => "7",
										"type" => "proupgrade");																											

										
		$options[] = array( "type" => "groupcontainerclose");									
						
	$options[] = array( "type" => "innertabclose");	
	
	$options[] = array( "name" => "country20",
						"type" => "innertabopen");
						
		$options[] = array( "name" => __("MagTen Settings", 'viper' ),
							"type" => "tabheading");
		
		
		$options[] = array( "name" => __("Recent Posts Settings", 'viper' ),
							"type" => "groupcontaineropen");	

					$options[] = array( "name" => __("Show Ratings?", 'viper' ),
										"desc" => __("Select yes if you want to show ratings", 'viper' ),
										"id" => "show_ratings_magten",
										"std" => "false",
										"type" => "select",
										"class" => "mini", //mini, tiny, small
										"options" => $magpro_slider_start);	
										
		$options[] = array( "type" => "groupcontainerclose");	
						
	$options[] = array( "type" => "innertabclose");		
	
	$options[] = array( "name" => "country21",
						"type" => "innertabopen");
						
		$options[] = array( "name" => __("MagEleven Settings", 'viper' ),
							"type" => "tabheading");
		
		
		$options[] = array( "name" => __("Recent Posts Settings", 'viper' ),
							"type" => "groupcontaineropen");	

					$options[] = array( "name" => __("Show posted by and on?", 'viper' ),
										"desc" => __("Select yes if you want to show posted by and on", 'viper' ),
										"id" => "show_ratings_magten",
										"std" => "true",
										"type" => "proupgrade",
										"options" => $magpro_slider_start);	
										
		$options[] = array( "type" => "groupcontainerclose");	
		
		$options[] = array( "name" => __("Category Box Settings", 'viper' ),
							"type" => "groupcontaineropen");	

					$options[] = array( "name" => __("Select a category for 1st box.", 'viper' ),
										"desc" => __("Two posts from this category will show up in category box.", 'viper' ),
										"id" => "magelvn_cat_1",
										"std" => "Choose a category",
										"type" => "proupgrade",
										"options" => $options_categories);
										
					$options[] = array( "name" => __("Select a category for 2nd box.", 'viper' ),
										"desc" => __("Two posts from this category will show up in category box.", 'viper' ),
										"id" => "magelvn_cat_2",
										"std" => "Choose a category",
										"type" => "proupgrade",
										"options" => $options_categories);	
										
					$options[] = array( "name" => __("Select a category for 3rd box.", 'viper' ),
										"desc" => __("Two posts from this category will show up in category box.", 'viper' ),
										"id" => "magelvn_cat_3",
										"std" => "Choose a category",
										"type" => "proupgrade",
										"options" => $options_categories);																				
										
		$options[] = array( "type" => "groupcontainerclose");		
						
	$options[] = array( "type" => "innertabclose");		
	
	$options[] = array( "name" => "country9",
						"type" => "innertabopen");
						
		$options[] = array( "name" => __("Standard Blog Settings", 'viper' ),
							"type" => "groupcontaineropen");	

					$options[] = array( "name" => __("Show Ratings?", 'viper' ),
										"desc" => __("Select yes if you want to show ratings", 'viper' ),
										"id" => "show_ratings_standard",
										"std" => "true",
										"type" => "select",
										"class" => "mini", //mini, tiny, small
										"options" => $magpro_slider_start);		
										
					$options[] = array( "name" => __("Show Categories/Tags?", 'viper' ),
										"desc" => __("Select yes if you want to show categories and tags in posts", 'viper' ),
										"id" => "show_ctags_standard",
										"std" => "true",
										"type" => "select",
										"class" => "mini", //mini, tiny, small
										"options" => $magpro_slider_start);														

										
		$options[] = array( "type" => "groupcontainerclose");								
						
	$options[] = array( "type" => "innertabclose");	
	
	$options[] = array( "name" => "country5",
						"type" => "innertabopen");
						
		$options[] = array( "name" => __("Sidebar Settings", 'viper' ),
							"type" => "tabheading");
			
		
		$options[] = array( "name" => __("Sidebar Ad Settings", 'viper' ),
							"type" => "groupcontaineropen");	

					$options[] = array( "name" => __("Show 300x250 ads in sidebar?", 'viper' ),
										"desc" => __("Select yes if you want to show 300x250 ads in sidebar. If you select yes, go to widgets page and drag/drop the ads", 'viper' ),
										"id" => "show_sidebar_ads",
										"std" => "false",
										"type" => "select",
										"class" => "mini", //mini, tiny, small
										"options" => $magpro_slider_start);		
										
					$options[] = array( "name" => __("Show 125x125 ads in sidebar?", 'viper' ),
										"desc" => __("Select yes if you want to show 125x125 ads in sidebar. If you select yes, go to widgets page and drag/drop the ads", 'viper' ),
										"id" => "show_sidebar_ads_onetwofive",
										"std" => "false",
										"type" => "select",
										"class" => "mini", //mini, tiny, small
										"options" => $magpro_slider_start);											
										
		$options[] = array( "type" => "groupcontainerclose");	
		
		$options[] = array( "name" => __("Feedburner Settings", 'viper' ),
							"type" => "groupcontaineropen");	

					$options[] = array( "name" => __("Show feedburner?", 'viper' ),
										"desc" => __("Select yes if you want to show feedburner in sidebar.", 'viper' ),
										"id" => "show_feedburner",
										"std" => "true",
										"type" => "proupgrade",
										"options" => $magpro_slider_start);
										
					$options[] = array( "name" => __("Feedburner Id", 'viper' ),
										"desc" => __("Enter your feedburner id", 'viper' ),
										"id" => "feedburner_id",
										"std" => "",
										"type" => "proupgrade");																												
																				
		$options[] = array( "type" => "groupcontainerclose");
		
		$options[] = array( "name" => __("Social Settings", 'viper' ),
							"type" => "groupcontaineropen");	

										
					$options[] = array( "name" => __("Show Twitter Updates?", 'viper' ),
										"desc" => __("Select yes if you want to show twitter updates in sidebar.", 'viper' ),
										"id" => "show_twitter_updates",
										"std" => "true",
										"type" => "proupgrade",
										"options" => $magpro_slider_start);																												
																				
		$options[] = array( "type" => "groupcontainerclose");		
		
		$options[] = array( "name" => __("Video Settings", 'viper' ),
							"type" => "groupcontaineropen");	

					$options[] = array( "name" => __("Show Videos in sidebar?", 'viper' ),
										"desc" => __("Select yes if you want to show videos in sidebar.", 'viper' ),
										"id" => "sidebar_show_videos",
										"std" => "false",
										"type" => "proupgrade",
										"options" => $magpro_slider_start);

					$options[] = array( "name" => __("Select a Category", 'viper' ),
										"desc" => __("For posts in this category, You need to create a custom field called video and enter the url to video in its value field", 'viper' ),
										"id" => "sidebar_show_videos_cat",
										"type" => "proupgrade",
										"options" => $options_categories);


					$options[] = array( "name" => __("How many Videos", 'viper' ),
										"desc" => __("How many Videos would you like to show.", 'viper' ),
										"id" => "sidebar_show_videos_num",
										"std" => "3",
										"type" => "proupgrade");
										
		$options[] = array( "type" => "groupcontainerclose");	
		
		$options[] = array( "name" => __("Top Rated/Most Popular", 'viper' ),
							"type" => "groupcontaineropen");	

					$options[] = array( "name" => __("Show Top Rated/Most popular box in sidebar?", 'viper' ),
										"desc" => __("Select yes or no", 'viper' ),
										"id" => "sidebar_show_mostbox",
										"std" => "true",
										"type" => "proupgrade",
										"options" => $magpro_slider_start);

					$options[] = array( "name" => __("Select the Layout Type", 'viper' ),
										"desc" => __("Images for layout.", 'viper' ),
										"id" => "tabboxsidebarlayout",
										"std" => "tabbigthumb",
										"type" => "proupgrade",
										"options" => array(
											'tabbigthumb' => $imagepath . 'vidone.png',
											'tabsmallthumb' => $imagepath . 'vidfour.png')
										);	

					$options[] = array( "name" => __("How many posts", 'viper' ),
										"desc" => __("How many posts would you like to show.", 'viper' ),
										"id" => "sidebar_show_mostboxnum",
										"std" => "10",
										"type" => "proupgrade");
										
		$options[] = array( "type" => "groupcontainerclose");	
		
		$options[] = array( "name" => __("Polls", 'viper' ),
							"type" => "groupcontaineropen");	

					$options[] = array( "name" => __("Show Polls?", 'viper' ),
										"desc" => __("Select yes or no", 'viper' ),
										"id" => "sidebar_show_poll",
										"std" => "false",
										"type" => "proupgrade",
										"options" => $magpro_slider_start);


					$options[] = array( "name" => __("Which Poll?", 'viper' ),
										"desc" => __("Enter the poll ID", 'viper' ),
										"id" => "sidebar_show_poll_id",
										"std" => "",
										"type" => "proupgrade");
										
		$options[] = array( "type" => "groupcontainerclose");												
						
	$options[] = array( "type" => "innertabclose");		
	
	$options[] = array( "name" => "country10",
						"type" => "innertabopen");
						
		$options[] = array( "name" => __("AD Settings", 'viper' ),
							"type" => "tabheading");		
		
		$options[] = array( "name" => __("Header Ad Settings", 'viper' ),
							"type" => "groupcontaineropen");	

					
					$options[] = array( "name" => __("Show Adsense?", 'viper' ),
										"desc" => __("If yes, adsense will be show else enter html adcode below", 'viper' ),
										"id" => "show_header_adsense",
										"std" => "true",
										"type" => "proupgrade",
										"options" => $magpro_slider_start);		
										
					$options[] = array( "name" => __("Header Ad code", 'viper' ),
										"desc" => __("Enter the html ad code", 'viper' ),
										"id" => "header_ad_code",
										"type" => "proupgrade");														

										
		$options[] = array( "type" => "groupcontainerclose");								
						
	$options[] = array( "type" => "innertabclose");	
	
	$options[] = array( "name" => "country11",
						"type" => "innertabopen");
						
		$options[] = array( "name" => __("Footer Settings", 'viper' ),
							"type" => "tabheading");		
		
		$options[] = array( "name" => __("Footer Widgets", 'viper' ),
							"type" => "groupcontaineropen");	

					$options[] = array( "name" => __("Show footer widgets on homepage?", 'viper' ),
										"desc" => __("Select yes if you want to show footer widgets on homepage.", 'viper' ),
										"id" => "show_footer_widgets_home",
										"std" => "true",
										"type" => "proupgrade",
										"options" => $magpro_slider_start);
										
					$options[] = array( "name" => __("Show footer widgets on single post pages?", 'viper' ),
										"desc" => __("Select yes if you want to show footer widgets on single post pages.", 'viper' ),
										"id" => "show_footer_widgets_single",
										"std" => "true",
										"type" => "proupgrade",
										"options" => $magpro_slider_start);	
										
					$options[] = array( "name" => __("Show footer widgets on pages?", 'viper' ),
										"desc" => __("Select yes if you want to show footer widgets on pages.", 'viper' ),
										"id" => "show_footer_widgets_page",
										"std" => "true",
										"type" => "proupgrade",
										"options" => $magpro_slider_start);		
										
					$options[] = array( "name" => __("Show footer widgets on category pages?", 'viper' ),
										"desc" => __("Select yes if you want to show footer widgets on category pages.", 'viper' ),
										"id" => "show_footer_widgets_archive",
										"std" => "true",
										"type" => "proupgrade",
										"options" => $magpro_slider_start);																													
																				
		$options[] = array( "type" => "groupcontainerclose");
		
		$options[] = array( "name" => __("Footer Logo", 'viper' ),
							"type" => "groupcontaineropen");	

					$options[] = array( "name" => __("Show footer logo?", 'viper' ),
										"desc" => __("Select yes if you want to show logo in footer.", 'viper' ),
										"id" => "show_footer_logo",
										"std" => "true",
										"type" => "proupgrade",
										"options" => $magpro_slider_start);

				$options[] = array( "name" => __("Upload Logo", 'viper' ),
									"desc" => __("Upload your logo here. Max width 250px", 'viper' ),
									"id" => "footer_logo",
									"type" => "proupgrade");						

										
		$options[] = array( "type" => "groupcontainerclose");
		
		$options[] = array( "name" => __("Search Box", 'viper' ),
							"type" => "groupcontaineropen");	

					$options[] = array( "name" => __("Show search box in footer?", 'viper' ),
										"desc" => __("Select yes if you want to show search box in footer.", 'viper' ),
										"id" => "show_footer_search",
										"std" => "true",
										"type" => "proupgrade",
										"options" => $magpro_slider_start);						

										
		$options[] = array( "type" => "groupcontainerclose");												
						
	$options[] = array( "type" => "innertabclose");			
		
		
	return $options;
}