<?php
namespace Hairspress\App;

class Posttype_Setmenu
{
	public function __construct()
	{
		add_action('init', array($this, 'register'));
		add_filter('post_type_link', array($this, 'permalink'), 10, 3);
		add_filter('post_link', array($this, 'permalink'), 10, 3);
		add_action( 'manage_hair_posts_columns' , array($this, 'columns'));
		add_action( 'manage_hair_posts_custom_column' , array($this, 'column'), 10, 2);
		// add_filter('query_vars', array($this, 'query_vars'));
		add_action('pre_get_posts', array($this, 'pre_get_posts'));
	}

	public function query_vars($vars) {
		// $vars[] = 'hair_stylist';

		return $vars;
	}

	public function register()
	{
		register_post_type('setmenu', array(
			'labels' => array(
				'name' => 'セットメニュー',
				'menu_name' => 'セットメニュー',
				'singular_name' => 'セットメニュー',
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

		// register_taxonomy('catalog_tag', 'catalog', array(
		// 	'labels' => array(
		// 		'name' => 'イメージタグ',
		// 		'menu_name' => 'イメージタグ',
		// 		'singular_name' => 'イメージタグ:catalog_tag',
		// 	),
		// 	'hierarchical' => false,
		// 	'show_ui' => true,
		// 	'show_in_nav_menus' => false,
		// 	'show_admin_column' => true,
		// 	'query_var' => 'catalog_tag',
		// 	'has_archive' => true,
		// 	'rewrite' => array(
		// 		'slug' => 'catalog/tag',
		// 		'with_front' => false,
		// 	),
		// ));
		// register_taxonomy_for_object_type('catalog_tag', 'catalog');


		$this->rewrite();
	}


	public function rewrite()
	{
		global $wp_rewrite;

		$wp_rewrite->add_rewrite_tag('%setmenu%', '(setmenu)', 'post_type=');
		$wp_rewrite->add_permastruct('setmenu', '/%setmenu%/%post_id%/', false);
	}

	public function permalink($post_link, $id = 0, $leavename)
	{
		global $wp_rewrite;

		$post = get_post($id);

		if (is_wp_error($post)) {
			return $post;
		}

		if ('setmenu' === $post->post_type) {
			$newlink = $wp_rewrite->get_extra_permastruct($post->post_type);
			$newlink = str_replace('%setmenu%', $post->post_type, $newlink);
			$newlink = str_replace('%post_id%', $post->ID, $newlink);
			$newlink = home_url(user_trailingslashit($newlink));

			return $newlink;
		}

		return $post_link;
	}

	public function columns($columns)
	{
		$post_type = 'setmenu';
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

			if ($post_type === 'setmenu')
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