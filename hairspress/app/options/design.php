<?php
namespace Hairspress\App;

class Options_Design {
	public function __construct()
	{
		add_action('admin_menu', array($this, 'add_dashboard_page'));
		add_action('admin_init', array($this, 'add_settings'));
	}

	public function add_dashboard_page() {
		add_dashboard_page(
			'デザイン',
			'デザイン',
			'manage_options',
			'options-hp-theme',
			array($this, 'option_edit_page')
		);
	}

	public function option_edit_page() {
		?>
			<div class="wrap">
			<h2>デザイン切り替え</h2>
			<form method="post" action="options.php">
				<?php
					settings_fields('hairspress_theme_group');
					do_settings_sections( 'options-hp-theme' );
					submit_button();
				?>
			</form>
			</div>
		<?php
	}

	public function add_settings() {
		// ヘアーズプレスのテーマ切り替え
		add_settings_section(
			'options_hairspress_theme_id',
			'デザイン切り替え',
			array($this, 'section_text'),
			'options-hp-theme'
		);

		// テーマ選択フィールド
		add_settings_field(
			'options_hp_theme_name',
			'テーマ',
			array($this, 'fields'),
			'options-hp-theme',
			'options_hairspress_theme_id'
		);
		register_setting( 'hairspress_theme_group', 'options_hp_theme_name');
	}

	public function section_text() {
		echo '<p>ご利用中のHairsPressのテンプレートデザインを切り替えることができます。</p>';
	}

	public function fields() {
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
}

