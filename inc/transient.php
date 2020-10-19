<?php
function hairspress_delete_transient($post_id, $post) {
	$post_type = get_post_type($post_id);
	switch ($post_type) {
		case 'post':
			delete_transient('hairspress_front_blog');
			break;
		case 'news':
			delete_transient('hairspress_front_news');
			break;
		case 'catalog':
			delete_transient('hairspress_front_catalog');
			// delete_transient('hairspress_staff_catalog');
			// delete_transient('hairspress_catalog_other');
			break;
		case 'staff':
			// delete_transient('hairspress_staff_other');
			// delete_transient('hairspress_catalog_staff');
			break;
		default:
			# code...
			break;
	}
}
add_action('save_post', 'hairspress_delete_transient', 10, 2);

add_action('acf/save_post', function() {
	$screen = get_current_screen();
	if (strpos($screen->id, 'theme-slider-settings') !== false) {
		$hpSlider = get_field('hpSlider', 'option');
		$getSlider = get_transient('hairspress_front_hpSlider');
		if ($getSlider !== $hpSlider) {
			delete_transient('hairspress_front_hpSlider');
		}
	}
}, 20);