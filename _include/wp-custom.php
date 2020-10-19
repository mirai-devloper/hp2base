<?php

new WP_Mio_Custom;

class WP_Mio_Custom
{
	public function __construct()
	{
		// wp_nav_menu li class filter
		// add_filter('nav_menu_css_class', array($this, 'remove_nav_menu_class'), 100, 1);
		// add_filter('nav_menu_item_id', array($this, 'remove_nav_menu_class'), 100, 1);
		// add_filter('page_css_class', array($this, 'remove_nav_menu_class'), 100, 1);

		// 投稿制限のパスワードフォーム
		// add_filter('the_password_form', array($this, 'post_passwd_form'));
		// add_filter('protected_title_format', array($this, 'protected_title'));

		// More Jump
		// add_filter('the_content_more_link', array($this, 'remove_more_jump'));
		// add_filter('the_content_more_link', array($this, 'more_class'));

		// Comment Text Escape
		// add_filter('get_comment_text', array($this, 'esc_comment'), 9);
		// add_filter('get_comment_text', 'make_clickable');
	}

	public function remove_nav_menu_class($var)
	{
		return is_array($var) ? array_intersect($var, array('current-menu-item')) : '';
	}

	public function post_passwd_form()
	{
		$post_id = get_the_ID();
		$label = 'pwbox-'.(empty($post_id) ? rand() : $post_id);
		$text = sprintf(
			'<p>%1$s</p>',
			'こちらのコンテンツはパスワードが必要です。<br>パスワードを入力してください。'
		);

		$form = '<form action="'.esc_url(site_url('wp-login.php?action=postpass', 'login_post')).'" method="post" class="post-password-form form-inline"><div class="form-group"><label for="'.$label.'" class="sr-only">パスワード</label><div class="input-group"><div class="input-group-addon">パスワード</div><input type="password" name="post_password" id="'.$label.'" class="form-control" size="20" placeholder="パスワードを入力" /></div></div><div style="display: inline-block;"><button type="submit" name="Submit" class="btn btn-theme">送信</button></div></form>';
		return $text.$form;
	}

	public function protected_title($title)
	{
		// FontAwesome使用してます
		return '<span class="locked">&#xf023;</span>%s';
	}

	/*
	 * More Anchor
	 *
	 * @param $link string
	 */
	public function remove_more_jump($link)
	{
		$offset = strpos($link, '#more-');
		if ($offset)
		{
			$end = strpos($link, '"', $offset);
		}

		if ($end)
		{
			$link = substr_replace($link, '', $offset, $end-$offset);
		}

		return $link;
	}

	// More class="more-link" replace
	public function more_class($link)
	{
		$link = str_replace('more-link', 'btn btn-theme btn-sm', $link);

		return $link;
	}

	// Comment Text Escape
	public function esc_comment($comment)
	{
		$args = array(
			'a' => array(
				'href' => array(),
				'title' => array(),
				'target' => array(),
			),
			'em' => array(),
			'strong' => array(),
			'hr' => array(),
			'br' => array(),
		);
		if (get_comment_type() == 'comment')
			$comment = wp_kses( $comment, $args );

		return $comment;
	}
}
