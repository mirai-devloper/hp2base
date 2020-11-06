<?php

// Google Search Console
function google_search_console()
{
	global $wphp;
	if ($console = $wphp->hp_search_console and $console)
	{
		$allow_html = [
			'meta' => [
				'name' => [],
				'content' => [],
			],
		];
		return wp_kses($console, $allow_html).PHP_EOL;
	}

	return false;
}

// トラッキングコード
function ga_tracking_code()
{
	global $wphp;
	if (
		$tracking_code = $wphp->hp_google_analytics
		and ! is_user_logged_in()
	) {
		if (preg_match('/^[a-z|A-Z]+[-]+[0-9]+[-]+[0-9]{1,}$/', $tracking_code)) {
			return $tracking_code;
		}
	}

	return false;
}

function google_map_url($q = 'latlng') {
	global $wphp;

	$mapdata = $wphp->hp_salon_google_map;
	$query = array();

	if ($q !== 'latlng') {
		$query[] = $mapdata['address'];
	} else {
		$query[] = $mapdata['lat'];
		$query[] = $mapdata['lng'];
	}

	return 'https://maps.google.com/maps?q='.implode(',', $query);
}

function google_map_link($args = array()) {
	global $wphp;

	$mapdata = $wphp->hp_salon_google_map;

	$defaults = [
		'text' => '大きな地図で見る',
		'class' => '',
		'icon' => '',
	];

	$args = wp_parse_args($args, $defaults);
	$args = (object) $args;

	if ($mapdata) {
		return sprintf(
			'<a href="%1$s" target="_blank" class="%2$s" date-address="%3$s">%4$s%5$s</a>',
			google_map_url(),
			'mapApp'.$args->class,
			$mapdata['address'],
			$args->icon,
			$args->text
		);
	}

	return null;
}

add_action('wp_enqueue_scripts', function() {
	if (is_page_template('page-salon.php')) {
		wp_enqueue_script('google-map-api', '//maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&key=AIzaSyC2PVeXoLpOd7_52W1NuOsPMSE_UqUpT6A', array());
	}
});