<?php
namespace Hairspress\App;

class Wordpress_Query
{
	public function __construct()
	{
		add_action('pre_get_posts', array($this, 'posts_per_page'));
	}

	public function posts_per_page($query)
	{
		if (is_admin() OR ! $query->is_main_query())
			return;

		// チャンネル
		if ($query->is_post_type_archive('channel') OR $query->is_tax('channel_category'))
		{
			$query->set('posts_per_page', 6);
			return;
		}


		// カタログ
		if ($query->is_post_type_archive('catalog') OR $query->is_post_type_archive('staff'))
		{
			$query->set('posts_per_page', 12);
			return;
		}

		// タクソノミー
		if (
			$query->is_tax('com_category')
			OR $query->is_tax('manage')
			OR $query->is_tax('hair_style')
			OR $query->is_tax('catalog_tag')
			OR $query->is_tax('catalog_length')
		)
		{
			$query->set('posts_per_page', 12);
			return;
		}

		// お知らせ
		if ($query->is_post_type_archive('topics'))
		{
			$query->set('orderby', 'date');
			$query->set('order', 'DESC');
			return;
		}
	}
}
