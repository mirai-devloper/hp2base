<?php
namespace Hairspress\Core;
/**
 * Theme Helper on View
 *
 * テーマ内にあるViewsディレクトリのPHPファイルをインクルードするヘルパー
 *
 * @since 2017-05-09
 */
class View
{
	protected $filename = null;

	protected $data = array();

	protected $extension = 'php';

	protected static $instance;

	protected static $paths = 'hairspress/views/';

	public static function forge($file = null, $data = null)
	{
		new static($file, $data);
		return static::$instance;
	}

	public function __construct($file = null, $data = null)
	{
		if (is_object($data) === true)
		{
			$data = get_object_vars($data);
		}

		if ( ! is_null($file))
		{
			$this->filename = static::$paths.$file.'.'.$this->extension;
		}

		if ( ! is_null($data))
		{
			$this->data = $data;
		}

		static::$instance = $this->process_file();
	}

	public static function set_path($pathname) {
		static::$paths = $pathname;
	}

	private function process_file($file_override = false)
	{
		$clean_room = function($__file_name, array $__data)
		{
			extract($__data, EXTR_REFS);

			ob_start();
			mb_internal_encoding("UTF-8");
			try
			{
				include locate_template($__file_name);
			}
			catch (Exception $e)
			{
				ob_end_clean();

				throw $e;
			}

			return ob_get_clean();
		};

		try {
			//code...
			$result = $clean_room($file_override ?: $this->filename, $this->data);
		} catch (\Throwable $th) {
			ob_end_clean();
			throw $th;
			exit();
		}

		return mb_convert_encoding($result, "UTF-8");
	}
}
