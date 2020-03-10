<?php
namespace Hairspress\App;

// 移植途中
class Options_Topics {
	public function __construct() {
		// dummy
		add_action('admin_menu', array($this, 'admin_menu'));
		add_action('admin_init', array($this, ''));
	}

	public function admin_init() {

	}

	public function admin_menu() {
		add_submenu_page(
			'edit.php?post_type=topics',
			'お知らせの設定',
			'設定',
			'edit_posts',
			'topics_options',
			'topics_options'
		);
	}

	public function register_setting() {
		// ヘアーズプレスのテーマ切り替え
		add_settings_section(
			'options_hairspress_topics_id',
			'補足',
			'hairspress_topics_section',
			'topics_options'
		);

		// テーマ選択フィールド
		add_settings_field(
			'options_topics_name',
			'表示位置',
			'hairspress_topics_select_field',
			'topics_options',
			'options_hairspress_topics_id'
		);
		register_setting( 'hairspress_topics_group', 'options_topics_name');
	}
}