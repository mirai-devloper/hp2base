<?php
namespace Hairspress\App;

class Wordpress_Login
{
	public static function init()
	{
		return new static();
	}

	public function __construct()
	{
		$this->init_user_roles();
		add_action('wp_login', function($user_login, $user) {
			if ($user->roles[0] === 'contributor' or $user->roles[0] === 'subscriber') {
				wp_redirect('/wp-admin/profile.php');
				exit;
			}
		}, 10, 2);
		add_action('admin_menu', array($this, 'admin_menus'));
		add_action('admin_bar_menu', array($this, 'adminbar'), 99);
		$this->login();
	}

	public function admin_menus() {
		global $menu, $submenu;
		remove_menu_page('edit-comments.php');

		if ($this->can()) {
			remove_menu_page('tools.php');
			remove_menu_page('edit.php?post_type=page');
			remove_menu_page('edit.php?post_type=mw-wp-form');

			$menu[70][0] = 'アカウント';
		}
	}

	public function init_user_roles() {
		global $wp_roles;

		if ( class_exists( 'WP_Roles' ) && ! isset( $wp_roles ) ) {
			$wp_roles = new \WP_Roles();
		}

		if ( is_object( $wp_roles ) ) {
			$wp_roles->add_cap( 'editor', 'manage_downloads' );
		}
	}

	public function adminbar($wp_admin_bar) {
		$wp_admin_bar->remove_menu('wp-logo');
		$wp_admin_bar->remove_menu('about');
		$wp_admin_bar->remove_menu('wporg');
		$wp_admin_bar->remove_menu('documentation');
		$wp_admin_bar->remove_menu('support-forums');
		$wp_admin_bar->remove_menu('feedback');
		$wp_admin_bar->remove_menu('themes');
		$wp_admin_bar->remove_menu('customize');
		$wp_admin_bar->remove_menu('comments');

		if ($this->can()) {
			$wp_admin_bar->remove_menu('search');
			$wp_admin_bar->remove_menu('new-page');
			$wp_admin_bar->remove_menu('new-user');
			$wp_admin_bar->remove_menu('new-content');
			$wp_admin_bar->remove_menu('updates');
			$wp_admin_bar->remove_menu('my-account');
			$wp_admin_bar->add_menu(array(
				'id' => 'my-logout',
				'title' => __('Log Out'),
				'href' => wp_logout_url(),
				'meta' => array(
					'class' => 'ab-top-secondary'
				)
			));
		}
	}

	public function can() {
		if (current_user_can('administrator') or current_user_can('editor')) {
			return false;
		}

		return true;
	}

	public function login() {
		add_action('login_enqueue_scripts', function() {
			wp_dequeue_style('login');
			wp_enqueue_style('dashicons');
			wp_enqueue_style('mylogin', get_theme_file_uri('assets/css/login.css'), array(), '1');
		});

		add_filter('login_title', function($text) {
			$newtext = 'ログイン - '. get_bloginfo('name');
			return $newtext;
		});
		add_filter('login_headerurl', function() {
			return home_url('/');
		});
		add_filter('login_headertext', function() {
			return '<img src="'.get_theme_file_uri('assets/images/logo_width.svg').'" alt="HairsPress">';
		});

		add_filter('login_message', function() {
			return '';
		});

		add_filter('login_footer', '__return_false');

		add_filter('login_errors', function($errors) {
			return '<strong>エラー</strong>：ユーザー名またはパスワードを正しく入力してください。';
		});
	}
}
