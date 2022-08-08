<?php

class WP_Hairspress
{
	public $template;

	private $option_field_names = array(
		'hp_setting',
		'hp_search_console',
		'hp_google_analytics',
    'hp_ga4_id',
		'hpSlider',
		'hp_slider_mode',
		'hp_slider_speed',
		'hp_slider_pause',
		'free_space_hidden',
		'free_space',
		'hp_salon_logo',
		'hp_salon_name',
		'hp_salon_name_kana',
		'hp_salon_concept',
		'hp_webreserve_system',
		'hp_salon_reservia',
		'hp_salon_reserved',
		'hp_salon_telephone',
		'hp_salon_freedial',
		'hp_salon_freedial_region',
		'hairs_route_text',
		'hp_salon_postalcode',
		'hp_salon_address',
		'hp_salon_google_map_zoom',
		'hp_salon_google_map',
		'hp_salon_shop_photo',
		'hairs_mapimg_url',
		'hp_salon_holiday',
		'hairs_opens_text',
		'hairs_access_opens',
		'hp_salon_social_facebook',
		'hp_salon_social_instagram',
		'hp_salon_social_twitter',
		'hp_salon_social_line',
		'hp_salon_social_youtube',
		'hp_salon_social_googleplus',
		'hp_salon_social_pinterest',
		'hairspress_instagram_banner_use',
		'hairspress_instagram_banner_image',
		'menu_options',
	);

	private $option_names = array(
		'options_hp_theme_name',
		'options_topics_name',
		'hp_install_year',
	);

	public function __construct()
	{
		$this->template = new \stdClass;

		// Option field set.
		foreach ($this->option_field_names as $field) {
			$this->set_field($field);
		}

		foreach ($this->option_names as $name) {
			$this->set_option($name);
		}

	}

	public function init() {
		return $this->template;
	}

	public function set_field($field_name) {
		$this->template->$field_name = get_field($field_name, 'option');
	}

	public function set_option($option_name) {
		$this->template->$option_name = get_option($option_name);
	}

	public function set_post($field_name, $post_id = 0) {
		$this->template->$field_name = get_field($field_name, $post_id);
	}
}

global $wphp;
$wphp = get_transient('wp_hairspress_global_transient');

add_action('after_setup_theme', function() {
	global $wphp;
	// $wphp = get_transient('wp_hairspress_global_transient');
	if (!$wphp) {
		$wphp = new WP_Hairspress();
		set_transient('wp_hairspress_global_transient', $wphp->init(), 0);
	}
});

// add_action('update_option', function() {
// 	delete_transient('wp_hairspress_global_transient');
// });
add_action('updated_option', function() {
	global $wphp;

  delete_transient('wp_hairspress_global_transient');

	$wphp = new WP_Hairspress();
	set_transient('wp_hairspress_global_transient', $wphp->init(), 0);
});
