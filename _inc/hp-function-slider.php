<?php
function hp_get_slider() {
  get_template_part('template/temp-slider');
}
function hp_the_slider() {
  echo hp_get_slider();
}

add_action('wp_head', function() {
	$defaults = array(
		'mode' => 'fade',
		'speed' => 3500,
		'delay' => 5000,
	);

	$slider_setting = get_transient('slider_setting');

	if ($slider_setting === false) {
		$data = array();

		if ($mode = get_field('hp_slider_mode', 'option') and $mode) {
			$data['mode'] = $mode;
		}
		if ($speed = get_field('hp_slider_speed', 'option') and $speed) {
			$data['speed'] = (int) $speed;
		}
		if ($delay = get_field('hp_slider_pause', 'option') and $delay) {
			$data['delay'] = (int) $delay;
		}
		$data = wp_parse_args($data, $defaults);
		set_transient('slider_setting', $data, 3600);
	} else {
		$data = wp_parse_args($slider_setting, $defaults);
	}

	echo '<script>var sliderOptions = '.json_encode($data).'; window.sliderOptions = sliderOptions;</script>';
}, 10);
