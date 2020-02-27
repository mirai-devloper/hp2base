<?php

class Instagram
{
	public function __construct()
	{

	}

	public function section($id, $title, $callback, $page)
	{
		add_settings_section($id, $title, $callback, $page);
	}

	public function field($id, $title, $callback, $page, $section, $args = array())
	{
		add_settings_field($id, $title, $callback, $page, $section, $args);
	}

	public function add_options()
	{
		add_options_page(
			'Instagramの設定',
			'Instagramの設定',
			'edit_posts',
			'options-instagram',
			'options_edit_instagram'
		);
	}

	public function edit()
	{
		
	}

	public function general()
	{

	}
}
