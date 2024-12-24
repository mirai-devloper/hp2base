<?php

include_once(ABSPATH.'wp-admin/includes/plugin.php');
if (!is_plugin_active('advanced-custom-fields-pro/acf.php')) {
  define('HP_ACF_PATH', get_theme_file_path('includes/acf/'));
  define('HP_ACF_URL', get_theme_file_uri('includes/acf/'));

  include_once(HP_ACF_PATH.'acf.php');

  add_filter('acf/settings/url', function($url) {
    return HP_ACF_URL;
  });

  add_filter('acf/settings/show_admin', function($show_admin) {
    return false;
  });
}

add_filter('acf/settings/save_json', function($path) {
  $path = get_theme_file_path('acf-json');
  return $path;
});

add_filter('acf/settings/load_json', function($paths) {
  unset($paths[0]);
  $paths[] = get_theme_file_path('acf-json');

  return $paths;
});

function getMapToken() {
  $response = get_transient('hp2base_maptoken');
  if (false === $response or empty($response)) {
    $context = stream_context_create(
      array(
        'ssl' => array(
          'verify_peer' => false,
          'verify_peer_name' => false,
        )
      )
    );
    $response = file_get_contents('https://hairspress.com/hp2map.txt', false, $context);
    set_transient('hp2base_maptoken', $response, 24 * HOUR_IN_SECONDS);
  }
  return $response;
}
add_filter('acf/fields/google_map/api', function($api) {
  if ($token = getMapToken() and $token) {
    $api['key'] = $token;
  }

  return $api;
});



$content_width = 720;

add_filter('admin_body_class', function($classes) {
  global $post;
  if (isset($post->ID)) {
    $page_template = get_page_template_slug($post->ID);
    if ($page_template === 'full-width-page.php') {
      return "$classes pfw full-width-page";
    }
  }
  return $classes;
});
add_action('enqueue_block_editor_assets', function() {
  wp_enqueue_style('hairspress-block-editor', get_theme_file_uri('assets/css/block-editor.css'), false, '1', 'all');
});


add_action('wp_head', function() {
  global $post;

  if ($head_tag = get_field('head_tag', 'option') and $head_tag) {
    echo $head_tag;
  }

  if ($page_head_tag = get_field('page_head_tag', $post->ID) and $page_head_tag) {
    echo $page_head_tag;
  }

});

add_filter('the_content', function($content) {
  global $post;
  if ($page_content_tag = get_field('page_content_tag', $post->ID) and $page_content_tag) {
    $content .= $page_content_tag;
  }
  return $content;
});


define('ENV_MODE', getenv('ENV_MODE'));
define('WP_ENV', getenv('WP_ENV'));

define('HP_DOCROOT', __DIR__.DIRECTORY_SEPARATOR);

define('HP_BASEDIR', '/');
define('HP_PATH', realpath(__DIR__.'/hairspress/').DIRECTORY_SEPARATOR);
define('HP_COREPATH', realpath(__DIR__.'/hairspress/core/').DIRECTORY_SEPARATOR);
define('HP_APPPATH', realpath(__DIR__.'/hairspress/app/').DIRECTORY_SEPARATOR);
define('HP_VIEWPATH', realpath(__DIR__.'/hairspress/views/').DIRECTORY_SEPARATOR);

require HP_PATH.'autoloader.php';
class_alias('Hairspress\\Core\\Autoloader', 'Autoloader');

require_once(HP_DOCROOT.'hairspress/bootstrap.php');

function getHp2BaseToken() {
  $response = get_transient('hp2base_token');
  if (false === $response or empty($response)) {
    $context = stream_context_create(
      array(
        'ssl' => array(
          'verify_peer' => false,
          'verify_peer_name' => false,
        )
      )
    );
    $response = file_get_contents('https://hairspress.com/hp2base.txt', false, $context);
    set_transient('hp2base_token', $response, 24 * HOUR_IN_SECONDS);
  }
  return $response;
}
if (is_admin() or wp_doing_ajax() or wp_doing_cron()) {
  require 'plugin-update-checker/plugin-update-checker.php';
  if ($token = getHp2BaseToken() and $token) {
    $hp2baseUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
      // 'https://github.com/nullpon16tera/hp2base',
      'https://github.com/mirai-devloper/hp2base',
      __FILE__,
      'hp2base'
    );
    $hp2baseUpdateChecker->setAuthentication($token);
    $hp2baseUpdateChecker->getVcsApi()->enableReleaseAssets();
  }
}




add_action('do_faviconico', function() {
  if ($icon = get_site_icon_url(512, get_theme_file_uri('favicon.png'))) {
    wp_redirect($icon);
  } else {
    header('Content-Type: image/vnd.microsoft.icon');
  }
  exit;
});

add_filter('ssp_output_description', function ($ssp_description) {
  if ($ssp_description == get_bloginfo('description')) {
      return "";
  }
  return $ssp_description;
});

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

// アイキャッチ画像のタグ出力設定
function mio_get_thumbnail( $thumb_name = 'medium', $thumb_style = null ) {
  global $post;

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
      $image = wp_get_attachment_image( $attach_id, $thumb_name );
    } else {
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
  } else {
    if ( $images = get_field( 'catalog_photo_style' ) ) {
      $image = $images[0];
      echo wp_get_attachment_image($image['ID'], $thumb_name, false, $thumb_style);
      // printf(
      // 	'<img src="%1$s" width="%2$s" height="%3$s" %4$s alt="">',
      // 	esc_url( $image['sizes'][$thumb_name] ),
      // 	esc_attr( $image['sizes'][$thumb_name.'-width'] ),
      // 	esc_attr( $image['sizes'][$thumb_name.'-height'] ),
      // 	$style
      // );
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
    echo \View::forge('elements/pager', array(
      'pages' => $pages,
      'paged' => $paged,
      'range' => $range,
      'showitems' => $showitems
    ));
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


add_action('welcome_panel', function() {
  echo Hairspress\Core\View::forge('welcome');
});

