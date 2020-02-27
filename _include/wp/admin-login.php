<?php
/**
 * ログイン画面絡み
 */

new HP_Admin_Login;

class HP_Admin_Login
{
	public function __construct()
	{
		$this->login_header();
		add_action('login_enqueue_scripts', array($this, 'enqueue_scripts'), 10);
	}

	public function dir_uri()
	{
		return get_template_directory_uri();
	}

	public function login_header()
	{
		// リンク変更
		add_filter('login_headerurl', function() {
			return home_url();
		});

		// タイトル変更
		add_filter('login_headertitle', function() {
			return 'HairsPress';
		});

		// シェイク削除
		add_action('login_head', function() {
			remove_action('login_head', 'wp_shake_js', 12);
		});

		// エラー文の変更
		add_filter('login_errors', function() {
			return sprintf(
				'<strong>エラー：%1$s</strong>',
				'ユーザー名またはパスワードが違います'
			);
		});
	}

	// CSS
	public function enqueue_scripts()
	{
		wp_enqueue_style('hp-login', $this->dir_uri().'/assets/css/wp-login.css');

		// wp_enqueue_script('jquery');
		wp_enqueue_script('hp-login', $this->dir_uri().'/assets/js/wp-login.js', array());
	}
}
