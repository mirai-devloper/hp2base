<?php
namespace Hairspress\App;

class Posttype_Menucontents
{
	public function __construct()
	{
		add_action('init', array($this, 'register'));
		add_filter('post_type_link', array($this, 'permalink'), 10, 3);
		add_filter('post_link', array($this, 'permalink'), 10, 3);
		add_action( 'manage_menu-contents_posts_columns' , array($this, 'columns'));
		add_action( 'manage_menu-contents_posts_custom_column' , array($this, 'column'), 10, 2);
		// add_filter('query_vars', array($this, 'query_vars'));
		add_action('pre_get_posts', array($this, 'pre_get_posts'));
	}

	public function query_vars($vars) {
		// $vars[] = 'hair_stylist';

		return $vars;
	}

	public function register()
	{
		register_post_type('menu-contents', array(
			'labels' => array(
				'name' => 'メニューコンテンツ',
				'menu_name' => 'メニューコンテンツ',
				'singular_name' => 'メニューコンテンツ',
			),
			'public' => true,
			'has_archive' => true,
			'menu_position' => 10,
			'menu_icon' => 'dashicons-media-spreadsheet',
			// 'capabilities' => array('edit_post'),
			'supports' => array(
				'title',
				// 'editor',
				'author',
				'thumbnail',
				// 'excerpt',
				// 'revisions',
			),
			'capability_type' => 'post',
			'hierarchical' => false,
			// 'taxonomies' => array('com_category', 'catalog_length'),
			'rewrite' => array(
				'slug' => 'setmenu',
				'with_front' => false,
			),
		));

		register_taxonomy('menu-contents_type', 'menu-contents', array(
			'labels' => array(
				'name' => 'タイプ',
				'menu_name' => 'タイプ',
				'singular_name' => 'タイプ:menu-contents_type',
			),
			'hierarchical' => true,
			'show_ui' => true,
			'show_in_nav_menus' => false,
			'show_admin_column' => true,
			'meta_box_cb' => false,
			'query_var' => 'menu-contents_type',
			'has_archive' => true,
			'rewrite' => array(
				'slug' => 'menu-contents/type',
				'with_front' => false,
			),
		));
		register_taxonomy_for_object_type('menu-contents_type', 'menu-contents');

		register_taxonomy('menu-contents_category', 'menu-contents', array(
			'labels' => array(
				'name' => 'カテゴリー',
				'menu_name' => 'カテゴリー',
				'singular_name' => 'カテゴリー:menu-contents_category',
			),
			'hierarchical' => true,
			'show_ui' => true,
			'show_in_nav_menus' => false,
			'show_admin_column' => true,
			'meta_box_cb' => false,
			'query_var' => 'menu-contents_category',
			'has_archive' => true,
			'rewrite' => array(
				'slug' => 'menu-contents/category',
				'with_front' => false,
			),
		));
		register_taxonomy_for_object_type('menu-contents_category', 'menu-contents');


		$this->rewrite();
	}


	public function rewrite()
	{
		global $wp_rewrite;

		$wp_rewrite->add_rewrite_tag('%menu-contents%', '(menu-contents)', 'post_type=');
		$wp_rewrite->add_permastruct('menu-contents', '/%menu-contents%/%post_id%/', false);
	}

	public function permalink($post_link, $id = 0, $leavename)
	{
		global $wp_rewrite;

		$post = get_post($id);

		if (is_wp_error($post)) {
			return $post;
		}

		if ('menu-contents' === $post->post_type) {
			$newlink = $wp_rewrite->get_extra_permastruct($post->post_type);
			$newlink = str_replace('%menu-contents%', $post->post_type, $newlink);
			$newlink = str_replace('%post_id%', $post->ID, $newlink);
			$newlink = home_url(user_trailingslashit($newlink));

			return $newlink;
		}

		return $post_link;
	}

	public function columns($columns)
	{
		$post_type = 'menu-contents';
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
				echo '<style>#thumbnail { width: 85px; } .column-thumbnail { text-align:center; vertical-align: middle !important;} .column-thumbnail img { max-width:100%;height:auto; }</style>';
				if (has_post_thumbnail($post_id)) {
					the_post_thumbnail('thumbnail');
				} else {
					echo '&mdash;';
				}
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

			if ($post_type === 'menu-contents')
			{
				if ( ! empty($meta_query)) {
					$query->set('meta_query', $meta_query);
				}
				if ( ! empty($tax_query)) {
					$query->set('tax_query', $tax_query);
				}
				$query->set('posts_per_page', -1);
			}
		}
	}
}