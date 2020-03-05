<?php
namespace Hairspress\App;

use Hairspress\Core\View;

class Widget_Categories extends \WP_Widget_Categories
{
	protected $taxonomy = 'category';

	public function add_taxonomy_dropdown_args($category)
	{
		$category['taxonomy'] = $this->taxonomy;
		return $category;
	}

	public function get_taxonomies()
	{
		$taxonomies = get_taxonomies(array(
			'public' => true,
			'show_ui' => true,
		), 'objects');

		return $taxonomies;
	}

	public function widget($args, $instance)
	{
		if ( ! empty($instance['taxonomy']))
		{
			$this->taxonomy = $instance['taxonomy'];
		}

		add_filter('widget_categories_dropdown_args', array($this, 'add_taxonomy_dropdown_args'), 10);
		add_filter('widget_categories_args', array($this, 'add_taxonomy_dropdown_args'), 10);

		parent::widget($args, $instance);
	}

	public function update($new_instance, $old_instance)
	{
		$instance = parent::update($new_instance, $old_instance);
		$instance['taxonomy'] = $new_instance['taxonomy'];

		return $instance;
	}

	public function form($instance)
	{
		parent::form($instance);

		$taxonomy = $this->taxonomy;

		if ( ! empty($instance['taxonomy']))
		{
			$taxonomy = $instance['taxonomy'];
		}

		$taxonomies = $this->get_taxonomies();
		$field_id = $this->get_field_id('taxonomy');
		$field_name = $this->get_field_name('taxonomy');

		$fields = array(
			'id'   => $field_id,
			'name' => $field_name,
		);

		$params = array(
			'field'      => $fields,
			'taxonomies' => $taxonomies,
			'instance'   => $taxonomy
		);

		echo View::forge('widget/admin/categories', $params);
	}
}
