<?php
/*
 * Mio Helper Class
 */
class Mio_Helper
{

	/*
	 * classesをインクルードするためのヘルパー
	 * @param $path string
	 */
	public static function include_path()
	{
		return dirname(__FILE__);
	}

	public static function load($path)
	{
		$path = self::include_path().'/'.$path;
		require_once $path;
	}

	public static function classes_path($path)
	{
		return self::include_path().'/classes/'.$path;
	}

	public static function class_load($path)
	{

		$path = self::classes_path($path);
		include_once $path;
	}
}
