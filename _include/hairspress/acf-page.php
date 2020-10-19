<?php

new HP_Acf_Page;

class HP_Acf_Page extends HP_Acf
{
	public function __construct()
	{
		self::setup();

		add_action('admin_enqueue_scripts', array($this, 'admin_enqueue_scripts'), 10);
	}

	public static function setup()
	{
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
		foreach ($pages['main'] as $k1 => $v1)
			parent::add_page($v1);

		// サブページ
		foreach ($pages['sub'] as $k2 => $v2)
			parent::add_sub_page($v2);
	}

	public function admin_enqueue_scripts()
	{
		wp_enqueue_script('hp-acf', get_theme_file_uri('assets/js/wp-acf.js'), array('jquery'), '1.0');
	}
}
