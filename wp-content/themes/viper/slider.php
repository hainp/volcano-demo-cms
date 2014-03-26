<?php
	if( of_get_option('show_magpro_slider_typey') == 'wilto' ){
		get_template_part( 'slider', 'wilto');
	}else{
		get_template_part( 'slider', 'cheader' );
	}
?>