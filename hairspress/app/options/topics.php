<?php
namespace Hairspress\App;

// 移植途中
class Options_Topics {
	public function __construct() {
		// dummy
		add_action('admin_menu', array($this, 'admin_menu'));
		add_action('admin_init', array($this, 'register_setting'));
	}

	public function admin_init() {

	}

	public function admin_menu() {
		add_submenu_page(
			'edit.php?post_type=topics',
			'お知らせの設定',
			'設定',
			'edit_posts',
			'topics_options',
			array($this, 'option_edit_page')
		);
	}

	public function option_edit_page() {
		?>
			<div class="wrap">
			<h2>お知らせの設定</h2>
			<form method="post" action="options.php">
				<?php
					settings_fields('hairspress_topics_group');
					do_settings_sections( 'topics_options' );
					submit_button();
				?>
			</form>
			</div>
		<?php
	}

	public function register_setting() {
		// ヘアーズプレスのテーマ切り替え
		add_settings_section(
			'options_hairspress_topics_id',
			'補足',
			array($this, 'section_text'),
			'topics_options'
		);

		// テーマ選択フィールド
		add_settings_field(
			'options_topics_name',
			'表示位置',
			array($this, 'fields'),
			'topics_options',
			'options_hairspress_topics_id'
		);
		register_setting( 'hairspress_topics_group', 'options_topics_name');
	}

	public function section_text() {
		echo '<p>トップページの「Information」の表示位置を「上側」または「下側」を設定することができます。</p>';
	}

	public function fields() {
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
		echo sprintf(
			'<select name="%1$s" id="%1$s">%2$s</select>',
			'options_topics_name',
			$opt_str
		);
	}
}