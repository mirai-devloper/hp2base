<?php

namespace Hairspress\App;

use Hairspress\Core\Asset;

class Wordpress_Admin {
	public function __construct() {
		// dummy
	}

	public function init() {
		add_action('admin_init', array($this, 'admin_init'));
		add_action('admin_head', array($this, 'none_admin_css'));
		$this->theme_color();
		add_filter('template_include', array($this, 'custom_search_template'));
		add_action('wp_terms_checklist_args', array($this, 'terms_checklist'));
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

	public function theme_color() {
		remove_filter('admin_color_scheme_picker', 'admin_color_scheme_picker');
		add_filter('get_user_option_admin_color', function() {
			// return 'coffee';
			return 'hairspress_01';
		});
	}

	/**
	 * ダッシュボード内の不必要な部分を非表示にする
	 */
	public function none_admin_css()
	{
		$class_name = array(
			'form-table' => array(
				'user-description-wrap',
				'user-url-wrap',
				'user-first-name-wrap',
				'user-last-name-wrap',
			)
		);

		$str = null;
		foreach ($class_name as $k => $v)
		{
			for ($i = 0; $i < count($v); $i++)
			{
				$str .= !empty($str) ? ','."\n" : '';
				$str .= '.'.$k.' .'.$v[$i];
			}
		}

		printf(
			'<style>%1$s%2$s</style>',
			$str.'{display: none;}',
			! current_user_can('manage_options') ? '#contextual-help-link-wrap {display:none;}' : ''
		);
	}

	/**
	 * 検索用テンプレートをカスタム投稿タイプで使えるようにする
	 */
	public function custom_search_template($template)
	{
		if (is_search())
		{
			$post_types = get_query_var('post_type');
			foreach ((array) $post_types as $type)
				$templates[] = 'search-'.$type.'.php';

			$templates[] = 'search.php';

			$template = get_query_template('search', $templates);
		}
		return $template;
	}

	// カテゴリーのチェック時の並び順を維持
	public function terms_checklist($args, $post_id = null)
	{
		$args['checked_ontop'] = false;
		return $args;
	}
}