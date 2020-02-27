<?php
/**
 * 固定ページのセットアップ
 * 各固定ページが無かった場合は作成を行う。
 */

// new HP_Page_Setup;

class HP_Page_Setup
{
	private $page_arr = array();

	public function __construct()
	{
		$this->page_arr['front'] = array(
			'post_title'   => 'トップページ',
			'post_name'    => 'home',
			'post_status'  => 'publish',
			'post_type'    => 'page',
			'post_content' => '',
			'menu_order'   => 0,
		);

		$this->page_arr['blog'] = array(
			'post_title'   => 'ブログ',
			'post_name'    => 'blog',
			'post_status'  => 'publish',
			'post_type'    => 'page',
			'post_content' => '',
			'menu_order'   => 5
		);

		// 表示設定のフロントと投稿
		add_action('after_setup_theme', array($this, 'show_on_front'));

		// その他各固定ページを作成
		$this->page_arr['catalog'] = array(
			'post_title'   => 'ヘアカタログ一覧',
			'post_name'    => 'catalog',
			'post_status'  => 'publish',
			'post_type'    => 'page',
			'post_content' => '',
			'menu_order'   => 1
		);

		$this->page_arr['staff'] = array(
			'post_title'   => 'スタッフ一覧',
			'post_name'    => 'staff',
			'post_status'  => 'publish',
			'post_type'    => 'page',
			'post_content' => '',
			'menu_order'   => 2
		);

		$this->page_arr['menu'] = array(
			'post_title'   => 'メニュー',
			'post_name'    => 'menu',
			'post_status'  => 'publish',
			'post_type'    => 'page',
			'post_content' => '',
			'menu_order'   => 3
		);

		$this->page_arr['salon'] = array(
			'post_title'   => 'サロンについて',
			'post_name'    => 'salon',
			'post_status'  => 'publish',
			'post_type'    => 'page',
			'post_content' => '',
			'menu_order'   => 4
		);

		$this->page_arr['channel'] = array(
			'post_title'   => 'チャンネル',
			'post_name'    => 'channel',
			'post_status'  => 'publish',
			'post_type'    => 'page',
			'post_content' => '',
			'menu_order'   => 6
		);

		add_action('after_setup_theme', array($this, 'page'));
	}

	/**
	 * フロントページと投稿ページが無い場合、ページを作成し、表示設定を強制的に変更する
	 */
	public function show_on_front()
	{
		if (get_option('show_on_front') !== 'page')
		{
			update_option('show_on_front', 'page');
		}

		$home = get_page_by_path('home');
		$blog = get_page_by_path('blog');

		$page_on_front = (isset($home) and get_option('page_on_front') == 0) ? update_option('page_on_front', $home->ID) : null;
		$page_for_posts = (isset($blog) and get_option('page_for_posts') == 0) ? update_option('page_for_posts', $blog->ID) : null;

		$this->front_page();
		$this->page_blog();
	}

	/**
	 * フロントページの作成
	 */
	public function front_page()
	{
		if (is_null(get_page_by_path('home')))
		{
			$page_front = wp_insert_post($this->page_arr['front']);

			if ($page_front)
				update_option('page_on_front', $page_front);
		}
	}

	/**
	 * 投稿ページの作成
	 */
	public function page_blog()
	{
		if (is_null(get_page_by_path('blog')))
		{
			$page_blog = wp_insert_post($this->page_arr['blog']);

			if ($page_blog)
				update_option('page_for_posts', $page_blog);
		}
	}

	/**
	 * 各固定ページの生成
	 */
	public function page()
	{
		$page_catalog = is_null(get_page_by_path('catalog')) ? wp_insert_post($this->page_arr['catalog']) : null;

		$page_staff = is_null(get_page_by_path('staff')) ? wp_insert_post($this->page_arr['staff']) : null;

		$page_menu = is_null(get_page_by_path('price')) and is_null(get_page_by_path('menu')) ? wp_insert_post($this->page_arr['menu']) : null;

		$page_salon = is_null(get_page_by_path('access')) and is_null(get_page_by_path('salon')) ? wp_insert_post($this->page_arr['salon']) : null;

		$page_channel = is_null(get_page_by_path('channel')) ? wp_insert_post($this->page_arr['channel']) : null;

		return null;
	}
}
