<?php
/**
 * Googleアナリティクスなどのパーツ
 */

new HP_Google;

class HP_Google extends HP_Acf
{
	public function __construct()
	{

	}

	// Google Search Console
	public static function console()
	{
		if ($console = parent::get('hp_search_console', 'option'))
		{
			$allow_html = [
				'meta' => [
					'name' => [],
					'content' => [],
				],
			];
			return wp_kses($console, $allow_html).PHP_EOL;
		}
	}

	// トラッキングコード
	public static function tracking_code()
	{
		if (
			$tracking_code = parent::get('hp_google_analytics', 'option')
			and ! is_user_logged_in()
		)
			if (preg_match('/^[a-z|A-Z]+[-]+[0-9]+[-]+[0-9]{1,}$/', $tracking_code))
				return $tracking_code;

		return null;
	}
}
