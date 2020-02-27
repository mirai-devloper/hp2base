<?php
/*
 * Formのパーツを出力するためのクラス群です。
 */
class Form
{
	/*
	 * Attributeを追加するための配列処理
	 *
	 * @param $args | array
	 *
	 * @return ' $key="$value"' が繰り返し処理
	 */
	public static function attr($args = array())
	{
		$attr = null;

		if ( ! empty($args))
		{
			foreach ($args as $k => $v)
			{
				if (is_numeric($k))
					return $attr;

				$attr .= ' '.$k.'="'.$v.'"';
			}
		}
		return $attr;
	}

	/*
	 * Inputタグを生成するための処理
	 *
	 * @param $type | string
	 * @param $name | string
	 * @param $value | string
	 * @param $args | array
	 */
	public static function input($type, $name, $value = '', $args = array())
	{
		if ((isset($type) && $type) && (isset($name) && $name))
		{
			return sprintf(
				'<input type="%1$s" name="%2$s" value="%3$s" %4$s />',
				$type,
				$name,
				$value,
				empty(self::attr($args)) ? '' : self::attr($args)
			);
		}
	}

	// Input Hidden
	public static function hidden($name, $value = '', $args = array())
	{
		return self::input('hidden', $name, $value, $args);
	}

	// Input Text
	public static function text($name, $value = '', $args = array())
	{
		return self::input('text', $name, $value, $args);
	}

	// Input Checkbox
	public static function checkbox($name, $value = '', $args = array())
	{
		return self::input('checkbox', $name, $value, $args);
	}

	// Input RadioButton
	public static function radio($name, $value = '', $args = array())
	{
		return self::input('radio', $name, $value, $args);
	}

	// Input Password
	public static function password($name, $value = '', $args = array())
	{
		return self::input('password', $name, $value, $args);
	}

	// Input File
	public static function file($name, $value = '', $args = array())
	{
		return self::input('file', $name, $value, $args);
	}

	// Input Submit
	public static function submit($name, $value = '', $args = array())
	{
		return self::input('submit', $name, $value, $args);
	}

	// Input Reset
	public static function reset($name, $value = '', $args = array())
	{
		return self::input('reset', $name, $value, $args);
	}

	// Input Button
	public static function button($name, $value = '', $args = array())
	{
		return self::input('button', $name, $value, $args);
	}

	// Input Image
	public static function image($name, $value = '', $args = array())
	{
		return self::input('image', $name, $value, $args);
	}

	// Input Tel
	public static function tel($name, $value = '', $args = array())
	{
		return self::input('tel', $name, $value, $args);
	}

	// Input URL
	public static function url($name, $value = '', $args = array())
	{
		return self::input('url', $name, $value, $args);
	}

	// Input Email
	public static function email($name, $value = '', $args = array())
	{
		return self::input('email', $name, $value, $args);
	}

	// Input Number
	public static function number($name, $value = '', $args = array())
	{
		return self::input('number', $name, $value, $args);
	}

	// Input Search
	public static function search($name, $value = '', $args = array())
	{
		return self::input('search', $name, $value, $args);
	}
}
