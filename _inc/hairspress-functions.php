<?php
// function implode_assoc($inline, $outline, $array)
// {
// 	$output = array();

// 	foreach ($array as $key => $val)
// 	{
// 		$output[] = $key.$inline.'"'.$val.'"';
// 	}

// 	return implode($outline, $output);
// }
/*
カスタムメニューのカスタム投稿タイプのカレント表示に対応させる
（固定ページと投稿タイプのスラッグを同じ設定にし固定ページからメニューを設定している場合）
*/
function hp_nav_menu($args = array() ) {
	$defaults = array(
		'theme_location' => 'primary-menu',
		'ul_class' => '',
		'echo' => 1
	);

	$args = wp_parse_args( $args, $defaults );
	$args = (object) $args;

	// メニュー絡みを取得
	$nav_menu_id = get_nav_menu_locations($args->theme_location);
	if ($nav_menu_id)
		$menu = wp_get_nav_menu_object( $nav_menu_id[$args->theme_location] );

	if (isset($menu))
		$menu_items = wp_get_nav_menu_items( $menu->term_id );

	if(isset($menu_items)) {
		// オブジェクトIDを取得
		$get_obj = get_queried_object_id();

		// ULタグのクラス
		$ul_attr = array();

		if ( ! empty($args->ul_class))
			$ul_attr['class'] = esc_attr($args->ul_class);

		// リストを格納させる空変数
		$li = array();
		foreach( $menu_items as $item ) {
			$attrs = array();

			if ($item->url)
			{
				$attrs['href'] = esc_url($item->url);
			}

			if ($item->attr_title)
			{
				$attrs['title'] = wp_strip_all_tags($item->attr_title);
			}

			if ($item->target)
			{
				$attrs['target'] = $item->target;
			}

			$attr = implode_assoc('=', ' ', $attrs);

			// 表示テキスト
			$title = wp_strip_all_tags($item->title, true);

			$obj_id = (int) $item->object_id;

			$page_for_posts = get_option('page_for_posts');

			if ($item->type === 'post_type_archive')
			{
				if ($item->object === get_post_type())
				{
					$current = true;
				}
				else
				{
					$current = false;
				}
			}
			else if ($item->object === 'freepage')
			{
				if ((int) $item->object_id === $get_obj)
				{
					$current = true;
				}
				else
				{
					$current = false;
				}
			}
			else if ($item->type === 'post_type')
			{
				if ((int) $item->object_id === $get_obj)
				{
					$current = true;
				}
				else if (get_post_type() === 'post' and $item->object_id === $page_for_posts)
				{
					$current = true;
				}
				else if (get_post_type() === 'channel' and strpos($item->url, 'channel') !== false)
				{
					$current = true;
				}
				else
				{
					$current = false;
				}
			}
			else
			{
				if (strpos($item->url, get_post_type()) !== false)
				{
					$current = true;
				}
				else
				{
					$current = false;
				}
			}


			// カレントクラスを表示
			if ($current)
			{
				$li_attr['class'] = 'current-menu-item';
			}
			else
			{
				$li_attr['class'] = '';
			}

			// リストタグ
			$li[] = sprintf(
				'<li %1$s><a %2$s>%3$s</a></li>',
				implode_assoc('=', ' ', $li_attr),
				$attr,
				apply_filters('hp_nav_menu_title', $title, $item)
			);
		}
		if (empty($li))
		{
			$li = array('<li>メニューがありません</li>');
		}

		$str = sprintf(
			'<ul %1$s>%2$s</ul>',
			implode_assoc('=', ' ', $ul_attr),
			implode($li)
		);

		if( $args->echo !== 1 ) {
			return $str;
		}

		echo $str;
	}
}

// カテゴリー出力
function hp_the_cat( $args = array() ) {
	global $post;
	$defaults = array(
		'separate' => ', ',
		'container' => 'p',
		'container_class' => 'cat',
		'container_before' => '',
		'container_after' => '',
		'link_class' => '',
		'taxonomy' => 'category',
		'echo' => true
	);
	$args = wp_parse_args( $args, $defaults );
	$args = (object) $args;

	$taxonomy_name = !empty($args->taxonomy) ? $args->taxonomy : 'category';
	$terms = get_the_terms( $post->ID, $taxonomy_name );
	$output = null;
	if( !empty($terms) ) {
		if( !empty($args->container) ) {
			$container_class = !empty($args->container_class) ? ' class="'.esc_attr($args->container_class).'"' : '';
			$output .= '<'.$args->container.$container_class.'>';
		}
		if( !empty($args->container_before) ) {
			$output .= $args->container_before;
		}
		foreach( (array) $terms as $term ) {
			$separate = !empty($args->separate) ? $args->separate : '';
			if( !empty($output) ) {
				$output .= $separate;
			}

			$link = get_term_link($term);
			$name = $term->name;

			$link_class = !empty($args->link_class) ? ' class="'.$esc_attr($args->link_class).'"' : '';
			$output .= '<a href="'.esc_url($link).'"'.$link_class.'>'.esc_html($name).'</a>';
		}
		if( !empty($args->container) ) {
			$output .= '</'.$args->container.'>';
		}
	}
	if( $args->echo ) {
		echo $output;
	} else {
		return $output;
	}
}

function hp_cat_parent( $args = array() ) {
	global $post;

	$defaults = array(
		'container' => 'p',
		'container_class' => 'cat',
		'taxonomy' => 'category',
		'echo' => true,
		'anchor' => true
	);

	$args = wp_parse_args( $args, $defaults );
	$args = (object) $args;

	$taxonomy_name = !empty($args->taxonomy) ? $args->taxonomy : 'category';
	$terms = get_the_terms($post->ID, $taxonomy_name);

	if( !empty($terms) ) {
		$term = (object) $terms[0];
		$link = get_term_link($term);
		$name = $term->name;

		$output = '';
		if( !empty($args->container) ) {
			$container_class = !empty($args->container_class) ? ' class="'.$args->container_class.'"' : '';
			$output = '<'.$args->container.$container_class.'>';
		}

		$anchor = array();
		if( is_bool($args->anchor) && $args->anchor ) {
			$anchor += array('<a href="'.esc_url($link).'">', '</a>');
		}

		if( !empty($anchor) ) {
			$output .= $anchor[0].esc_html($name).$anchor[1];
		} else {
			$output .= esc_html($name);
		}

		if( !empty($args->container) ) {
			$output .= '</'.$args->container.'>';
		}
		if( is_bool($args->echo) && $args->echo ) {
			echo $output;
			return;
		}
		return $output;
	}
}


// カスタム投稿用のアーカイブリンク処理
// サイドバー向け
global $my_archives_post_type;

function my_getarchives_where( $where, $r ) {
	global $my_archives_post_type;
	if( isset( $r['post_type']) ) {
		$my_archives_post_type = $r['post_type'];
		$where = str_replace('\'post\'', '\'' . $r['post_type'] . '\'', $where);
	} else {
		$my_archives_post_type = '';
	}
	return $where;
}
add_filter('getarchives_where', 'my_getarchives_where', 10, 2);

function my_get_archives_link( $link_html ) {
	global $my_archives_post_type;
	if( $my_archives_post_type !== '' && $my_archives_post_type !== 'post' ) {
		$patterns = array ('/(blog)/', '/(\/details\/)/');
		$replace = array ($my_archives_post_type, '/');
		$link_html = preg_replace($patterns, $replace, $link_html);
	}
	// if( $my_archives_post_type != '' ) {
	//   $add_link = '?post_type='.$my_archives_post_type;
	//   $link_html = preg_replace("/href='(.+)'/", "href='$1".$add_link."'", $link_html);
	// }
	return $link_html;
}
add_filter('get_archives_link', 'my_get_archives_link');

function mio_get_archives_list( $post_type = '', $show_count = 1) {
	$args = array(
		'type' => 'monthly',
		'post_type' => $post_type,
		'show_post_count' => $show_count,
		'format' => 'custom',
		'after' => '|',
		'echo' => 0
	);
	$html = wp_get_archives($args);
	$arr = explode("|", $html);
	array_pop($arr);

	$array_archives = array();

	foreach( $arr as $key => $val ) {
		$year = substr( trim( strip_tags( $val ) ), 0, 4);
		$abc = array();
		for( $i = 0; $i < count($arr); $i++ ) {
			if( strstr($arr[$i], $year.'年') ) {
				$abc[] = $arr[$i];
			}
		}
		$array_archives += array(
			$year => $abc
		);
	}
	$result = '';
	foreach( $array_archives as $keys => $vals ) {
		$result .= '<li>';
		$result .= '<button class="tgl"><span>'.$keys.'年<i class="fa fa-angle-down"></i></span></button>';
		$result .= '<ul class="tgl_child">';
		for( $linked = 0; $linked < count($vals); $linked++ ) {
			$result .= '<li>'.$vals[$linked].'</li>';
		}
		$result .= '</ul>';
		$result .= '</li>';
	}
	return $result;
}
function mio_the_archives_list( $type ) {
	echo mio_get_archives_list( $type );
}

// シングルページのページャー
function hp_single_pager( $args = array() ) {
	$defaults = array(
		'next' => '前の記事へ',
		'prev' => '次の記事へ',
		'container' => 'div',
		'container_class' => 'single-pager',
		'next_before' => '<i class="fa fa-angle-left"></i>',
		'next_after' => '',
		'prev_before' => '',
		'prev_after' => '<i class="fa fa-angle-right"></i>',
		'echo' => true
	);
	$args = wp_parse_args( $args, $defaults );
	$args = (object) $args;

	$next_text = $args->next_before.$args->next.$args->next_after;
	$prev_text = $args->prev_before.$args->prev.$args->prev_after;
	$next = get_next_post_link('%link', $next_text);
	$prev = get_previous_post_link('%link', $prev_text);

	$output = '';
	if( !empty($args->container) ) {
		$container_class = !empty($args->container_class) ? ' class="'.$args->container_class.'"' : '';
		$output = '<'.$args->container.$container_class.'>';
	}

	$output .= '<div class="next">'.$next.'</div>';
	$output .= '<div class="prev">'.$prev.'</div>';

	if( !empty($args->container) ) {
		$output .= '</'.$args->container.'>';
	}

	if( is_bool($args->echo) && $args->echo ) {
		echo $output;
		return;
	}
	return $output;
}
