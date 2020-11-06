<?php
namespace Hairspress\App;

class Wordpress_User {
	public function __construct() {
		// dummy
	}

	public function init() {
		add_action('admin_init', array($this, 'user_role'));
	}

	/**
	 * HairsPress専用の編集者権限を変更
	 *
	 * User Role List
	 * Super_Admin|Administrator|Editor|Author|Contributor|Subscriber
	 */
	public function user_role() {
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
}