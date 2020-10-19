<?php

/*--- ロゴに関する関数 ---*/
function get_logo_id() {
	global $wphp;
	return $wphp->hp_salon_logo;
}
function get_logo($size = 'logo') {
	$img_id = get_logo_id();
	$attachment = wp_get_attachment_image_src($img_id, $size);
	return $attachment;
}
function the_logo($size = 'logo') {
	global $wphp;

	$attachment = wp_get_attachment_image($wphp->hp_salon_logo, $size);
	if($attachment) {
		echo $attachment;
	}
}


/*--- コンセプトに関する関数 ---*/
function get_concept() {
	global $wphp;
	return $wphp->hp_salon_concept;
}
function the_concept() {
	echo get_concept();
}

