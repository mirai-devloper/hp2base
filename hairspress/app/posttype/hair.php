<?php
namespace Hairspress\App;

class Posttype_Hair
{
	public function __construct()
	{
		add_action('init', array($this, 'register'));
		// add_action('init', array($this, 'add_rewrite_rule'));
		add_filter('post_type_link', array($this, 'permalink'), 10, 3);
		add_filter('post_link', array($this, 'permalink'), 10, 3);
		add_action( 'manage_hair_posts_columns' , array($this, 'columns'));
		add_action( 'manage_hair_posts_custom_column' , array($this, 'column'), 10, 2);
		add_filter('query_vars', array($this, 'query_vars'));
		add_action('pre_get_posts', array($this, 'pre_get_posts'));
	}

	public function query_vars($vars) {
		$vars[] = 'hair_stylist';
		$vars[] = 'hair_length';
		$vars[] = 'hair_imagetag';

		return $vars;
	}

	public function register()
	{
		register_post_type('catalog', array(
			'labels' => array(
				'name' => 'ヘアカタログ',
				'menu_name' => 'ヘアカタログ',
				'singular_name' => 'ヘアカタログ',
			),
			'public' => true,
			'has_archive' => true,
			'menu_position' => 8,
			'menu_icon' => 'dashicons-book',
			// 'capabilities' => array('edit_post'),
			'supports' => array(
				'title',
				// 'editor',
				'author',
				'thumbnail',
				// 'excerpt',
				'revisions',
			),
			'capability_type' => 'post',
			'hierarchical' => false,
			'taxonomies' => array('com_category', 'catalog_length'),
			'rewrite' => array(
				'slug' => 'catalog',
				'with_front' => false,
			),
		));

		register_taxonomy('catalog_tag', 'catalog', array(
			'labels' => array(
				'name' => 'イメージタグ',
				'menu_name' => 'イメージタグ',
				'singular_name' => 'イメージタグ:catalog_tag',
			),
			'hierarchical' => false,
			'show_ui' => true,
			'show_in_nav_menus' => false,
			'show_admin_column' => true,
			'query_var' => 'catalog_tag',
			'has_archive' => true,
			'rewrite' => array(
				'slug' => 'catalog/tag',
				'with_front' => false,
			),
		));
		register_taxonomy_for_object_type('catalog_tag', 'catalog');

		$show = current_user_can('manage_options');
		register_taxonomy('catalog_length', 'catalog', array(
			'labels' => array(
				'name' => 'LENGTH',
				'menu_name' => 'LENGTH',
				'singular_name' => 'LENGTH:catalog_length',
			),
			'hierarchical' => false,
			'show_ui' => $show,
			'show_in_nav_menus' => false,
			'query_var' => 'length',
			'has_archive' => true,
			'rewrite' => array(
				'slug' => 'catalog/length',
				'with_front' => false,
			),
			'sort' => true,
		));
		register_taxonomy_for_object_type('catalog_length', 'catalog');

		$this->rewrite();
	}


	public function add_rewrite_rule()
	{
		// ヘアカタログ
		add_rewrite_rule( 'catalog/details/([0-9]+)/?$', 'index.php?post_type=catalog&p=$matches[1]', 'top' );
		add_rewrite_rule( 'catalog/details/([0-9]+)(/[0-9]+)?/?$', 'index.php?post_type=catalog&p=$matches[1]&page=$matches[2]', 'top' );

		// ヘアカタログ　タクソノミー
		add_rewrite_rule( 'catalog/tag/([^/]+)/?$', 'index.php?post_type=catalog&taxonomy=catalog_tag&catalog_tag=$matches[1]', 'top' );
		add_rewrite_rule( 'catalog/stylist/([^/]+)/?$', 'index.php?post_type=catalog&taxonomy=com_category&stylist=$matches[1]', 'top' );

		// カタログ　レングス
		add_rewrite_rule( 'catalog/length/([^/]+)/?$', 'index.php?post_type=catalog&taxonomy=catalog_length&length=$matches[1]', 'top' );

		// カタログサーチ
			// シングルサーチ
		add_rewrite_rule( 'catalog/search/s/([^/]+)/?$', 'index.php?post_type=catalog&stylist=$matches[1]', 'top' );
		add_rewrite_rule( 'catalog/search/l/([^/]+)/?$', 'index.php?post_type=catalog&length=$matches[1]', 'top' );
		add_rewrite_rule( 'catalog/search/t/([^/]+)/?$', 'index.php?post_type=catalog&catalog_tag=$matches[1]', 'top' );

			// 2パターン
		add_rewrite_rule( 'catalog/search/s/([^/]+)/l/([^/]+)/?$', 'index.php?post_type=catalog&stylist=$matches[1]&length=$matches[2]', 'top' );
		add_rewrite_rule( 'catalog/search/s/([^/]+)/t/([^/]+)/?$', 'index.php?post_type=catalog&stylist=$matches[1]&catalog_tag=$matches[2]', 'top' );
		add_rewrite_rule( 'catalog/search/l/([^/]+)/t/[,]?([^/]+)/?$', 'index.php?post_type=catalog&length=$matches[1]&catalog_tag=$matches[2]', 'top' );

		add_rewrite_rule( 'catalog/search/s/([^/]+)/l/([^/]+)/t/([^/]+)/?$', 'index.php?post_type=catalog&stylist=$matches[1]&length=$matches[2]&catalog_tag=$matches[3]', 'top' );

			// ページング
		add_rewrite_rule( 'catalog/search/s/([^/]+)/page/?([0-9]{1,})/?$', 'index.php?post_type=catalog&stylist=$matches[1]&paged=$matches[2]', 'top' );
		add_rewrite_rule( 'catalog/search/l/([^/]+)/page/?([0-9]{1,})/?$', 'index.php?post_type=catalog&length=$matches[1]&paged=$matches[2]', 'top' );
		add_rewrite_rule( 'catalog/search/t/([^/]+)/page/?([0-9]{1,})/?$', 'index.php?post_type=catalog&catalog_tag=$matches[1]&paged=$matches[2]', 'top' );

		add_rewrite_rule( 'catalog/search/s/([^/]+)/l/([^/]+)/page/?([0-9]{1,})/?$', 'index.php?post_type=catalog&stylist=$matches[1]&length=$matches[2]&paged=$matches[3]', 'top' );
		add_rewrite_rule( 'catalog/search/s/([^/]+)/t/([^/]+)/page/?([0-9]{1,})/?$', 'index.php?post_type=catalog&stylist=$matches[1]&catalog_tag=$matches[2]&paged=$matches[3]', 'top' );
		add_rewrite_rule( 'catalog/search/l/([^/]+)/t/([^/]+)/page/?([0-9]{1,})/?$', 'index.php?post_type=catalog&length=$matches[1]&catalog_tag=$matches[2]&paged=$matches[3]', 'top' );

		add_rewrite_rule( 'catalog/search/s/([^/]+)/l/([^/]+)/t/([^/]+)/page/?([0-9]{1,})/?$', 'index.php?post_type=catalog&stylist=$matches[1]&length=$matches[2]&catalog_tag=$matches[3]&paged=$matches[4]', 'top' );
		// add_rewrite_rule( 'catalog/length/([^/]+)/?$', 'index.php?post_type=catalog&length=$matches[1]', 'top' );
	}

	public function rewrite()
	{
		global $wp_rewrite;

		$wp_rewrite->add_rewrite_tag('%catalog%', '(catalog)', 'post_type=');
		$wp_rewrite->add_permastruct('catalog', '/%catalog%/details/%post_id%/', false);
	}

	public function permalink($post_link, $id = 0, $leavename)
	{
		global $wp_rewrite;

		$post = get_post($id);

		if (is_wp_error($post)) {
			return $post;
		}

		if ('catalog' === $post->post_type) {
			$newlink = $wp_rewrite->get_extra_permastruct($post->post_type);
			$newlink = str_replace('%catalog%', $post->post_type, $newlink);
			$newlink = str_replace('%post_id%', $post->ID, $newlink);
			$newlink = home_url(user_trailingslashit($newlink));

			return $newlink;
		}

		return $post_link;
	}

	public function columns($columns)
	{
		$post_type = 'catalog';
		unset($columns);
		$columns['cb'] = '<input type="checkbox" />';
		$columns['thumbnail'] = 'サムネイル';
		$columns['title'] = _x('Title', 'column name');

		// $columns['news-category'] = 'カテゴリー';

		$taxonomies = get_object_taxonomies($post_type, 'objects');
		$taxonomies = wp_filter_object_list($taxonomies, array('show_admin_column' => true), 'and', 'name');
		foreach ($taxonomies as $taxonomy) {
			$column_key = 'taxonomy-'.$taxonomy;
			$columns[$column_key] = get_taxonomy($taxonomy)->labels->name;
		}
		$columns['date'] = __('Date');

		return $columns;
	}

	public function column($column, $post_id)
	{
		switch ($column) {
			case 'thumbnail':
				if (has_post_thumbnail($post_id)) {
					the_post_thumbnail(array(80, 80));
				} else {
					_e('None');
				}
				echo '<style>#thumbnail { width: 80px; } #thumbnail img { max-width:100%;height:auto; }</style>';
				break;
			case 'news-category':
				$news_category = get_field('news_category', $post_id);
				echo $news_category['label'];
				break;
		}
	}

	public function pre_get_posts($query)
	{
		$post_type = get_query_var('post_type');
		if ( ! is_admin() and $query->is_main_query())
		{
			$meta_query = array();
			$tax_query = array();

			if ($post_type === 'catalog')
			{
				if ( ! empty($meta_query)) {
					$query->set('meta_query', $meta_query);
				}
				if ( ! empty($tax_query)) {
					$query->set('tax_query', $tax_query);
				}
				$query->set('posts_per_page', 12);
			}
		}
	}
}