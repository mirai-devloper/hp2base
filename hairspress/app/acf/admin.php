<?php
namespace Hairspress\App;

class Acf_Admin {
	public function __construct()
	{
		$this->acf_add_options_page();
		// add_action('admin_enqueue_scripts', array($this, 'enqueue_script'), 10);
		add_filter('acf/fields/flexible_content/layout_title/name=free_space', array($this, 'banner_space_flexible_layout_title'), 10, 4);
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
			'toppage' => array(
				'page_title' => 'トップページ設定',
				'menu_title' => 'トップページ設定',
				'menu_slug' => 'hairspress-toppage-setting',
				'position' => 47,
				'capability' => 'edit_posts',
				'icon_url' => 'dashicons-index-card',
				'redirect' => false,
			),
			'salon' => [
				'page_title' => 'サロン設定',
				'menu_title' => 'サロン設定',
				'menu_slug'  => 'theme-salon-settings',
				'position'   => 48,
				'capability' => 'edit_posts',
				'icon_url'   => 'dashicons-index-card',
				'redirect'   => false,
			],
			// 'slider' => [
			// 	'page_title' => '画像を投稿',
			// 	'menu_title' => 'スライダー設定',
			// 	'menu_slug'  => 'theme-slider-settings',
			// 	'position'   => 46,
			// 	'capability' => 'edit_posts',
			// 	'icon_url'   => 'dashicons-images-alt2',
			// 	'redirect'   => false,
			// ],
			// 'freespace' => [
			// 	'page_title'  => 'バナースペースの設定',
			// 	'menu_title'  => 'バナースペース設定',
			// 	'menu_slug'   => 'theme-salon-freespace',
			// 	// 'parent_slug' => $pages['main']['salon']['menu_slug'],
			// 	'position'   => 49,
			// 	'capability'  => 'edit_posts',
			// 	'icon_url' => 'dashicons-admin-links',
			// 	'redirect' => false,
			// ],
		];

		$pages['sub'] = [
			'setting' => [
				'page_title'  => 'HairsPress設定',
				'menu_title'  => 'HairsPress設定',
				'menu_slug'   => 'options-hairspress-setting',
				'parent_slug' => 'themes.php',
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

	public function banner_space_flexible_layout_title($title, $field, $layout, $i) {
		$title = '';

		if ($image = get_sub_field('image')) {
			$title .= '<div class="thumbanil" style="display:inline-block;vertical-align:bottom;"><img src="'.wp_get_attachment_image_url( $image, 'thumbanil' ).'" width="60" alt=""></div>';
		}

		if ($text = get_sub_field('link_text')) {
			$title .= '<b>'.esc_html($text).'</b>';
		}

		return $title;
	}
}