<?php
namespace Hairspress\App;

class Wordpress_Initialize {
	public function __construct()
	{

		$this->do_feed();

		add_action('admin_init', array($this, 'wp_head'));
		add_action('admin_menu', array($this, 'remove_menu'), 999);
		add_action('admin_menu', array($this, 'remove_post_metaboxes'));
		add_action('admin_menu', array($this, 'admin_menu_name'));
		add_action('admin_bar_menu', array($this, 'remove_admin_bar'), 201);
		add_action('wp_dashboard_setup', array($this, 'remove_dashboard_widgets'));
		add_filter('manage_posts_columns', array($this, 'remove_post_columns'));
		add_filter('manage_pages_columns', array($this, 'remove_page_columns'));
		add_action('widgets_init', array($this, 'unregister_widgets'));

		add_filter('admin_footer_text', array($this, 'admin_footer_text'));

		add_action('pre_ping', array($this, 'self_pinback'));

		add_filter('nav_menu_css_class', array($this, 'remove_nav_class'), 100, 1);
		add_filter('nav_menu_item_id', array($this, 'remove_nav_class'), 100, 1);
		add_filter('page_css_class', array($this, 'remove_nav_class'), 100, 1);
	}

	public function wp_head()
	{
		// 初期出力のタグを削除
		remove_action('wp_head', 'wp_generator');
		remove_action('wp_head', 'rsd_link');
		remove_action('wp_head', 'feed_links', 2);
		remove_action('wp_head', 'feed_links_extra', 3);
		remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
		remove_action('wp_head', 'wlwmanifest_link');

		// WordPressへようこそ！を非表示にする
		remove_action( 'welcome_panel', 'wp_welcome_panel' );
	}

	/**
	 * ウィジェットの削除
	 */
	public function unregister_widgets()
	{
		unregister_widget('WP_Widget_RSS'); // RSS
		// unregister_widget('WP_Widget_Archives'); // アーカイブ
		// unregister_widget('WP_Widget_Nav_Menu'); // カスタムメニュー
		// unregister_widget('WP_Widget_Categories'); // カテゴリー
		unregister_widget('WP_Widget_Calendar'); // カレンダー
		// unregister_widget('WP_Widget_Tag_Cloud'); // タグクラウド
		// unregister_widget('WP_Widget_Text'); // テキスト
		unregister_widget('WP_Widget_Meta'); // メタ情報
		// unregister_widget('WP_Widget_Pages'); // 固定ページ
		unregister_widget('WP_Widget_Recent_Comments'); // 最近のコメント
		unregister_widget('WP_Widget_Recent_Posts'); // 最近の投稿
		unregister_widget('WP_Widget_Search'); // 検索
	}

	/**
	 * 管理画面のメニュー表示変更
	 */
	public function remove_menu()
	{
		// remove_menu_page('index.php'); // ダッシュボード
		// remove_submenu_page('index.php', 'index.php');
		// remove_submenu_page('index.php', 'update-core.php');
		// remove_menu_page('edit.php'); // 投稿
		// remove_submenu_page('edit.php', 'edit-tags.php?taxonomy=post_tag');
		// remove_menu_page('upload.php'); // メディア
		// remove_menu_page('link-manager.php'); // リンク
		// remove_menu_page('edit.php?post_type=page'); // 固定ページ
		remove_menu_page('edit-comments.php'); // コメント
		// remove_menu_page('customize.php?return=/wp-admin/themes.php'); // カスタマイズ

		// remove_menu_page('themes.php'); // 概観
		// remove_menu_page('plugins.php'); // プラグイン
		// remove_menu_page('users.php'); // ユーザー
		remove_menu_page('profile.php');
		// remove_menu_page('tools.php'); // ツール
		// remove_menu_page('options-general.php'); // 設定
		// remove_submenu_page('themes.php', 'customize.php?return=%2Fwp-admin%2Fthemes.php');

		if ( ! current_user_can('manage_options')) {
			global $submenu;
			remove_menu_page('edit.php?post_type=page');
			unset($submenu['themes.php'][5]);
			// unset($submenu['themes.php'][6]);
		}
	}

	/**
	 * 管理画面のナビバーの非表示
	 */
	public function remove_admin_bar($wp_admin_bar)
	{
		$menu = [
			'wp-logo', // WordPressロゴ
			// 'my-sites', // 参加サイト for マルチサイト
			// 'site-name', // サイト名
			// 'view-site', // サイト名 -> サイトを表示
			'updates', // 更新
			'comments', // コメント
			// 'new-content', // 新規
			// 'new-post', // 新規 -> 投稿
			'new-media', // 新規 -> メディア
			'new-link', // 新規 -> リンク
			'new-page', // 新規 -> 固定ページ
			'new-user', // 新規 -> ユーザー
			// 'my-account', // マイアカウント
			'user-info', // マイアカウント -> プロフィール
			'edit-profile', // マイアカウント -> プロフィール編集
			// 'logout', // マイアカウント -> ログアウト
			// 'search', // 検索
		];

		foreach ($menu as $v) {
			$wp_admin_bar->remove_menu($v);
		}
	}

	/**
	 * remove_meta_boxの管理画面内のウィジェット版
	 */
	public function remove_mbox($name, $array = array())
	{
		if ( ! isset($name) and ! array_key_exists($name, $array)) {
			return;
		}

		foreach ($array[$name] as $key => $board) {
			foreach ($board as $v) {
				remove_meta_box($v, $name, $key);
			}
		}
	}

	/**
	 * ダッシュボードの不用なウィジェットを削除
	 */
	public function remove_dashboard_widgets()
	{
		// var_dump($dashboard['normal']);
		$dashboards['dashboard'] = array(
			'normal' => array(
				'dashboard_right_now', // 現在の状況
				'dashboard_activity', // アクティビティ
				'dashboard_recent_comments', // 最近のコメント
				'dashboard_incoming_links', // 被リンク
				'dashboard_plugins', // プラグイン
			),
			'side' => array(
				'dashboard_quick_press', // クイック投稿
				'dashboard_recent_drafts', // 最近の下書き
				'dashboard_primary', // WordPressブログ
				'dashboard_secondary', // WordPressフォーラム
			),
		);

		$this->remove_mbox('dashboard', $dashboards);
	}

	/**
	 * 投稿画面の項目を削除
	 */
	public function remove_post_metaboxes()
	{
		$dashboards['post'] = array(
			'normal' => array(
				'postcustom', // カスタムフィールド
				// 'postexcerpt', // 抜粋
				'commentstatusdiv', // コメント設定
				'trackbacksdiv', // トラックバック設定
				// 'revisionsdiv', // リビジョン表示
				'formatdiv', // フォーマット設定
				// 'slugdiv', // スラッグ設定
				// 'authordiv', // 投稿者
				// 'categorydiv', // カテゴリー
				// 'tagsdiv-post_tag', // タグ
			),
		);

		$this->remove_mbox('post', $dashboards);
	}

	/**
	 * 投稿一覧画面の項目削除
	 */
	public function remove_post_columns($columns)
	{
		// unset($columns['cb']); // チェックボックス
		// unset($columns['title']); // タイトル
		// unset($columns['author']); // 作成者
		// unset($columns['categories']); // カテゴリー
		// unset($columns['tags']); // タグ、カスタムフィールド
		unset($columns['comments']); // コメント
		// unset($columns['date']); // 日付
		return $columns;
	}

	/**
	 * 固定ページ一覧の項目削除
	 */
	public function remove_page_columns($columns)
	{
		// unset($columns['cb']); // チェックボックス
		// unset($columns['title']); // タイトル
		unset($columns['author']); // 作成者
		unset($columns['comments']); // コメント
		// unset($columns['date']); // 日付
		return $columns;
	}

	// メニューの項目名を変更
	public function admin_menu_name()
	{
		global $menu, $submenu;
		$menu[5][0] = 'ブログ';
		$submenu['edit.php'][5][0] = '全ての投稿';
	}

	// フッター変更
	public function admin_footer_text()
	{
		$theme = wp_get_theme();
		return 'HairsPress '.$theme->get('Version');
	}

	/**
	 * フィードの配信を停止
	 */
	public function disable_feed()
	{
		wp_die('<h1>現在RSS配信は行っておりません。</h1><p><a href="'.esc_url(home_url()).'">トップページへ戻る</a></p>', 'HairsPress');
	}

	// フィード配信の停止アクション
	public function do_feed()
	{
		// RSS配信
		add_action('do_feed', array($this, 'disable_feed'), 1);
		add_action('do_feed_rdf', array($this, 'disable_feed'), 1);
		add_action('do_feed_rss', array($this, 'disable_feed'), 1);
		add_action('do_feed_rss2', array($this, 'disable_feed'), 1);
		add_action('do_feed_atom', array($this, 'disable_feed'), 1);
	}

	/**
	 * ピンバック禁止
	 */
	public function self_pinback(&$links)
	{
		foreach ($links as $k => $v) {
			if (strpos($v, home_url() === 0)) {
				unset($links[$k]);
			}
		}
	}

	/**
	 * カスタムメニューのクラスを消す
	 */
	public function remove_nav_class($var)
	{
		return is_array($var) ? array_intersect($var, array('current-menu-item')) : '';
	}
}