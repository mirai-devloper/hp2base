<?php
/**
 * タイトルタグの出力を変更する
 */
new Mio_Wp_Title;

class Mio_Wp_Title
{
	public function __construct()
	{
		// add_filter('pre_get_document_title', array($this, 'title_tag'));
		add_filter('document_title_parts', array($this, 'title_parts'));
		add_filter('document_title_separator', array($this, 'title_separator'));
	}

	public static function get($option, $default = false)
	{
		return get_option($option, $default);
	}

	/**
	 * タイトルの出力を変更
	 */
	public function title_tag($title)
	{
		$blog_name = get_bloginfo('name');
		if (self::get('show_on_front') == 'page')
		{
			if ($page_on_front = self::get('page_on_front') and is_front_page())
			{
				// get_the_title($page_on_front)
				$title = get_the_title($page_on_front);
			}
			elseif ($page_for_posts = self::get('page_for_posts') and is_home())
			{
				$title = get_the_title($page_for_posts);
			}
		}

		return $title.' | '.$blog_name;
	}

	// タイトルのセパレート
	public function title_separator($sep)
	{
		return '|';
	}

	// タイトルを部分的に変更
	public function title_parts($title)
	{
		if (is_404())
		{
			$title['title'] = 'ページを見つけることができませんでした';
		}
		elseif (is_search())
		{
			$title['title'] = sprintf(
				'検索結果：『%1$s』',
				get_search_query()
			);
		}
		elseif (is_singular() and ! is_page())
		{
			$obj = get_queried_object();
			if ($post_obj = get_post_type_object($obj->post_type))
			{
				$title['site'] = $post_obj->labels->name == '投稿' ? 'ブログ' : $post_obj->labels->name;
				$title['sitename'] = get_bloginfo('name', 'display');
			}
		}
		elseif (is_front_page())
		{
			$title['title'] = get_bloginfo('description');
			$title['tagline'] = get_bloginfo('name');
		}

		return $title;
	}
}
