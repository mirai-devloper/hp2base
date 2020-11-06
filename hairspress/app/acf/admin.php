<?php
namespace Hairspress\App;

class Acf_Admin {
	public function __construct()
	{
		$this->acf_add_options_page();
		add_action('admin_enqueue_scripts', array($this, 'enqueue_script'), 10);
	}

	public function enqueue_script() {
		wp_enqueue_script(
			'hp-acf',
			get_theme_file_uri('assets/js/wp-acf.js'),
			array('jquery'),
			'1.0'
		);
	}

	public function acf_add_options_page() {
		$pages['main'] = [
			'salon' => [
				'page_title' => 'サロン情報',
				'menu_title' => 'サロン情報',
				'menu_slug'  => 'theme-salon-settings',
				'position'   => 48,
				'capability' => 'edit_posts',
				'icon_url'   => 'dashicons-index-card',
				'redirect'   => false,
			],
			'slider' => [
				'page_title' => '画像を投稿',
				'menu_title' => 'スライダー設定',
				'menu_slug'  => 'theme-slider-settings',
				'position'   => 46,
				'capability' => 'edit_posts',
				'icon_url'   => 'dashicons-images-alt2',
				'redirect'   => false,
			],
			'freespace' => [
				'page_title'  => 'バナースペースの設定',
				'menu_title'  => 'バナースペース設定',
				'menu_slug'   => 'theme-salon-freespace',
				// 'parent_slug' => $pages['main']['salon']['menu_slug'],
				'position'   => 47,
				'capability'  => 'edit_posts',
				'icon_url' => 'dashicons-admin-links',
				'redirect' => false,
			],
		];

		$pages['sub'] = [

			'google' => [
				'page_title'  => 'Google設定',
				'menu_title'  => 'Google設定',
				'menu_slug'   => 'options-google-code',
				'parent_slug' => 'options-general.php',
				'capability'  => 'manage_options',
			],
			'setting' => [
				'page_title'  => '管理設定',
				'menu_title'  => '管理者専用',
				'menu_slug'   => 'options-hairspress-setting',
				'parent_slug' => 'options-general.php',
				'capability'  => (is_multisite() ? 'manage_network' : 'manage_options'),
			],
		];

		// メインページ
		foreach ($pages['main'] as $k1 => $v1) {
			acf_add_options_page($v1);
		}

		// サブページ
		foreach ($pages['sub'] as $k2 => $v2) {
			acf_add_options_sub_page($v2);
		}
	}
}