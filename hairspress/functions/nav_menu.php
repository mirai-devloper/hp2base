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

class Hairspress_Nav_Menus {
	private $menu_items;
	private $object;
	private $object_id;

	public function __construct($theme_location)
	{
		$locations = get_nav_menu_locations($theme_location);
		if ($locations) {
			$nav_menu_object = wp_get_nav_menu_object($locations[$theme_location]);
		}

		if (!$this->menu_items) {
			if (isset($nav_menu_object) and $nav_menu_object) {
				$this->menu_items = wp_get_nav_menu_items($nav_menu_object->term_id);
			}
		}
		if ($this->menu_items) {
			$this->object = get_queried_object();
			$this->object_id = get_queried_object_id();
			$this->page_for_posts = get_option('page_for_posts');
		}
	}

	public function menu_list($args = array()) {
		if (!$this->menu_items) return;

		$defaults = array(
			'ul_class' => array()
		);
		$args = wp_parse_args($args, $defaults);

		$li = array();
		$post_type = get_query_var('post_type');
		if (get_post_type()) {
			$post_type = get_post_type();
		}
		foreach ($this->menu_items as $item) {
			$li_attr = array();
			$attr = array();
			if ($item->url) {
				$attr['href'] = esc_url($item->url);
			}
			if ($item->attr_title) {
				$attr['title'] = esc_attr($item->attr_title);
			}
			if (!empty($item->target)) {
				$attr['target'] = $item->target;
			}

			$title = $item->title;
			$current = false;

			if ($item->type === 'post_type_archive') {
				if ($item->object === $post_type) {
					$current = true;
				}
			} elseif ($item->type === 'post_type') {
				if ($item->object === 'page') {
					if ((int) $item->object_id === (int) $this->object_id) {
						$current = true;
					} elseif ((int) $item->object_id === (int) $this->page_for_posts) {
						if ($post_type === 'post') {
							$current = true;
						}
					}
				} elseif ($item->object === 'freepage') {
					if ((int) $item->object_id === (int) $this->object_id) {
						$current = true;
					}
				}
			}

			$li_attr['class'] = '';
			if ($current) {
				$li_attr['class'] = 'current-menu-item';
			}

			$tag_a = html_tag('a', $attr, apply_filters('hp_nav_menu_title', $title, $item));

			$li[] = html_tag('li', $li_attr, $tag_a);
		}

		if ($li) {
			return html_tag('ul', $args['ul_class'], implode($li));
		}

		return null;
	}
}

global $hp_nav_menu;
add_action('get_header', function() {
	global $hp_nav_menu;
	if (!is_admin() and !$hp_nav_menu) {
		$hp_nav_menu = new Hairspress_Nav_Menus('primary-menu');
	}
});
