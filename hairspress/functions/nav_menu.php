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