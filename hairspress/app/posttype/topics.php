<?php
namespace Hairspress\App;

class Posttype_Topics
{
	public function __construct()
	{
		add_action('init', array($this, 'register'));
		add_filter('post_type_link', array($this, 'permalink'), 10, 3);
		add_filter('post_link', array($this, 'permalink'), 10, 3);
		add_filter('month_link', array($this, 'month_link'), 10, 3);
		add_action( 'manage_topics_posts_columns' , array($this, 'columns'));
		add_action( 'manage_topics_posts_custom_column' , array($this, 'column'), 10, 2);
		// add_filter('query_vars', array($this, 'query_vars'));
		add_action('pre_get_posts', array($this, 'pre_get_posts'));
	}

	public function query_vars($vars) {
		// $vars[] = 'hair_stylist';

		return $vars;
	}

	public function register()
	{
		register_post_type('topics', array(
			'labels' => array(
				'name' => 'お知らせ',
				'menu_name' => 'お知らせ',
				'singular_name' => 'お知らせ',
			),
			'public' => true,
			'has_archive' => true,
			'menu_position' => 6,
			'menu_icon' => 'dashicons-welcome-write-blog',
			// 'capabilities' => array('edit_post'),
			'supports' => array(
				'title',
				'editor',
				// 'author',
				// 'thumbnail',
				// 'excerpt',
				// 'revisions',
			),
			'capability_type' => 'post',
			'hierarchical' => false,
			// 'taxonomies' => array('com_category', 'catalog_length'),
			'show_in_rest' => true,
			'rewrite' => array(
				'slug' => 'topics',
				'with_front' => false,
			),
		));

		$this->rewrite();
	}


	public function rewrite()
	{
		global $wp_rewrite;

		$wp_rewrite->add_rewrite_tag('%topics%', '(topics)', 'post_type=');
		$wp_rewrite->add_permastruct('topics', '/%topics%/%post_id%/', false);
		$wp_rewrite->add_permastruct('topics', '/%topics%/date/%year%/%monthnum%/', false);
	}

	public function permalink($post_link, $id = 0, $leavename)
	{
		global $wp_rewrite;

		$post = get_post($id);

		if (is_wp_error($post)) {
			return $post;
		}

		if ('topics' === $post->post_type) {
			$newlink = $wp_rewrite->get_extra_permastruct($post->post_type);
			$newlink = str_replace('%topics%', $post->post_type, $newlink);
			$newlink = str_replace('%post_id%', $post->ID, $newlink);
			$newlink = home_url(user_trailingslashit($newlink));

			return $newlink;
		}

		return $post_link;
	}

	public function month_link($monthlink, $year, $month) {
		global $wp_rewrite;
		if (!$year) {
			$year = current_time('Y');
		}
		if (!$month) {
			$month = current_time('m');
		}

		$current_post_type = get_query_var('post_type');

		if ($current_post_type === 'topics') {
			$monthlink = $wp_rewrite->get_extra_permastruct($current_post_type);
			$monthlink = str_replace('%topics%', $current_post_type, $monthlink);
			$monthlink = str_replace('%year%', $year, $monthlink);
			$monthlink = str_replace('%monthnum%', $month, $monthlink);
			$monthlink = home_url(user_trailingslashit($monthlink));
		}

		return $monthlink;
	}

	public function columns($columns)
	{
		$post_type = 'topics';
		unset($columns);
		$columns['cb'] = '<input type="checkbox" />';
		// $columns['thumbnail'] = 'サムネイル';
		$columns['title'] = _x('Title', 'column name');

		// $columns['news-category'] = 'カテゴリー';

		// $taxonomies = get_object_taxonomies($post_type, 'objects');
		// $taxonomies = wp_filter_object_list($taxonomies, array('show_admin_column' => true), 'and', 'name');
		// foreach ($taxonomies as $taxonomy) {
		// 	$column_key = 'taxonomy-'.$taxonomy;
		// 	$columns[$column_key] = get_taxonomy($taxonomy)->labels->name;
		// }
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

			if ($post_type === 'topics')
			{
				$query->set('posts_per_page', 10);
				if ( ! empty($meta_query)) {
					$query->set('meta_query', $meta_query);
				}
				if ( ! empty($tax_query)) {
					$query->set('tax_query', $tax_query);
				}
			}
		}
	}
}