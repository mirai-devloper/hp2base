<?php
namespace Hairspress\App;

class Wordpress_Widget {
	public function __construct() {
		// dummy
	}

	public function init() {
		// カテゴリーウィジェットの再登録
		unregister_widget('WP_Widget_Categories');
		register_widget('Hairspress\\App\\Widget_Categories');

		// 最新の投稿ウィジェットの再登録
		unregister_widget('WP_Widget_Recent_Posts');
		register_widget('Hairspress\\App\\Widget_Recentposts');

		// アーカイブウィジェットの再登録
		unregister_widget('WP_Widget_Archives');
		register_widget('Hairspress\\App\\Widget_Archives');

		// 人気の記事ウィジェットの登録
		register_widget('Hairspress\\App\\Widget_Popularposts');

		unregister_widget('WP_Widget_Recent_Comments');
		unregister_widget('WP_Widget_Meta');
		unregister_widget('WP_Widget_RSS');
	}
}