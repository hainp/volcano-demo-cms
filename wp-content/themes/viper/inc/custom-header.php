<?php

  // Add Custom header feature  
function viper_custom_header_setup() {
	 
  $viper_customhargs = array(
	'default-image' => get_template_directory_uri() . '/skins/images/defaulth.jpg',
	'flex-width'    => true,
	'width'         => 1200,
	'flex-height'    => true,
	'height'        => 500,
	'header-text'   => false,
  );
  
  add_theme_support( 'custom-header', $viper_customhargs );
  
}
add_action( 'after_setup_theme', 'viper_custom_header_setup' );  
?>