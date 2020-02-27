<?php


class WP_Helper
{
	public function __construct()
	{

	}

	// テーマのバージョンを取得
	public static function version()
	{
		$theme = wp_get_theme();
		return $theme->get('Version');
	}

	public static function noimage($file = 'noimage.jpg', $args = array())
	{
		$defaults = array(
			'width' => 108,
			'height' => 72,
		);
		$args = wp_parse_args( $args, $defaults );
		$args = (object) $args;

		$src = Assets::img($file);

		if (is_file($src))
		{
			return '<img src="'.$src.'" width="'.$args->width.'" height="'.$args->height.'" alt="noimage">';
		}
	}

	/**
	 * 配列からwp_register_scriptを設定する
	 */
	public static function register_script($args = array())
	{
		$defaults = array(
			'src'       => '',
			'deps'      => array(),
			'ver'       => self::version(),
			'in_footer' => false,
		);

		if (is_array($args) and ! empty($args))
		{
			foreach ($args as $k => $v)
			{
				$call = wp_parse_args($v, $defaults);
				wp_register_script($k, $call['src'], $call['deps'], $call['ver'], $call['in_footer']);
			}
		}
	}

	public static function enqueue_style($args = array())
	{
		$defaults = array(
			'src'       => '',
			'deps'      => array(),
			'ver'       => self::version(),
			'in_footer' => false,
		);

		if (is_array($args) and ! empty($args))
		{
			foreach ($args as $k => $v)
			{
				$call = wp_parse_args($v, $defaults);
				wp_enqueue_style($k, $call['src'], $call['deps'], $call['ver'], $call['in_footer']);
			}
		}
	}


	public static function enqueue_script($args = array())
	{
		$defaults = array(
			'src'       => '',
			'deps'      => array(),
			'ver'       => self::version(),
			'in_footer' => false,
		);

		if (is_array($args) and ! empty($args))
		{
			foreach ($args as $k => $v)
			{
				$call = wp_parse_args($v, $defaults);
				wp_enqueue_script($k, $call['src'], $call['deps'], $call['ver'], $call['in_footer']);
			}
		}
	}
}
