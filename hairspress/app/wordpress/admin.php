<?php

namespace Hairspress\App;

use Hairspress\Core\Asset;

class Wordpress_Admin {
	public function __construct() {
		// dummy
	}

	public function init() {
		add_action('admin_init', array($this, 'admin_init'));
	}

	// admin_init action
	public function admin_init() {
		$this->wp_admin_css_color();
	}

	// 管理画面の配色追加
	public function wp_admin_css_color() {
		wp_admin_css_color(
			'hairspress_01',
			__('HairsPress 01'),
			Asset::get_file_uri('admin-colors.css', 'css'),
			array('#3C4242', '#3C4242', '#3488C9', '#BCCFEB')
		);
	}
}