<?php
/**
 * Googleアナリティクスなどのパーツ
 */

class HP_Google
{
	public function __construct()
	{
		// dummy
	}

	// Google Search Console
	public static function console()
	{
		global $wphp;
		if ($console = $wphp->hp_search_console and $console)
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
		global $wphp;
		if (
			$tracking_code = $wphp->hp_google_analytics
			and ! is_user_logged_in()
		)
			if (preg_match('/^[a-z|A-Z]+[-]+[0-9]+[-]+[0-9]{1,}$/', $tracking_code))
				return $tracking_code;

		return null;
	}
}
