<?php
// ダッシュボードにデザインのページを追加
add_action('admin_menu', 'options_hp_theme');
function options_hp_theme() {
	add_dashboard_page(
		'デザイン',
		'デザイン',
		'manage_options',
		'options-hp-theme',
		'options_edit_hp_theme'
	);
	add_action('admin_init', 'hairspress_options_theme');
}

// デザインページの画面生成
function options_edit_hp_theme() {
	echo '<div class="wrap">';
	echo '<h2>デザイン切り替え</h2>';
	echo '<form method="post" action="options.php">';
			settings_fields('hairspress_theme_group');
			do_settings_sections( 'options-hp-theme' );
			submit_button();
	echo '</form>';
	echo '</div>';
}

// オプションの生成
function hairspress_options_theme() {
	// ヘアーズプレスのテーマ切り替え
	add_settings_section(
		'options_hairspress_theme_id',
		'デザイン切り替え',
		'hairspress_theme_section',
		'options-hp-theme'
	);

	// テーマ選択フィールド
	add_settings_field(
		'options_hp_theme_name',
		'テーマ',
		'hairspress_theme_select_field',
		'options-hp-theme',
		'options_hairspress_theme_id'
	);
	register_setting( 'hairspress_theme_group', 'options_hp_theme_name');
}
function hairspress_theme_section() {
	echo '<p>ご利用中のHairsPressのテンプレートデザインを切り替えることができます。</p>';
}

function hairspress_theme_select_field() {
	$options_hp_theme_name = get_option('options_hp_theme_name');
	$opt = array(
		'hp2mode' => 'モード',
		'hp2antique' => 'アンティーク',
		'hp2organic' => 'オーガニック',
		'hp2sweet' => 'スウィート'
	);
	$opt_str = '';
	foreach( $opt as $key => $val ) {
		$opt_str .= sprintf(
			'<option value="%1$s"%2$s>%3$s</option>',
			esc_attr( $key ),
			selected( $options_hp_theme_name, $key, false ),
			$val
		);
	}
	printf(
		'<select name="%1$s" id="%1$s">%2$s</select>',
		'options_hp_theme_name',
		$opt_str
	);
}

// add_action('admin_init', 'hairspress_theme_change_init');
function hairspress_theme_change_init() {
	$hp_theme_name = get_option('options_hp_theme_name');
	$e = new WP_Error();
	if( $hp_theme_name && !empty($hp_theme_name) ) {
		$get_theme = wp_get_theme($hp_theme_name);
		$theme_check = $get_theme->get('Template');
		if( $theme_check ) {
			switch_theme($hp_theme_name);
			delete_transient( 'hairspress_theme_error_message');
		} else {
			switch_theme('hp2base');
			$e->add('error', 'テーマファイルが見つかりませんでした。再度設定をしてください。');
			set_transient( 'hairspress_theme_error_message', $e->get_error_messages() );
		}
		// wp_safe_redirect( menu_page_url('options-hp-theme', false) );
	} else {
		$e->add('error', 'デザイン設定が完了していません。設定を完了させてください。');
		set_transient( 'hairspress_theme_error_message', $e->get_error_messages() );
	}
}
// add_action('admin_notices', 'hairspress_theme_change_notices');
function hairspress_theme_change_notices() {
	if( $messages = get_transient('hairspress_theme_error_message') ) :
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
