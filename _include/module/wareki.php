<?php
/**
 * 西暦と和暦の配列を返すモジュールです
 * 西暦と和暦の両方欲しいですって要望に答えるために・・・
 *
 * @author miosee
 * @since 1.0
 */
new Wareki;

class Wareki
{
	public static $config = [];

	/**
	 * __construct
	 */
	public function __construct()
	{
		// WordPressで使用する場合は、date_i18nを使用する
		$toyear = function_exists('date_i18n') ? date_i18n('Y') : date('Y');

		// 初期設定
		self::$config = [
			[
				'range' => [1868, 1912],
				'kanji' => '明治',
			],
			[
				'range' => [1912, 1926],
				'kanji' => '大正',
			],
			[
				'range' => [1926, 1989],
				'kanji' => '昭和',
			],
			[
				'range' => [1989, $toyear],
				'kanji' => '平成',
			],
		];
	}

	/**
	 * 最初の配列を取得するためだけのメソッド
	 */
	public static function get_first_child($arr)
	{
		return current($arr);
	}

	/**
	 * 配列の逆順にするときにキーも保持させる引数を付け忘れるのを防ぐためのメソッド
	 */
	public static function array_reversed($arr, $pre_keys = true)
	{
		return array_reverse($arr, $pre_keys);
	}

	/**
	 * 開始年を指定し、現在年の加算値を指定して、何年先まで配列にするか指定する
	 * 開始年が設定より低い場合は、設定の初期値を設定する
	 *
	 * @var get
	 * @param int $year 最小値の年を指定
	 * @param int $max_range 現在年の加算値を指定
	 * @return array
	 */
	public static function get($year = 1868, $max_range = 1)
	{
		$conf = self::$config;
		$first_child = self::get_first_child($conf);

		// 最小値の設定　$year が 最初のrangeより多い場合に指定した値が設定される
		$min = $year < $first_child['range'][0] ? $first_child['range'][0] : $year;

		// 現在の年を加算するための最大値を処理
		$keys = array_keys($conf);
		if ($max_range > 0)
		{
			$conf[array_pop($keys)]['range'][1] = date('Y', strtotime('+'.$max_range.' Year'));
		}

		// $key[$year] => $value[和暦] を返す
		foreach ($conf as $k => $v)
		{
			// $v['range'][0] が $min より小さいとき処理を中断し、次へすすめる
			if ($min > $v['range'][0])
				continue;

			for ($i = $v['range'][0]; $i < $v['range'][1]; $i++)
			{
				$str[$i] = $v['kanji'].(($i === $v['range'][0]) ? '元年' : (($i + 1) - $v['range'][0]).'年');
			}
		}

		return $str;
	}

	public static function get_reverse($year = 1868, $max_range = 1)
	{
		return array_reverse(self::get($year, $max_range), true);
	}
}
