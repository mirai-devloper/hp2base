<?php
/**
 * Assetsまでのディレクトリ
 */
// namespace wpel\classes;

new Assets;

class Assets
{
	public static $assets;
	public static $paths = array();
	public static $vendor = array();

	/**
	 * Setup param
	 */
	public function __construct()
	{
		self::$assets = get_template_directory_uri().'/assets/';
		self::$paths = array(
			'css'    => self::$assets.'css/',
			'js'     => self::$assets.'js/',
			'img'    => self::$assets.'images/',
			'vendor' => self::$assets.'lib/',
		);
		self::$vendor = array(
			'css' => self::$paths['vendor'].'css/',
			'js'  => self::$paths['vendor'].'js/',
			'img' => self::$paths['vendor'].'images/',
		);
	}

	// Images
	public static function img($file)
	{
		return self::$paths['img'].$file;
	}

	// StyleSheet
	public static function css($file)
	{
		return self::$paths['css'].$file;
	}

	// JavaScript
	public static function js($file)
	{
		return self::$paths['js'].$file;
	}

	/**
	 * Vendor
	 */
	// Vendor Images
	public static function vendor_img($file)
	{
		return self::$vendor['img'].$file;
	}

	// Vendor StyleSheet
	public static function vendor_css($file)
	{
		return self::$vendor['css'].$file;
	}

	// Vendor JavaScript
	public static function vendor_js($file)
	{
		return self::$vendor['js'].$file;
	}
}
