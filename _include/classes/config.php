<?php
/**
 * Configファイルを読み込む
 */

new Config;

class Config
{
	private static $conf;

	/**
	 * セットアップ
	 *
	 * ここにコンフィグファイルを読み込む設定を行う
	 */
	public function __construct()
	{
		self::$conf = self::load('config.php');

	}

	public static function load($file)
	{
		$path = get_template_directory()."/wpel/config/";

		if (is_file($path.$file))
		{
			return require $path.$file;
		}
	}

	public static function get($key)
	{
		if (empty(self::$conf))
			return;

		if (isset($key) and array_key_exists($key, self::$conf))
		{
			return self::$conf[$key];
		}

		return self::$conf;
	}
}
