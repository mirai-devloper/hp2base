<?php

function menucontents_thumbnail($thumb_name = 'medium', $thumb_style = null ) {
	$result = '<span class="not-thumb"></span>';

	if ( has_post_thumbnail() ) {
		$result = get_the_post_thumbnail(get_the_ID(), $thumb_name, $thumb_style );
	} else {
		$image = get_field('menu_contents_images_0_image');
		if ( $image ) {
			$result = wp_get_attachment_image($image, $thumb_name, false, $thumb_style);
		}
	}

	return $result;
}

function menucontents_type() {
	$field = get_field('menu_contents_type');

	if ($field) {
		$term = get_term($field, 'menu-contents_type');
		return "<span>{$term->name}</span>";
	}
}

function menucontents_category() {
	$field = get_field('menu_contents_category');

	if ($field) {
		$output = '';

		foreach ((array) $field as $k => $v) {
			$output .= $output != '' ? ', ' : '';
			$term = get_term($v, 'menu-contents_category');
			$output .= $term->name;
		}

		return $output;
	}
}