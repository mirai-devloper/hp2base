<?php
namespace Hairspress\App;

use Hairspress\Core\View;

/**
 * 投稿パスワードのカスタマイズ
 */
class Wordpress_Post_Password
{
	public function __construct()
	{
		add_filter('the_password_form', array($this, 'the_password_form'));
		add_filter('protected_title_format', array($this, 'protected_title_format'));
	}

	/**
	 * Post password form
	 * 投稿のパスワードフォーム
	 */
	public function the_password_form()
	{
		global $post;
		$label  = 'pwbox-'.$post->ID;
		$form = View::forge('blog/password-form', array('label' => $label));

		return $form;
	}

	/**
	 * パスワード制限付きの投稿のタイトルを変更する
	 */
	public function protected_title_format($title)
	{
		return '<span class="locked">[保護中]</span>%s';
	}
}