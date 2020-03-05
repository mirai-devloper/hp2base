<?php
/**
 * HairsPressで使用するソーシャルアイコンの発行
 */

new HP_Social;

class HP_Social extends HP_Acf
{
	private static $option;

	public function __construct()
	{
		self::$option['prefix'] = 'hp_salon_social_';
		self::$option['social'] = array(
			'instagram',
			'twitter',
			'facebook',
			'youtube',
			'pinterest',
			'line',
		);

		self::$option['prefix_staff'] = 'staff_';
		self::$option['social_staff'] = array(
			'instagram',
			'twitter',
			'facebook',
			'youtube',
			'pinterest',
			'line',
		);
	}

	//カスタムフィールドからURLを取得する
	public static function option_url($prefix = 'prefix', $social = 'social', $post_id = 0)
	{
		foreach (self::$option[$social] as $k => $v)
		{
			if ($url = parent::get(self::$option[$prefix].$v, $post_id) and ! empty($url))
				$arr[$v] = $url;
		}

		return isset($arr) ? $arr : array();
	}

	// Attributeを作成する
	public static function attr($inner = '=', $outer = ' ', $attr = array(), $skip_empty = false)
	{
		if (empty($attr))
			return null;

		foreach ($attr as $k => $v)
		{
			if ( ! $skip_empty OR $v)
				$output[] = $k.$inner.'"'.$v.'"';
		}

		return isset($output) ? implode($outer, $output) : '';
	}

	// タグの出力
	public static function view($prefix = 'prefix', $social = 'social', $post_id = 0, $attr = array())
	{
		foreach (self::option_url($prefix, $social, $post_id) as $k => $v)
			$str[] = '<a href="'.esc_url($v).'" target="_blank"><span>'.$k.'</span></a>';

		return sprintf(
			'<ul %1$s><li>%2$s</li></ul>',
			self::attr('=', ' ', $attr),
			isset($str) ? implode('</li><li>', $str) : ''
		);
	}
}
