<?php

/*--- ロゴに関する関数 ---*/
function get_logo_id() {
	$attachment_id = function_exists('get_field') ? get_field('hp_salon_logo', 'option') : null;
	return $attachment_id;
}
function get_logo($size) {
	$img_id = get_logo_id();
	$img_size = !empty($size) ? $size : 'logo';
	$attachment = wp_get_attachment_image_src($img_id, $size);
	return $attachment;
}
function the_logo($sized = '') {
	$attachment = get_logo($sized);
	if( !empty($attachment) ) {
		echo '<img src="'.$attachment[0].'" width="'.$attachment[1].'" height="'.$attachment[2].'" alt="'.get_bloginfo('title').'">';
	}
}


/*--- コンセプトに関する関数 ---*/
function get_concept() {
	$concept = function_exists('get_field') ? get_field('hp_salon_concept', 'option') : null;
	return $concept;
}
function the_concept() {
	echo get_concept();
}

