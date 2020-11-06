<?php

################################################
## カスタム投稿タイプ追加
################################################
add_filter( 'post_type_link', 'hp_post_type_link', 1, 2 );
function hp_post_type_link( $link, $post ){
	if ( 'topics' === $post->post_type ) {
		return home_url( '/topics/details/' . $post->ID );

	} else if( 'staff' === $post->post_type ) {
		return home_url( '/staff/details/' . $post->ID );

	} else if( 'catalog' === $post->post_type ) {
		return home_url( '/catalog/details/' . $post->ID );

	} else if( 'channel' === $post->post_type ) {
		return home_url( '/channel/details/' . $post->ID );

	} else if( 'menu' === $post->post_type ) {
		return home_url( '/menu/' . $post->ID );

	} else if( 'freepage' === $post->post_type ) {
		return home_url( '/freepage/' . $post->ID );
	} else {
		return $link;
	}
}
// flush_rewrite_rules();
add_filter( 'rewrite_rules_array', 'hp_rewrite_rules_array' );
function hp_rewrite_rules_array( $rules ) {
	$new_rules = array(
		'topics/details/([0-9]+)/?$' => 'index.php?post_type=topics&p=$matches[1]',
		'topics/details/([0-9]+)/([0-9]+)?$' => 'index.php?post_type=topics&p=$matches[1]&page=$matches[2]',
		'topics/date/([0-9]+)/?$' => 'index.php?post_type=topics&year=$matches[1]',
		'topics/date/([0-9]+)/([0-9]+)/?$' => 'index.php?post_type=topics&year=$matches[1]&monthnum=$matches[2]',
		'topics/date/([0-9]+)/([0-9]+)/([0-9]+)?$' => 'index.php?post_type=topics&year=$matches[1]&monthnum=$matches[2]&day=$matches[3]',
		'staff/details/([0-9]+)/?$' => 'index.php?post_type=staff&p=$matches[1]',
		'catalog/details/([0-9]+)/?$' => 'index.php?post_type=catalog&p=$matches[1]',
		'channel/details/([0-9]+)/?$' => 'index.php?post_type=channel&p=$matches[1]',
		'menu/([0-9]+)/?$' => 'index.php?post_type=menu&p=$matches[1]',
		'freepage/([0-9]+)/?$' => 'index.php?post_type=freepage&p=$matches[1]',
		'freepage/([0-9]+)/([0-9]+)/?$' => 'index.php?post_type=freepage&p=$matches[1]&page=$matches[2]',
	);
	return $rules;
	// return $new_rules + $rules;
}

// リライトルールの追加
add_action('init', 'hp_custom_rewrite_rules');
function hp_custom_rewrite_rules() {
	// お知らせ
	add_rewrite_rule( 'topics/details/([0-9]+)/?$', 'index.php?post_type=topics&p=$matches[1]', 'top' );
	add_rewrite_rule( 'topics/details/([0-9]+)(/[0-9]+)?/?$', 'index.php?post_type=topics&p=$matches[1]&page=$matches[2]', 'top' );
	add_rewrite_rule( 'topics/date/([0-9]{4})/?$', 'index.php?post_type=topics&year=$matches[1]', 'top' );
	add_rewrite_rule( 'topics/date/([0-9]{4})/page/?([0-9]{1,})/?$', 'index.php?post_type=topics&year=$matches[1]&paged=$matches[2]', 'top' );
	add_rewrite_rule( 'topics/date/([0-9]{4})/([0-9]{1,2})/?$', 'index.php?post_type=topics&year=$matches[1]&monthnum=$matches[2]', 'top' );
	add_rewrite_rule( 'topics/date/([0-9]{4})/([0-9]{1,2})/page/?([0-9]{1,})/?$', 'index.php?post_type=topics&year=$matches[1]&monthnum=$matches[2]&paged=$matches[3]', 'top' );
	add_rewrite_rule( 'topics/date/([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/?$', 'index.php?post_type=topics&year=$matches[1]&monthnum=$matches[2]&day=$matches[3]', 'top' );
	add_rewrite_rule( 'topics/date/([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})/page/?([0-9]{1,})/?$', 'index.php?post_type=topics&year=$matches[1]&monthnum=$matches[2]&day=$matches[3]&paged=$matches[4]', 'top' );

	// メニュー
	// add_rewrite_rule( 'menu/([0-9]+)/?$', 'index.php?post_type=menu&p=$matches[1]', 'top' );
	// add_rewrite_rule( 'menu/([0-9]+)(/[0-9]+)?/?$', 'index.php?post_type=staff&p=$matches[1]&page=$matches[2]', 'top' );

	// スタッフ
	add_rewrite_rule( 'staff/details/([0-9]+)/?$', 'index.php?post_type=staff&p=$matches[1]', 'top' );
	add_rewrite_rule( 'staff/details/([0-9]+)(/[0-9]+)?/?$', 'index.php?post_type=staff&p=$matches[1]&page=$matches[2]', 'top' );

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

	// チャンネル
	add_rewrite_rule( 'channel/details/([0-9]+)/?$', 'index.php?post_type=channel&p=$matches[1]', 'top' );
	add_rewrite_rule( 'channel/category/([^/]+)/?$', 'index.php?post_type=channel&taxonomy=channel_category&channel_term=$matches[1]', 'top' );

	// フリーページ
	add_rewrite_rule( 'freepage/([0-9]+)/?$', 'index.php?post_type=freepage&p=$matches[1]', 'top' );
	add_rewrite_rule( 'freepage/([0-9]+)(/[0-9]{1,})/?$', 'index.php?post_type=freepage&p=$matches[1]&page=$matches[2]', 'top' );

}

// function hp_rewrite_rules_register() {
// 	hp_custom_rewrite_rules();
// 	flush_rewrite_rules();
// }
// function hp_deactivate() {
// 	flush_rewrite_rules();
// }
// register_activation_hook(__FILE__, 'hp_rewrite_rules_register' );
// register_deactivation_hook(__FILE__, 'hp_deactivate' );


function hp_custom_posttype_register() {
	add_topics_post_type();
	add_staff_post_type();
	add_catalog_post_type();
	add_channel_post_type();
	add_menu_post_type();
	add_freepage_post_type();

	flush_rewrite_rules();
}
register_activation_hook(__FILE__, 'hp_custom_posttype_register' );


// お知らせ
add_action('init', 'add_topics_post_type');
function add_topics_post_type() {
	$params = array(
		'labels' => array(
			'name' => 'お知らせ',
			'singular_name' => 'お知らせ',
			'add_new' => '新規追加',
			'add_new_item' => '新規投稿を追加',
			'edit_item' => '投稿の編集',
			'new_item' => '新規お知らせ',
			'all_items' => '一覧',
			'view_item' => 'この投稿を表示',
			'search_items' => '投稿を検索する',
			'not_found' => 'お知らせ内に投稿が見つかりませんでした。',
			'not_found_in_trash' => 'ゴミ箱内に投稿が見つかりませんでした。'
		),
		'menu_position' => 6,
		'menu_icon' => 'dashicons-welcome-write-blog',
		'public' => true,
		'has_archive' => true,
		'supports' => array(
			'title',
			'editor',
			// 'thumbnail',
			// 'page-attributes',
			'revisions'
		),
		// 'taxonomies' => array('news_cat'),
		'capability_type' => 'post',
		'hierarchical' => true,
		'rewrite' => array(
			'slug' => 'topics',
			'with_front' => false
		)
	);
	register_post_type('topics', $params);
}

// スタッフ
add_filter('enter_title_here', 'change_staff_title_here');
function change_staff_title_here($title) {
	$screen = get_current_screen();
	if ($screen->post_type == 'staff') {
		$title = 'スタッフの名前を入力してください。';
		return $title;
	}
	if( $screen->post_type == 'catalog') {
		$title = 'ヘアスタイル名を入力してください。';
		return $title;
	}
	if( $screen->post_type == 'menu' ) {
		$title = 'メニュータイトル（英字）を入力してください。';
		return $title;
	}
	if( $screen->post_type == 'channel' ) {
		// $title = '';
	}
	return $title;
}

add_action('init', 'add_staff_post_type');
function add_staff_post_type() {
	$params = array(
		'labels' => array(
			'name' => 'スタッフ',
			'singular_name' => 'スタッフ',
			'add_new' => 'スタッフを新規追加',
			'add_new_item' => '投稿を新規追加',
			'edit_item' => '投稿を編集する',
			'new_item' => '新規サイト',
			'all_items' => 'スタッフ一覧',
			'view_item' => '投稿を表示',
			'search_items' => '検索する',
			'not_found' => '投稿が見つかりませんでした。',
			'not_found_in_trash' => 'ゴミ箱内に投稿が見つかりませんでした。'
		),
		'menu_position' => 7,
		'menu_icon' => 'dashicons-id-alt',
		'public' => true,
		'has_archive' => true,
		'supports' => array(
			'title',
			'editor',
			'thumbnail',
			// 'page-attributes'
			'revisions'
		),
		'taxonomies' => array('com_category', 'manage'),
		'capability_type' => 'post',
		'hierarchical' => true,
		'rewrite' => array(
			'slug' => 'staff',
			'with_front' => false
		),
		'query_var' => 'staffs'
	);
	register_post_type('staff', $params);
}

// ヘアカタログ

function add_catalog_post_type() {
	$params = array(
		'labels' => array(
			'name' => 'ヘアカタログ',
			'singular_name' => 'ヘアカタログ',
			'add_new' => 'カタログを新規追加',
			'add_new_item' => '投稿を新規追加',
			'edit_item' => '投稿を編集する',
			'new_item' => '新規サイト',
			'all_items' => 'カタログ一覧',
			'view_item' => '投稿を表示',
			'search_items' => '検索する',
			'not_found' => '投稿が見つかりませんでした。',
			'not_found_in_trash' => 'ゴミ箱内に投稿が見つかりませんでした。'
		),
		'menu_position' => 8,
		'menu_icon' => 'dashicons-book',
		'public' => true,
		'has_archive' => true,
		'supports' => array(
			'title',
			// 'editor',
			'thumbnail',
			// 'page-attributes',
			'revisions'
		),
		'taxonomies' => array('com_category', 'catalog_length'),
		'capability_type' => 'post',
		'hierarchical' => false,
		'rewrite' => array(
			'slug' => 'catalog',
			'with_front' => false
		)
	);
	register_post_type('catalog', $params);
}

// チャンネル
function add_channel_post_type() {
	$params = array(
		'labels' => array(
			'name' => 'チャンネル',
			'singular_name' => 'チャンネル',
			'add_new' => '動画を新規追加',
			'add_new_item' => '投稿を新規追加',
			'edit_item' => '投稿を編集する',
			'new_item' => '新規サイト',
			'all_items' => 'チャンネルの一覧',
			'view_item' => '投稿を表示',
			'search_items' => '検索する',
			'not_found' => '投稿が見つかりませんでした。',
			'not_found_in_trash' => 'ゴミ箱内に投稿が見つかりませんでした。'
		),
		'menu_position' => 10,
		'menu_icon' => 'dashicons-format-video',
		'show_in_nav_menus' => true,
		'public' => true,
		'has_archive' => true,
		'supports' => array(
			'title',
			// 'editor',
			'thumbnail',
			// 'page-attributes',
			'revisions'
		),
		'taxonomies' => array('channel_category'),
		'capability_type' => 'post',
		'hierarchical' => false,
		'rewrite' => array(
			'slug' => 'channel',
			'with_front' => false
		)
	);
	register_post_type('channel', $params);
}

add_action('init', 'add_menu_post_type');
function add_menu_post_type() {
	$params = array(
		'labels' => array(
			'name' => 'メニュー',
			'singular_name' => 'メニュー',
			'add_new' => 'メニューを追加',
			'add_new_item' => 'メニューを追加',
			'edit_item' => 'メニューを編集する',
			'new_item' => '新規メニュー',
			'all_items' => 'メニュー一覧',
			'view_item' => 'メニューを表示',
			'search_items' => '検索する',
			'not_found' => 'メニューが見つかりませんでした。',
			'not_found_in_trash' => 'ゴミ箱内にメニューが見つかりませんでした。'
		),
		'menu_position' => 9,
		'menu_icon' => 'dashicons-media-spreadsheet',
		'show_in_nav_menus' => false,
		'public' => true,
		// 'has_archive' => true,
		'supports' => array(
			'title',
			// 'editor',
			// 'thumbnail',
			// 'page-attributes',
			'revisions'
		),
		// 'taxonomies' => array('com_category'),
		'capability_type' => 'post',
		'hierarchical' => true,
		'rewrite' => array(
			'slug' => 'menu',
			'with_front' => false
		)
	);
	register_post_type('menu', $params);
}

// フリーページ
add_action('init', 'add_freepage_post_type');
function add_freepage_post_type() {
	$params = array(
		'labels' => array(
			'name' => 'フリーページ',
			'singular_name' => 'フリーページ',
			'add_new' => '新規追加',
			'add_new_item' => '新規ページを追加',
			'edit_item' => 'ページの編集',
			'new_item' => '新規ページ',
			'all_items' => '一覧',
			'view_item' => 'このページを表示',
			'search_items' => 'ページを検索する',
			'not_found' => 'ページ内にページが見つかりませんでした。',
			'not_found_in_trash' => 'ゴミ箱内にページが見つかりませんでした。'
		),
		'menu_position' => 11,
		'menu_icon' => 'dashicons-admin-page',
		'public' => true,
		// 'has_archive' => true,
		'supports' => array(
			'title',
			'editor',
			'thumbnail',
			// 'page-attributes',
			'revisions'
		),
		// 'taxonomies' => array('news_cat'),
		'capability_type' => 'page',
		'capability'  => 'edit_posts',
		// 'hierarchical' => true,
		'rewrite' => array(
			'slug' => 'freepage',
			'with_front' => false
		)
	);
	register_post_type('freepage', $params);
}


// 担当者タクソノミーの作成
add_action('init', 'create_staff_taxonomies');
function create_staff_taxonomies() {
	register_taxonomy(
		'com_category',
		array('catalog'),
		array(
			'label' => '担当者',
			'hierarchical' => true,
			'public' => true,
			// 'show_ui' => false,
			'show_in_nav_menus' => false,
			'show_admin_column' => true,
			'query_var' => 'stylist',
			'has_archive' => true,
			'rewrite' => array(
				'slug' => 'catalog/stylist',
				'with_front' => false
			)
		)
	);
	register_taxonomy_for_object_type( 'com_category', 'catalog');
	// register_taxonomy_for_object_type( 'com_category', 'staff');
	// add_rewrite_rule('hair_style/([^/]+)/?$', 'index.php?hair_style=$matches[1]', 'top');
}

// スタッフの役職タクソノミーの作成
add_action('init', 'create_staffmanage_taxonomies');
function create_staffmanage_taxonomies() {
	register_taxonomy(
		'manage',
		'staff',
		array(
			'label' => '役職',
			'hierarchical' => true,
			// 'show_ui' => false,
			'show_in_nav_menus' => false,
			'show_admin_column' => true,
			'query_var' => 'manage_term',
			'has_archive' => true,
			'rewrite' => array(
				'slug' => 'staff/manage',
				'with_front' => false
			)
		)
	);
	register_taxonomy_for_object_type( 'manage', 'staff');
}

// ヘアカタログのタグ用タクソノミーの作成
add_action('init', 'create_catalog_tag_taxonomies');
function create_catalog_tag_taxonomies() {
	register_taxonomy(
		'catalog_tag',
		'catalog',
		array(
			'label' => 'イメージタグ',
			'hierarchical' => false,
			'show_ui' => true,
			'show_in_quick_edit' => false,
			'show_in_nav_menus' => false,
			'show_admin_column' => true,
			'show_tagcloud' => true,
			'query_var' => 'catalog_tag',
			'has_archive' => true,
			'rewrite' => array(
				'slug' => 'catalog/tag',
				'with_front' => false
			)
		)
	);
	register_taxonomy_for_object_type( 'catalog_tag', 'catalog');
}

add_action('init', 'create_catalog_length_taxonomies');
function create_catalog_length_taxonomies() {
	$show = !current_user_can('manage_options') ? false : true;
	register_taxonomy(
		'catalog_length',
		'catalog',
		array(
			'label' => 'LENGTH',
			'hierarchical' => false,
			'show_ui' => $show,
			'show_in_nav_menus' => false,
			'query_var' => 'length',
			'has_archive' => true,
			'rewrite' => array(
				'slug' => 'catalog/length',
				'with_front' => false
			),
			'sort' => true
		)
	);
	register_taxonomy_for_object_type( 'catalog_length', 'catalog');
}

add_action('init', 'custom_length_rewrite_tag', 10, 0);
function custom_length_rewrite_tag() {
	add_rewrite_tag( '%length%', '([^&]+)', 'length=');
}

add_action('init', 'create_catalog_length_term');
function create_catalog_length_term() {
	wp_insert_term('ショート', 'catalog_length', array('slug' => 'short'));
	wp_insert_term('ボブ', 'catalog_length', array('slug' => 'bob'));
	wp_insert_term('ミディアム', 'catalog_length', array('slug' => 'medium'));
	wp_insert_term('ロング', 'catalog_length', array('slug' => 'long'));
	wp_insert_term('ヘアアレンジ', 'catalog_length', array('slug' => 'arrange'));
	wp_insert_term('メンズ', 'catalog_length', array('slug' => 'mens'));
}

add_action('create_com_category', 'hp_create_category_staff');
function hp_create_category_staff($cat_id) {
	$terms = get_term( $cat_id, 'com_category' );
	if( !empty($terms) ) {
		$cat_by_slug = get_category_by_slug($terms->slug);

		if( !$cat_by_slug ) {
			wp_insert_term($terms->name, 'category', array('slug' => $terms->slug));
		}
	}
}


// チャンネルのタクソノミーの作成
add_action('init', 'create_channel_taxonomies');
function create_channel_taxonomies() {
	register_taxonomy(
		'channel_category',
		'channel',
		array(
			'label' => 'カテゴリー',
			'hierarchical' => true,
			// 'show_ui' => false,
			'show_in_nav_menus' => false,
			'show_admin_column' => true,
			'query_var' => 'channel_term',
			'has_archive' => true,
			'rewrite' => array(
				'slug' => 'channel/category',
				'with_front' => false
			)
		)
	);
	register_taxonomy_for_object_type( 'channel_category', 'channel');
}

// 投稿タイプの一覧画面
add_filter('manage_posts_columns', 'add_column_sort');
function add_column_sort($columns) {
	$columns = array(
		'cb' => '<input type="checkbox" />',
		'title' => 'タイトル',
		'categories' => 'カテゴリー',
		'date' => '日時',
		'popular' => '表示回数',
		'mio_thumbs' => 'アイキャッチ'
	);
	return $columns;
}

// トピックスの一覧画面
add_filter('manage_topics_posts_columns', 'add_topics_column');
function add_topics_column($columns) {
	$columns = array(
		'cb' => '<input type="checkbox" />',
		'title' => 'タイトル',
		// 'mio_thumbs' => 'アイキャッチ画像',
		// 'member_cat' => 'カテゴリー',
		'date' => '日時'
	);
	return $columns;
}

// スタッフ一覧の項目
add_filter('manage_edit-staff_columns', 'manage_custom_staff_columns');
function manage_custom_staff_columns($columns) {
	$columns = array(
		'cb' => '<input type="checkbox" />',
		'title' => 'タイトル',
		'taxonomy-com_category' => '担当者',
		'taxonomy-manage' => '役職',
		'date' => '日時',
		'mio_thumbs' => 'アイキャッチ'
	);
	return $columns;
}

// ヘアカタログ一覧の項目
add_filter('manage_edit-catalog_columns', 'add_custom_catalog_columns');
function add_custom_catalog_columns($columns) {
	$columns = array(
		'cb' => '<input type="checkbox" />',
		'title' => 'タイトル',
		'taxonomy-com_category' => '担当者',
		'taxonomy-catalog_tag' => 'タグ',
		'date' => '日時',
		'mio_thumbs' => 'アイキャッチ'
	);
	return $columns;
}

// チャンネル一覧の項目
add_filter('manage_edit-channel_columns', 'manage_custom_channel_columns');
function manage_custom_channel_columns($columns) {
	$columns = array(
		'cb' => '<input type="checkbox" />',
		'title' => 'タイトル',
		'taxonomy-channel_category' => 'カテゴリー',
		'date' => '日時',
		'channel_thumbs' => 'アイキャッチ'
	);
	return $columns;
}

// 投稿一覧にアイキャッチ欄の表示を追加
add_action('manage_posts_custom_column', 'add_thumbs_img_column');
add_action('manage_staff_posts_custom_column', 'add_thumbs_img_column');
// add_action('manage_catalog_posts_custom_column', 'add_thumbs_img_column');
function add_thumbs_img_column($column_name) {
	global $post;
	if( $column_name == 'mio_thumbs' ) {
		if( has_post_thumbnail() ) {
			echo get_the_post_thumbnail($post->ID, 'square');
		} else {
			// echo __('None');
			echo 'なし';
		}
	} elseif ($column_name === 'popular') {
		$pop_data = get_post_meta($post->ID, 'post_views_count', true);
		if ($pop_data) {
			echo $pop_data;
		} else {
			echo '-';
		}
	}
}

add_action('manage_channel_posts_custom_column', 'add_channel_thumbs_column');
function add_channel_thumbs_column($column_name) {
	global $post;
	$yt_url = function_exists('get_field') ? get_field('hp_youtube_id', $post->ID) : null;
	if( $column_name == 'channel_thumbs' ) {
		if( has_post_thumbnail() ) {
			echo get_the_post_thumbnail($post->ID, 'admin-thumb');
		} elseif( !empty($yt_url) ) {
			$id = null;
			if( preg_match('/.*v=([\d\w|-]+).*/', $yt_url, $match) )
				$id = $match[1];

			if( preg_match('/.*youtu.be\/([\d\w|-]+).*/', $yt_url, $match) )
				$id = $match[1];

			if( !is_null($id) ) {
				echo '<img src="http://i.ytimg.com/vi/'.$id.'/default.jpg" width="80" alt="">';
			} else {
				echo 'ー';
			}
		} else {
			// echo __('None');
			echo 'なし';
		}
	}
}

add_action('manage_posts_custom_column', 'add_post_id_column');
add_action('manage_topics_posts_custom_column', 'add_post_id_column');
add_action('manage_staff_posts_custom_column', 'add_post_id_column');
// add_action('manage_catalog_posts_custom_column', 'add_post_id_column');
function add_post_id_column($column_name) {
	global $post;
	if( $column_name == 'postID' ) {
		echo '<span>'.$post->ID.'</span>';
	}
}

// アイキャッチ部分のスタイル設定
add_action('admin_print_styles', 'custom_admin_thumbs_css');
function custom_admin_thumbs_css() {
	echo <<< __CSS__
<style type="text/css">
.column-popular {
	width: 80px;
	text-align: center;
}
#the-list tr {
	-webkit-transition: none !important;
	-moz-transition: none !important;
	-ms-transition: none !important;
	-o-transition: none !important;
	transition: none !important;
}
#com_categorydiv,
#managediv,
#tagsdiv-catalog_tag,
#tagsdiv-catalog_length {
	display: none;
}

.type-staff .inline,
.type-catalog .inline,
.type-menu .inline,
.type-channel .inline {
	display: none;
}
#com_category-tabs,
#manage-tabs,
#category-tabs {
	display: none;
}
#hpLength .acf-bl > li,
#hpStaff .acf-bl > li,
#staffManage .acf-bl > li,
#catalogImageTag .acf-bl > li {
	display: inline-block;
	margin-right: 12px;
}


@media screen and (max-width: 782px) {

}
@media screen and (min-width: 783px) {
	.column-mio_thumbs,
	.column-channel_thumbs {
		width: 12%;
		text-align: center;
	}

	.column-mio_thumbs img,
	.column-channel_thumbs img {
		max-width: 100%;
		width: 150px;
		height: 120px;
		object-fit: cover;
		object-position: center 0px;
	}
	.column-mio_thumbs img {
		width: 150px;
		height: 120px;
		object-fit: cover;
		object-position: center 0px;
	}
	.column-taxonomy-com_category,
	.column-taxonomy-manage,
	.column-taxonomy-catalog_tag,
	.column-taxonomy-channel_category {
		width: 14%;
	}

	.column-date {
		width: 120px;
	}
}
</style>
__CSS__;
}


add_action('admin_print_styles', 'wp_column_list_css');
function wp_column_list_css() {
	// $quick_link = get_post_type() == 'topics' ? 'span.inline { display: none; }' : '';
	echo <<< __CSS__
<style>
table.fixed {
	table-layout: auto;
}

@media screen and (max-width: 782px) {
	.wp-list-table th.column-postID,
	.wp-list-table tr:not(.inline-edit-row):not(.no-items) td.column-postID:not(.check-column) {
		display: none;
		padding: 3px 8px 3px 35%;
	}
}
@media screen and (min-width: 783px) {
	#postID {
		width: 30px;
		text-align: center;
	}
	.column-postID {
		text-align: right;
		border-left: 1px solid #e0e0e0;
		border-right: 1px solid #e0e0e0;
	}
}
#the-list th,
#the-list td {
	border-bottom: 1px solid #e0e0e0;
}
#the-list tr {
	-webkit-transition: 500ms ease-in-out;
		 -moz-transition: 500ms ease-in-out;
			-ms-transition: 500ms ease-in-out;
			 -o-transition: 500ms ease-in-out;
					transition: 500ms ease-in-out;
}
#the-list tr:hover {
	background-color: #e9f0f5;
}

</style>
__CSS__;
///*{$quick_link}*/
}

