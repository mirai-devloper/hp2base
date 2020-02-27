<?php
// カスタムエディターCSS
// add_editor_style('editor-style.css');


add_filter('tiny_mce_before_init', 'hp_mce_editor_style');
function hp_mce_editor_style($init) {
  $init['body_class'] = 'editor-area';
  $init['extended_valid_elements'] = "iframe[id|class|title|style|align|frameborder|height|longdesc|marginheight|marginwidth|name|scrolling|src|width]";
  $init['remove_linebreaks'] = false;
  $init['wpautop'] = false;
  $init['indent'] = true;
  $init['hptm_noautop'] = true;
  return $init;
}

add_filter('mce_external_plugins', 'hp_mce_external_plugins', 999);
function hp_mce_external_plugins($mce_plugins)
{
	$mce_plugins = (array) $mce_plugins;

	$mce_plugins['hptm'] = get_theme_file_uri('mce/hptm/plugin.js');

	return $mce_plugins;
}

// 1行目のエディターボタン
add_filter('mce_buttons', 'tinymce1_btn_edit');
function tinymce1_btn_edit($buttons) {
  $buttons = array(
    // $buttons,
    // 'fontsizeselect',
    'formatselect',
    'bold',
    'italic',
    'strikethrough',
    'underline',
    'bullist',
    'numlist',
    'blockquote',
    'hr',
    'alignleft',
    'aligncenter',
    'alignright',
    // 'wp_more',
    'wp_page',
    'spellchecker',
    'fullscreen',
    'wp_adv'
  );
  return $buttons;
}

// 2行目のエディターボタン
add_filter('mce_buttons_2', 'tinymce2_btn_edit');
function tinymce2_btn_edit($buttons) {
  $buttons = array(
    // $buttons,
    // 'fontselect',
    'fontsizeselect',
    'link',
    'unlink',
    'forecolor',
    'backcolor',
    // 'copy',
    // 'cut',
    // 'paste',
    'pastetext',
    'outdent',
    'indent',
    'removeformat',
    'wp_emoji',
    'charmap',
    'undo',
    'redo',
    'styleselect',
    'wp_help',
    'dfw'
  );
  return $buttons;
}

// 3行目のエディターボタン
// add_filter('mce_buttons_3', 'tinymce3_btn_edit');
function tinymce3_btn_edit($buttons) {
  $buttons = array(
    $buttons,
  );
  return $buttons;
}


// フォーマットの変更
add_filter('tiny_mce_before_init', 'customize_tinymce_settings', 10, 3);
function customize_tinymce_settings($init) {
  global $wp_version;

  if( version_compare($wp_version, '3.9', '>=') ) {
    // フォーマット
    if( $init['language'] === 'ja' ) {
      $init['block_formats'] = 'Paragraph=p; Pre=pre; 見出し2=h2; 見出し3=h3;　見出し4=h4;　見出し5=h5;　見出し6=h6;';
    } else {
      $init['block_formats'] = 'Paragraph=p; Pre=pre; Heading 2=h2; Heading 3=h3; Heading 4=h4; Heading 5=h5; Heading 6=h6;';
    }

    // フォントサイズ
    $init['fontsize_formats'] = '8px 10px 12px 14px 16px 18px 20px 22px 24px 26px 28px 30px 32px 34px 36px 38px 40px 42px 44px 46px 48px 50px 64px 72px';
    $init['force_hex_style_colors'] = true;
    $init['schema'] = 'html5';
    $init['menubar'] = true;
  } else {
    // WP_Version 3.8 以下
    // フォーマット
    $init['theme_advanced_blockformats'] = 'p,pre,h2,h3,h4,h5,h6';
    $init['theme_advanced_font_sizes'] = '8pt,10pt,12pt,14pt,16pt,18pt,20pt,22pt,24pt,26pt,28pt,30pt,32pt,34pt,36pt,38pt,40pt,42pt,44pt,46pt,48pt,50pt,64pt,72pt';
  }
  return $init;
}

// HTMLエディターに[ nextpage ]ボタンを追加
// 公式Codexから抜粋
add_action('admin_print_footer_scripts', 'hp_add_quicktags_buttons');
function hp_add_quicktags_buttons() {
  if( wp_script_is('quicktags') ) {
    echo <<< __SCRIPT__
<script type="text/javascript">
QTags.addButton( 'eg_nextpage', 'nextpage', '<!--nextpage-->', '', 'n');
</script>
__SCRIPT__;
  }
}
