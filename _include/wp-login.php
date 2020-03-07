<?php
/*
 * リラclubログイン class
 */

new WP_Mio_Login;

class WP_Mio_Login
{
	public $cap = 'manage_options';

	/*
	 * __construct
	 */
	public function __construct()
	{
		add_action('init', array($this, 'login'));
		add_filter('login_redirect', array($this, 'login_redirect'), 10, 3);
		add_action('auth_redirect', array($this, 'auth_redirect'));
		add_filter('show_admin_bar', array($this, 'admin_bar'));
		add_action('login_enqueue_scripts', array($this, 'enqueue_scripts'));
		$this->login_header();
	}

	public function dir_uri()
	{
		return get_template_directory_uri();
	}

	/*
	 * ログインしていない場合は、ログイン画面へ強制的に遷移させる
	 */
	public function login()
	{
		if (
			 ! is_user_logged_in()
			and ! preg_match('/^(wp-login\.php|async-upload\.php|member)/', basename($_SERVER['REQUEST_URI']))
			and ! (defined('DOING_AJAX') and DOING_AJAX)
			and ! (defined('DOING_CRON') and DOING_CRON)
		)
		{
			wp_redirect( wp_login_url() );
			exit();
		}
	}

	/*
	 * 管理者以外でログイン後のリダイレクト先を変更する
	 */
	public function login_redirect($redirect_to, $request, $user)
	{
		if (isset($user->roles) and is_array($user->roles))
		{
			// 管理者以外はトップページへリダイレクト
			if ( ! in_array('administrator', $user->roles))
			{
				return home_url();
			}
		}

		return $redirect_to;
	}

	/*
	 * 管理者以外は管理画面に入れないようにする
	 */
	public function auth_redirect()
	{
		if ( ! current_user_can($this->cap))
		{
			wp_redirect(home_url());
			exit();
		}
	}

	/*
	 * 管理者以外は管理バーを非表示
	 */
	public function admin_bar($content)
	{
		return ( current_user_can($this->cap) ) ? $content : false;
	}

	/*
	 * ログイン画面のCSS・JSの読み込み
	 */
	public function enqueue_scripts()
	{
		wp_enqueue_style('lira-login', $this->dir_uri().'/assets/css/wp-login.css');
	}

	public function login_header()
	{
		// ロゴ部分のリンクURL
		add_filter('login_headerurl', function() {
			return home_url();
		});

		// ロゴヘッダーのタイトル
		add_filter('login_headertext', function() {
			return get_bloginfo('title');
		});

		add_action('login_head', function() {
			remove_action('login_head', 'wp_shake_js', 12);
		});
	}
}
