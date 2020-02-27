<?php
/**
 * HairsPressの管理設定
 * 管理画面などに関する設定を行う
 */
new HP_Admin;

class HP_Admin
{
	public function __construct()
	{
		$this->auto_update();

		// 権限変更
		add_action('admin_init', array($this, 'user_role'));

		$this->theme_color();

		add_action('admin_head', array($this, 'none_admin_css'));

		add_action('wp_terms_checklist_args', array($this, 'terms_checklist'));

		add_filter('template_include', array($this, 'custom_search_template'));
	}

	/**
	 * 自動更新機能の設定
	 */
	public function auto_update()
	{
		// add_filter('allow_major_auto_core_updates', '__return_true');
		add_filter('auto_update_plugin', '__return_true');
		add_filter('auto_update_theme', '__return_true');
		add_filter('auto_update_translation', '__return_true');
	}

	/**
	 * HairsPress専用の編集者権限を変更
	 *
	 * User Role List
	 * Super_Admin|Administrator|Editor|Author|Contributor|Subscriber
	 */
	public function user_role()
	{
		// 初期権限を削除（寄稿者・購読者）
		remove_role('author');
		remove_role('contributor');

		// 編集者権限を取得
		$role = get_role('editor');

		// 権限を追加
		$role->add_cap('edit_dashboard');
		$role->add_cap('edit_other_posts');
		$role->add_cap('edit_theme_options');
		$role->add_cap('update_themes');
		$role->add_cap('export');

		// 権限を削除
		$role->remove_cap('manage_options');
	}

	/**
	 * ダッシュボードの配色を変更
	 */
	public function theme_color()
	{
		remove_filter('admin_color_scheme_picker', 'admin_color_scheme_picker');
		add_filter('get_user_option_admin_color', function() {
			return 'coffee';
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
