<?php
function hp_get_slider() {
  get_template_part('template-parts/front/slider');
}
function hp_the_slider() {
  echo hp_get_slider();
}

add_action('wp_head', function() {
	global $wphp;

	$defaults = array(
		'mode' => 'fade',
		'speed' => 3500,
		'delay' => 5000,
	);

	$data = array();

	if ($mode = $wphp->hp_slider_mode and $mode) {
		$data['mode'] = $mode;
	}
	if ($speed = $wphp->hp_slider_speed and $speed) {
		$data['speed'] = (int) $speed;
	}
	if ($delay = $wphp->hp_slider_pause and $delay) {
		$data['delay'] = (int) $delay;
	}
	$data = wp_parse_args($data, $defaults);

	echo '<script>var sliderOptions = '.json_encode($data).'; window.sliderOptions = sliderOptions;</script>';
}, 10);
