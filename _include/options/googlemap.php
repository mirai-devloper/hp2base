<?php
/**
 * Google Maps
 */
new HP_Googlemap;

class HP_Googlemap extends HP_Acf
{
	public static $location;

	public function __construct()
	{
		// global $wp_query;
		self::$location = parent::get('hp_salon_google_map', 'option');

		add_action('wp', function() {
			if ($this->is_salon())
				add_action('wp_enqueue_scripts', array($this, 'google_api'));
		});
	}

	public static function mapdata()
	{
		return parent::get('hp_salon_google_map', 'option');
	}

	/**
	 * GoogleMapのURLを生成
	 *
	 * @param string $q
	 * @return url
	 */
	public static function url($q = 'latlng')
	{
		if ($q !== 'latlng')
		{
			$query[] = self::mapdata()['address'];
		}
		else
		{
			$query[] = self::mapdata()['lat'];
			$query[] = self::mapdata()['lng'];
		}
		return 'https://maps.google.com/maps?q='.implode(',', $query);
	}

	// GoogleMapの設定からリンクを生成させる
	public static function link($args = array())
	{
		$defaults = [
			'text' => '大きな地図で見る',
			'class' => '',
			'icon' => '',
		];

		$args = wp_parse_args($args, $defaults);
		$args = (object) $args;

		if (isset(self::$location))
			return sprintf(
				'<a href="%1$s" target="_blank" class="%2$s" date-address="%3$s">%4$s%5$s</a>',
				self::url(),
				'mapApp'.$args->class,
				self::$location['address'],
				$args->icon,
				$args->text
			);

		return null;
	}

	// サロンについてのページかチェック
	public function is_salon()
	{


		if ($access = get_page_by_path('access'))
			$pages[] = $access->ID;

		if ($salon = get_page_by_path('salon'))
			$pages[] = $salon->ID;

		if (isset($pages) and is_page($pages))
			return true;
	}

	// GoogleMapsApiのJSを読み込む
	public function google_api()
	{
		// $mio = new Mio;
		wp_enqueue_script('google-map-api', '//maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&key=AIzaSyC2PVeXoLpOd7_52W1NuOsPMSE_UqUpT6A', array());
		// wp_enqueue_script('google-map-render', $mio->paths['js'].'gmap.js', array(), '1.0', true);
	}
}
