<?php
/**
 * Slider
 *
 */
add_action('hairspress_slider', function() {
	if (is_front_page()) {
		return get_template_part('template-parts/front/slider');
	}
});

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
	$data_json = json_encode($data);

	echo <<< __EOT__
<script>
	var sliderOptions = JSON.parse('{$data_json}');
	window.sliderOptions = sliderOptions;
</script>
__EOT__;
}, 10);