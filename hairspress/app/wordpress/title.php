<?php
namespace Hairspress\App;


class Wordpress_Title
{
	public function __construct()
	{
		add_filter('document_title_parts', array($this, 'title_parts'));
		add_filter('document_title_separator', array($this, 'title_separator'));
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
