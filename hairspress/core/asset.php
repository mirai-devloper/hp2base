<?php
namespace Hairspress\Core;

/**
 * Asset
 */
class Asset
{
	/**
	 * Default Folder
	 */
	protected static $folder = array(
		'js'  => 'assets/js/',
		'css' => 'assets/css/',
		'img' => 'assets/images/',
		'lib' => 'assets/lib/',
	);

	protected static $preset = array(
		'2x', '3x', '4x',
	);

	public static function add_path($path, $type = null)
	{
		static::$folder[$type] = $path;
	}

	protected static function _get_file_path($file, $type = 'img') {
		return get_theme_file_path(static::$folder[$type].$file);
	}

	/**
	 * 指定のファイルを取得し、URIで返す
	 * URLが指定されればそのまま返す。テーマ内とルートからファイルを調べ、見つかれば返す。
	 * テーマ内から先に見つかればテーマ内のファイルを優先する。
	 *
	 * @param String $file 'common/logo.png'
	 * @param String $type static::$folderのKeyを参照
	 * @return String File URI
	 */
	public static function get_file_path($file, $type = 'img')
	{
		return static::_get_file_path($file, $type);
	}

	public static function get_file_uri($file, $type = 'img') {
		if (preg_match('/^(http|https|\/\/|mailto:|tel:|#)/', $file)) return $file;

		return get_theme_file_uri(static::$folder[$type].ltrim($file, '/'));
	}

	protected static function render_img($file = '', $attr = array())
	{
		$result = '';

		$attr['src'] = static::get_file_uri($file);
		if (file_exists(static::get_file_path($file, 'img'))) {
			$attr['src'] .= '?v='.filemtime(static::get_file_path($file, 'img'));
		}

		$ext = pathinfo($file, PATHINFO_EXTENSION);
		$filename = preg_replace("/(.+)(\.[^.]+$)/", "$1", $file);
		$preset = static::$preset;

		$srcset = '';
		foreach ($preset as $x)
		{
			if (strpos($filename, '@'.$x) === false)
			{
				$file_x = $filename.'@'.$x.'.'.$ext;
				$srcset_file = static::get_file_path($file_x, 'img');
				if (file_exists($srcset_file))
				{
					if ( ! empty($srcset))
					{
						$srcset .= ', ';
					}
					$srcset .= static::get_file_uri($file_x).'?v='.filemtime($srcset_file).' '.$x;
				}
			}
		}

		if ( ! empty($srcset))
		{
			$attr['srcset'] = $srcset;
		}


		$size = getimagesize(static::get_file_path($file));
		if ($size)
		{
			if ( ! isset($attr['width'])) {
				$attr['width'] = $size[0];
			}
			if ( ! isset($attr['height']) ) {
				$attr['height'] = $size[1];
			}
		}

		$attr['alt'] = isset($attr['alt']) ? $attr['alt'] : '';

		$result = html_tag('img', $attr);

		return $result;
	}

	/**
	 * Image Tag
	 */
	public static function img($file, $attr = array())
	{
		return static::render_img($file, $attr);
	}


	public static function js($files, $attr = array()) {
		if (is_array($files)) {
			$str = '';
			foreach ($files as $file) {
				$str .= static::js($file, $attr);
			}
			return $str;
		} else {
			$default = array(
				'type' => 'text/javascript',
			);
			$attr = array_merge($attr, $default);

			if (filter_var($files, FILTER_VALIDATE_URL) and preg_match('/^https?:\/\/.*$/', $files)) {
				$attr['src'] = $files;
				return html_tag('script', $attr);
			}

			$attr['src'] = static::get_file_uri($files, 'js');

			return html_tag('script', $attr);
		}
	}

	public static function css($files, $attr = array()) {
		if (is_array($files)) {
			$str = '';
			foreach ($files as $file) {
				$str .= static::css($file, $attr);
			}
			return $str;
		} else {
			$default = array(
				'rel' => 'stylesheet',
				'type' => 'text/css'
			);
			$attr = array_merge($attr, $default);

			if (filter_var($files, FILTER_VALIDATE_URL) and preg_match('/^https?:\/\/.*$/', $files)) {
				$attr['href'] = $files;
				return html_tag('link', $attr);
			}

			$attr['href'] = static::get_file_uri($files, 'css');

			return html_tag('link', $attr);
		}
	}


	public static function svg($file) {
		ob_start();
		mb_internal_encoding("UTF-8");
		try
		{
			include(static::get_file_path($file, 'img'));
		}
		catch (Exception $e)
		{
			ob_end_clean();

			throw $e;
		}
		return ob_get_clean();
	}

	public static function favicon($file) {
		return static::get_file_uri($file, 'favicon');
	}
}
