<?php
function hp_get_slider() {
  get_template_part('template/temp-slider');
}
function hp_the_slider() {
  echo hp_get_slider();
}

add_action('wp_head', function() {
	$mode = get_field('hp_slider_mode', 'option');
	$speed = get_field('hp_slider_speed', 'option');
	$delay = get_field('hp_slider_pause', 'option');

	$data = array(
		'mode' => empty($mode) ? 'fade' : strip_tags($mode),
		'speed' => (empty($speed) and is_numeric($speed)) ? 3500 : intval($speed),
		'delay' => (empty($delay) and is_numeric($delay)) ? 5000 : intval($delay),
	);
	echo '<script>var sliderOptions = '.json_encode($data).'; window.sliderOptions = sliderOptions;</script>';
}, 10);
