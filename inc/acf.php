<?php

// 設定権限がないユーザーにはACFを非表示にする
add_filter('acf/settings/show_admin', function($show) {
	if (current_user_can('manage_options')) {
		return true;
	}

	return $show;
});

add_filter('acf/settings/save_json', function($path) {
	$path = get_theme_file_path('acf-json');
	return $path;
});

add_filter('acf/settings/load_json', function($paths) {
	unset($paths[0]);
	$paths[] = get_theme_file_path('acf-json');

	return $paths;
});

add_filter('acf/fields/google_map/api', function($api) {
	// $api['key'] = 'AIzaSyC2PVeXoLpOd7_52W1NuOsPMSE_UqUpT6A';
	$api['key'] = 'AIzaSyASFdc_0QU2yCvIjXgW8zCj8i2nIG6yk_U';

	return $api;
});