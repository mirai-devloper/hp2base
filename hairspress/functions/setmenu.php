<?php

function setmenu_thumbnail( $thumb_name = 'medium', $thumb_style = null ) {
	$result = '<span class="not-thumb"></span>';

	if ( has_post_thumbnail() ) {
		$result = get_the_post_thumbnail( $thumb_name, $thumb_style );
	} else {
		$image = get_field('setmenu_images_0_image');
		if ( $image ) {
			$result = wp_get_attachment_image($image, $thumb_name, false, $thumb_style);
		}
	}

	return $result;
}