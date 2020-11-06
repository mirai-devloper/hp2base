<?php
// Bootstrap Pagination
if ( ! function_exists('bootstrap_pagination'))
{
	function bootstrap_pagination($echo = true)
	{
		global $wp_query;

		$pagination = paginate_links(array(
			'current' => max(1, get_query_var('paged')),
			'total' => $wp_query->max_num_pages,
			// 'show_all' => true,
			'end_size' => 0,
			'mid_size' => (wp_is_mobile() ? 0 : 2),
			'prev_text' => '前へ',
			'next_text' => '次へ',
			'type' => 'array',
		));

		if ( ! empty($pagination))
		{
			$str = '<ul class="pagination">';
			foreach ($pagination as $k => $v)
			{
				$str .= sprintf(
					'<li%1$s>%2$s</li>',
					( (strpos($v, 'current') !== false) ? ' class="active"' : '' ),
					$v
				);
			}
			$str .= '</ul>';

			if ((bool) $echo)
			{
				echo $str;
			}

			return $str;
		}
	}
}

/*
 * コメントのページネーションを独自のものへ変更
 * 見た目の並び順を逆順にしています。
 * Bootstrapに合わせて作成済み
 */
if ( ! function_exists('comment_pagination'))
{
	function comment_pagination($args = array())
	{
		global $wp_rewrite;

		if ( ! is_singular())
			return;

		$page = get_query_var('cpage');
		if ( ! $page)
			$page = 1;

		$max_page = get_comment_pages_count();
		$defaults = array(
			'base' => add_query_arg('cpage', '%#%'),
			'format' => '',
			'total' => $max_page,
			'current' => $page,
			'add_fragment' => '#comments',
			'prev_text' => '前へ',
			'next_text' => '次へ',
			'end_size' => 0,
			'mid_size' => (wp_is_mobile() ? 0 : 2),
		);

		if ($wp_rewrite->using_permalinks())
			$default['base'] = user_trailingslashit(trailingslashit(get_permalink()).$wp_rewrite->comments_pagination_base.'-%#%', 'commentpaged');

		$args = wp_parse_args($args, $defaults);
		$args['echo'] = false;
		$args['type'] = 'array';

		$page_links = paginate_links($args);

		if ( ! empty($page_links))
		{
			$str = '<ul class="pagination">';

			foreach ($page_links as $k => $v)
			{
				$str .= sprintf(
					'<li%1$s>%2$s</li>',
					( (strpos($v, 'current') !== false) ? ' class="active"' : '' ),
					// ! empty($match) ? $str_replace : $v
					$v
				);
			}
			$str .= '</ul>';

			echo $str;
		}
	}
}
