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

function menucontents_type_array() {
	$field = get_field('menu_contents_type');
	if ($field and is_array($field)) {
		$term_names = array();
		foreach ($field as $r) {
			$term = get_term($r, 'menu-contents_type');
			$term_names[] = $term->name;
		}
		return $term_names;
	}
}

function menucontents_type() {
	if ($field = menucontents_type_array()) {
		$output = '';
		foreach ($field as $v) {
			$output .= sprintf(
				'<span>%1$s</span>',
				$v
			);
		}
		return $output;
	}
}

function menucontents_type_single() {
	if ($field = menucontents_type_array()) {
		$output = '';
		foreach ($field as $v) {
			if (!empty($output)) {
				$output .= ', ';
			}
			$output .= $v;
		}
		return $output;
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