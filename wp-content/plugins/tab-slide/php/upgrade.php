<?php
// Handles all current and future upgrades for tab_slide
function tab_slide_upgrade( $from ) {
	if ( !$from || version_compare( $from, '2.0.0', '<' ) ) tab_slide_upgrade_200();
}

// Upgrade to 2.0.0
function tab_slide_upgrade_200() {
	global $tab_slide;
	$tab_slide->update_plugin_option( 'version', '2.0.0' );
	delete_option( $tab_slide->get_plugin_option_fullname('include_method') );
}
