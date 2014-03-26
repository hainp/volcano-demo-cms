<?php 
do_action('tab_slide_iframe_template'); 
$url   = $instance['iframe_url'];
$width = $instance['open_width'] . $instance['window_unit'];
?>
<iframe id="tab_slide_iframe" src="<?php echo $url; ?>" style="width:<?php echo $width; ?>;height:relative;"></iframe>
