<?php
namespace Hairspress\App;

class Wordpress_Tinymce {
	public function __construct(){
		// dummy
	}

	public function init() {
		add_filter('mce_external_plugins', array($this, 'mce_external_plugins'));
		add_filter('mce_buttons', array($this, 'mce_buttons'));
		add_filter('tiny_mce_before_init', array($this, 'tiny_mce_before_init'));
		add_action('admin_print_footer_scripts', array($this, 'admin_print_footer_scripts'));
	}

	public function mce_buttons($buttons) {
		$buttons[] = 'button_tel_link';

		return $buttons;
	}

	public function mce_external_plugins($arr) {
		$arr['tel_link'] = get_theme_file_uri('assets/wordpress/tinymce/tel-link.js');
		return $arr;
	}

	public function tiny_mce_before_init($init) {
		global $wp_version;

		$init['cache_suffix'] = 'v='.filemtime(get_theme_file_path('assets/css/editor-style.css'));
		$init['body_class'] = 'editor-area';
		$init['extended_valid_elements'] = "iframe[id|class|title|style|align|frameborder|height|longdesc|marginheight|marginwidth|name|scrolling|src|width]";

		if (version_compare($wp_version, '3.9', '>=')) {
			return $init;
		}
		if ($init['language'] === 'ja') {
			$init['block_formats'] = '段落=p; 見出し2=h2; 見出し3=h3; 見出し4=h4; 見出し5=h5; 見出し6=h6; 整形済みテキスト=pre;';
		}

		return $init;
	}

	// HTMLエディターに[ nextpage ]ボタンを追加
	// 公式Codexから抜粋
	public function admin_print_footer_scripts() {
		if( wp_script_is('quicktags') ) {
			?>
				<script type="text/javascript">QTags.addButton( 'eg_nextpage', 'nextpage', '<!--nextpage-->', '', 'n');</script>
			<?php
		}
	}
}