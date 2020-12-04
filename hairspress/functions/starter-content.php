<?php
return array(
	'posts' => array(
		'custom' => array(
			'post_type' => 'post',
			'post_title' => 'Coming soon...',
			'post_name' => 'example-blog',
			'post_content' => 'Coming soon...',
			'comment_status' => 'closed',
		),
		'home' => array(
			'post_type' => 'page',
			'post_title' => 'トップページ',
			'post_name' => 'front-page',
		),
		'menu' => array(
			'post_type' => 'page',
			'post_title' => 'メニュー',
			'post_name' => 'menu',
		),
		'salon' => array(
			'post_type' => 'page',
			'post_title' => 'サロンについて',
			'post_name' => 'salon',
		),
		'reviews' => array(
			'post_type' => 'page',
			'post_title' => '口コミ',
			'post_name' => 'reviews',
		),
		'blog' => array(
			'post_type' => 'page',
			'post_title' => 'ブログ',
			'post_name' => 'blog',
		),
	),
	'options' => array(
		'show_on_front' => 'page',
		'page_on_front' => '{{home}}',
		'page_for_posts' => '{{blog}}',
	),
	'nav_menus' => array(
		'primary-menu' => array(
			'name' => 'メインメニュー',
			'items' => array(
				'page_home' => array(
					'title' => 'ホーム',
					'field_5e572aad21632' => 'Home'
				),
				'page_blog' => array(
					'title' => 'ブログ',
				),
			),
		),
	),
	'widgets' => array(
		'blog-sidebar-top-widget' => array(
			'search',
			'recentposts',
			'popularposts',
			'categories',
			'archives',
		),
		'blog-sidebar-bottom-widget' => array(
		),
		'blog-content-bottom' => array(
		),
	)
);