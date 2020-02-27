<?php
require 'plugin-update-checker/plugin-update-checker.php';
$hp2baseUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
	'https://github.com/nullpon16tera/hp2base',
	__FILE__,
	'hp2base'
);
$hp2baseUpdateChecker->setAuthentication('1407214a37299d2a0947f9c37dc8abce56a563c4');
$hp2baseUpdateChecker->getVcsApi()->enableReleaseAssets();

// ブログのコンテンツ幅の最大値（エディタエリアに影響）
if ( ! isset( $content_width ) )
	$content_width = 840;

define('ENV_MODE', getenv('ENV_MODE'));
define('WP_ENV', getenv('WP_ENV'));


// Mio_Helper
define("INCLUDEPATH", TEMPLATEPATH."/_include");
get_template_part('_include/mio', 'helper');


// Vendorモジュール
// Mio_helper::load('acf/acf-field-group.php');

Mio_helper::load('classes/assets.php');
Mio_helper::load('classes/config.php');

// 自作モジュールの読み込み
Mio_helper::load('module/form.php');
Mio_helper::load('module/wareki.php');

/*** WPのアクション呼び出し ***/
Mio_helper::load('wp/admin-setup.php');
Mio_helper::load('wp/admin-login.php');
Mio_helper::load('wp/wp-title.php');

/*** セットアップ ***/
// Mio_helper::load('wp-login.php');
Mio_helper::load('wp-setup.php');
Mio_helper::load('wp-custom.php');

// Mio_helper::load('classes/walker-comment.php');

/*** HairsPress ***/
Mio_helper::load('hairspress/acf.php');
Mio_helper::load('hairspress/acf-page.php');
Mio_helper::load('hairspress/admin.php');
Mio_helper::load('hairspress/dashboard.php');
Mio_helper::load('hairspress/options.php');
Mio_helper::load('hairspress/query.php');
// Mio_helper::load('hairspress/page-setup.php');
Mio_helper::load('hairspress/social.php');

/*** Options ***/
Mio_Helper::load('options/google.php');
Mio_Helper::load('options/googlemap.php');

/*** WordPress用関数群の呼び出し ***/
Mio_helper::load('functions/pagination.php');
Mio_helper::load('functions/demo-mode.php');

require(TEMPLATEPATH.'/_inc/ogp.php');

// 設定権限がないユーザーにはACFを非表示にする
add_filter('acf/settings/show_admin', function($show) {
	return current_user_can('manage_options');
});

add_filter('acf/settings/save_json', function($path) {
	$path = get_theme_file_path('acf-json');
	return $path;
});

add_filter('acf/settings/load_json', function($paths) {
	unset($paths[0]);
	$paths[] = get_theme_file_path('acf-json');

	return $paths;
});

// var_dump(HP_Social::view('prefix', 'social', 'option'));

// V3のデータベース更新するためのSQL（仮）
function hp_replace_field() {
	global $wpdb;
	$wpdb->query(
"
UPDATE $wpdb->postmeta
SET meta_key = 'menu_remarks'
WHERE meta_key LIKE '%hp_menu_other_text'
"
	);
	$wpdb->query(
"
UPDATE $wpdb->postmeta
SET meta_key = REPLACE(meta_key, 'hp_menu_', 'menu_')
WHERE meta_key LIKE '%hp_menu_%'
"
	);
	$wpdb->query(
"
UPDATE $wpdb->postmeta
SET meta_key = REPLACE(meta_key, 'menu_price_end', 'max_price'),
meta_key = REPLACE(meta_key, 'menu_price', 'min_price'),
meta_key = REPLACE(meta_key, 'menu_kara', 'kara'),
meta_key = REPLACE(meta_key, 'menu_etc_text', 'description'),
meta_key = REPLACE(meta_key, 'menu_time', 'time'),
meta_key = REPLACE(meta_key, 'menu_name', 'name')
WHERE meta_key LIKE '%menu_%'
"
	);
}
// $count = 0;
// if ($count === 0) {
// 	$count++;
// 	hp_replace_field();
// }
add_filter('acf/fields/google_map/api', function($api) {
	// $api['key'] = 'AIzaSyC2PVeXoLpOd7_52W1NuOsPMSE_UqUpT6A';
	$api['key'] = 'AIzaSyASFdc_0QU2yCvIjXgW8zCj8i2nIG6yk_U';

	return $api;
});


function hp_h($length) {
	if( is_array($length) ) {
		return array_map('hp_h', $length);
	} else {
		return htmlspecialchars($length, ENT_QUOTES, 'UTF-8');
	}
}


// Facebook User Agent
function isFacebook() {
	return in_array($_SERVER['HTTP_USER_AGENT'], array(
		'facebookexternalhit/1.1 (+https://www.facebook.com/externalhit_uatext.php)',
		'facebookexternalhit/1.1 (+http://www.facebook.com/externalhit_uatext.php)',
	));
}



function hp_news_view($check = 'up') {
	$topics_setting = get_option('options_topics_name', 'option');

	if ($topics_setting === $check) {
		get_template_part('top', 'topics');
	}
}



// アイキャッチ画像のタグ出力設定
function mio_get_thumbnail( $thumb_name = 'medium', $thumb_style = null ) {
	global $post;
	$gtdu = get_template_directory_uri();
	$post_type = get_post_type();
	if( $thumb_style !== null ) {
		$style = ' style="'.$thumb_style['style'].'"';
	} else {
		$style = '';
	}
	$image = '';
	if( has_post_thumbnail() ) {
		$image = get_the_post_thumbnail( $post->ID, $thumb_name, $thumb_style );
	} else {
		$files_arr = array(
			'post_parent' => $post->ID,
			'post_type' => 'attachment',
			'post_mime_type' => 'image'
		);
		$files = get_children($files_arr);
		if (!empty($files)){

			$keys = array_keys($files);
			$attach_id = $keys[0];
			$thumb = wp_get_attachment_image_src( $attach_id, $thumb_name );
			$width = ' width="'.$thumb[1].'"';
			$height = ' height="'.$thumb[2].'"';
			$image = '<img src="'.$thumb[0].'"'.$width.$height.' alt="*"'.$style.'>';
		} else {
			// if( is_front_page() ) {
			//   $image = '<img src="'.$gtdu.'/common/images/common/img_no-image_top.png" alt="*">';
			// }
			// if( !is_front_page() && $post_type == 'post' ) {
			//   $image = '<img src="'.$gtdu.'/common/images/common/img_no-image_loop.png" alt="*">';
			// }
			$image = '<span class="not-thumb"></span>';
		}
	}
	echo $image;
}

function mio_get_catalog_thumb( $thumb_name = 'medium', $thumb_style = null ) {
	global $post;

	if( $thumb_style !== null ) {
		$style = ' style="'.$thumb_style['style'].'"';
	} else {
		$style = '';
	}
	if ( has_post_thumbnail() ) {
		the_post_thumbnail( $thumb_name, $thumb_style );
		$image = get_the_post_thumbnail( $post->ID, $thumb_name, $thumb_style );
	} else {
		$images = get_field( 'catalog_photo_style' );
		if ( $images ) {
			$image = $images[0];
			printf(
				'<img src="%1$s" width="%2$s" height="%3$s" %4$s alt="">',
				esc_url( $image['sizes'][$thumb_name] ),
				esc_attr( $image['sizes'][$thumb_name.'-width'] ),
				esc_attr( $image['sizes'][$thumb_name.'-height'] ),
				$style
			);
		} else {
			echo '<span class="not-thumb"></span>';
		}
	}
}


// ページング

//ページネーション
function pagination($pages = '', $range = 2) {
	$range = mio_is_mobile() ? 1 : $range;
	$showitems = ($range * 2)+1;
	global $paged;
	if(empty($paged)) $paged = 1;
	if($pages == '') {
		global $wp_query;
		$pages = $wp_query->max_num_pages;
		if(!$pages) {
			$pages = 1;
		}
	}
	if(1 != $pages) {
		echo "<div class=\"pagination c-fix\">";
		// if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<a href=\"".get_pagenum_link(1)."\">&laquo;</a>";
		if($paged > 1 /*&& $showitems < $pages*/) {
			echo "<a href=\"".get_pagenum_link($paged - 1)."\" class=\"prev\"><i class=\"fa fa-angle-left\"></i><span>前へ</span></a>";
		} else {
			echo "<span class=\"prev not\"><i class=\"fa fa-angle-left\"></i><span>前へ</span></span>";
		}
		for ($i=1; $i <= $pages; $i++) {
			if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems )) {
				echo ($paged == $i)? "<span class=\"current f-aleg_sc\">".$i."</span>":"<a href=\"".get_pagenum_link($i)."\" class=\"inactive f-aleg_sc\" >".$i."</a>";
			}
		}
		if ($paged < $pages /*&& $showitems < $pages*/) {
			echo "<a href=\"".get_pagenum_link($paged + 1)."\" class=\"next\"><span>次へ</span><i class=\"fa fa-angle-right\"></i></a>";
		} else {
			echo "<span class=\"next not\"><span>次へ</span><i class=\"fa fa-angle-right\"></i></span>";
		}
		// if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) echo "<a href=\"".get_pagenum_link($pages)."\">&raquo;</a>";
		echo "</div>\n";
	}
}

/* アーカイブ用 */
function mio_archive_pager() {
	global $wp_query;
	if($wp_query->max_num_pages < 2) return;
	$next = get_next_posts_link('Prev', false);
	$prev = get_previous_posts_link('Next', false);
	$str = '<div id="archive-pager" class="c-fix"><ul class="pager">';
	if($prev) {
		$str .= '<li class="archive-next">'.$prev.'</li>';
	}
	if($next) {
		$str .= '<li class="archive-prev">'.$next.'</li>';
	}
	$str .= '</ul></div>';
	echo $str;
}

/* シングル用 */
function mio_single_pager() {
	// タグを除去してタイトルを文字列だけにする
	$next_str = strip_tags(get_next_post_link('%link', '%title', false));
	// 次ページのリンクを出力する。文字数制限する
	$next = get_next_post_link('%link', mio_get_excerpt($next_str, 12), false);
	// Prevも上記のNextと同じ
	$prev_str = strip_tags(get_previous_post_link('%link', '%title', false));
	$prev = get_previous_post_link('%link', mio_get_excerpt($prev_str, 12), false);
	// タグエリア
	$str = '<div class="single-pager c-fix"><ul class="pager-list">';
	if(get_next_post()) {
		$str .= '<li class="single-next"><span><i class="fa fa-angle-left"></i>'.$next.'</span></li>';
	}
	if(get_previous_post()) {
		$str .= '<li class="single-prev"><span>'.$prev.'<i class="fa fa-angle-right"></i></span></li>';
	}

	$str .= '</ul></div>';
	echo $str;
}

// 文字数制限の関数
function mio_get_excerpt($contents = '', $length = 48, $more = ' ...') {
	// $exec = !empty($exec) ? $exec : null;
	if( empty($contents) )
		return null;
	$substr = mb_strlen($contents) > (int) $length ? mb_substr($contents, 0, (int) $length).$more : $contents;
	return $substr;
}

// get_template_directory_uri()の簡略化
function mio_get_temp_dir() {
	$gtdu = get_template_directory_uri();
	return $gtdu;
}
function mio_the_temp_dir() {
	echo mio_get_temp_dir();
}

// カテゴリーリンク取得関数
// アンカーのみを出力させます。
// get_cat( $separate ); $separate に区切り文字を設定します。初期値 = ", "

function mio_get_cat( $args = array() ) {
	global $post;

	$defaults = array(
		'separate' => ', ',
		'class_name' => '',
		'taxonomy' => 'category'
	);
	$args = wp_parse_args( $args, $defaults );
	$args = (object) $args;
	// $categories = get_the_terms($post->ID, array('category') );
	$categories = wp_get_post_terms($post->ID, $args->taxonomy);
	$category = $categories;

	$separator = $args->separate;
	$class = !empty($args->class_name) ? ' class="'.$class_name.'"' : '';

	$output = null;
	foreach( $category as $cat ) {
		$term_id = $cat->term_id;
		$name = $cat->name;
		// $slug = $cat->slug;
		$taxonomy = $cat->taxonomy;
		// $cat_id = $cat->cat_ID;
		// $cat_name = $cat->cat_name;
		// $parent = $cat->category_parent;
		// タグ生成
		$cat_link = get_term_link( $term_id, $taxonomy );
		$cat_title = $name;
		$output .= '<a href="'.esc_url($cat_link).'" title="'.esc_html($cat_title).'"'.$class.'>'.esc_html($name).'</a>'.$separator;
	}
	if( !empty($output) ) {
		echo trim( $output, $separator );
	} else {
		print_r('カテゴリーの取得に失敗しました');
	}
}
// 親カテゴリのみ取得関数
function mio_get_cat_parent() {
	global $post;
	$categories = get_the_category();
	// var_dump(wp_get_post_terms( $post->ID, 'category', array('orderby' => 'count', 'order' => 'DESC') ));
	$cat = $categories[0];
	$parent_id = $cat->category_parent;
	$parent = $parent_id !== 0 ? get_category($parent_id) : $cat;
	$link = $parent_id !== 0 ? get_term_link($parent->term_id, $parent->taxonomy) : get_term_link($cat->term_id, $cat->taxonomy);
	$name = $parent->name;
	$slug = $parent->slug;

	$output = '<a href="'.esc_url($link).'">'.esc_html($name).'</a>';

	echo $output;
}

// 検索結果の件数・ページ数
function hp_get_search_found() {
	global $wp_query;

	$get_paged = get_query_var('paged');
	$current = $get_paged === 0 || $get_paged === 1 ? 1 : (int) $get_paged;
	$str = '';
	if ( $current > 1 ) {
		$str = '<span class="search-found">(&nbsp;'.$current.'&nbsp;/&nbsp;'.$wp_query->max_num_pages.'&nbsp;ページ中)</span>';
	} else {
		$str = '<span class="search-found">(計&nbsp;'.$current.'&nbsp;ページ)</span>';
	}
	return $str;
}
function hp_the_search_found() {
	echo hp_get_search_found();
}

function hp_search_found() {
	global $wp_query;

	if( is_search() ) {
		$found = $wp_query->found_posts;
		$current_found = $found > 0 ? '<span class="found">'.$found.'件</span>見つかりました。' : '見つかりませんでした。';
		$search_query = get_search_query();
		$search_found = hp_get_search_found();

		$str = '<div class="search-found-wrapper"><div class="left">';
		if( !empty($search_query) ) {
			$str .= '<span class="head">検索結果：</span>「<span class="keyword">'.esc_html($search_query).'</span>」のキーワードで'.$current_found.'</div>'.$search_found.'</div>';
		} else {
			$str .= '<span>検索キーワードが入力されていません。探したいキーワードを入力して検索をしてください。</span></div></div>';
		}

		echo $str;
	}
}

// NEW表示
function hp_new_flag( $args = array() ) {
	$defaults = array(
		'days' => 7,
		'container' => 'span',
		'id' => '',
		'class' => 'new en',
		'before' => '',
		'after' => '',
		'label' => 'NEW'
	);
	$args = wp_parse_args( $args, $defaults );
	$args = (object) $args;

	$days = $args->days > 1 ? $args->days : 7;
	$today = date_i18n('U');
	$entry = get_the_time('U');
	$day_post = date('U', ($today - $entry)) / 86400;

	// コンテナー
	$container = !empty($args->container) ? $args->container : 'span';
	$id = !empty($args->id) ? " id=\"{$args->id}\"" : '';
	$class = !empty($args->class) ? " class=\"{$args->class}\"" : '';
	$label = !empty($args->label) ? $args->label : '';
	if( $days > $day_post ) {
		return '<'.$container.$id.$class.'>'.$args->before.$label.$args->after.'</'.$container.'>';
	}
	return NULL;
}

// モバイル判定関数
function mio_is_mobile() {
	$useragents = array(
		'iPhone',          // iPhone
		'iPod',            // iPod touch
		'Android',         // 1.5+ Android
		'dream',           // Pre 1.5 Android
		'CUPCAKE',         // 1.5+ Android
		'blackberry9500',  // Storm
		'blackberry9530',  // Storm
		'blackberry9520',  // Storm v2
		'blackberry9550',  // Storm v2
		'blackberry9800',  // Torch
		'webOS',           // Palm Pre Experimental
		'incognito',       // Other iPhone browser
		'webmate'          // Other iPhone browser
	);
	$pattern = '/'.implode('|', $useragents).'/i';
	return preg_match($pattern, $_SERVER['HTTP_USER_AGENT']);
}

// BOT判定関数
function isBot() {
	$bot_list = array(
		'Googlebot',
		'Yahoo! Slurp',
		'Mediapartners-Google',
		'msnbot',
		'bingbot',
		'MJ12bot',
		'Ezooms',
		'pirst; MSIE 8.0;',
		'Google Web Preview',
		'ia_archiver',
		'Sogou web spider',
		'Googlebot-Mobile',
		'AhrefsBot',
		'YandexBot',
		'Purebot',
		'Baiduspider',
		'UnwindFetchor',
		'TweetmemeBot',
		'MetaURI',
		'PaperLiBot',
		'Showyoubot',
		'JS-Kit',
		'PostRank',
		'Crowsnest',
		'PycURL',
		'bitlybot',
		'Hatena',
		'facebookexternalhit',
		'NINJA bot',
		'YahooCacheSystem',
	);

	$is_bot = false;
	foreach ($bot_list as $bot) {
		if (stripos($_SERVER['HTTP_USER_AGENT'], $bot) !== false) {
			$is_bot = true;
			break;
		}
	}
	return $is_bot;
}

// アクセス数集計
function get_post_views( $postID ) {
	$count_key = 'post_views_count';
	$count = get_post_meta( $postID, $count_key, true );
	if( $count == '' ) {
		delete_post_meta( $postID, $count_key );
		add_post_meta( $postID, $count_key, '0' );
		return "0 views";
	}
	return $count . '';
}
function set_post_views( $postID ) {
	$count_key = 'post_views_count';
	$count = get_post_meta( $postID, $count_key, true );
	if( $count == '' ) {
		$count = 0;
		delete_post_meta( $postID, $count_key );
		add_post_meta( $postID, $count_key, '0' );
	} else {
		$count ++;
		update_post_meta( $postID, $count_key, $count );
	}
}

function head_set_array()
{
	return array();
}

function head_strpos($str, $arr = array())
{
	if (empty($arr))
		return false;

	foreach ($arr as $v)
	{
		if (strpos($v, $str) !== false)
		{
			return true;
		}
	}

	return false;
}

function head_attr($args = array())
{
	if ( ! empty($args))
	{
		foreach ($args as $k => $v)
		{
			if ( ! is_numeric($k) or head_strpos($k, head_set_array()))
			{
				$attr[] = $k.'="'.$v.'"';
			}
		}
	}

	if (isset($attr))
		return implode(' ', $attr);
}

function head_ogp($args = array())
{
	if (empty($args))
		return '<head>'."\n";

	return sprintf(
		'<head %1$s>'."\n",
		head_attr($args)
	);
}

// HairsPressで作成した関数群
require_once (TEMPLATEPATH . '/_inc/hairspress-functions.php');

// HairsPress Options
require_once (TEMPLATEPATH . '/_inc/hp-options-theme.php');


// Mio-Theme MetaField
require_once (TEMPLATEPATH . '/_inc/hp-custom-meta-seo.php');

//カスタムエディター
require_once (TEMPLATEPATH . '/_inc/hp-custom-editor.php');

//カスタム投稿タイプ
require_once (TEMPLATEPATH . '/_inc/hp-custom-posts.php');

//Topics Option
require_once (TEMPLATEPATH . '/_inc/hp-options-topics.php');

//Instagram Option
// require_once (TEMPLATEPATH . '/_inc/hp-options-instagram.php');

//パンくずリスト
require_once (TEMPLATEPATH . '/_inc/hp-function-breadcrumbs.php');

//ヘアカタログで使用するの関数群
require_once (TEMPLATEPATH . '/_inc/hp-function-catalog.php');

// HairsPress Instagram
// require_once (TEMPLATEPATH . '/_inc/hp-function-instagram.php');

// HairsPress Slider
require_once (TEMPLATEPATH . '/_inc/hp-function-slider.php');

// AdvancedCustomField オプションページ生成
// require_once (TEMPLATEPATH . '/_inc/acf-setup-add-options-page.php');


// WEB予約のリンクまたはURLをだす関数
require_once (TEMPLATEPATH . '/_option/opt-shop-setting.php');

function search_result_url_change() {
	if (is_search() and ! empty($_GET['s'])) {
		wp_safe_redirect(esc_url_raw(home_url('search/'.get_search_query())));
		exit();
	}
}
// add_action('template_redirect', 'search_result_url_change');
add_filter('search_rewrite_rules', '__return_empty_array');

// add_filter('wp_nav_menu_objects', function($items, $args) {
// 	var_dump($items);
// 	foreach ($items as &$item) {
// 		$en = get_field('navi_en', $item);
// 		if ($en) {
// 			$item->title .= $en;
// 		}
// 	}

// 	return $items;
// }, 10, 2);

add_filter('hp_nav_menu_title', function($title, $item) {
	$navi_en = get_field('navi_en', $item);
	$ja = sprintf(
		'<span class="ja %2$s">%1$s</span>',
		$title,
		empty($navi_en) ? 'not-en' : ''
	);
	if ($navi_en) {
		$ja .= '<span class="en">'.$navi_en.'</span>';
	}

	$title = $ja;

	return $title;
}, 10, 2);