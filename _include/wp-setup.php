<?php

new Mio;

class Mio
{
	private static $conf;
	public $assets;
	public $paths = array();
	public $vendor = array();

	public $types = array(
		'img' => 'assets/images/',
		'css' => 'assets/css/',
		'js'  => 'assets/js/',
		'lib' => 'assets/lib/',
	);

	/**
	 * construct
	 */
	public function __construct()
	{
		$this->assets = $this->dir_uri().'/assets/';
		$this->paths = array(
			'css' => $this->assets.'css/',
			'js' => $this->assets.'js/',
			'img' => $this->assets.'images/',
			'lib' => $this->assets.'lib/',
		);
		$this->vendor = array(
			'css' => $this->paths['lib'].'css/',
			'js' => $this->paths['lib'].'js/',
			'img' => $this->paths['lib'].'images/',
		);

		add_action('after_setup_theme', array($this, 'theme_setup'));
		add_action('widgets_init', array($this, 'theme_widgets'));
		add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
		add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts_child'), 1);

		// add_filter('acf/settings/google_api_key', function() {
		// 	return 'AIzaSyA1Lf1DqEhix6KzZSf9h64UfJ2jZi6wF-4';
		// });

		self::$conf = include_once dirname(__FILE__)."/config/config.php";
	}

	/**
	 * コンフィグ配列の取得
	 *
	 * @param string $key
	 * @return array
	 */
	public static function conf($key)
	{
		if (isset($key) and array_key_exists($key, self::$conf))
			return self::$conf[$key];

		return self::$conf;
	}

	/**
	 * テンプレートのディレクトリURLを取得
	 */
	public function dir_uri()
	{
		return get_template_directory_uri();
	}

	/**
	 * テーマのセットアップ
	 */
	public function theme_setup()
	{
		add_theme_support('title-tag');
		add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption'));
		add_theme_support('post-thumbnails');

		// Thumbnail Support
		add_theme_support('post-thumbnails');
		//初期設定の投稿サムネイル値
		set_post_thumbnail_size( 300, 300 );

		// 各種サムネイルサイズ
		add_image_size('logo', 9999, 100);
		add_image_size('front-free-thumb', 640, 384, true);
		add_image_size('catalog-loop', 320, 393, true);
		add_image_size('catalog-thumb', 284, 432, true);
		add_image_size('catalog-staff', 232, 296, true);
		add_image_size('catalog-single', 360, 460, true);
		add_image_size('staff', 320, 9999);
		add_image_size('square', 252, 252, true);
		add_image_size('salon-info', 620, 420, true);
		add_image_size('salon-info-map', 620, 9999);
		add_image_size('admin-thumb', 80, 80, true);
		add_image_size('youtube', 320, 180, true);
		add_image_size('mio-slider-thumb', 240, 100, true);
		add_image_size('mio-slider-large', 1280, 545, true);
		add_image_size('hairspress-slider', 1600, 9999, true);
		add_image_size('ogp', 1200, 630, true);

		add_theme_support('responsive-embeds');

		add_editor_style(array('assets/css/editor-style.css'));

		add_theme_support('wp-block-styles');
		add_theme_support('align-wide');

		register_nav_menus(
			array(
				'primary-menu' => 'メインメニュー',
			)
		);

		if ( ! is_customize_preview())
		{
			update_option('permalink_structure', '/blog/details/%post_id%');
		}
	}

	/**
	 * ウィジェットのセットアップ
	 */
	public function theme_widgets()
	{
		register_sidebar(self::conf('widgets')['sidebar_blog_top']);
		register_sidebar(self::conf('widgets')['sidebar_blog_bottom']);
	}

	/**
	 * テーマのバージョンを取得
	 */
	public function version()
	{
		$theme = wp_get_theme();
		return $theme->get('Version');
	}

	public function asset_uri($file = '', $type = 'img') {
		if (empty($file)) return;

		return get_theme_file_uri($this->types[$type].$file);
	}

	public function asset_path($file = '', $type = 'img') {
		if (empty($file)) return;

		return get_theme_file_path($this->types[$type].$file);
	}

	public function filemtime($file = '', $type = 'img') {
		if (empty($file)) return $this->version();

		$filepath = $this->asset_path($file, $type);

		if (file_exists($filepath)) {
			return filemtime($filepath);
		}

		return $this->version();
	}

	public function min_file($file, $type = 'css')
	{
		$file_info = pathinfo($file);
		$min_file = $file_info['filename'].'.min.'.$file_info['extension'];
		if (file_exists($this->asset_path($min_file, $type))) {
			return $min_file;
		}

		return $file;
	}

	public function min_css($file)
	{
		if (ENV_MODE === 'develop') return $file;
		return $this->min_file($file, 'css');
	}

	public function min_js($file)
	{
		if (ENV_MODE === 'develop') return $file;
		return $this->min_file($file, 'js');
	}

	/**
	 * テーマのCSS・JSをセットアップ
	 */
	public function enqueue_scripts()
	{
		// StyleSheet
		wp_enqueue_style(
			'gfont-robot',
			'//fonts.googleapis.com/css?family=Roboto+Condensed'
		);
		wp_enqueue_style(
			'font-awesome-style',
			'//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css',
			array(),
			'4.7.0'
		);

		wp_enqueue_style(
			'font-mirai',
			$this->asset_uri($this->min_css('font-mirai.css'), 'css'),
			array(),
			$this->filemtime($this->min_css('font-mirai.css'), 'css')
		);
		// wp_enqueue_style('bootstrap', $this->paths['css'].'bootstrap.css', array(), '3.3.4');
		// if (is_front_page()) {
		// 	wp_enqueue_style(
		// 		'pogo-slider',
		// 		$this->asset_uri('css/pogo-slider.min.css', 'lib'),
		// 		array(),
		// 		$this->filemtime('css/pogo-slider.min.css', 'lib')
		// 	);
		// }
		wp_enqueue_style(
			'hairspress',
			$this->asset_uri($this->min_css('hairspress.css'), 'css'),
			array(),
			$this->filemtime($this->min_css('hairspress.css'), 'css')
		);

		// デザイン毎にCSSを切り替え
		if ($css_name = get_option('options_hp_theme_name') and ! empty($css_name))
		{
			switch ($css_name)
			{
				default:
				case 'hp2mode':
					wp_enqueue_style(
						'hairspress-child',
						$this->asset_uri($this->min_css('mode.css'), 'css'),
						array('hairspress'),
						$this->filemtime($this->min_css('mode.css'), 'css')
					);
					break;
				case 'hp2antique':
					wp_enqueue_style(
						'hairspress-child',
						$this->asset_uri($this->min_css('antique.css'), 'css'),
						array('hairspress'),
						$this->filemtime($this->min_css('antique.css'), 'css')
					);
					break;
				case 'hp2organic':
					wp_enqueue_style(
						'hairspress-child',
						$this->asset_uri($this->min_css('organic.css'), 'css'),
						array('hairspress'),
						$this->filemtime($this->min_css('organic.css'), 'css')
					);
					break;
				case 'hp2sweet':
					wp_enqueue_style(
						'hairspress-child',
						$this->asset_uri($this->min_css('sweet.css'), 'css'),
						array('hairspress'),
						$this->filemtime($this->min_css('sweet.css'), 'css')
					);
					break;
			}
		}

		wp_enqueue_style(
			'hairspress-block-editor',
			$this->asset_uri('block-editor.css', 'css'),
			false,
			$this->filemtime('block-editor.css', 'css'),
			'all'
		);

		// JavaScript
		wp_enqueue_script('jquery');
		// wp_deregister_script('jquery');
		// wp_enqueue_script(
		// 	'jquery',
		// 	$this->asset_uri('js/jquery.min.js', 'lib'),
		// 	array(),
		// 	'1.11.3',
		// 	false
		// );

		// wp_enqueue_script(
		// 	'pogo-slider',
		// 	$this->asset_uri('js/jquery.pogo-slider.min.js', 'lib'),
		// 	array('jquery'),
		// 	'4.2.5',
		// 	true
		// );

		wp_enqueue_script(
			'hairspress-vendor',
			$this->asset_uri($this->min_js('vendor.bundle.js'), 'js'),
			array(),
			$this->filemtime($this->min_js('vendor.bundle.js'), 'js'),
			true
		);
		wp_enqueue_script(
			'hairspress-app',
			$this->asset_uri($this->min_js('app.bundle.js'), 'js'),
			array(),
			$this->filemtime($this->min_js('app.bundle.js'), 'js'),
			true
		);
	}

	/**
	 * デザイン毎のWEBフォントをセットアップ
	 */
	public function enqueue_scripts_child()
	{
		if ($theme_name = get_option('options_hp_theme_name') and ! empty($theme_name))
		{
			switch($theme_name)
			{
				default:
				case 'hp2mode':
					wp_enqueue_style(
						'hp-font',
						'//fonts.googleapis.com/css?family=Josefin+Slab'
					);
					break;
				case 'hp2antique':
					wp_enqueue_style(
						'hp-font',
						'//fonts.googleapis.com/css?family=Lora'
					);
					break;
				case 'hp2organic':
					wp_enqueue_style(
						'hp-font',
						'//fonts.googleapis.com/css?family=Amatic+SC:400,700'
					);
					break;
				case 'hp2sweet':
					wp_enqueue_style(
						'hp-font',
						'//fonts.googleapis.com/css?family=Josefin+Slab'
					);
					break;
			}
		}
	}
}
