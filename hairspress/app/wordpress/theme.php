<?php
namespace Hairspress\App;

class Wordpress_Theme
{
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
		$this->register_nav_menus();
		add_action('after_setup_theme', array($this, 'after_setup_theme'));
		add_action('widgets_init', array($this, 'register_sidebar'));
		add_action('wp_enqueue_scripts', array($this, 'wp_enqueue_scripts'));
		add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts_child'), 1);
	}

	/**
	 * テーマのセットアップ
	 */
	public function after_setup_theme()
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
		add_image_size('mio-slider-large', 1280, 596, true);
		add_image_size('hairspress-slider', 1600, 9999, true);
		add_image_size('ogp', 1200, 630, true);

		$starter_content_args = require(get_theme_file_path('hairspress/functions/starter-content.php'));
		add_theme_support('starter-content', $starter_content_args);

		add_theme_support('responsive-embeds');

		add_editor_style(array('assets/css/editor-style.css'));

		add_theme_support('wp-block-styles');
		add_theme_support('align-wide');

		add_theme_support('customize-selective-refresh-widgets');
	}

	public function register_nav_menus()
	{
		register_nav_menus(
			array(
				'primary-menu' => 'メインメニュー',
			)
		);
	}

	/**
	 * ウィジェットのセットアップ
	 */
	public function register_sidebar()
	{
		register_sidebar(
			array(
				'name'          => 'サイドバー上部',
				'id'            => 'blog-sidebar-top-widget',
				'description'   => 'ブログのサイドバー上部のウィジェットエリアです。',
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h3 class="widgettitle heading-mark"><span class="f-um">',
				'after_title'   => '</span></h3>',
			)
		);

		register_sidebar(
			array(
				'name'          => 'サイドバー下部',
				'id'            => 'blog-sidebar-bottom-widget',
				'description'   => 'ブログのサイドバー下部のウィジェットエリアです。',
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h3 class="widgettitle heading-mark"><span class="f-um">',
				'after_title'   => '</span></h3>',
			)
		);

		register_sidebar(
			array(
				'name'          => 'ブログの本文下部',
				'id'            => 'blog-content-bottom',
				'description'   => 'ブログ本文の最後に共通のウィジェットを配置できます。',
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h3 class="widgettitle">',
				'after_title'   => '</h3>',
			)
		);

		register_sidebar(
			array(
				'name'          => 'お知らせのサイドバー',
				'id'            => 'topics-sidebar',
				'description'   => 'お知らせのサイドバーウィジェットエリアです。',
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h3 class="widgettitle heading-mark"><span class="f-um">',
				'after_title'   => '</span></h3>',
			)
		);
	}

	/**
	 * テーマのバージョンを取得
	 */
	public function version()
	{
		$theme = wp_get_theme();
		return $theme->get('Version');
	}

	public function asset_uri($file, $type = 'img') {
		return get_theme_file_uri($this->types[$type].$file);
	}

	public function asset_path($file, $type = 'img') {
		return get_theme_file_path($this->types[$type].$file);
	}

	public function filemtime($file, $type = 'img') {
		$filepath = $this->asset_path($file, $type);

		if (file_exists($filepath)) {
			return filemtime($filepath);
		}

		return $this->version();
	}

	/**
	 * テーマのCSS・JSをセットアップ
	 */
	public function wp_enqueue_scripts()
	{
    global $post;
		// StyleSheet
		wp_enqueue_style(
			'gfont-robot',
			'//fonts.googleapis.com/css?family=Roboto+Condensed'
		);
		// wp_enqueue_style(
		// 	'font-awesome-style',
		// 	'//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css',
		// 	array(),
		// 	'4.7.0'
		// );

		wp_enqueue_style(
			'font-mirai',
			$this->asset_uri('font-mirai.css', 'css'),
			array(),
			$this->filemtime('font-mirai.css', 'css')
		);

		wp_enqueue_style(
			'hairspress',
			$this->asset_uri('hairspress.css', 'css'),
			array(),
			$this->filemtime('hairspress.css', 'css')
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
						$this->asset_uri('mode.css', 'css'),
						array('hairspress'),
						$this->filemtime('mode.css', 'css')
					);
					break;
				case 'hp2antique':
					wp_enqueue_style(
						'hairspress-child',
						$this->asset_uri('antique.css', 'css'),
						array('hairspress'),
						$this->filemtime('antique.css', 'css')
					);
					break;
				case 'hp2organic':
					wp_enqueue_style(
						'hairspress-child',
						$this->asset_uri('organic.css', 'css'),
						array('hairspress'),
						$this->filemtime('organic.css', 'css')
					);
					break;
				case 'hp2sweet':
					wp_enqueue_style(
						'hairspress-child',
						$this->asset_uri('sweet.css', 'css'),
						array('hairspress'),
						$this->filemtime('sweet.css', 'css')
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
    if ($post) {
      $has_blocks = has_blocks(get_post($post->ID));

      if (!empty($post->post_content) and !$has_blocks) {
        wp_enqueue_style(
          'hairspress-classic-editor',
          $this->asset_uri('editor-style.css', 'css'),
          false,
          $this->filemtime('editor-style.css', 'css'),
          'all'
        );
      }
    }

		// JavaScript
		wp_enqueue_script('jquery');

		wp_enqueue_script(
			'hairspress-vendor',
			$this->asset_uri('vendor.bundle.js', 'js'),
			array(),
			$this->filemtime('vendor.bundle.js', 'js'),
			true
		);
		wp_enqueue_script(
			'hairspress-app',
			$this->asset_uri('app.bundle.js', 'js'),
			array(),
			$this->filemtime('app.bundle.js', 'js'),
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
