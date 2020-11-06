<?php

class WP_Staff
{
	public $template;

	private $field_names = array(
		'furigana',
		'staff_haircatalog_link',
		'manage',
		'beauty_history',
		'hobby',
		'good_image',
		'good_technology',
		'blog_url_text',
		'blog_url_for',
		'blog_url_select',
		'appeal',
		'reserve_staff',
		'reserve_btn_hidden',
	);

	private $social_names = array(
		'staff_instagram',
		'staff_twitter',
		'staff_facebook',
		'staff_youtube',
		'staff_pinterest',
		'staff_line',
	);

	public function __construct()
	{
		$this->template = new \stdClass;

		foreach ($this->field_names as $field) {
			$this->set_field($field);
		}

		foreach ($this->social_names as $social) {
			$this->set_social($social);
		}
	}

	public function init() {
		return $this->template;
	}

	public function set_field($field_name) {
		$this->template->$field_name = get_field($field_name, get_the_ID());
	}

	public function set_social($field_name) {
		$this->template->social[] = get_field($field_name, get_the_ID());
	}
}

function get_staff() {
	$wp_staff = new WP_Staff();

	return $wp_staff->init();
}


function get_staff_manage($field) {
	$manage = $field;

	$result = NULL;
	foreach ($manage as $r) {
		if (!empty($result)) $result .= '・';
		$result .= $r->name;
	}

	return $result;
}


function get_staff_social(Array $field) {
	if (is_array($field)) {
		$str = array();
		foreach ($field as $url) {
			if ($url) {
				$str[] = sprintf(
					'<a href="%1$s" target="_blank"><span></span></a>',
					esc_url($url)
				);
			}
		}
		return $str;
	}
}