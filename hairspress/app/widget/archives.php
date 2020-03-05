<?php
namespace Hairspress\App;

use Hairspress\Core\View;

class Widget_Archives extends \WP_Widget_Archives
{
	private $post_type = 'post';

	public function __construct() {
		parent::__construct();
		add_filter('widget_archives_args', function($args) {
			$args['post_type'] = $this->post_type;
			return $args;
		});
	}

	public function add_archives_posttype($args)
	{
		$args['post_type'] = $this->post_type;
		return $args;
	}

	public function get_post_types()
	{
		$post_types = get_post_types(
			array(
				'public'  => true,
				'show_ui' => true,
				'hierarchical' => false,
			),
			'objects'
		);
		return $post_types;
	}

	public function widget($args, $instance)
	{
		if ( ! isset($args['widget_id']) ) {
			$args['widget_id'] = $this->id;
		}

		if ( ! empty($instance['post_type']))
		{
			$this->post_type = $instance['post_type'];
		}

		parent::widget($args, $instance);
	}

	public function update($new_instance, $old_instance)
	{
		$instance = parent::update($new_instance, $old_instance);
		$instance['post_type'] = $new_instance['post_type'];

		return $instance;
	}

	public function form($instance)
	{
		parent::form($instance);

		$post_type = isset($instance['post_type']) ? $instance['post_type'] : $this->post_type;

		$post_types = $this->get_post_types();
		$field_id = $this->get_field_id('post_type');
		$field_name = $this->get_field_name('post_type');

		$fields = array(
			'id'   => $field_id,
			'name' => $field_name,
		);

		$params = array(
			'field'      => $fields,
			'post_types' => $post_types,
			'instance'   => $post_type
		);

		echo View::forge('widget/admin/archives', $params);
	}
}
