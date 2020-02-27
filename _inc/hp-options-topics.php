<?php
// ダッシュボードにデザインのページを追加
add_action('admin_menu', 'options_topics');
function options_topics() {
  add_submenu_page(
    'edit.php?post_type=topics',
    'お知らせの設定',
    '設定',
    'edit_posts',
    'topics_options',
    'topics_options'
  );
  add_action('admin_init', 'hairspress_options_topics');
}

// デザインページの画面生成
function topics_options() {
  echo '<div class="wrap">';
  echo '<h2>お知らせの設定</h2>';
  echo '<form method="post" action="options.php">';
      settings_fields('hairspress_topics_group');
      do_settings_sections( 'topics_options' );
      submit_button();
  echo '</form>';
  echo '</div>';
}

// オプションの生成
function hairspress_options_topics() {
  // ヘアーズプレスのテーマ切り替え
  add_settings_section(
    'options_hairspress_topics_id',
    '補足',
    'hairspress_topics_section',
    'topics_options'
  );

  // テーマ選択フィールド
  add_settings_field(
    'options_topics_name',
    '表示位置',
    'hairspress_topics_select_field',
    'topics_options',
    'options_hairspress_topics_id'
  );
  register_setting( 'hairspress_topics_group', 'options_topics_name');
}
function hairspress_topics_section() {
  echo '<p>トップページの「Information」の表示位置を「上側」または「下側」を設定することができます。</p>';
}

function hairspress_topics_select_field() {
  $options_hp_theme_name = get_option('options_topics_name');
  $opt = array(
    'up' => '上側',
    'down' => '下側'
  );
  $opt_str = '';
  foreach( $opt as $key => $val ) {
    $selected = $options_hp_theme_name === $key ? ' selected' : '';
    $opt_str .= '<option value="'.$key.'"'.$selected.'>'.$val.'</option>';
  }
  echo <<< __FORM__
<select name="options_topics_name" id="options_topics_name">
  {$opt_str}
</select>
__FORM__;
}

// add_action('admin_init', 'hairspress_topics_change_init');
function hairspress_topics_change_init() {
  $hp_topics_name = get_option('options_topics_name');
  $e = new WP_Error();
  if( $hp_topics_name && !empty($hp_topics_name) ) {
    $get_theme = wp_get_theme($hp_theme_name);
    $theme_check = $get_theme->get('Template');
    if( $theme_check ) {
      switch_theme($hp_theme_name);
      delete_transient( 'hairspress_topics_error_message');
    } else {
      switch_theme('hp2base');
      $e->add('error', 'テーマファイルが見つかりませんでした。再度設定をしてください。');
      set_transient( 'hairspress_topics_error_message', $e->get_error_messages() );
    }
    // wp_safe_redirect( menu_page_url('options-hp-theme', false) );
  } else {
    $e->add('error', 'デザイン設定が完了していません。設定を完了させてください。');
    set_transient( 'hairspress_topics_error_message', $e->get_error_messages() );
  }
}
// add_action('admin_notices', 'hairspress_topics_change_notices');
function hairspress_topics_change_notices() {
  if( $messages = get_transient('hairspress_topics_error_message') ) :
    $str = '';
    foreach( $messages as $message ) {
      $str .= '<li>'.esc_html($message).'</li>';
    }
    echo <<< __HTML__
<div class="error">
  <ul>
    {$str}
  </ul>
</div>
__HTML__;
  endif;
}
