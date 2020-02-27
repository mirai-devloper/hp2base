<?php

new HP_Options;

class HP_Options
{
	public function __construct()
	{
		// 初回インストール時に現在の年を保存する
		if ( ! is_customize_preview() and ! get_option('hp_install_year'))
			update_option('hp_install_year', date_i18n('Y'));
	}

	/**
	 * 保存された年を取得する
	 */
	public static function get_op($option_name)
	{
		if ( ! isset($option_name))
			return;

		return (get_option($option_name)) ? get_option($option_name) : '';
	}

	/**
	 * 
	 */
	public static function year()
	{
		return sprintf(
			'<span>%1$s%2$s</span>',
			self::get_op('hp_install_year'),
			(self::get_op('hp_install_year') < date_i18n('Y')) ? '-'.date_i18n('Y') : ''
		);
	}
}
