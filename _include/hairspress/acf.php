<?php
/**
 * ACFを使った関数
 */
new HP_Acf;

class HP_Acf
{
	public function __construct()
	{
		// 管理者以外はカスタムフィールドのメニューを非表示
		if ( ! current_user_can('manage_options'))
			add_filter('acf/settings/show_admin', '__return_false');
	}

	/**
	 * ACFのget_fieldの短縮系、また関数があるかチェック
	 */
	public static function get($field, $id = 0)
	{
		if ( ! function_exists('get_field'))
			return null;

		return get_field($field, $id);
	}

	/**
	 * フッターのコピーライト
	 */
	public static function copyright()
	{
		if ($copyright = self::get('hp_salon_name', 'option'))
		{
			return $copyright;
		}
		else
		{
			return 'HairsPress';
		}
	}

	// 予約URL
	public static function reserve_url()
	{
		$system = self::get('hp_webreserve_system', 'option');
		$reservia = self::get('hp_salon_reservia', 'option');
		if (
			$system == 'reservia'
			and ! empty($reservia)
			and ctype_digit($reservia)
		)
		{
			// return 'https://cs.appnt.me/shops/'.$reservia.'/reserve';
			return esc_url('https://reservia.jp/shop/reserve/'.$reservia);
		}
		else if (
			$system == 'other'
			and $url = self::get('hp_salon_reserved', 'option')
		)
		{
			return $url;
		}
		return null;
	}

	/**
	 * ACF オプションページの作成
	 */
	public static function add_page($args = array())
	{
		if ( ! function_exists('acf_add_options_page') or empty($args))
			return null;

		return acf_add_options_page($args);
	}

	/**
	 * ACF オプションサブページの作成
	 */
	public static function add_sub_page($args = array())
	{
		if ( ! function_exists('acf_add_options_sub_page') or empty($args))
			return null;

		return acf_add_options_sub_page($args);
	}
}
